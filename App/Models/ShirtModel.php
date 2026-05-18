<?php

namespace App\Models;

use App\Database\BdConn;
use PDO;

class ShirtModel
{
    private int $shirt_id;
    private string $shirt_title;
    private string $shirt_text;
    private string $shirt_gender;
    private float $shirt_price;
    private PDO $conn;

    public function __construct()
    {
        $this->conn = BdConn::getInstance();
    }
    
    public function readAll()
    {
        $sql = "SELECT * FROM shirt";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();  
    }

    public function create(String $shirt_title, String $shirt_text, String $shirt_gender, float $shirt_price)
    {
        $sql = "INSERT INTO shirt (shirt_title, shirt_text, shirt_gender, shirt_price) 
                           VALUES (:shirt_title, :shirt_text, :shirt_gender, :shirt_price)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':shirt_title', $this->$shirt_title, PDO::PARAM_STR);
        $stmt->bindParam(':shirt_text', $this->$shirt_text, PDO::PARAM_STR);
        $stmt->bindParam(':shirt_gender', $this->$shirt_gender, PDO::PARAM_STR);
        $stmt->bindParam(':shirt_price', $this->$shirt_price, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function find(int $shirt_id)
    {
        $this->shirt_id = $shirt_id;
        $sql = "SELECT * FROM shirt WHERE shirt_id = :shirt_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':shirt_id', $this->shirt_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();  
    }

    public function delete(int $shirt_id)
    {
        $sql = "DELETE FROM shirt WHERE shirt_id = :shirt_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':shirt_id', $shirt_id);
        return $stmt->execute();
    }

    public function update(int $shirt_id, String $shirt_title, String $shirt_text, String $shirt_gender, float $shirt_price)
    {
        $sql = "UPDATE shirt SET shirt_title = :shirt_title, shirt_text = 
                                :shirt_text, shirt_gender = :shirt_gender, shirt_price = :shirt_price 
                WHERE shirt_id = :shirt_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':shirt_id', $this->shirt_id, PDO::PARAM_INT);
        $stmt->bindParam(':shirt_title', $this->shirt_title, PDO::PARAM_STR);
        $stmt->bindParam(':shirt_text', $this->shirt_text, PDO::PARAM_STR);
        $stmt->bindParam(':shirt_gender', $this->shirt_gender, PDO::PARAM_STR);
        $stmt->bindParam(':shirt_price', $this->shirt_price, PDO::PARAM_STR);
        return $stmt->execute();
    }
}