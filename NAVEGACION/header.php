<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Escuela IICP</title>
    <link rel="stylesheet" href="../ASSETS/CSS/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
      /* Permite desplegar el submenú secundario en el navbar */
      .dropdown-menu .dropend:hover .dropdown-menu {
        display: block;
        position: absolute;
        top: 0;
        left: 100%;
        margin-top: -1px;
      }
    </style>
</head>
<body>