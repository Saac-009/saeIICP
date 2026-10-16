<?php
include '../conexion.php'; 
if (!isset($conexion) && isset($mysqli)) $conexion = $mysqli;

// Capturar el valor enviado desde el formulario de registros
$nombre = trim($_POST['nombre'] ?? $_POST['nombre_materia'] ?? $_POST['descripcion_materia'] ?? '');
$exito = false;
$mensaje = "";

if ($conexion && !empty($nombre)) {
    $nom_e = mysqli_real_escape_string($conexion, $nombre);
    
    // Insertar la materia asegurando el estatus ALTA
    $sql = "INSERT INTO materias (nombre, estatus) VALUES ('$nom_e', 'ALTA')";

    if (mysqli_query($conexion, $sql)) {
        $exito = true;
        $mensaje = "¡Materia registrada con éxito!";
    } else {
        $mensaje = "Error al registrar en base de datos: " . mysqli_error($conexion);
    }
} else {
    $mensaje = "Por favor ingrese el nombre o descripción de la materia.";
}

include '../NAVEGACION/header.php';
include '../NAVEGACION/navegacion.php';
?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header custom-header p-4 text-center">
                    <h4 class="mb-0 fw-bold">Resultado del Proceso</h4>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="alert <?php echo $exito ? 'alert-success' : 'alert-danger'; ?> p-4 mb-4">
                        <h5 class="fw-bold mb-0"><?php echo $mensaje; ?></h5>
                    </div>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="../REGISTRO/materias.php" class="btn btn-outline-secondary px-4">Registrar Otra</a>
                        <a href="../CRUDE/crudematerias.php" class="btn btn-primary fw-bold px-4" style="background: #1e3c72; border: none;">Ver Materias</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../NAVEGACION/footer.php'; ?>