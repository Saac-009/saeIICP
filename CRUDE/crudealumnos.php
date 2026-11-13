<?php
include('../NAVEGACION/header.php');

// Restricción: Los alumnos no pueden acceder a la gestión de alumnos
if ($_SESSION['rol'] === 'ALUMNO') {
    header("Location: ../REPORTES/alumnos.php");
    exit();
}

include('../NAVEGACION/navegacion.php');
include('../conexion.php');

$query = "SELECT a.*, g.nombre AS nombre_grupo 
          FROM alumnos a 
          LEFT JOIN grupo g ON a.id_grupo = g.id 
          WHERE a.estatus != 'BAJA' OR a.estatus IS NULL 
          ORDER BY a.id ASC";
$resultado = mysqli_query($conexion, $query);
?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold mb-0">Control de Alumnos</h3>
            <small class="text-muted">Listado general de alumnos activos</small>
        </div>
        <?php if ($_SESSION['rol'] === 'ADMIN'): ?>
            <a href="../REGISTRO/alumnos.php" class="btn btn-sm btn-outline-dark fw-bold">+ Nuevo Alumno</a>
        <?php endif; ?>
    </div>

    <!-- BLOQUE DE ALERTA DE EXITO O ERROR DE MODIFICACION -->
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>¡Éxito!</strong> Los datos del alumno fueron actualizados correctamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($_GET['status'] === 'error'): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Error:</strong> Ocurrió un problema al guardar las modificaciones. Inténtalo de nuevo.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center" style="font-size: 0.9rem;">
                <thead class="table-light text-uppercase small border-bottom">
                    <tr>
                        <th>ID</th>
                        <th>NO. CONTROL</th>
                        <th>NOMBRE COMPLETO</th>
                        <th>DOMICILIO</th>
                        <th>CORREO ELECTRÓNICO</th>
                        <th>TELÉFONO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><span class="badge bg-primary-subtle text-primary fw-bold"><?= $row['id'] ?></span></td>
                            <td class="fw-bold text-secondary"><?= htmlspecialchars($row['nocontrol'] ?? '') ?></td>
                            <td class="fw-semibold text-start"><?= htmlspecialchars($row['nombre'] . ' ' . $row['apaterno'] . ' ' . $row['amaterno']) ?></td>
                            <td class="text-secondary"><?= htmlspecialchars($row['domicilio'] ?? '') ?></td>
                            <td class="text-secondary"><?= htmlspecialchars($row['correo'] ?? '') ?></td>
                            <td class="text-secondary"><?= htmlspecialchars($row['telefono'] ?? '') ?></td>
                            <td>
                                <a href="../MODIFICACIONES/modif_alum.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary py-0 px-2">Editar</a>
                                <?php if ($_SESSION['rol'] === 'ADMIN'): ?>
                                    <a href="../BAJA/baja_alum.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="return confirm('¿Desea dar de baja este alumno?');">Eliminar</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="py-4 text-muted">No se encontraron alumnos registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('../NAVEGACION/footer.php'); ?>