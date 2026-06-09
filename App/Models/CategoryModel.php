<?php 

namespace App\Models;

use App\Database\BdConn;
use PDO;

class CategoryModel
{
    private int $category_id;
    private PDO $conn;

    public function __construct()
    {
        $this->conn = BdConn::getInstance();
    }
    
    public function readAll(): array
    {
        $sql = "SELECT * FROM category ORDER BY category_name ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();  
    }

    public function create(string $category_name, ?string $category_description, int $category_status): bool
    {
        $sql = "INSERT INTO category (category_name, category_description, category_status) 
                              VALUES (:category_name, :category_description, :category_status)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
        $stmt->bindParam(':category_description', $category_description, PDO::PARAM_STR);
        $stmt->bindParam(':category_status', $category_status, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function find(int $category_id): array|false
    {
        $this->category_id = $category_id;
        $sql = "SELECT * FROM category WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();  
    }

    public function delete(int $category_id): bool
    {
        $sql = "DELETE FROM category WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update(int $category_id, string $category_name, ?string $category_description, int $category_status): bool
    {
        $sql = "UPDATE category SET category_name = 
                :category_name, category_description = :category_description, category_status = :category_status 
                WHERE category_id = :category_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
        $stmt->bindParam(':category_description', $category_description, PDO::PARAM_STR);
        $stmt->bindParam(':category_status', $category_status, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function search(string $term): array
    {
        $sql = "SELECT * FROM category WHERE category_name LIKE :term";
        $stmt = $this->conn->prepare($sql);
        $searchTerm = '%' . $term . '%';
        $stmt->bindParam(':term', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();  
    }
    
}