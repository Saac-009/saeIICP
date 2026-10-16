<?php
require_once "../conexion.php";

$idgrupo = isset($_GET['idgrupo']) ? intval($_GET['idgrupo']) : 0;
$grupo = null;

if ($idgrupo > 0) {
    $stmt = $mysqli->prepare("SELECT * FROM grupo WHERE idgrupo = ?");
    $stmt->bind_param("i", $idgrupo);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $grupo = $resultado->fetch_assoc();
}

if (!$grupo) {
    header("Location: ../CRUDE/crudegrupos.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcion = $_POST['des_grupo'];

    $stmt_update = $mysqli->prepare("UPDATE grupo SET des_grupo=? WHERE idgrupo=?");
    $stmt_update->bind_param("si", $descripcion, $idgrupo);

    if ($stmt_update->execute()) {
        header("Location: ../CRUDE/crudegrupos.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Grupo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include_once "../navegacion.php"; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4>Modificar Grupo</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Descripción / Nombre del Grupo</label>
                            <input type="text" name="des_grupo" class="form-control" value="<?php echo htmlspecialchars($grupo['des_grupo'] ?? ''); ?>" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="../CRUDE/crudegrupos.php" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>