<?php
session_start();
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_input = trim($_POST['usuario']);
    $password    = trim($_POST['password']);

    if (empty($login_input) || empty($password)) {
        header("Location: login.php?error=1");
        exit();
    }

    // Limpieza de caracteres para prevenir inyección SQL
    $input_clean = mysqli_real_escape_string($conexion, $login_input);
    $pass_clean  = mysqli_real_escape_string($conexion, $password);

    // 1. EVALUAR ADMINISTRADORES (Por usuario)
    $query_admin = "SELECT id, usuario, nombre FROM administradores 
                    WHERE usuario = '$input_clean' 
                    AND password = '$pass_clean' LIMIT 1";
    $res_admin = mysqli_query($conexion, $query_admin);

    if ($res_admin && mysqli_num_rows($res_admin) > 0) {
        $data = mysqli_fetch_assoc($res_admin);
        $_SESSION['id_usuario'] = $data['id'];
        $_SESSION['usuario']    = $data['usuario'];
        $_SESSION['nombre']     = $data['nombre'];
        $_SESSION['rol']        = 'ADMIN';

        header("Location: PROCESO/captura_calificaciones.php");
        exit();
    }

    // 2. EVALUAR PROFESORES (Por usuario/nocontrol O correo)
    $query_prof = "SELECT id, usuario, nombre, apaterno FROM profesores 
                   WHERE (usuario = '$input_clean' OR nocontrol = '$input_clean' OR correo = '$input_clean') 
                   AND password = '$pass_clean' 
                   AND (estatus != 'BAJA' OR estatus IS NULL) LIMIT 1";
    $res_prof = mysqli_query($conexion, $query_prof);

    if ($res_prof && mysqli_num_rows($res_prof) > 0) {
        $data = mysqli_fetch_assoc($res_prof);
        $_SESSION['id_usuario'] = $data['id'];
        $_SESSION['usuario']    = $data['usuario'];
        $_SESSION['nombre']     = trim($data['nombre'] . ' ' . $data['apaterno']);
        $_SESSION['rol']        = 'PROFESOR';

        header("Location: PROCESO/captura_calificaciones.php");
        exit();
    }

    // 3. EVALUAR ALUMNOS (Por usuario/nocontrol O correo)
    $query_alum = "SELECT id, usuario, nombre, apaterno FROM alumnos 
                   WHERE (usuario = '$input_clean' OR nocontrol = '$input_clean' OR correo = '$input_clean') 
                   AND password = '$pass_clean' 
                   AND (estatus != 'BAJA' OR estatus IS NULL) LIMIT 1";
    $res_alum = mysqli_query($conexion, $query_alum);

    if ($res_alum && mysqli_num_rows($res_alum) > 0) {
        $data = mysqli_fetch_assoc($res_alum);
        $_SESSION['id_usuario'] = $data['id'];
        $_SESSION['usuario']    = $data['usuario'];
        $_SESSION['nombre']     = trim($data['nombre'] . ' ' . $data['apaterno']);
        $_SESSION['rol']        = 'ALUMNO';

        header("Location: REPORTES/alumnos.php");
        exit();
    }

    // Si no coincide ninguna combinación en la BD
    header("Location: login.php?error=1");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>