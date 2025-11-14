<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: ./UserController.php', true, 307);
    exit;
}
header('Location: /mi_login_php/');
exit;
?>
