<?php
include('../NAVEGACION/header.php');
include('../NAVEGACION/navegacion.php');
include('../conexion.php');

$es_alumno = ($_SESSION['rol'] === 'ALUMNO');

if ($es_alumno) {
    // 1. Obtener datos completos del alumno y su grupo
    $id_alumno = intval($_SESSION['id_usuario']);
    $query_info = "SELECT a.*, g.nombre AS nombre_grupo 
                   FROM alumnos a 
                   LEFT JOIN grupo g ON a.id_grupo = g.id 
                   WHERE a.id = '$id_alumno' LIMIT 1";
    $res_info = mysqli_query($conexion, $query_info);
    $datos_alumno = mysqli_fetch_assoc($res_info);

    // 2. Obtener sus calificaciones
    $query_calif = "SELECT c.id, u.descripcion AS unidad, c.calificacion 
                    FROM calificaciones c
                    INNER JOIN unidades u ON c.id_unidad = u.id
                    WHERE c.id_alumno = '$id_alumno'
                    ORDER BY u.id ASC";
    $res_calif = mysqli_query($conexion, $query_calif);
} else {
    // Vista general para Admin o Profesor
    $query_general = "SELECT c.id, a.nocontrol, a.nombre, a.apaterno, a.amaterno, g.nombre AS grupo, u.descripcion AS unidad, c.calificacion 
                      FROM calificaciones c
                      INNER JOIN alumnos a ON c.id_alumno = a.id
                      LEFT JOIN grupo g ON a.id_grupo = g.id
                      INNER JOIN unidades u ON c.id_unidad = u.id
                      WHERE (a.estatus != 'BAJA' OR a.estatus IS NULL)
                      ORDER BY a.apaterno ASC, u.id ASC";
    $res_general = mysqli_query($conexion, $query_general);
}
?>

<div class="container my-4">

<?php if ($es_alumno && $datos_alumno): ?>
    <!-- ========================================================= -->
    <!-- VISTA DE BOLETA OFICIAL PARA EL ALUMNO                    -->
    <!-- ========================================================= -->
    <div class="mb-3">
        <h4 class="fw-bold mb-0">Boleta Oficial de Calificaciones</h4>
        <small class="text-muted">Documento informativo de rendimiento académico</small>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden" id="boleta-oficial">
        <!-- Encabezado Institucional de la Boleta -->
        <div class="card-header text-white p-4" style="background-color: #1f4287 !important;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="fw-bold mb-0">ESCUELA IICP</h4>
                    <small class="opacity-75 text-uppercase">Sistema de Control Escolar — Boleta de Evaluaciones</small>
                </div>
                <div class="col-md-4 text-md-end mt-2 mt-md-0">
                    <span class="badge bg-light text-dark px-3 py-2 fw-bold">CICLO ESCOLAR 2026</span>
                </div>
            </div>
        </div>

        <!-- Ficha de Datos del Estudiante -->
        <div class="card-body p-4">
            <div class="row g-3 bg-light p-3 rounded-3 border mb-4">
                <div class="col-md-3">
                    <small class="text-muted text-uppercase d-block fw-semibold" style="font-size: 0.75rem;">No. de Control</small>
                    <span class="fw-bold fs-6 text-dark"><?= htmlspecialchars($datos_alumno['nocontrol'] ?? 'N/A') ?></span>
                </div>
                <div class="col-md-5">
                    <small class="text-muted text-uppercase d-block fw-semibold" style="font-size: 0.75rem;">Nombre del Alumno</small>
                    <span class="fw-bold fs-6 text-dark">
                        <?= htmlspecialchars($datos_alumno['nombre'] . ' ' . $datos_alumno['apaterno'] . ' ' . $datos_alumno['amaterno']) ?>
                    </span>
                </div>
                <div class="col-md-2">
                    <small class="text-muted text-uppercase d-block fw-semibold" style="font-size: 0.75rem;">Grupo</small>
                    <span class="badge bg-primary px-2 py-1"><?= htmlspecialchars($datos_alumno['nombre_grupo'] ?? 'Sin grupo') ?></span>
                </div>
                <div class="col-md-2">
                    <small class="text-muted text-uppercase d-block fw-semibold" style="font-size: 0.75rem;">Estatus</small>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">ACTIVO</span>
                </div>
            </div>

            <!-- Tabla de Calificaciones por Unidad -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0" style="font-size: 0.92rem;">
                    <thead class="table-light text-uppercase small text-center">
                        <tr>
                            <th style="width: 8%;">#</th>
                            <th class="text-start">Unidad / Asignatura Evaluada</th>
                            <th style="width: 18%;">Calificación</th>
                            <th style="width: 18%;">Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $suma = 0;
                        $total_materias = 0;
                        if ($res_calif && mysqli_num_rows($res_calif) > 0): 
                            $contador = 1;
                            while ($row = mysqli_fetch_assoc($res_calif)): 
                                $cal = floatval($row['calificacion']);
                                $suma += $cal;
                                $total_materias++;
                                $aprobado = ($cal >= 6.0);
                        ?>
                            <tr>
                                <td class="text-center fw-bold text-secondary"><?= $contador++ ?></td>
                                <td class="fw-semibold text-dark"><?= htmlspecialchars($row['unidad']) ?></td>
                                <td class="text-center fw-bold fs-6 <?= $aprobado ? 'text-success' : 'text-danger' ?>">
                                    <?= number_format($cal, 2) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($aprobado): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3">APROBADO</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3">REPROBADO</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php 
                            endwhile; 
                        else: 
                        ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Aún no tienes calificaciones capturadas en el sistema.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                    <!-- Pie de Boleta con Promedio General -->
                    <?php if ($total_materias > 0): 
                        $promedio = $suma / $total_materias;
                    ?>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="2" class="text-end fw-bold text-uppercase text-secondary">Promedio General:</td>
                            <td class="text-center">
                                <span class="badge text-white fs-6 px-3 py-2" style="background-color: #1f4287 !important;">
                                    <?= number_format($promedio, 2) ?>
                                </span>
                            </td>
                            <td class="text-center fw-bold small <?= ($promedio >= 6.0) ? 'text-success' : 'text-danger' ?>">
                                <?= ($promedio >= 6.0) ? 'REGULAR' : 'IRREGULAR' ?>
                            </td>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>

            <!-- Nota y Firma al pie de boleta -->
            <div class="row mt-5 pt-3 text-center text-muted small">
                <div class="col-md-6">
                    <p class="mb-0">Fecha de emisión: <strong><?= date('d/m/Y') ?></strong></p>
                </div>
                <div class="col-md-6">
                    <div class="border-top w-50 mx-auto pt-1">Control Escolar — Escuela IICP</div>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
    <!-- ========================================================= -->
    <!-- VISTA GENERAL PARA ADMINISTRADORES Y PROFESORES           -->
    <!-- ========================================================= -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold mb-0">Reporte General de Calificaciones</h3>
            <small class="text-muted">Concentrado de evaluaciones del alumnado</small>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center" style="font-size: 0.9rem;">
                <thead class="table-light text-uppercase small border-bottom">
                    <tr>
                        <th>NO. CONTROL</th>
                        <th>ALUMNO</th>
                        <th>GRUPO</th>
                        <th>UNIDAD / MATERIA</th>
                        <th>CALIFICACIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($res_general && mysqli_num_rows($res_general) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($res_general)): ?>
                        <tr>
                            <td class="fw-bold text-secondary"><?= htmlspecialchars($row['nocontrol'] ?? '') ?></td>
                            <td class="fw-semibold text-start"><?= htmlspecialchars($row['nombre'] . ' ' . $row['apaterno'] . ' ' . $row['amaterno']) ?></td>
                            <td><span class="badge bg-primary-subtle text-primary"><?= htmlspecialchars($row['grupo'] ?? 'N/A') ?></span></td>
                            <td class="text-secondary"><?= htmlspecialchars($row['unidad'] ?? '') ?></td>
                            <td>
                                <span class="badge bg-success px-3 py-2 fs-6"><?= number_format($row['calificacion'], 2) ?></span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-4 text-muted">No se encontraron calificaciones registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

</div>

<?php include('../NAVEGACION/footer.php'); ?>