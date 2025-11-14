<?php
include __DIR__ . '/UserModel.php';

class UserController {
    public $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    public function getUser($id) {
        return $this->model->getUser($id);
    }

    public function getAllUsers() {
        return $this->model->getAll();
    }

    public function updateUser($id, $nombre, $email) {
        return $this->model->update($id, $nombre, $email);
    }
}
?>
