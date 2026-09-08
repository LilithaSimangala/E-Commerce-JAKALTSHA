<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . "/../controllers/MusicController.php";

$musicController = new MusicController();

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);

    echo json_encode([
        "error" => "Method not allowed"
    ]);

    exit;
}

// Get music by artist
if (isset($_GET["artist_id"])) {
    $music = $musicController->getMusicByArtist($_GET["artist_id"]);

    echo json_encode($music);
    exit;
}

// Get one music track
if (isset($_GET["id"])) {
    $music = $musicController->getMusicById($_GET["id"]);

    echo json_encode($music);
    exit;
}

// Get all music
$music = $musicController->getAllMusic();

echo json_encode($music);