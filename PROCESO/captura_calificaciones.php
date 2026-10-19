<?php
// Mostrar errores para diagnóstico
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../conexion.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_captura = $_POST['tipo_captura'] ?? '';

    if ($tipo_captura === 'individual' && isset($conexion)) {
        $id_alumno = intval($_POST['id_alumno']);
        $id_unidad = intval($_POST['id_unidad']);
        $calificacion = floatval($_POST['calificacion']);

        $check = mysqli_query($conexion, "SELECT id FROM calificaciones WHERE id_alumno = $id_alumno AND id_unidad = $id_unidad");
        if (mysqli_num_rows($check) > 0) {
            $query = "UPDATE calificaciones SET calificacion = $calificacion WHERE id_alumno = $id_alumno AND id_unidad = $id_unidad";
        } else {
            $query = "INSERT INTO calificaciones (id_alumno, id_unidad, calificacion) VALUES ($id_alumno, $id_unidad, $calificacion)";
        }
        mysqli_query($conexion, $query);

        header("Location: captura_calificaciones.php?status=success");
        exit();

    } elseif ($tipo_captura === 'masiva' && isset($conexion)) {
        $id_unidad = intval($_POST['id_unidad']);
        $calificaciones = $_POST['calificaciones'] ?? [];

        foreach ($calificaciones as $id_alumno => $calificacion) {
            if ($calificacion !== '' && $calificacion !== null) {
                $id_alumno = intval($id_alumno);
                $cal = floatval($calificacion);

                $check = mysqli_query($conexion, "SELECT id FROM calificaciones WHERE id_alumno = $id_alumno AND id_unidad = $id_unidad");
                if (mysqli_num_rows($check) > 0) {
                    $query = "UPDATE calificaciones SET calificacion = $cal WHERE id_alumno = $id_alumno AND id_unidad = $id_unidad";
                } else {
                    $query = "INSERT INTO calificaciones (id_alumno, id_unidad, calificacion) VALUES ($id_alumno, $id_unidad, $cal)";
                }
                mysqli_query($conexion, $query);
            }
        }

        $id_grupo_retorno = intval($_POST['id_grupo_retorno'] ?? 0);
        header("Location: captura_calificaciones.php?id_grupo=$id_grupo_retorno&id_unidad_masiva=$id_unidad&status=success");
        exit();
    }
}

$res_alumnos = mysqli_query($conexion, "SELECT id, nocontrol, nombre, apaterno, amaterno FROM alumnos WHERE estatus = 'ALTA' ORDER BY apaterno ASC");
$res_unidades = mysqli_query($conexion, "SELECT id, descripcion FROM unidades WHERE estatus = 'ALTA' ORDER BY id ASC");
$res_grupos = mysqli_query($conexion, "SELECT id, nombre FROM grupo WHERE estatus = 'ALTA' ORDER BY nombre ASC");

// Carga de cabecera y barra de navegación
include("../NAVEGACION/header.php");
include("../NAVEGACION/navegacion.php");
?>

<div class="container mt-4">

    <!-- ALERTA DE ÉXITO -->
    <?php if (isset($_GET['status'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>¡Éxito!</strong> Las calificaciones se guardaron correctamente en la base de datos.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 mb-4">
        <!-- Encabezado con color exacto en hexadecimal sin conflicto de clases Bootstrap -->
        <div class="card-header text-white p-3" style="background-color: #1f4287 !important;">
            <h4 class="m-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Captura de Calificaciones</h4>
            <small class="text-light">Registro individual de evaluaciones por alumno o masivo por grupo</small>
        </div>
        <div class="card-body">
            
            <!-- Pestañas de Selección -->
            <ul class="nav nav-tabs mb-4" id="calificacionesTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= (!isset($_GET['id_grupo'])) ? 'active' : '' ?> fw-bold" id="individual-tab" data-bs-toggle="tab" data-bs-target="#individual" type="button" role="tab">
                        <i class="bi bi-person-fill me-1"></i> Captura Individual
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= (isset($_GET['id_grupo'])) ? 'active' : '' ?> fw-bold" id="masiva-tab" data-bs-toggle="tab" data-bs-target="#masiva" type="button" role="tab">
                        <i class="bi bi-people-fill me-1"></i> Captura Masiva (Por Grupo)
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="calificacionesTabContent">
                
                <!-- CAPTURA INDIVIDUAL -->
                <div class="tab-pane fade <?= (!isset($_GET['id_grupo'])) ? 'show active' : '' ?>" id="individual" role="tabpanel">
                    <form action="captura_calificaciones.php" method="POST" class="row g-3">
                        <input type="hidden" name="tipo_captura" value="individual">
                        
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Alumno</label>
                            <select name="id_alumno" class="form-select" required>
                                <option value="" selected disabled>Selecciona un alumno...</option>
                                <?php 
                                if ($res_alumnos) {
                                    mysqli_data_seek($res_alumnos, 0);
                                    while($al = mysqli_fetch_assoc($res_alumnos)): 
                                    ?>
                                        <option value="<?= $al['id'] ?>">
                                            [<?= htmlspecialchars($al['nocontrol']) ?>] <?= htmlspecialchars($al['nombre'].' '.$al['apaterno'].' '.$al['amaterno']) ?>
                                        </option>
                                    <?php 
                                    endwhile; 
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Unidad</label>
                            <select name="id_unidad" class="form-select" required>
                                <option value="" selected disabled>Selecciona una unidad...</option>
                                <?php 
                                if ($res_unidades) {
                                    mysqli_data_seek($res_unidades, 0);
                                    while($un = mysqli_fetch_assoc($res_unidades)): 
                                    ?>
                                        <option value="<?= $un['id'] ?>"><?= htmlspecialchars($un['descripcion']) ?></option>
                                    <?php 
                                    endwhile; 
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Calificación</label>
                            <input type="number" name="calificacion" class="form-control" min="0" max="10" step="0.1" placeholder="Ej. 10.0" required>
                        </div>

                        <div class="col-12 mt-3">
                            <button type="submit" class="btn text-white px-4" style="background-color: #1f4287 !important; border-color: #1f4287 !important;"><i class="bi bi-save me-1"></i> Guardar Calificación</button>
                        </div>
                    </form>
                </div>

                <!-- CAPTURA MASIVA POR GRUPO -->
                <div class="tab-pane fade <?= (isset($_GET['id_grupo'])) ? 'show active' : '' ?>" id="masiva" role="tabpanel">
                    <form method="GET" action="captura_calificaciones.php" class="row g-3 bg-light p-3 rounded mb-4">
                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Seleccionar Grupo</label>
                            <select name="id_grupo" class="form-select" required>
                                <option value="" selected disabled>Selecciona un grupo...</option>
                                <?php 
                                if ($res_grupos) {
                                    while($gr = mysqli_fetch_assoc($res_grupos)): 
                                    ?>
                                        <option value="<?= $gr['id'] ?>" <?= (isset($_GET['id_grupo']) && $_GET['id_grupo'] == $gr['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($gr['nombre']) ?>
                                        </option>
                                    <?php 
                                    endwhile; 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Seleccionar Unidad</label>
                            <select name="id_unidad_masiva" class="form-select" required>
                                <option value="" selected disabled>Selecciona una unidad...</option>
                                <?php 
                                if ($res_unidades) {
                                    mysqli_data_seek($res_unidades, 0);
                                    while($un = mysqli_fetch_assoc($res_unidades)): 
                                    ?>
                                        <option value="<?= $un['id'] ?>" <?= (isset($_GET['id_unidad_masiva']) && $_GET['id_unidad_masiva'] == $un['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($un['descripcion']) ?>
                                        </option>
                                    <?php 
                                    endwhile; 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-secondary w-100"><i class="bi bi-filter me-1"></i> Cargar Lista</button>
                        </div>
                    </form>

                    <?php
                    if (isset($_GET['id_grupo']) && isset($_GET['id_unidad_masiva'])):
                        $id_grupo_sel = intval($_GET['id_grupo']);
                        $id_unidad_sel = intval($_GET['id_unidad_masiva']);

                        $query_lista = "SELECT a.id, a.nocontrol, a.nombre, a.apaterno, a.amaterno, c.calificacion
                                       FROM alumnos a
                                       LEFT JOIN calificaciones c ON (a.id = c.id_alumno AND c.id_unidad = $id_unidad_sel)
                                       WHERE a.id_grupo = $id_grupo_sel AND a.estatus = 'ALTA'
                                       ORDER BY a.apaterno ASC";
                        $res_lista = mysqli_query($conexion, $query_lista);
                    ?>
                        <form action="captura_calificaciones.php" method="POST">
                            <input type="hidden" name="tipo_captura" value="masiva">
                            <input type="hidden" name="id_unidad" value="<?= $id_unidad_sel ?>">
                            <input type="hidden" name="id_grupo_retorno" value="<?= $id_grupo_sel ?>">
                            
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 80px;">ID</th>
                                        <th>No. Control</th>
                                        <th>Nombre Completo del Alumno</th>
                                        <th style="width: 180px;">Calificación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($res_lista && mysqli_num_rows($res_lista) > 0): ?>
                                        <?php while ($row = mysqli_fetch_assoc($res_lista)): ?>
                                            <tr>
                                                <td><?= $row['id'] ?></td>
                                                <td><span class="badge bg-secondary"><?= htmlspecialchars($row['nocontrol']) ?></span></td>
                                                <td><?= htmlspecialchars($row['nombre'].' '.$row['apaterno'].' '.$row['amaterno']) ?></td>
                                                <td>
                                                    <input type="number" 
                                                           name="calificaciones[<?= $row['id'] ?>]" 
                                                           class="form-control" 
                                                           min="0" max="10" step="0.1" 
                                                           value="<?= $row['calificacion'] ?? '' ?>" 
                                                           placeholder="0.0 - 10.0">
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">No se encontraron alumnos asignados a este grupo.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                            <?php if ($res_lista && mysqli_num_rows($res_lista) > 0): ?>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn text-white px-4" style="background-color: #1f4287 !important; border-color: #1f4287 !important;"><i class="bi bi-check-all me-1"></i> Guardar Calificaciones Masivas</button>
                                </div>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

    <!-- TABLA DE CALIFICACIONES REGISTRADAS -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-secondary text-white fw-bold">
            Calificaciones Registradas
        </div>
        <div class="card-body p-0">
            <table class="table table-striped m-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ALUMNO</th>
                        <th>UNIDAD</th>
                        <th>CALIFICACIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query_recientes = "SELECT c.id, CONCAT(a.nombre, ' ', a.apaterno, ' ', a.amaterno) AS alumno, 
                                               u.descripcion AS unidad, c.calificacion 
                                        FROM calificaciones c
                                        INNER JOIN alumnos a ON c.id_alumno = a.id
                                        INNER JOIN unidades u ON c.id_unidad = u.id
                                        ORDER BY c.id DESC LIMIT 10";
                    $res_recientes = mysqli_query($conexion, $query_recientes);
                    if ($res_recientes && mysqli_num_rows($res_recientes) > 0):
                        while ($rec = mysqli_fetch_assoc($res_recientes)):
                    ?>
                        <tr>
                            <td><?= $rec['id'] ?></td>
                            <td><?= htmlspecialchars($rec['alumno']) ?></td>
                            <td><?= htmlspecialchars($rec['unidad']) ?></td>
                            <td><span class="badge bg-success fs-6"><?= number_format($rec['calificacion'], 2) ?></span></td>
                        </tr>
                    <?php 
                        endwhile;
                    else:
                    ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">Aún no hay calificaciones registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
include("../NAVEGACION/footer.php");
?>