<?php

namespace App\Models;
use App\Database\BdConn;
use PDO;

class ContactModel
{
      private PDO $conn;
      private string $contact_title;
      private string $contact_mail;
      private string $contact_text;

      public function __construct()
      {
          $this->conn = BdConn::getInstance();
      }
      
      public function readAll()
      {
          $sql = "SELECT * FROM contact";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          return $stmt->fetchAll();  
      }

      public function create(String $contact_title, String $contact_mail, String $contact_text)
      {
          $sql = "INSERT INTO contact (contact_title, contact_mail, contact_text) 
                               VALUES (:contact_title, :contact_mail, :contact_text)";

          $stmt = $this->conn->prepare($sql);
          $stmt->bindParam(':contact_title', $this->$contact_title, PDO::PARAM_STR);
          $stmt->bindParam(':contact_mail', $this->$contact_mail, PDO::PARAM_STR);
          $stmt->bindParam(':contact_text', $this->$contact_text, PDO::PARAM_STR);
          return $stmt->execute();
      }

      public function delete(int $contact_id)
      {
          $sql = "DELETE FROM contact WHERE contact_id = :contact_id";
          $stmt = $this->conn->prepare($sql);
          $stmt->bindParam(':contact_id', $contact_id, PDO::PARAM_INT);
          return $stmt->execute();
      }
}