<?php

require_once __DIR__ . "/../config/database.php";

class ArtistController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAllArtists()
    {
        try {
            $query = "SELECT id, name, bio, image, created_at
                      FROM artists
                      ORDER BY name ASC";

            $statement = $this->db->prepare($query);
            $statement->execute();

            $artists = $statement->fetchAll();

            return $artists;

        } catch (PDOException $error) {
            return [
                "error" => "Failed to retrieve artists"
            ];
        }
    }

    public function getArtistById($id)
    {
        try {
            $query = "SELECT id, name, bio, image, created_at
                      FROM artists
                      WHERE id = :id";

            $statement = $this->db->prepare($query);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();

            $artist = $statement->fetch();

            if (!$artist) {
                return [
                    "error" => "Artist not found"
                ];
            }

            return $artist;

        } catch (PDOException $error) {
            return [
                "error" => "Failed to retrieve artist"
            ];
        }
    }
}