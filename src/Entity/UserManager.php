<?php

namespace App\Entity;

use Exception;
use InvalidArgumentException;
use PDO;

class UserManager {
    private PDO $db;

    public function __construct() {
        $dsn = "mysql:host=localhost;dbname=tests_unitaires_efrei;charset=utf8";
        $username = "root"; // Modifier si besoin
        $password = ""; // Modifier si besoin
        $this->db = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function addUser(string $name, string $email, string|int $age): void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email invalide.");
        }

        if('' === $age) $age = 30;

        $stmt = $this->db->prepare("INSERT INTO users (name, email, age) VALUES (:name, :email, :age)");
        $stmt->execute(['name' => $name, 'email' => $email, 'age' => $age]);

    }

    public function removeUser(int $id): void {

        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $user = $stmt->fetch();
        if(!$user) throw new Exception("Utilisateur introuvable.");

        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function getUsers(): array {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    public function getUser(int $id): array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        if (!$user) throw new Exception("Utilisateur introuvable.");
        return $user;
    }

    public function updateUser(int $id, string $name, string $email, string|int $age): void {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $user = $stmt->fetch();
        if(!$user) throw new Exception("Utilisateur introuvable.");

        if('' === $age) $age = 30;

        $stmt = $this->db->prepare("UPDATE users SET name = :name, email = :email, age = :age WHERE id = :id");
        $stmt->execute(['id' => $id, 'name' => $name, 'email' => $email, 'age' => $age]);

    }
}
?>
