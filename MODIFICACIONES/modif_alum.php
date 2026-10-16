<?php
require_once "../conexion.php";

$idalumn = isset($_GET['idalumn']) ? intval($_GET['idalumn']) : 0;
$alumno = null;

if ($idalumn > 0) {
    $stmt = $mysqli->prepare("SELECT * FROM alumnos WHERE idalumn = ?");
    $stmt->bind_param("i", $idalumn);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $alumno = $resultado->fetch_assoc();
}

if (!$alumno) {
    header("Location: ../CRUDE/crudealumnos.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricula = $_POST['matricula_al'];
    $nombre = $_POST['nombre_al'];
    $apaterno = $_POST['apaterno_al'];
    $amaterno = $_POST['amaterno_al'];
    $domicilio = $_POST['dom_al'];
    $email = $_POST['mail_al'];

    $stmt_update = $mysqli->prepare("UPDATE alumnos SET matricula_al=?, nombre_al=?, apaterno_al=?, amaterno_al=?, dom_al=?, mail_al=? WHERE idalumn=?");
    $stmt_update->bind_param("ssssssi", $matricula, $nombre, $apaterno, $amaterno, $domicilio, $email, $idalumn);

    if ($stmt_update->execute()) {
        header("Location: ../CRUDE/crudealumnos.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include_once "../navegacion.php"; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4>Modificar Alumno</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Matrícula</label>
                            <input type="text" name="matricula_al" class="form-control" value="<?php echo htmlspecialchars($alumno['matricula_al']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre_al" class="form-control" value="<?php echo htmlspecialchars($alumno['nombre_al']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Apellido Paterno</label>
                            <input type="text" name="apaterno_al" class="form-control" value="<?php echo htmlspecialchars($alumno['apaterno_al']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Apellido Materno</label>
                            <input type="text" name="amaterno_al" class="form-control" value="<?php echo htmlspecialchars($alumno['amaterno_al']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Domicilio</label>
                            <input type="text" name="dom_al" class="form-control" value="<?php echo htmlspecialchars($alumno['dom_al']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="mail_al" class="form-control" value="<?php echo htmlspecialchars($alumno['mail_al']); ?>" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="../CRUDE/crudealumnos.php" class="btn btn-secondary">Cancelar</a>
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