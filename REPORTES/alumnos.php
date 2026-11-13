<?php
include('../NAVEGACION/header.php');
include('../NAVEGACION/navegacion.php');
include('../conexion.php');

$es_alumno = ($_SESSION['rol'] === 'ALUMNO');

if ($es_alumno) {
    // El alumno sólo consulta sus datos y calificaciones registradas
    $id_alumno = $_SESSION['id_usuario'];
    $query = "SELECT c.id, a.nocontrol, a.nombre, a.apaterno, a.amaterno, u.descripcion AS unidad, c.calificacion 
              FROM calificaciones c
              INNER JOIN alumnos a ON c.id_alumno = a.id
              INNER JOIN unidades u ON c.id_unidad = u.id
              WHERE a.id = '$id_alumno' AND (a.estatus != 'BAJA' OR a.estatus IS NULL)";
} else {
    // Admins y Profesores consultan el reporte completo
    $query = "SELECT c.id, a.nocontrol, a.nombre, a.apaterno, a.amaterno, u.descripcion AS unidad, c.calificacion 
              FROM calificaciones c
              INNER JOIN alumnos a ON c.id_alumno = a.id
              INNER JOIN unidades u ON c.id_unidad = u.id
              WHERE (a.estatus != 'BAJA' OR a.estatus IS NULL)";
}

$resultado = mysqli_query($conexion, $query);
?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold mb-0"><?= $es_alumno ? 'Mi Boleta de Calificaciones' : 'Reporte de Calificaciones de Alumnos' ?></h3>
            <small class="text-muted"><?= $es_alumno ? 'Consulta de calificaciones personales' : 'Consulta general del alumnado' ?></small>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center" style="font-size: 0.9rem;">
                <thead class="table-light text-uppercase small border-bottom">
                    <tr>
                        <th>NO. CONTROL</th>
                        <th>ALUMNO</th>
                        <th>UNIDAD / MATERIA</th>
                        <th>CALIFICACIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($resultado) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td class="fw-bold text-secondary"><?= htmlspecialchars($row['nocontrol'] ?? '') ?></td>
                            <td class="fw-semibold text-start"><?= htmlspecialchars($row['nombre'] . ' ' . $row['apaterno'] . ' ' . $row['amaterno']) ?></td>
                            <td class="text-secondary"><?= htmlspecialchars($row['unidad'] ?? '') ?></td>
                            <td>
                                <span class="badge bg-success px-3 py-2 fs-6"><?= number_format($row['calificacion'], 2) ?></span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="py-4 text-muted">No se encontraron calificaciones registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('../NAVEGACION/footer.php'); ?>