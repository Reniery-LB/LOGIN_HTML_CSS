<?php
include "ConnectionController.php";
class UserModel {
    private $conn;
    public function __construct() {
        $connection = new ConnectionController();
        $this->conn = $connection->connect();
    }
    public function emailExists($email) {
        $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE email = ? LIMIT 1");
        if (!$stmt) return false;
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }
    public function emailExistsExcept($email, $id) {
        $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE email = ? AND id <> ? LIMIT 1");
        if (!$stmt) return false;
        $stmt->bind_param("si", $email, $id);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }
    public function create($nombre, $email, $hashedPassword) {
        if ($this->emailExists($email)) {
            return ['ok' => false, 'reason' => 'exists'];
        }
        $stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
        if (!$stmt) return ['ok' => false, 'reason' => 'db'];
        $stmt->bind_param("sss", $nombre, $email, $hashedPassword);
        $success = $stmt->execute();
        $stmt->close();
        if ($success) return ['ok' => true];
        return ['ok' => false, 'reason' => 'db'];
    }
    public function getUser($id) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }
    public function getByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ? LIMIT 1");
        if (!$stmt) return null;
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }
    public function getByNombre($nombre) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE nombre = ? LIMIT 1");
        if (!$stmt) return null;
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }
    public function updateUser($id, $nombre, $email, $hashedPassword = null) {
        if ($hashedPassword === null) {
            $stmt = $this->conn->prepare("UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?");
            if (!$stmt) return false;
            $stmt->bind_param("ssi", $nombre, $email, $id);
        } else {
            $stmt = $this->conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, password = ? WHERE id = ?");
            if (!$stmt) return false;
            $stmt->bind_param("sssi", $nombre, $email, $hashedPassword, $id);
        }
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
    public function update($id, $nombre, $email) {
        return $this->updateUser($id, $nombre, $email, null);
    }
    public function getAll() {
        $result = $this->conn->query("SELECT * FROM usuarios");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
