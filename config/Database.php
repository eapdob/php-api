<?php

class Database
{
    private $host = 'db';
    private $db_name = 'myblog';
    private $username = 'root';
    private $password = 'demo1234';
    private $connection = null;

    public function connect()
    {
        try {
            $this->connection = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->connection;
    }
}