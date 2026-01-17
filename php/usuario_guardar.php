<?php

require_once "main.php";

//almcacenar los datos que vienen del formulario y usamos el metodo limpiar cadena
$nombre = limpiar_cadena($_POST['usuario_nombre']);
$apellido = limpiar_cadena($_POST['usuario_apellido']);
$usuario = limpiar_cadena($_POST['usuario_usuario']);
$email = limpiar_cadena($_POST['usuario_email']);
$clave_1 = limpiar_cadena($_POST['usuario_clave_1']);
$clave_2 = limpiar_cadena($_POST['usuario_clave_2']);


// verificar campos obligatorios esto backend
//si estos campos vienen vacios dan un alerta de error
if ($nombre == "" || $apellido == "" || $usuario == "" || $clave_1 == "" || $clave_2 == "") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
    ';
    exit();
}



//verificar integridad de los datos
//los datos que vienen del formulario deben cumplir con los patrones establecidos
//patrones son letras
//esta es la parte del backend

//se ara el: nombre, apellido, usuario, clave
if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El NOMBRE no coincide con el formato solicitado
        </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El APELLIDO no coincide con el formato solicitado
        </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El USUARIO no coincide con el formato solicitado
        </div>
    ';
    exit();
}



if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_1)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La CLAVE no coincide con el formato solicitado
        </div>
    ';
    exit();
}

//verificar correo electronico existe y su formato 
if ($email!="") {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $check_email = conexion();
        $check_email = $check_email->query("SELECT usuario_email FROM usuario
         WHERE usuario_email='$email'");
         if ($check_email->rowCount()>0) {
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El CORREO ELECTRONICO ya esta registrado
            </div>
        ';
        exit();
         }
         $check_email = null;
        //el email es valido
    } else {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El CORREO ELECTRONICO no coincide con el formato solicitado
        </div>
    ';
    exit();
}
}

# verificar que no exista otro usuario mismo nombre
$check_usuario = conexion();
$check_usuario = $check_usuario->query("SELECT usuario_usuario FROM usuario
 WHERE usuario_usuario='$usuario'");
if ($check_usuario->rowCount() > 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El NOMBRE DE USUARIO ya esta registrado, por favor elija otro
        </div>
    ';
    exit();
}
$check_usuario = null;



# verificacion de las claves 

//las claves deben ser iguales 
if ($clave_1 != $clave_2) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Las CLAVES no coinciden
        </div>
    ';
    exit();
}else{
    //encriptar la clave
    $clave = password_hash($clave_1, PASSWORD_BCRYPT, ["cost" => 10]);
}


//guardar datos en la base de datos
$guardar_usuario = conexion();
$guardar_usuario = $guardar_usuario->prepare("INSERT INTO usuario(
    usuario_nombre,usuario_apellido,usuario_usuario,usuario_email,usuario_clave
) VALUES (
    :nombre,:apellido,:usuario,:email,:clave
)");

$marcadores = [
    ":nombre" => $nombre,
    ":apellido" => $apellido,
    ":usuario" => $usuario,
    ":email" => $email,
    ":clave" => $clave
];  

$guardar_usuario->execute($marcadores);

if ($guardar_usuario->rowCount()==1) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡USUARIO REGISTRADO!</strong><br>
            El usuario se ha registrado con exito
        </div>
    ';
    exit();
}else{
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar el usuario, por favor intente nuevamente
        </div>
    ';
    exit();
}
$guardar_usuario = null;

?>