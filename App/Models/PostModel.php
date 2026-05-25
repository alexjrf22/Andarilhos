<?php 

namespace App\Models;

use App\Database\BdConn;
use PDO;

class PostModel
{
    private int $post_id;
    private string $post_title;
    private string $post_text;
    private PDO $conn;

    public function __construct()
    {
        $this->conn = BdConn::getInstance();
    }
    
    public function readAll()
    {
        $sql = "SELECT * FROM post";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();  
    }

    public function create(string $post_title, string $post_text)
    {
        $sql = "INSERT INTO post (post_title, post_text) 
                           VALUES (:post_title, :post_text)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':post_title', $post_title, PDO::PARAM_STR);
        $stmt->bindParam(':post_text', $post_text, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function find(int $post_id)
    {
        $this->post_id = $post_id;
        $sql = "SELECT * FROM post WHERE post_id = :post_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':post_id', $this->post_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();  
    }

    public function findByCategory(int $category_id)
    {
        $sql = "SELECT * FROM post WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function delete(int $post_id)
    {
        $sql = "DELETE FROM post WHERE post_id = :post_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update(int $post_id, string $post_title, string $post_text)
    {
        $sql = "UPDATE post SET post_title = :post_title, post_text = :post_text WHERE post_id = :post_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->bindParam(':post_title', $post_title, PDO::PARAM_STR);
        $stmt->bindParam(':post_text', $post_text, PDO::PARAM_STR);
        return $stmt->execute();
    }



    public function search(string $term)
    {
        $sql = "SELECT * FROM post WHERE post_title LIKE :term OR post_text LIKE :term";
        $stmt = $this->conn->prepare($sql);
        $searchTerm = '%' . $term . '%';
        $stmt->bindParam(':term', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();  
    }
    
}