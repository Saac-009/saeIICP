<?php
session_start();
if (isset($_SESSION['usuario'])) {
    if ($_SESSION['rol'] === 'ALUMNO') {
        header("Location: REPORTES/alumnos.php");
    } else {
        header("Location: PROCESO/captura_calificaciones.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Escuela IICP</title>
    <link rel="stylesheet" href="ASSETS/CSS/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

<div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="max-width: 400px; width: 100%;">
    <div class="card-header text-white text-center p-4" style="background-color: #1f4287 !important;">
        <h3 class="fw-bold mb-0">ESCUELA IICP</h3>
        <small class="opacity-75">Sistema de Control Escolar</small>
    </div>
    <div class="card-body p-4">
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <small><strong>Error:</strong> Credenciales incorrectas.</small>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="validar.php" method="POST">
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary small text-uppercase">Usuario / Correo Electrónico</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary"><i class="bi bi-person"></i></span>
                    <input type="text" name="usuario" class="form-control" placeholder="Ej. 00001 o usuario@correo.com" required autocomplete="username">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary small text-uppercase">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
                </div>
            </div>

            <button type="submit" class="btn text-white w-100 fw-bold py-2 shadow-sm" style="background-color: #1f4287 !important;">
                Iniciar Sesión
            </button>
        </form>
    </div>
</div>

<script src="ASSETS/JS/bootstrap.bundle.min.js"></script>
</body>
</html>