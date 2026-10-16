<?php
include '../conexion.php'; 
if (!isset($conexion) && isset($mysqli)) $conexion = $mysqli;

$id_unidad = intval($_POST['id_unidad'] ?? 0);
$descripcion = trim($_POST['descripcion'] ?? '');
$exito = false;
$mensaje = "";

if ($conexion && $id_unidad > 0 && !empty($descripcion)) {
    $desc_e = mysqli_real_escape_string($conexion, $descripcion);
    
    // Insertar ID explícito y la descripción
    $sql = "INSERT INTO unidades (id, descripcion, estatus) VALUES ($id_unidad, '$desc_e', 'ALTA')";

    if (mysqli_query($conexion, $sql)) {
        $exito = true;
        $mensaje = "¡Unidad $id_unidad registrada correctamente!";
    } else {
        $mensaje = "Error al registrar la unidad: " . mysqli_error($conexion);
    }
} else {
    $mensaje = "Por favor ingrese un ID válido y la descripción de la unidad.";
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
                        <a href="../REGISTRO/unidades.php" class="btn btn-outline-secondary px-4">Registrar Otra</a>
                        <a href="../PROCESO/captura_calificaciones.php" class="btn btn-primary fw-bold px-4" style="background: #1e3c72; border: none;">Capturar Calificaciones</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../NAVEGACION/footer.php'; ?>