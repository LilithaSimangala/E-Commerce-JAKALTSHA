<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

require_once __DIR__ . "/../controllers/AuthController.php";

$authController = new AuthController();

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "error" => "Method not allowed"
    ]);

    exit;
}

// Get JSON data sent by the frontend
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    http_response_code(400);

    echo json_encode([
        "error" => "Invalid JSON data"
    ]);

    exit;
}

// Registration
if (isset($_GET["action"]) && $_GET["action"] === "register") {

    if (
        empty($data["name"]) ||
        empty($data["email"]) ||
        empty($data["password"])
    ) {
        http_response_code(400);

        echo json_encode([
            "error" => "Name, email and password are required"
        ]);

        exit;
    }

    $result = $authController->register(
        $data["name"],
        $data["email"],
        $data["password"]
    );

    echo json_encode($result);
    exit;
}

// Login
if (isset($_GET["action"]) && $_GET["action"] === "login") {

    if (
        empty($data["email"]) ||
        empty($data["password"])
    ) {
        http_response_code(400);

        echo json_encode([
            "error" => "Email and password are required"
        ]);

        exit;
    }

    $result = $authController->login(
        $data["email"],
        $data["password"]
    );

    echo json_encode($result);
    exit;
}

http_response_code(400);

echo json_encode([
    "error" => "Invalid authentication action"
]);