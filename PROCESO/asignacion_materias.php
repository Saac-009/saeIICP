<?php
include '../conexion.php'; 
if (!isset($conexion) && isset($mysqli)) $conexion = $mysqli;

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_materia'], $_POST['id_alumno'], $_POST['id_profesor'])) {
    $id_materia = intval($_POST['id_materia']);
    $id_alumno = intval($_POST['id_alumno']);
    $id_profesor = intval($_POST['id_profesor']);

    if ($id_materia > 0 && $id_alumno > 0 && $id_profesor > 0) {
        $stmt = mysqli_prepare($conexion, "INSERT INTO asignaciones (id_materia, id_alumno, id_profesor) VALUES (?, ?, ?)");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iii", $id_materia, $id_alumno, $id_profesor);
            if (mysqli_stmt_execute($stmt)) {
                $mensaje = "<div class='alert alert-success alert-dismissible fade show' role='alert'>¡Materia asignada correctamente!<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
            } else {
                $mensaje = "<div class='alert alert-danger'>Error al asignar: " . mysqli_error($conexion) . "</div>";
            }
            mysqli_stmt_close($stmt);
        } else {
            $mensaje = "<div class='alert alert-danger'>Error en la base de datos: " . mysqli_error($conexion) . "</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-warning'>Seleccione todas las opciones válidas.</div>";
    }
}

include '../NAVEGACION/header.php';
include '../NAVEGACION/navegacion.php';
?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-9">
            <?php echo $mensaje; ?>
            
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
                <div class="card-header custom-header p-4">
                    <h4 class="mb-0 fw-bold">Asignación de materias</h4>
                    <small class="opacity-75">Asignar materias a alumnos y profesores</small>
                </div>
                <div class="card-body p-4">
                    <form action="asignacion_materias.php" method="POST">
                        <div class="mb-3">
                            <label for="id_materia" class="form-label fw-semibold">Materia</label>
                            <select class="form-select" id="id_materia" name="id_materia" required>
                                <option value="">Selecciona una materia...</option>
                                <?php
                                $res_m = mysqli_query($conexion, "SELECT * FROM materias");
                                if ($res_m) {
                                    while ($m = mysqli_fetch_assoc($res_m)) {
                                        if (isset($m['estatus']) && $m['estatus'] === 'BAJA') continue;
                                        echo "<option value='{$m['id']}'>" . htmlspecialchars($m['nombre']) . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_alumno" class="form-label fw-semibold">Alumno</label>
                            <select class="form-select" id="id_alumno" name="id_alumno" required>
                                <option value="">Selecciona un alumno...</option>
                                <?php
                                $res_a = mysqli_query($conexion, "SELECT * FROM alumnos");
                                if ($res_a) {
                                    while ($a = mysqli_fetch_assoc($res_a)) {
                                        if (isset($a['estatus']) && $a['estatus'] === 'BAJA') continue;
                                        $mat = !empty($a['nocontrol']) ? $a['nocontrol'] : 'Sin Matrícula';
                                        $nom_comp = trim(($a['nombre'] ?? '') . ' ' . ($a['apaterno'] ?? '') . ' ' . ($a['amaterno'] ?? ''));
                                        echo "<option value='{$a['id']}'>[{$mat}] " . htmlspecialchars($nom_comp) . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="id_profesor" class="form-label fw-semibold">Profesor</label>
                            <select class="form-select" id="id_profesor" name="id_profesor" required>
                                <option value="">Selecciona un profesor...</option>
                                <?php
                                $res_p = mysqli_query($conexion, "SELECT * FROM profesores");
                                if ($res_p) {
                                    while ($p = mysqli_fetch_assoc($res_p)) {
                                        if (isset($p['estatus']) && $p['estatus'] === 'BAJA') continue;
                                        $mat_p = !empty($p['nocontrol']) ? $p['nocontrol'] : 'Sin No. Control';
                                        $nom_prof = trim(($p['nombre'] ?? '') . ' ' . ($p['apaterno'] ?? '') . ' ' . ($p['amaterno'] ?? ''));
                                        echo "<option value='{$p['id']}'>[{$mat_p}] " . htmlspecialchars($nom_prof) . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary fw-bold px-4" style="background: #1e3c72; border: none;">Asignar materia</button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Asignaturas registradas</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light border-bottom">
                                <tr class="text-secondary small text-uppercase">
                                    <th>ID Asignatura</th>
                                    <th>Materia</th>
                                    <th>Alumno</th>
                                    <th>Profesor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_as = "SELECT asg.id AS id_asignatura, m.nombre AS materia, 
                                                  a.id AS id_a, a.nombre AS nom_a, 
                                                  p.id AS id_p, p.nombre AS nom_p
                                           FROM asignaciones asg 
                                           LEFT JOIN materias m ON asg.id_materia = m.id 
                                           LEFT JOIN alumnos a ON asg.id_alumno = a.id 
                                           LEFT JOIN profesores p ON asg.id_profesor = p.id";
                                $res_as = mysqli_query($conexion, $sql_as);

                                if ($res_as && mysqli_num_rows($res_as) > 0) {
                                    while ($row = mysqli_fetch_assoc($res_as)) {
                                        // Obtener datos detallados de alumno
                                        $id_a = $row['id_a'];
                                        $det_a = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM alumnos WHERE id = '$id_a'"));
                                        $mat_a = !empty($det_a['nocontrol']) ? "[{$det_a['nocontrol']}] " : "";
                                        $nom_a = $mat_a . trim(($det_a['nombre'] ?? '') . ' ' . ($det_a['apaterno'] ?? '') . ' ' . ($det_a['amaterno'] ?? ''));

                                        // Obtener datos detallados de profesor
                                        $id_p = $row['id_p'];
                                        $det_p = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM profesores WHERE id = '$id_p'"));
                                        $mat_p = !empty($det_p['nocontrol']) ? "[{$det_p['nocontrol']}] " : "";
                                        $nom_p = $mat_p . trim(($det_p['nombre'] ?? '') . ' ' . ($det_p['apaterno'] ?? '') . ' ' . ($det_p['amaterno'] ?? ''));

                                        echo "<tr>";
                                        echo "<td><span class='badge bg-secondary-subtle text-secondary fw-bold px-2 py-1'>{$row['id_asignatura']}</span></td>";
                                        echo "<td class='fw-bold text-dark'>" . htmlspecialchars($row['materia'] ?? '-') . "</td>";
                                        echo "<td class='fw-semibold text-dark'>" . htmlspecialchars($nom_a) . "</td>";
                                        echo "<td class='fw-semibold text-dark'>" . htmlspecialchars($nom_p) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center text-muted py-4'>No hay asignaciones registradas.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include '../NAVEGACION/footer.php'; ?>