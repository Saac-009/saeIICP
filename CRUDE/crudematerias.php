<?php
include('../NAVEGACION/header.php');

if ($_SESSION['rol'] !== 'ADMIN') {
    header("Location: crudealumnos.php");
    exit();
}

include('../NAVEGACION/navegacion.php');
include('../conexion.php');

$query = "SELECT * FROM materias WHERE estatus != 'BAJA' OR estatus IS NULL ORDER BY id ASC";
$resultado = mysqli_query($conexion, $query);
?>

<div class="container my-4">

    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'success' || $_GET['status'] === 'updated'): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>¡Éxito!</strong> Los datos de la materia fueron actualizados correctamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($_GET['status'] === 'error'): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Error:</strong> Ocurrió un problema al guardar las modificaciones. Inténtalo de nuevo.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-3 bg-white p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Control de Materias</h4>
                <small class="text-muted">Listado general de materias activas</small>
            </div>
            <a href="../REGISTRO/materias.php" class="text-dark text-decoration-none fw-bold small">+ Nueva Materia</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center" style="font-size: 0.9rem;">
                <thead class="table-light text-uppercase small border-bottom">
                    <tr>
                        <th style="width: 15%;">ID</th>
                        <th class="text-start">NOMBRE DE LA MATERIA</th>
                        <th style="width: 25%;">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><span class="badge bg-primary-subtle text-primary fw-bold"><?= $row['id'] ?></span></td>
                            <td class="fw-semibold text-start"><?= htmlspecialchars($row['nombre']) ?></td>
                            <td>
                                <a href="../MODIFICACIONES/modif_mat.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary py-0 px-2">Editar</a>
                                <a href="../BAJA/baja_mat.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="return confirm('¿Desea dar de baja esta materia?');">Eliminar</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="py-4 text-muted">No se encontraron materias registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('../NAVEGACION/footer.php'); ?>