<?php

class Category
{
    private $connection;
    private $table = 'categories';
    public $id;
    public $name;

    public function __construct($db)
    {
        $this->connection = $db;
    }

    public function read()
    {
        $query = "
            SELECT
                id,
                name,
                created_at
            FROM
                " . $this->table . "
            ORDER BY
                created_at DESC
        ";

        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function read_single()
    {
        $query = "
            SELECT
                id,
                name
            FROM
                " . $this->table . "
            WHERE id = ?
                LIMIT 0,1
        ";

        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $this->id);
        
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->id = $row['id'];
        $this->name = $row['name'];
        
        if ($stmt->rowCount()) {
            return true;
        }

        return false;
    }

    // Create Category
    public function create()
    {
        $query = "
            INSERT INTO 
                " . $this->table . "
            SET
                name = :name
        ";

        $stmt = $this->connection->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $stmt->bindParam(':name', $this->name);

        $stmt->execute();
        if ($stmt->rowCount()) {
            return true;
        }

        return false;
    }

    // Update Category
    public function update()
    {
        $query = "
            UPDATE 
                " . $this->table . "
            SET
                name = :name
            WHERE
                id = :id
        ";

        $stmt = $this->connection->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);

        $stmt->execute();
        if ($stmt->rowCount()) {
            return true;
        }

        return false;
    }

    // Delete Category
    public function delete()
    {
        $query = "
            DELETE 
            FROM 
                " . $this->table . " 
            WHERE 
                id = :id
        ";

        $stmt = $this->connection->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        $stmt->execute();
        if ($stmt->rowCount()) {
            return true;
        }

        return false;
    }
}