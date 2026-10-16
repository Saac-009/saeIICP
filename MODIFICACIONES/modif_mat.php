<?php
require_once "../conexion.php";

$idmateria = isset($_GET['idmateria']) ? intval($_GET['idmateria']) : 0;
$materia = null;

if ($idmateria > 0) {
    $stmt = $mysqli->prepare("SELECT * FROM materias WHERE idmateria = ?");
    $stmt->bind_param("i", $idmateria);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $materia = $resultado->fetch_assoc();
}

if (!$materia) {
    header("Location: ../CRUDE/crudematerias.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcion = $_POST['descripcion_mat'];

    $stmt_update = $mysqli->prepare("UPDATE materias SET descripcion_mat=? WHERE idmateria=?");
    $stmt_update->bind_param("si", $descripcion, $idmateria);

    if ($stmt_update->execute()) {
        header("Location: ../CRUDE/crudematerias.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Materia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include_once "../navegacion.php"; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4>Modificar Materia</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Descripción / Nombre de la Materia</label>
                            <input type="text" name="descripcion_mat" class="form-control" value="<?php echo htmlspecialchars($materia['descripcion_mat']); ?>" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="../CRUDE/crudematerias.php" class="btn btn-secondary">Cancelar</a>
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