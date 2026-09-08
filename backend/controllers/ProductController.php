<?php

require_once __DIR__ . "/../config/database.php";

class ProductController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Get all products with artist information
    public function getAllProducts()
    {
        try {
            $query = "SELECT
                        products.id,
                        products.name,
                        products.description,
                        products.price,
                        products.image,
                        products.stock,
                        products.artist_id,
                        artists.name AS artist_name
                      FROM products
                      INNER JOIN artists ON products.artist_id = artists.id
                      ORDER BY products.created_at DESC";

            $statement = $this->db->prepare($query);
            $statement->execute();

            return $statement->fetchAll();

        } catch (PDOException $error) {
            return [
                "error" => "Failed to retrieve products"
            ];
        }
    }

    // Get one product by ID
    public function getProductById($id)
    {
        try {
            $query = "SELECT
                        products.id,
                        products.name,
                        products.description,
                        products.price,
                        products.image,
                        products.stock,
                        products.artist_id,
                        artists.name AS artist_name
                      FROM products
                      INNER JOIN artists ON products.artist_id = artists.id
                      WHERE products.id = :id";

            $statement = $this->db->prepare($query);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();

            $product = $statement->fetch();

            if (!$product) {
                return [
                    "error" => "Product not found"
                ];
            }

            return $product;

        } catch (PDOException $error) {
            return [
                "error" => "Failed to retrieve product"
            ];
        }
    }

    // Get all products belonging to one artist
    public function getProductsByArtist($artistId)
    {
        try {
            $query = "SELECT
                        products.id,
                        products.name,
                        products.description,
                        products.price,
                        products.image,
                        products.stock,
                        products.artist_id,
                        artists.name AS artist_name
                      FROM products
                      INNER JOIN artists ON products.artist_id = artists.id
                      WHERE products.artist_id = :artist_id
                      ORDER BY products.created_at DESC";

            $statement = $this->db->prepare($query);
            $statement->bindParam(":artist_id", $artistId, PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetchAll();

        } catch (PDOException $error) {
            return [
                "error" => "Failed to retrieve artist products"
            ];
        }
    }
}