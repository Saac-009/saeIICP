<?php
include("../conexion.php");

$id = intval($_GET['id'] ?? $_GET['id_profesor'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id        = intval($_POST['id']);
    $nocontrol = $_POST['nocontrol'];
    $nombre    = $_POST['nombre'];
    $apaterno  = $_POST['apaterno'];
    $amaterno  = $_POST['amaterno'];
    $domicilio = $_POST['domicilio'];
    $correo    = $_POST['correo'];
    $telefono  = $_POST['telefono'];

    $query = "UPDATE profesores SET 
                nocontrol = '$nocontrol', nombre = '$nombre', apaterno = '$apaterno', amaterno = '$amaterno', 
                domicilio = '$domicilio', correo = '$correo', telefono = '$telefono' 
              WHERE id = $id";

    if (mysqli_query($conexion, $query)) {
        header("Location: ../CRUDE/crudeprofesores.php?status=updated");
        exit();
    }
}

$res = mysqli_query($conexion, "SELECT * FROM profesores WHERE id = $id");
$profesor = mysqli_fetch_assoc($res);

if (!$profesor) {
    header("Location: ../CRUDE/crudeprofesores.php");
    exit();
}

include("../NAVEGACION/header.php");
include("../NAVEGACION/navegacion.php");
?>

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header text-white p-3" style="background-color: #1f4287 !important;">
            <h4 class="m-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Modificar Profesor</h4>
        </div>
        <div class="card-body">
            <form action="modif_prof.php" method="POST" class="row g-3">
                <input type="hidden" name="id" value="<?= $profesor['id'] ?>">

                <div class="col-md-3">
                    <label class="form-label fw-semibold">No. Control</label>
                    <input type="text" name="nocontrol" class="form-control" value="<?= htmlspecialchars($profesor['nocontrol'] ?? '') ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($profesor['nombre']) ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Apellido Paterno</label>
                    <input type="text" name="apaterno" class="form-control" value="<?= htmlspecialchars($profesor['apaterno']) ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Apellido Materno</label>
                    <input type="text" name="amaterno" class="form-control" value="<?= htmlspecialchars($profesor['amaterno']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($profesor['telefono'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Correo Electrónico</label>
                    <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($profesor['correo'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Domicilio</label>
                    <input type="text" name="domicilio" class="form-control" value="<?= htmlspecialchars($profesor['domicilio'] ?? '') ?>">
                </div>

                <div class="col-12 text-end mt-4">
                    <a href="../CRUDE/crudeprofesores.php" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn text-white px-4" style="background-color: #1f4287 !important;">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("../NAVEGACION/footer.php"); ?>