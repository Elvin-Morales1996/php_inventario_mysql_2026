<?php

//almacenar las variables de los campos del formulario
//limpiar las cadenas para evitar inyecciones sql de la funcion limpiar_cadena o codigo malicioso
$usuario = limpiar_cadena($_POST['login_usuario']);
$clave = limpiar_cadena($_POST['login_clave']);


//campos obligatorios en el backend
if ($usuario == "" || $clave == "") {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>
    ';
    exit();
}

//verificar formato de los campos que tiene el formulario 
if (verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El NOMBRE DE USUARIO no coincide con el formato solicitado
    </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave)) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        La CLAVE no coincide con el formato solicitado
    </div>
    ';
    exit();
}

//verificar si el usuario existe en la base de datos
$check_usuario = conexion();
$check_usuario = $check_usuario->query("SELECT * FROM usuario WHERE usuario_usuario='$usuario'");
if ($check_usuario->rowCount() <= 1) {
    $check_usuario = $check_usuario->fetch();

    if (
        $check_usuario['usuario_usuario'] == $usuario &&
        password_verify($clave, $check_usuario['usuario_clave'])
    ) {
        //iniciar sesion

        $_SESSION['id'] = $check_usuario['usuario_id'];
        $_SESSION['nombre'] = $check_usuario['usuario_nombre'];
        $_SESSION['apellido'] = $check_usuario['usuario_apellido'];
        $_SESSION['usuario'] = $check_usuario['usuario_usuario'];

        if (headers_sent()) {
            echo "<script> window.location.href='index.php?vista=home'; </script>";
        } else {
            header("Location: index.php?vista=home");
        }
    } else {
        echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El USUARIO o CLAVE son incorrectos
    </div>
    ';
        exit();
    }
} else {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        El USUARIO o CLAVE son incorrectos
    </div>
    ';
    exit();
}

$check_usuario = null;
