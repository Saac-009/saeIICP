<?php
include("../conexion.php");

// Soporta tanto ?id= como ?id_alumno=
$id = intval($_GET['id'] ?? $_GET['id_alumno'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id        = intval($_POST['id']);
    $nocontrol = $_POST['nocontrol'];
    $nombre    = $_POST['nombre'];
    $apaterno  = $_POST['apaterno'];
    $amaterno  = $_POST['amaterno'];
    $domicilio = $_POST['domicilio'];
    $correo    = $_POST['correo'];
    $telefono  = $_POST['telefono'];
    $id_grupo  = intval($_POST['id_grupo']);

    $query = "UPDATE alumnos SET 
                nocontrol = '$nocontrol', nombre = '$nombre', apaterno = '$apaterno', amaterno = '$amaterno', 
                domicilio = '$domicilio', correo = '$correo', telefono = '$telefono', id_grupo = $id_grupo 
              WHERE id = $id";

    if (mysqli_query($conexion, $query)) {
        header("Location: ../CRUDE/crudealumnos.php?status=updated");
        exit();
    }
}

// Consultar datos del alumno
$res = mysqli_query($conexion, "SELECT * FROM alumnos WHERE id = $id");
$alumno = mysqli_fetch_assoc($res);

if (!$alumno) {
    header("Location: ../CRUDE/crudealumnos.php");
    exit();
}

// Consultar grupos
$res_grupos = mysqli_query($conexion, "SELECT id, nombre FROM grupo WHERE estatus = 'ALTA'");

include("../NAVEGACION/header.php");
include("../NAVEGACION/navegacion.php");
?>

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header text-white p-3" style="background-color: #1f4287 !important;">
            <h4 class="m-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Modificar Alumno</h4>
        </div>
        <div class="card-body">
            <form action="modif_alum.php" method="POST" class="row g-3">
                <input type="hidden" name="id" value="<?= $alumno['id'] ?>">

                <div class="col-md-4">
                    <label class="form-label fw-semibold">No. Control</label>
                    <input type="text" name="nocontrol" class="form-control" value="<?= htmlspecialchars($alumno['nocontrol'] ?? '') ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($alumno['nombre']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Apellido Paterno</label>
                    <input type="text" name="apaterno" class="form-control" value="<?= htmlspecialchars($alumno['apaterno']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Apellido Materno</label>
                    <input type="text" name="amaterno" class="form-control" value="<?= htmlspecialchars($alumno['amaterno']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Grupo</label>
                    <select name="id_grupo" class="form-select" required>
                        <?php while($gr = mysqli_fetch_assoc($res_grupos)): ?>
                            <option value="<?= $gr['id'] ?>" <?= ($gr['id'] == $alumno['id_grupo']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($gr['nombre']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($alumno['telefono'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Correo Electrónico</label>
                    <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($alumno['correo'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Domicilio</label>
                    <input type="text" name="domicilio" class="form-control" value="<?= htmlspecialchars($alumno['domicilio'] ?? '') ?>">
                </div>

                <div class="col-12 text-end mt-4">
                    <a href="../CRUDE/crudealumnos.php" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn text-white px-4" style="background-color: #1f4287 !important;">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("../NAVEGACION/footer.php"); ?>