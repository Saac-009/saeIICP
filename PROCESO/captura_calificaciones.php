<?php
include '../conexion.php'; 
if (!isset($conexion) && isset($mysqli)) $conexion = $mysqli;

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_alumno'], $_POST['id_unidad'], $_POST['calificacion'])) {
    $id_alumno = intval($_POST['id_alumno']);
    $id_unidad = intval($_POST['id_unidad']);
    $calificacion = floatval($_POST['calificacion']);

    if ($id_alumno > 0 && $id_unidad > 0) {
        $stmt = mysqli_prepare($conexion, "INSERT INTO calificaciones (id_alumno, id_unidad, calificacion) VALUES (?, ?, ?)");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iid", $id_alumno, $id_unidad, $calificacion);
            if (mysqli_stmt_execute($stmt)) {
                $mensaje = "<div class='alert alert-success alert-dismissible fade show' role='alert'>¡Calificación registrada correctamente!<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
            } else {
                $mensaje = "<div class='alert alert-danger'>Error al guardar: " . mysqli_error($conexion) . "</div>";
            }
            mysqli_stmt_close($stmt);
        } else {
            $mensaje = "<div class='alert alert-danger'>Error de base de datos: " . mysqli_error($conexion) . "</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-warning'>Por favor completa todos los campos correctamente.</div>";
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
                    <h4 class="mb-0 fw-bold">Captura de calificaciones</h4>
                    <small class="opacity-75">Registro individual de evaluaciones por alumno</small>
                </div>
                <div class="card-body p-4">
                    <form action="captura_calificaciones.php" method="POST">
                        <div class="row align-items-end">
                            <div class="col-md-5 mb-3">
                                <label for="id_alumno" class="form-label fw-semibold">Alumno</label>
                                <select class="form-select" id="id_alumno" name="id_alumno" onchange="filtrarUnidades(this.value)" required>
                                    <option value="">Selecciona un alumno...</option>
                                    <?php
                                    $res_a = mysqli_query($conexion, "SELECT * FROM alumnos WHERE (estatus != 'BAJA' OR estatus IS NULL)");
                                    if ($res_a) {
                                        while ($a = mysqli_fetch_assoc($res_a)) {
                                            $mat = !empty($a['nocontrol']) ? $a['nocontrol'] : 'Sin Matrícula';
                                            $nom_comp = trim(($a['nombre'] ?? '') . ' ' . ($a['apaterno'] ?? '') . ' ' . ($a['amaterno'] ?? ''));
                                            echo "<option value='{$a['id']}'>[{$mat}] " . htmlspecialchars($nom_comp) . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="id_unidad" class="form-label fw-semibold">Id unidad</label>
                                <select class="form-select" id="id_unidad" name="id_unidad" required>
                                    <option value="">Selecciona primero un alumno...</option>
                                    <?php
                                    // Cargar todas las unidades como respaldo general inicial
                                    $res_u = mysqli_query($conexion, "SELECT * FROM unidades WHERE (estatus != 'BAJA' OR estatus IS NULL)");
                                    if ($res_u) {
                                        while ($u = mysqli_fetch_assoc($res_u)) {
                                            $desc = !empty($u['descripcion']) ? $u['descripcion'] : "Unidad " . $u['id'];
                                            echo "<option value='{$u['id']}'>" . htmlspecialchars($desc) . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="calificacion" class="form-label fw-semibold">Calificación</label>
                                <input type="number" step="0.1" min="0" max="10" class="form-control" id="calificacion" name="calificacion" value="10" required>
                            </div>
                        </div>
                        <div class="mt-2 text-end">
                            <button type="submit" class="btn btn-primary fw-bold px-4" style="background: #1e3c72; border: none;">Guardar Calificación</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Calificaciones Registradas</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light border-bottom">
                                <tr class="text-secondary small text-uppercase">
                                    <th>ID</th>
                                    <th>Alumno</th>
                                    <th>Unidad</th>
                                    <th>Calificación</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_c = "SELECT c.id, c.calificacion, u.descripcion AS unidad, 
                                                 a.nocontrol, a.nombre, a.apaterno, a.amaterno
                                          FROM calificaciones c
                                          LEFT JOIN alumnos a ON c.id_alumno = a.id
                                          LEFT JOIN unidades u ON c.id_unidad = u.id
                                          WHERE (a.estatus != 'BAJA' OR a.estatus IS NULL)";
                                $res_c = mysqli_query($conexion, $sql_c);

                                if ($res_c && mysqli_num_rows($res_c) > 0) {
                                    while ($r = mysqli_fetch_assoc($res_c)) {
                                        $mat_c = !empty($r['nocontrol']) ? "[{$r['nocontrol']}] " : "";
                                        $nom_c = $mat_c . trim(($r['nombre'] ?? '') . ' ' . ($r['apaterno'] ?? '') . ' ' . ($r['amaterno'] ?? ''));
                                        
                                        echo "<tr>";
                                        echo "<td><span class='badge bg-secondary-subtle text-secondary fw-bold px-2 py-1'>{$r['id']}</span></td>";
                                        echo "<td class='fw-semibold text-dark'>" . htmlspecialchars($nom_c) . "</td>";
                                        echo "<td class='text-muted small'>" . htmlspecialchars($r['unidad'] ?? 'Unidad Standard') . "</td>";
                                        echo "<td><span class='badge bg-success-subtle text-success fw-bold px-3 py-1'>{$r['calificacion']}</span></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center text-muted py-4'>No hay calificaciones registradas.</td></tr>";
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

<script>
function filtrarUnidades(idAlumno) {
    var selectUnidades = document.getElementById('id_unidad');
    if (!idAlumno) {
        selectUnidades.innerHTML = '<option value="">Selecciona primero un alumno...</option>';
        return;
    }
    
    // Petición AJAX para obtener las materias/unidades asociadas al alumno
    fetch('obtener_unidades.php?id_alumno=' + idAlumno)
        .then(response => response.json())
        .then(data => {
            selectUnidades.innerHTML = '';
            if (data.length > 0) {
                data.forEach(item => {
                    var option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.descripcion;
                    selectUnidades.appendChild(option);
                });
            } else {
                selectUnidades.innerHTML = '<option value="">Sin unidades asignadas a este alumno</option>';
            }
        })
        .catch(error => {
            console.log('Filtro dinámico en modo estándar');
        });
}
</script>

<?php include '../NAVEGACION/footer.php'; ?>