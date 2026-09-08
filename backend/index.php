<?php

header("Content-Type: application/json");

$request = $_SERVER["REQUEST_URI"];
$request = parse_url($request, PHP_URL_PATH);

// Artists
if ($request === "/JAKALTSHA/backend/artists") {
    require_once __DIR__ . "/routes/artists.php";
    exit;
}

// Music
if ($request === "/JAKALTSHA/backend/music") {
    require_once __DIR__ . "/routes/music.php";
    exit;
}

// Products
if ($request === "/JAKALTSHA/backend/products") {
    require_once __DIR__ . "/routes/products.php";
    exit;
}

// Authentication
if ($request === "/JAKALTSHA/backend/auth") {
    require_once __DIR__ . "/routes/auth.php";
    exit;
}

// Orders
if ($request === "/JAKALTSHA/backend/orders") {
    require_once __DIR__ . "/routes/orders.php";
    exit;
}

// Default response
http_response_code(404);

echo json_encode([
    "error" => "Endpoint not found"
]);