<?php

namespace Aries\Dbmodel\Models;

use Aries\Dbmodel\Includes\Database;

class Post extends Database {
    private $db;

    public function __construct() {
        parent::__construct(); // Call the parent constructor to establish the connection
        $this->db = $this->getConnection(); // Get the connection instance
    }

    public function getPosts() {
        $sql = "SELECT * FROM posts";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPostsByLoggedInUser ($id) {
        $sql = "SELECT * FROM posts WHERE author_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addPost() {
        // Validate author_id
        if (!$this->isUserExists($_POST['author_id'])) {
            throw new \Exception("Author ID does not exist.");
        }

        $sql = "INSERT INTO posts (title, content, author_id) VALUES (:title, :content, :author_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'author_id' => $_POST['author_id']
        ]);
        
        header('Location: index.php');
        exit;
    }

    private function isUserExists($authorId) {
        $sql = "SELECT COUNT(*) FROM user WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $authorId]);
        return $stmt->fetchColumn() > 0; // Returns true if user exists
    }

    public function update($data) {
        $sql = "UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $data['id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);
        return "Record UPDATED successfully";
    }

    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return "Record DELETED successfully";
    }   
}