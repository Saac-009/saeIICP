<?php
require_once "../conexion.php";

$idprof = isset($_GET['idprof']) ? intval($_GET['idprof']) : 0;
$profesor = null;

if ($idprof > 0) {
    $stmt = $mysqli->prepare("SELECT * FROM profesores WHERE idprof = ?");
    $stmt->bind_param("i", $idprof);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $profesor = $resultado->fetch_assoc();
}

if (!$profesor) {
    header("Location: ../CRUDE/crudeprofesores.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nocontrol = $_POST['nocontrol_prof'];
    $nombre = $_POST['nombre_prof'];
    $apaterno = $_POST['apaterno_prof'];
    $amaterno = $_POST['amaterno_prof'];
    $email = $_POST['mail_prof'];

    $stmt_update = $mysqli->prepare("UPDATE profesores SET nocontrol_prof=?, nombre_prof=?, apaterno_prof=?, amaterno_prof=?, mail_prof=? WHERE idprof=?");
    $stmt_update->bind_param("sssssi", $nocontrol, $nombre, $apaterno, $amaterno, $email, $idprof);

    if ($stmt_update->execute()) {
        header("Location: ../CRUDE/crudeprofesores.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include_once "../navegacion.php"; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4>Modificar Profesor</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">No. Control</label>
                            <input type="text" name="nocontrol_prof" class="form-control" value="<?php echo htmlspecialchars($profesor['nocontrol_prof']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre_prof" class="form-control" value="<?php echo htmlspecialchars($profesor['nombre_prof']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Apellido Paterno</label>
                            <input type="text" name="apaterno_prof" class="form-control" value="<?php echo htmlspecialchars($profesor['apaterno_prof']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Apellido Materno</label>
                            <input type="text" name="amaterno_prof" class="form-control" value="<?php echo htmlspecialchars($profesor['amaterno_prof']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="mail_prof" class="form-control" value="<?php echo htmlspecialchars($profesor['mail_prof']); ?>" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="../CRUDE/crudeprofesores.php" class="btn btn-secondary">Cancelar</a>
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