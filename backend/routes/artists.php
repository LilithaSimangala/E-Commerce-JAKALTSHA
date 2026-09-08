<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . "/../controllers/ArtistController.php";

$artistController = new ArtistController();

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    if (isset($_GET["id"])) {
        $artist = $artistController->getArtistById($_GET["id"]);

        header("Content-Type: application/json");
        echo json_encode($artist);
        exit;
    }

    $artists = $artistController->getAllArtists();

    header("Content-Type: application/json");
    echo json_encode($artists);
    exit;
}

http_response_code(405);

header("Content-Type: application/json");

echo json_encode([
    "error" => "Method not allowed"
]);