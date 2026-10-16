<?php
include '../conexion.php'; 
if (!isset($conexion) && isset($mysqli)) $conexion = $mysqli;

$nombre = trim($_POST['nombre'] ?? $_POST['descripcion_grupo'] ?? '');
$exito = false;
$mensaje = "";

if ($conexion && !empty($nombre)) {
    $nom_e = mysqli_real_escape_string($conexion, $nombre);
    $sql = "INSERT INTO grupo (nombre) VALUES ('$nom_e')";

    if (mysqli_query($conexion, $sql)) {
        $exito = true;
        $mensaje = "¡Grupo registrado con éxito!";
    } else {
        $mensaje = "Error al registrar el grupo: " . mysqli_error($conexion);
    }
} else {
    $mensaje = "Por favor ingrese el nombre del grupo.";
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
                        <a href="../REGISTRO/grupos.php" class="btn btn-outline-secondary px-4">Registrar Otro</a>
                        <a href="../CRUDE/crudegrupos.php" class="btn btn-primary fw-bold px-4" style="background: #1e3c72; border: none;">Ver Grupos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../NAVEGACION/footer.php'; ?>