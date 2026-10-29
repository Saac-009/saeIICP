<?php
include("../conexion.php");

$id = intval($_GET['id'] ?? $_GET['id_grupo'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = intval($_POST['id']);
    $nombre = $_POST['nombre'];

    $query = "UPDATE grupo SET nombre = '$nombre' WHERE id = $id";

    if (mysqli_query($conexion, $query)) {
        header("Location: ../CRUDE/crudegrupos.php?status=updated");
        exit();
    }
}

$res = mysqli_query($conexion, "SELECT * FROM grupo WHERE id = $id");
$grupo = mysqli_fetch_assoc($res);

if (!$grupo) {
    header("Location: ../CRUDE/crudegrupos.php");
    exit();
}

include("../NAVEGACION/header.php");
include("../NAVEGACION/navegacion.php");
?>

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header text-white p-3" style="background-color: #1f4287 !important;">
            <h4 class="m-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Modificar Grupo</h4>
        </div>
        <div class="card-body">
            <form action="modif_grupo.php" method="POST" class="row g-3">
                <input type="hidden" name="id" value="<?= $grupo['id'] ?>">

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Nombre del Grupo</label>
                    <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($grupo['nombre']) ?>" required>
                </div>

                <div class="col-12 text-end mt-4">
                    <a href="../CRUDE/crudegrupos.php" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn text-white px-4" style="background-color: #1f4287 !important;">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("../NAVEGACION/footer.php"); ?>