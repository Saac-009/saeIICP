<?php
include '../conexion.php'; 
if (!isset($conexion) && isset($mysqli)) $conexion = $mysqli;

$nocontrol = trim($_POST['nocontrol_alum'] ?? '');
$nombre = trim($_POST['nombre_alum'] ?? '');
$apaterno = trim($_POST['apaterno_alum'] ?? '');
$amaterno = trim($_POST['amaterno_alum'] ?? '');
$domicilio = trim($_POST['dom_alum'] ?? '');
$correo = trim($_POST['mail_alum'] ?? '');
$telefono = trim($_POST['tel_alum'] ?? '');

$exito = false;
$mensaje = "";

if ($conexion && !empty($nombre)) {
    $nocontrol_e = mysqli_real_escape_string($conexion, $nocontrol);
    $nombre_e = mysqli_real_escape_string($conexion, $nombre);
    $apaterno_e = mysqli_real_escape_string($conexion, $apaterno);
    $amaterno_e = mysqli_real_escape_string($conexion, $amaterno);
    $domicilio_e = mysqli_real_escape_string($conexion, $domicilio);
    $correo_e = mysqli_real_escape_string($conexion, $correo);
    $telefono_e = mysqli_real_escape_string($conexion, $telefono);

    $sql = "INSERT INTO alumnos (nocontrol, nombre, apaterno, amaterno, domicilio, correo, telefono) 
            VALUES ('$nocontrol_e', '$nombre_e', '$apaterno_e', '$amaterno_e', '$domicilio_e', '$correo_e', '$telefono_e')";

    if (mysqli_query($conexion, $sql)) {
        $exito = true;
        $mensaje = "¡Alumno registrado con éxito!";
    } else {
        $mensaje = "Error al registrar: " . mysqli_error($conexion);
    }
} else {
    $mensaje = "Por favor ingrese al menos el nombre del alumno.";
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
                        <a href="../REGISTRO/alumnos.php" class="btn btn-outline-secondary px-4">Registrar Otro</a>
                        <a href="../CRUDE/crudealumnos.php" class="btn btn-primary fw-bold px-4" style="background: #1e3c72; border: none;">Ver Alumnos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../NAVEGACION/footer.php'; ?>