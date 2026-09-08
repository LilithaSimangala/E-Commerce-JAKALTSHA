<?php

require_once __DIR__ . "/../config/database.php";

class MusicController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Get all music tracks with artist information
    public function getAllMusic()
    {
        try {
            $query = "SELECT 
                        music.id,
                        music.title,
                        music.audio_url,
                        music.cover_image,
                        music.artist_id,
                        artists.name AS artist_name
                      FROM music
                      INNER JOIN artists ON music.artist_id = artists.id
                      ORDER BY music.created_at DESC";

            $statement = $this->db->prepare($query);
            $statement->execute();

            return $statement->fetchAll();

        } catch (PDOException $error) {
            return [
                "error" => "Failed to retrieve music"
            ];
        }
    }

    // Get one music track by ID
    public function getMusicById($id)
    {
        try {
            $query = "SELECT 
                        music.id,
                        music.title,
                        music.audio_url,
                        music.cover_image,
                        music.artist_id,
                        artists.name AS artist_name
                      FROM music
                      INNER JOIN artists ON music.artist_id = artists.id
                      WHERE music.id = :id";

            $statement = $this->db->prepare($query);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();

            $music = $statement->fetch();

            if (!$music) {
                return [
                    "error" => "Music track not found"
                ];
            }

            return $music;

        } catch (PDOException $error) {
            return [
                "error" => "Failed to retrieve music track"
            ];
        }
    }

    // Get all music belonging to one artist
    public function getMusicByArtist($artistId)
    {
        try {
            $query = "SELECT 
                        music.id,
                        music.title,
                        music.audio_url,
                        music.cover_image,
                        music.artist_id,
                        artists.name AS artist_name
                      FROM music
                      INNER JOIN artists ON music.artist_id = artists.id
                      WHERE music.artist_id = :artist_id
                      ORDER BY music.created_at DESC";

            $statement = $this->db->prepare($query);
            $statement->bindParam(":artist_id", $artistId, PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetchAll();

        } catch (PDOException $error) {
            return [
                "error" => "Failed to retrieve artist music"
            ];
        }
    }
}