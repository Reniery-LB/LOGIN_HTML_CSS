<?php
session_start();
include __DIR__ . '/UserModel.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /mi_login_php/index.html');
    exit;
}
$action = isset($_POST['action']) ? $_POST['action'] : '';
if ($action === 'register') {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email  = isset($_POST['email'])  ? trim($_POST['email'])  : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    if ($nombre === '' || mb_strlen($nombre) < 3) {
        header('Location: /mi_login_php/index.html?error=name');
        exit;
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: /mi_login_php/index.html?error=email');
        exit;
    }
    if ($password === '' || mb_strlen($password) < 6) {
        header('Location: /mi_login_php/index.html?error=password');
        exit;
    }
    $model = new UserModel();
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $res = $model->create($nombre, $email, $hash);
    if (is_array($res) && isset($res['ok']) && $res['ok']) {
        header('Location: /mi_login_php/assets/app/registro_exitoso.php');
        exit;
    }
    if (is_array($res) && isset($res['reason']) && $res['reason'] === 'exists') {
        header('Location: /mi_login_php/index.html?error=exists');
        exit;
    }
    header('Location: /mi_login_php/index.html?error=db');
    exit;
}
if ($action === 'login') {
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';
    if ($usuario === '' || $contrasena === '') {
        header('Location: /mi_login_php/assets/views/login.html?error=empty');
        exit;
    }
    $model = new UserModel();
    $user = null;
    if (filter_var($usuario, FILTER_VALIDATE_EMAIL)) {
        $user = $model->getByEmail($usuario);
    } 
    if (!$user) {
        $user = $model->getByNombre($usuario);
    }
    if (!$user) {
        header('Location: /mi_login_php/assets/views/login.html?error=notfound');
        exit;
    }
    if (!isset($user['password']) || !password_verify($contrasena, $user['password'])) {
        header('Location: /mi_login_php/assets/views/login.html?error=invalid');
        exit;
    }
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_nombre'] = $user['nombre'];
    header('Location: /mi_login_php/assets/app/registro_exitoso.php');
    exit;
}
if ($action === 'update') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    if ($id <= 0) {
        header('Location: /mi_login_php/assets/app/registro_exitoso.php');
        exit;
    }
    if ($nombre === '' || mb_strlen($nombre) < 3) {
        header("Location: /mi_login_php/assets/app/editar.php?id={$id}&error=name");
        exit;
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: /mi_login_php/assets/app/editar.php?id={$id}&error=email");
        exit;
    }
    $model = new UserModel();
    if ($model->emailExistsExcept($email, $id)) {
        header("Location: /mi_login_php/assets/app/editar.php?id={$id}&error=exists");
        exit;
    }
    $hash = null;
    if ($password !== '') {
        if (mb_strlen($password) < 6) {
            header("Location: /mi_login_php/assets/app/editar.php?id={$id}&error=password");
            exit;
        }
        $hash = password_hash($password, PASSWORD_BCRYPT);
    }
    $ok = $model->updateUser($id, $nombre, $email, $hash);
    if ($ok) {
        header('Location: /mi_login_php/assets/app/registro_exitoso.php');
        exit;
    } else {
        header("Location: /mi_login_php/assets/app/editar.php?id={$id}&error=db");
        exit;
    }
}
header('Location: /mi_login_php/index.html');
exit;
?>
