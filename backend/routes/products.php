<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . "/../controllers/ProductController.php";

$productController = new ProductController();

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);

    echo json_encode([
        "error" => "Method not allowed"
    ]);

    exit;
}

// Get products by artist
if (isset($_GET["artist_id"])) {
    $products = $productController->getProductsByArtist($_GET["artist_id"]);

    echo json_encode($products);
    exit;
}

// Get one product
if (isset($_GET["id"])) {
    $product = $productController->getProductById($_GET["id"]);

    echo json_encode($product);
    exit;
}

// Get all products
$products = $productController->getAllProducts();

echo json_encode($products);