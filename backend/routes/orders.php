<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

require_once __DIR__ . "/../controllers/OrderController.php";

$orderController = new OrderController();

header("Content-Type: application/json");

$requestMethod = $_SERVER["REQUEST_METHOD"];

// Create a new order
if ($requestMethod === "POST") {

    $data = json_decode(file_get_contents("php://input"), true);

    if (
        !$data ||
        !isset($data["user_id"]) ||
        !isset($data["items"]) ||
        !is_array($data["items"]) ||
        empty($data["items"])
    ) {
        http_response_code(400);

        echo json_encode([
            "error" => "User ID and order items are required"
        ]);

        exit;
    }

    $result = $orderController->createOrder(
        $data["user_id"],
        $data["items"]
    );

    echo json_encode($result);
    exit;
}

// Get orders
if ($requestMethod === "GET") {

    // Get one specific order
    if (isset($_GET["id"])) {

        $result = $orderController->getOrderById(
            $_GET["id"],
            $_GET["user_id"] ?? null
        );

        echo json_encode($result);
        exit;
    }

    // Get all orders belonging to the user
    if (isset($_GET["user_id"])) {

        $result = $orderController->getOrdersByUser(
            $_GET["user_id"]
        );

        echo json_encode($result);
        exit;
    }

    http_response_code(400);

    echo json_encode([
        "error" => "Order ID or User ID is required"
    ]);

    exit;
}
// Method not supported
http_response_code(405);

echo json_encode([
    "error" => "Method not allowed"
]);