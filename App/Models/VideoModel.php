<?php 

namespace App\Models;
use App\Database\BdConn;
use PDO;

class VideoModel
{
    private PDO $conn;
    private string $video_title;
    private string $video_url;

    public function __construct()
    {
        $this->conn = BdConn::getInstance();
    }
    
    public function readAll()
    {
        $sql = "SELECT * FROM video";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();  
    }

    public function create(String $video_title, String $video_url)
    {
        $sql = "INSERT INTO video (video_title, video_url) 
                             VALUES (:video_title, :video_url)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':video_title', $this->$video_title, PDO::PARAM_STR);
        $stmt->bindParam(':video_url', $this->$video_url, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function delete(int $video_id)
    {
        $sql = "DELETE FROM video WHERE video_id = :video_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':video_id', $video_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function find(int $video_id)
    {
        $sql = "SELECT * FROM video WHERE video_id = :video_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':video_id', $video_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();  
    }

    public function update(int $video_id, String $video_title, String $video_url)
    {
        $sql = "UPDATE video SET video_title = :video_title, video_url = :video_url WHERE video_id = :video_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':video_id', $video_id, PDO::PARAM_INT);
        $stmt->bindParam(':video_title', $this->$video_title, PDO::PARAM_STR);
        $stmt->bindParam(':video_url', $this->$video_url, PDO::PARAM_STR);
        return $stmt->execute();
    }
}