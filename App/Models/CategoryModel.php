<?php 

namespace App\Models;

use App\Database\BdConn;
use PDO;

class CategoryModel
{
    private int $category_id;
    private string $category_name;
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

    public function create(string $category_name)
    {
        $sql = "INSERT INTO category (category_name) VALUES (:category_name)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function find(int $category_id)
    {
        $this->category_id = $category_id;
        $sql = "SELECT * FROM category WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();  
    }

    public function delete(int $category_id)
    {
        $sql = "DELETE FROM category WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update(int $category_id, string $category_name)
    {
        $sql = "UPDATE category SET category_name = :category_name WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function search(string $term)
    {
        $sql = "SELECT * FROM category WHERE category_name LIKE :term";
        $stmt = $this->conn->prepare($sql);
        $searchTerm = '%' . $term . '%';
        $stmt->bindParam(':term', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();  
    }
    
}