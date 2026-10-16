<?php
include '../conexion.php'; 
if (!isset($conexion) && isset($mysqli)) $conexion = $mysqli;

include '../NAVEGACION/header.php';
include '../NAVEGACION/navegacion.php';

$id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
$confirmado = isset($_POST['confirmar_baja']);
$exito = false;
$mensaje = "";

// 1. Si el usuario ya hizo clic en "Sí, Confirmar Baja"
if ($confirmado && $id > 0) {
    $sql_update = "UPDATE alumnos SET estatus = 'BAJA' WHERE id = $id";
    if (mysqli_query($conexion, $sql_update)) {
        $exito = true;
        $mensaje = "¡El alumno ha sido dado de baja correctamente!";
    } else {
        $mensaje = "Error al dar de baja: " . mysqli_error($conexion);
    }
}

// 2. Consultar los datos del alumno para mostrar en el recuadro
$alumno = null;
if ($id > 0) {
    $res = mysqli_query($conexion, "SELECT * FROM alumnos WHERE id = $id");
    if ($res && mysqli_num_rows($res) > 0) {
        $alumno = mysqli_fetch_assoc($res);
    }
}
?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <?php if ($confirmado): ?>
                <!-- Notificación posterior a la confirmación -->
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden text-center">
                    <div class="card-header custom-header p-4">
                        <h4 class="mb-0 fw-bold">Resultado del Proceso</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert <?php echo $exito ? 'alert-success' : 'alert-danger'; ?> p-4 mb-4">
                            <h5 class="fw-bold mb-0"><?php echo $mensaje; ?></h5>
                        </div>
                        <a href="../CRUDE/crudealumnos.php" class="btn btn-primary fw-bold px-4" style="background: #1e3c72; border: none;">Volver al Catálogo</a>
                    </div>
                </div>

            <?php elseif ($alumno): ?>
                <!-- Recuadro con los datos del alumno y confirmación -->
                <div class="card border-danger shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-danger text-white p-4">
                        <h4 class="mb-0 fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmación de Baja</h4>
                        <small class="opacity-75">¿Está seguro de que desea dar de baja al siguiente alumno?</small>
                    </div>
                    <div class="card-body p-4">
                        <div class="bg-light p-3 rounded-3 mb-4 border">
                            <div class="row mb-2">
                                <div class="col-4 text-muted fw-semibold">ID:</div>
                                <div class="col-8 fw-bold text-dark">#<?php echo htmlspecialchars($alumno['id']); ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-muted fw-semibold">No. Control:</div>
                                <div class="col-8 fw-bold text-dark"><?php echo htmlspecialchars($alumno['nocontrol'] ?? '-'); ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-muted fw-semibold">Nombre:</div>
                                <div class="col-8 fw-bold text-dark">
                                    <?php echo htmlspecialchars(trim(($alumno['nombre'] ?? '') . ' ' . ($alumno['apaterno'] ?? '') . ' ' . ($alumno['amaterno'] ?? ''))); ?>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-muted fw-semibold">Correo:</div>
                                <div class="col-8 text-dark"><?php echo htmlspecialchars($alumno['correo'] ?? '-'); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-muted fw-semibold">Teléfono:</div>
                                <div class="col-8 text-dark"><?php echo htmlspecialchars($alumno['telefono'] ?? '-'); ?></div>
                            </div>
                        </div>

                        <form action="baja_alum.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $alumno['id']; ?>">
                            <input type="hidden" name="confirmar_baja" value="1">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="../CRUDE/crudealumnos.php" class="btn btn-outline-secondary fw-semibold">Cancelar</a>
                                <button type="submit" class="btn btn-danger fw-bold px-4">Sí, Confirmar Baja</button>
                            </div>
                        </form>
                    </div>
                </div>

            <?php else: ?>
                <!-- ID no válido -->
                <div class="alert alert-warning text-center p-4">
                    <h5 class="fw-bold">Alumno no encontrado</h5>
                    <a href="../CRUDE/crudealumnos.php" class="btn btn-primary mt-2">Volver al Catálogo</a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include '../NAVEGACION/footer.php'; ?>