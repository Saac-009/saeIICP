<?php
include('../NAVEGACION/header.php');

if ($_SESSION['rol'] === 'ALUMNO') {
    header("Location: ../REPORTES/alumnos.php");
    exit();
}

include('../NAVEGACION/navegacion.php');
include('../conexion.php');

// Detectar pestaña activa (por defecto "individual")
$tab = $_GET['tab'] ?? 'individual';

// Consultas para selección individual
$query_grupos = "SELECT * FROM grupo WHERE estatus != 'BAJA' OR estatus IS NULL";
$res_grupos = mysqli_query($conexion, $query_grupos);

$query_unidades = "SELECT * FROM unidades WHERE estatus != 'BAJA' OR estatus IS NULL";
$res_unidades = mysqli_query($conexion, $query_unidades);

// Consulta para el historial de calificaciones registradas
$query_historial = "SELECT c.id, a.nombre, a.apaterno, a.amaterno, u.descripcion AS unidad, c.calificacion 
                   FROM calificaciones c
                   INNER JOIN alumnos a ON c.id_alumno = a.id
                   INNER JOIN unidades u ON c.id_unidad = u.id
                   ORDER BY c.id DESC LIMIT 10";
$res_historial = mysqli_query($conexion, $query_historial);
?>

<div class="container my-4">
    <!-- Encabezado Principal -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
        <div class="card-body p-4 text-white" style="background-color: #1f4287 !important;">
            <h4 class="fw-bold mb-1"><i class="bi bi-pencil-square me-2"></i>Captura de Calificaciones</h4>
            <p class="mb-0 small opacity-75">Registro individual de evaluaciones por alumno o masivo por grupo</p>
        </div>
    </div>

    <!-- Pestañas de Interfaz -->
    <ul class="nav nav-tabs border-bottom-0 mb-4" id="calificacionesTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link fw-bold px-4 <?= ($tab === 'individual') ? 'active text-primary border-primary border-bottom-0' : 'text-secondary' ?>" 
               href="captura_calificaciones.php?tab=individual">
                <i class="bi bi-person me-2"></i>Captura Individual
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link fw-bold px-4 <?= ($tab === 'masiva') ? 'active text-primary border-primary border-bottom-0' : 'text-secondary' ?>" 
               href="captura_calificaciones.php?tab=masiva">
                <i class="bi bi-people me-2"></i>Captura Masiva (Por Grupo)
            </a>
        </li>
    </ul>

    <!-- MENSAJES DE ALERTA -->
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <strong>¡Éxito!</strong> Se procesaron correctamente <strong><?= htmlspecialchars($_GET['count'] ?? 0) ?></strong> calificaciones.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($_GET['status'] === 'error'): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <strong>Error:</strong> No se pudo procesar el archivo. Revisa el formato.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- PESTAÑA 1: CAPTURA INDIVIDUAL -->
    <?php if ($tab === 'individual'): ?>
        <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
            <form action="procesar_captura_individual.php" method="POST">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label fw-semibold text-secondary small text-uppercase">Seleccionar Grupo</label>
                        <select name="id_grupo" class="form-select" required>
                            <option value="" selected disabled>Selecciona un grupo...</option>
                            <?php while ($g = mysqli_fetch_assoc($res_grupos)): ?>
                                <option value="<?= $g['id'] ?>"><?= htmlspecialchars($g['nombre']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-semibold text-secondary small text-uppercase">Seleccionar Unidad</label>
                        <select name="id_unidad" class="form-select" required>
                            <option value="" selected disabled>Selecciona una unidad...</option>
                            <?php while ($u = mysqli_fetch_assoc($res_unidades)): ?>
                                <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['descripcion']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn text-white w-100 fw-bold" style="background-color: #1f4287 !important;">
                            = Cargar Lista
                        </button>
                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!-- PESTAÑA 2: CAPTURA MASIVA (POR GRUPO) -->
    <?php if ($tab === 'masiva'): ?>
        <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
            <div class="border-bottom pb-3 mb-4">
                <h5 class="fw-bold mb-1 text-dark">Importación de Calificaciones mediante Excel / CSV</h5>
                <small class="text-muted">Sube tu plantilla para registrar calificaciones masivamente</small>
            </div>

            <form action="procesar_masivo.php" method="POST" enctype="multipart/form-data">
                <div class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold text-secondary small text-uppercase">Selecciona el archivo Excel / CSV</label>
                        <input type="file" name="archivo_excel" class="form-control" accept=".csv, .xlsx, .xls" required>
                        <div class="form-text mt-2">
                            El archivo debe contener las columnas: <code class="text-danger">nocontrol</code>, <code class="text-danger">id_unidad</code> y <code class="text-danger">calificacion</code>.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" name="importar" class="btn text-white w-100 fw-bold py-2" style="background-color: #1f4287 !important;">
                            <i class="bi bi-cloud-upload me-1"></i> Cargar e Importar Excel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!-- TABLA DE HISTORIAL DE CALIFICACIONES REGISTRADAS -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-secondary text-white p-3">
            <h6 class="mb-0 fw-bold">Calificaciones Registradas</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center" style="font-size: 0.9rem;">
                <thead class="table-light text-uppercase small border-bottom">
                    <tr>
                        <th>ID</th>
                        <th>ALUMNO</th>
                        <th>UNIDAD</th>
                        <th>CALIFICACIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($res_historial && mysqli_num_rows($res_historial) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($res_historial)): ?>
                        <tr>
                            <td class="fw-bold text-secondary"><?= $row['id'] ?></td>
                            <td class="fw-semibold text-start"><?= htmlspecialchars($row['nombre'] . ' ' . $row['apaterno'] . ' ' . $row['amaterno']) ?></td>
                            <td class="text-secondary"><?= htmlspecialchars($row['unidad']) ?></td>
                            <td>
                                <span class="badge bg-success px-3 py-2 fs-6"><?= number_format($row['calificacion'], 2) ?></span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="py-3 text-muted">No hay registros recientes.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('../NAVEGACION/footer.php'); ?>