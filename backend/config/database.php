<?php

class Database
{
    private $host = "localhost";
    private $databaseName = "jakaltsha";
    private $username = "root";
    private $password = "Zanethemba@2023";

    public function connect()
    {
        try {
            $connection = new PDO(
                "mysql:host=" . $this->host . ";port=3307;dbname=" . $this->databaseName,
                $this->username,
                $this->password
            );

            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $connection;

        } catch (PDOException $error) {
            die("Database connection failed: " . $error->getMessage());
        }
    }
}