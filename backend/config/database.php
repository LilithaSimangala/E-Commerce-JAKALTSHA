<?php

class Database
{
    private $host;
    private $port;
    private $databaseName;
    private $username;
    private $password;

    public function __construct()
    {
        // Vercel's TiDB integration supplies TIDB_* variables.
        // DB_* variables are supported for other MySQL-compatible providers.
        $this->host = getenv("TIDB_HOST") ?: (getenv("DB_HOST") ?: "localhost");
        $this->port = getenv("TIDB_PORT") ?: (getenv("DB_PORT") ?: "3307");
        $this->databaseName = getenv("TIDB_DATABASE") ?: (getenv("DB_DATABASE") ?: "jakaltsha");
        $this->username = getenv("TIDB_USER") ?: (getenv("DB_USERNAME") ?: "root");
        $this->password = getenv("TIDB_PASSWORD") ?: (getenv("DB_PASSWORD") ?: "");
    }

    public function connect()
    {
        try {
            $options = [];
            if (getenv("TIDB_HOST")) {
                // TiDB Cloud requires TLS; verify it using the platform's trusted CA bundle.
                $caFile = getenv("TIDB_CA_FILE") ?: "/etc/ssl/certs/ca-certificates.crt";
                if (is_readable($caFile)) {
                    $options[PDO::MYSQL_ATTR_SSL_CA] = $caFile;
                }
                $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;
            }

            $connection = new PDO(
                "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->databaseName . ";charset=utf8mb4",
                $this->username,
                $this->password,
                $options
            );
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $connection;
        } catch (PDOException $error) {
            error_log("Database connection failed: " . $error->getMessage());
            http_response_code(500);
            header("Content-Type: application/json");
            die(json_encode(["error" => "Database connection failed"]));
        }
    }
}