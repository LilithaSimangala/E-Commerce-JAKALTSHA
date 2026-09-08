<?php

require_once __DIR__ . "/../config/database.php";

class OrderController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Create a new order
    public function createOrder($userId, $items)
    {
        try {
            // Start a database transaction
            $this->db->beginTransaction();

            $totalAmount = 0;
            $validatedItems = [];

            // Validate every product and calculate the total
            foreach ($items as $item) {

                if (
                    !isset($item["product_id"]) ||
                    !isset($item["quantity"]) ||
                    $item["quantity"] <= 0
                ) {
                    throw new Exception("Invalid order item");
                }

                $productQuery = "SELECT id, price, stock
                                 FROM products
                                 WHERE id = :product_id
                                 FOR UPDATE";

                $productStatement = $this->db->prepare($productQuery);
                $productStatement->bindParam(
                    ":product_id",
                    $item["product_id"],
                    PDO::PARAM_INT
                );
                $productStatement->execute();

                $product = $productStatement->fetch();

                if (!$product) {
                    throw new Exception("Product not found");
                }

                if ($product["stock"] < $item["quantity"]) {
                    throw new Exception(
                        "Insufficient stock for product ID " . $item["product_id"]
                    );
                }

                $itemTotal = $product["price"] * $item["quantity"];
                $totalAmount += $itemTotal;

                $validatedItems[] = [
                    "product_id" => $product["id"],
                    "quantity" => $item["quantity"],
                    "price" => $product["price"]
                ];
            }

            // Create the order
            $orderQuery = "INSERT INTO orders
                           (user_id, total_amount, status, payment_status)
                           VALUES
                           (:user_id, :total_amount, 'pending', 'pending')";

            $orderStatement = $this->db->prepare($orderQuery);

            $orderStatement->bindParam(
                ":user_id",
                $userId,
                PDO::PARAM_INT
            );

            $orderStatement->bindParam(
                ":total_amount",
                $totalAmount
            );

            $orderStatement->execute();

            $orderId = $this->db->lastInsertId();

            // Add products to order_items
            foreach ($validatedItems as $item) {

                $itemQuery = "INSERT INTO order_items
                              (order_id, product_id, quantity, price)
                              VALUES
                              (:order_id, :product_id, :quantity, :price)";

                $itemStatement = $this->db->prepare($itemQuery);

                $itemStatement->bindParam(
                    ":order_id",
                    $orderId,
                    PDO::PARAM_INT
                );

                $itemStatement->bindParam(
                    ":product_id",
                    $item["product_id"],
                    PDO::PARAM_INT
                );

                $itemStatement->bindParam(
                    ":quantity",
                    $item["quantity"],
                    PDO::PARAM_INT
                );

                $itemStatement->bindParam(
                    ":price",
                    $item["price"]
                );

                $itemStatement->execute();

                // Reduce product stock
                $stockQuery = "UPDATE products
                               SET stock = stock - :quantity
                               WHERE id = :product_id";

                $stockStatement = $this->db->prepare($stockQuery);

                $stockStatement->bindParam(
                    ":quantity",
                    $item["quantity"],
                    PDO::PARAM_INT
                );

                $stockStatement->bindParam(
                    ":product_id",
                    $item["product_id"],
                    PDO::PARAM_INT
                );

                $stockStatement->execute();
            }

            // Complete the transaction
            $this->db->commit();

            return [
                "message" => "Order created successfully",
                "order_id" => $orderId,
                "total_amount" => $totalAmount
            ];

        } catch (Exception $error) {

            // Undo everything if something goes wrong
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            return [
                "error" => $error->getMessage()
            ];
        }
    }

    // Get all orders belonging to a user
    public function getOrdersByUser($userId)
    {
        try {
            $query = "SELECT
                        id,
                        user_id,
                        total_amount,
                        status,
                        payment_status,
                        created_at
                      FROM orders
                      WHERE user_id = :user_id
                      ORDER BY created_at DESC";

            $statement = $this->db->prepare($query);

            $statement->bindParam(
                ":user_id",
                $userId,
                PDO::PARAM_INT
            );

            $statement->execute();

            return $statement->fetchAll();

        } catch (PDOException $error) {
            return [
                "error" => "Failed to retrieve orders"
            ];
        }
    }

    // Get one order
    public function getOrderById($orderId, $userId)
    {
        try {
            $query = "SELECT
                        id,
                        user_id,
                        total_amount,
                        status,
                        payment_status,
                        created_at
                      FROM orders
                      WHERE id = :order_id
                      AND user_id = :user_id";

            $statement = $this->db->prepare($query);

            $statement->bindParam(
                ":order_id",
                $orderId,
                PDO::PARAM_INT
            );

            $statement->bindParam(
                ":user_id",
                $userId,
                PDO::PARAM_INT
            );

            $statement->execute();

            $order = $statement->fetch();

            if (!$order) {
                return [
                    "error" => "Order not found"
                ];
            }

            return $order;

        } catch (PDOException $error) {
            return [
                "error" => "Failed to retrieve order"
            ];
        }
    }
}