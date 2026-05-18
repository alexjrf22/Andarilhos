<?php 

namespace App\Models;
use App\Database\BdConn;
use PDO;

class WaterfallModel
{
    private PDO $conn;
    private string $waterfall_name;
    private string $waterfall_text;
    private string $waterfall_trail;
    private string $waterfall_difficulty;
    private string $waterfall_date;
    private int $admin_admin_id; 

    public function __construct()
    {
        $this->conn = BdConn::getInstance();
    }

    public function readAll()
    {
        $sql = "SELECT * FROM waterfall";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();  
    }

    public function create(String $waterfall_name, String $waterfall_text, String $waterfall_trail, String $waterfall_difficulty, String $waterfall_date, int $admin_admin_id)
    {
        $sql = "INSERT INTO waterfall 
                (waterfall_name, waterfall_text, waterfall_trail, waterfall_difficulty, waterfall_date, admin_admin_id) 
                VALUES 
                (:waterfall_name, :waterfall_text, :waterfall_trail, :waterfall_difficulty, :waterfall_date, :admin_admin_id)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':waterfall_name', $this->$waterfall_name, PDO::PARAM_STR);
        $stmt->bindParam(':waterfall_text', $this->$waterfall_text, PDO::PARAM_STR);
        $stmt->bindParam(':waterfall_trail', $this->$waterfall_trail, PDO::PARAM_STR);
        $stmt->bindParam(':waterfall_difficulty', $this->$waterfall_difficulty, PDO::PARAM_STR);
        $stmt->bindParam(':waterfall_date', $this->$waterfall_date, PDO::PARAM_STR);
        $stmt->bindParam(':admin_admin_id', $this->$admin_admin_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete(int $waterfall_id)
    {
        $sql = "DELETE FROM waterfall WHERE waterfall_id = :waterfall_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':waterfall_id', $waterfall_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function find(int $waterfall_id)
    {
        $sql = "SELECT * FROM waterfall WHERE waterfall_id = :waterfall_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':waterfall_id', $waterfall_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function update(int $waterfall_id, String $waterfall_name, String $waterfall_text, String $waterfall_trail, String $waterfall_difficulty, String $waterfall_date, int $admin_admin_id)
    {
        $sql = "UPDATE waterfall SET waterfall_name = :waterfall_name, waterfall_text = :waterfall_text, waterfall_trail = :waterfall_trail, waterfall_difficulty = :waterfall_difficulty, waterfall_date = :waterfall_date, admin_admin_id = :admin_admin_id WHERE waterfall_id = :waterfall_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':waterfall_id', $waterfall_id, PDO::PARAM_INT);
        $stmt->bindParam(':waterfall_name', $this->$waterfall_name, PDO::PARAM_STR);
        $stmt->bindParam(':waterfall_text', $this->$waterfall_text, PDO::PARAM_STR);
        $stmt->bindParam(':waterfall_trail', $this->$waterfall_trail, PDO::PARAM_STR);
        $stmt->bindParam(':waterfall_difficulty', $this->$waterfall_difficulty, PDO::PARAM_STR);
        $stmt->bindParam(':waterfall_date', $this->$waterfall_date, PDO::PARAM_STR);
        $stmt->bindParam(':admin_admin_id', $this->$admin_admin_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}