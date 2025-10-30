<?php
    include "ConnectionController.php";

    $action = $_POST['action'];

    if($action == "register") {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $auth = new AuthController();
        $auth->register($nombre, $email, $password);
    }

    class AuthController {
        private $conn;

        public function __construct() {
            $connection = new ConnectionController();
            $this->conn = $connection->connect();
        }

        public function register($nombre, $email, $password) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $email, $hashedPassword);

            if ($stmt->execute()) {
                header("Location: ../views/registro_exitoso.html");
            } else {
                header("Location: ../../index.html?error=1");
            }

            $stmt->close();
            $this->conn->close();
        }
    }
?>
