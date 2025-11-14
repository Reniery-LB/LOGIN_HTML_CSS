<?php
include __DIR__ . '/UserController.php';
$controller = new UserController();
$users = $controller->getAllUsers();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Usuarios Registrados</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <div class="main_container">
        <div class="login_container">
            <h1>Usuarios Registrados</h1>
            <?php if (!is_array($users) || count($users) === 0): ?>
                <div class="no-users">No hay usuarios registrados todavía.</div>
            <?php else: ?>
            <div class="table-wrapper">
                <table class="users-table" role="table" aria-label="Usuarios">
                    <thead>
                        <tr>
                            <th style="width:8%;">ID</th>
                            <th style="width:36%;">Nombre</th>
                            <th style="width:38%;">Email</th>
                            <th style="width:18%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id'], ENT_QUOTES) ?></td>
                            <td><?= htmlspecialchars($user['nombre'], ENT_QUOTES) ?></td>
                            <td><?= htmlspecialchars($user['email'], ENT_QUOTES) ?></td>
                            <td class="table-actions">
                            <a class="edit-link" href="editar.php?id=<?= htmlspecialchars($user['id'], ENT_QUOTES) ?>">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
            <br>
            <button class="login_btn" onclick="location.href='../views/login.html'">Cerrar Sesión</button>
        </div>
    </div>
</body>
</html>
