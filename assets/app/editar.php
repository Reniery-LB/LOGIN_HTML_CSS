<?php
include "UserController.php";
if (!isset($_GET['id'])) {
    header("Location: registro_exitoso.php");
    exit;
}
$controller = new UserController();
$user = $controller->getUser((int)$_GET['id']);
if (!$user) {
    header("Location: registro_exitoso.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Usuario</title>
  <link rel="stylesheet" href="../styles/styles.css" />
</head>
<body>
  <div class="main_container">
    <div class="login_container">
      <h1>Editar usuario</h1>
      <form action="/mi_login_php/assets/app/user_actions.php" method="POST">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id'], ENT_QUOTES) ?>">
        <div class="input_group">
          <input type="text" name="nombre" placeholder="Nombre completo" required value="<?= htmlspecialchars($user['nombre'], ENT_QUOTES) ?>">
        </div>
        <div class="input_group">
          <input type="email" name="email" placeholder="Correo electrónico" required value="<?= htmlspecialchars($user['email'], ENT_QUOTES) ?>">
        </div>
        <div class="input_group">
          <input type="password" name="password" placeholder="Contraseña (dejar vacío para no cambiar)" />
        </div>
        <div class="form_footer" style="justify-content:center;">
          <a href="registro_exitoso.php" class="login_btn" style="display:inline-block;text-align:center;width:48%;background:#777;">Cancelar</a>
          <button type="submit" class="login_btn" style="width:48%;margin-right:4%;">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
