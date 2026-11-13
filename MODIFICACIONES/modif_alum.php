<?php
include('../NAVEGACION/header.php');

// Restricción: Los alumnos no pueden modificar datos
if ($_SESSION['rol'] === 'ALUMNO') {
    header("Location: ../REPORTES/alumnos.php");
    exit();
}

include('../NAVEGACION/navegacion.php');
include('../conexion.php');

// Procesar el guardado si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id        = intval($_POST['id']);
    $nocontrol = mysqli_real_escape_string($conexion, trim($_POST['nocontrol']));
    $nombre    = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $apaterno  = mysqli_real_escape_string($conexion, trim($_POST['apaterno']));
    $amaterno  = mysqli_real_escape_string($conexion, trim($_POST['amaterno']));
    $id_grupo  = intval($_POST['id_grupo']);
    $telefono  = mysqli_real_escape_string($conexion, trim($_POST['telefono']));
    $correo    = mysqli_real_escape_string($conexion, trim($_POST['correo']));
    $domicilio = mysqli_real_escape_string($conexion, trim($_POST['domicilio']));

    $query_update = "UPDATE alumnos SET 
                        nocontrol = '$nocontrol',
                        nombre = '$nombre',
                        apaterno = '$apaterno',
                        amaterno = '$amaterno',
                        id_grupo = '$id_grupo',
                        telefono = '$telefono',
                        correo = '$correo',
                        domicilio = '$domicilio'
                    WHERE id = '$id'";

    if (mysqli_query($conexion, $query_update)) {
        header("Location: ../CRUDE/crudealumnos.php?status=success");
        exit();
    } else {
        header("Location: ../CRUDE/crudealumnos.php?status=error");
        exit();
    }
}

// Obtener datos del alumno a editar
$id_edit = intval($_GET['id'] ?? 0);
$query_alum = "SELECT * FROM alumnos WHERE id = '$id_edit' LIMIT 1";
$res_alum = mysqli_query($conexion, $query_alum);

if (!$res_alum || mysqli_num_rows($res_alum) === 0) {
    header("Location: ../CRUDE/crudealumnos.php");
    exit();
}

$alumno = mysqli_fetch_assoc($res_alum);

// Consultar grupos para el select
$query_grupos = "SELECT * FROM grupo WHERE estatus != 'BAJA' OR estatus IS NULL";
$res_grupos = mysqli_query($conexion, $query_grupos);
?>

<div class="container my-4">
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header text-white p-3" style="background-color: #1f4287 !important;">
            <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Modificar Alumno</h5>
        </div>
        <div class="card-body p-4">
            <form action="modif_alum.php" method="POST">
                <input type="hidden" name="id" value="<?= $alumno['id'] ?>">

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary small">No. Control</label>
                        <input type="text" name="nocontrol" class="form-control" value="<?= htmlspecialchars($alumno['nocontrol'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary small">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($alumno['nombre'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary small">Apellido Paterno</label>
                        <input type="text" name="apaterno" class="form-control" value="<?= htmlspecialchars($alumno['apaterno'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary small">Apellido Materno</label>
                        <input type="text" name="amaterno" class="form-control" value="<?= htmlspecialchars($alumno['amaterno'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary small">Grupo</label>
                        <select name="id_grupo" class="form-select" required>
                            <?php while ($g = mysqli_fetch_assoc($res_grupos)): ?>
                                <option value="<?= $g['id'] ?>" <?= ($g['id'] == $alumno['id_grupo']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($g['nombre']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary small">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($alumno['telefono'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary small">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($alumno['correo'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary small">Domicilio</label>
                        <input type="text" name="domicilio" class="form-control" value="<?= htmlspecialchars($alumno['domicilio'] ?? '') ?>">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="../CRUDE/crudealumnos.php" class="btn btn-secondary fw-semibold">Cancelar</a>
                    <button type="submit" class="btn text-white fw-bold px-4" style="background-color: #1f4287 !important;">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('../NAVEGACION/footer.php'); ?>