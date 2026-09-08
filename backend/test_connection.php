<?php

require_once "config/database.php";

$database = new Database();
$db = $database->connect();

echo "Database connection successful!";