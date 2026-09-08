<?php

require_once __DIR__ . "/../config/database.php";

class AuthController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Register a new customer
    public function register($name, $email, $password)
    {
        try {
            // Check if email already exists
            $checkQuery = "SELECT id FROM users WHERE email = :email";
            $checkStatement = $this->db->prepare($checkQuery);
            $checkStatement->bindParam(":email", $email);
            $checkStatement->execute();

            if ($checkStatement->fetch()) {
                return [
                    "error" => "Email already exists"
                ];
            }

            // Hash the password before storing it
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (name, email, password, role)
                      VALUES (:name, :email, :password, 'customer')";

            $statement = $this->db->prepare($query);

            $statement->bindParam(":name", $name);
            $statement->bindParam(":email", $email);
            $statement->bindParam(":password", $hashedPassword);

            $statement->execute();

            return [
                "message" => "Registration successful",
                "user_id" => $this->db->lastInsertId()
            ];

        } catch (PDOException $error) {
            return [
                "error" => "Registration failed"
            ];
        }
    }

    // Login an existing customer
    public function login($email, $password)
    {
        try {
            $query = "SELECT id, name, email, password, role
                      FROM users
                      WHERE email = :email";

            $statement = $this->db->prepare($query);
            $statement->bindParam(":email", $email);
            $statement->execute();

            $user = $statement->fetch();

            if (!$user) {
                return [
                    "error" => "Invalid email or password"
                ];
            }

            // Verify the submitted password
            if (!password_verify($password, $user["password"])) {
                return [
                    "error" => "Invalid email or password"
                ];
            }

            // Never send the password back to the frontend
            unset($user["password"]);

            return [
                "message" => "Login successful",
                "user" => $user
            ];

        } catch (PDOException $error) {
            return [
                "error" => "Login failed"
            ];
        }
    }
}