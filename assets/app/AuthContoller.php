<?php

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    if($usuario == "reniery") {

        if($contrasena == "123") {

            header('Location: ../views/home.html');
        }
    } else {
        header('Location: ../../index.html');
    }

?>