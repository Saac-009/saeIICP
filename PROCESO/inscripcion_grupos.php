<?php
include '../conexion.php'; 
if (!isset($conexion) && isset($mysqli)) $conexion = $mysqli;

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_grupo'], $_POST['id_alumno'])) {
    $id_grupo = intval($_POST['id_grupo']);
    $id_alumno = intval($_POST['id_alumno']);

    if ($id_grupo > 0 && $id_alumno > 0) {
        $sql = "UPDATE alumnos SET id_grupo = '$id_grupo' WHERE id = '$id_alumno'";
        if (mysqli_query($conexion, $sql)) {
            $mensaje = "<div class='alert alert-success alert-dismissible fade show' role='alert'>¡Alumno inscrito al grupo correctamente!<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
        } else {
            $mensaje = "<div class='alert alert-danger'>Error: " . mysqli_error($conexion) . "</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-warning'>Seleccione opciones válidas.</div>";
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
                    <h4 class="mb-0 fw-bold">Inscripción de alumnos a grupos</h4>
                    <small class="opacity-75">Asignación de alumnos a su grupo correspondiente</small>
                </div>
                <div class="card-body p-4">
                    <form action="inscripcion_grupos.php" method="POST">
                        <div class="mb-3">
                            <label for="id_grupo" class="form-label fw-semibold">Grupo</label>
                            <select class="form-select" id="id_grupo" name="id_grupo" required>
                                <option value="">Selecciona un grupo...</option>
                                <?php
                                $res_g = mysqli_query($conexion, "SELECT id, nombre FROM grupo WHERE estatus != 'BAJA' OR estatus IS NULL");
                                while ($g = mysqli_fetch_assoc($res_g)) {
                                    echo "<option value='{$g['id']}'>" . htmlspecialchars($g['nombre']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="id_alumno" class="form-label fw-semibold">Alumno</label>
                            <select class="form-select" id="id_alumno" name="id_alumno" required>
                                <option value="">Selecciona un alumno...</option>
                                <?php
                                $res_a = mysqli_query($conexion, "SELECT id, nocontrol, nombre, apaterno, amaterno FROM alumnos WHERE estatus != 'BAJA' OR estatus IS NULL");
                                while ($a = mysqli_fetch_assoc($res_a)) {
                                    $mat = !empty($a['nocontrol']) ? $a['nocontrol'] : 'Sin Matrícula';
                                    $nom_comp = trim(($a['nombre'] ?? '') . ' ' . ($a['apaterno'] ?? '') . ' ' . ($a['amaterno'] ?? ''));
                                    echo "<option value='{$a['id']}'>[{$mat}] " . htmlspecialchars($nom_comp) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary fw-bold px-4" style="background: #1e3c72; border: none;">Inscribir alumno</button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Alumnos inscritos</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light border-bottom">
                                <tr class="text-secondary small text-uppercase">
                                    <th>ID Grupo</th>
                                    <th>Grupo</th>
                                    <th>No. Control</th>
                                    <th>Nombre Completo Alumno</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_i = "SELECT a.id_grupo, g.nombre AS grupo, a.nocontrol, a.nombre, a.apaterno, a.amaterno 
                                          FROM alumnos a 
                                          INNER JOIN grupo g ON a.id_grupo = g.id 
                                          WHERE (a.estatus != 'BAJA' OR a.estatus IS NULL)";
                                $res_i = mysqli_query($conexion, $sql_i);

                                if ($res_i && mysqli_num_rows($res_i) > 0) {
                                    while ($row = mysqli_fetch_assoc($res_i)) {
                                        $mat_tabla = !empty($row['nocontrol']) ? $row['nocontrol'] : '-';
                                        $nom_tabla = trim(($row['nombre'] ?? '') . ' ' . ($row['apaterno'] ?? '') . ' ' . ($row['amaterno'] ?? ''));
                                        
                                        echo "<tr>";
                                        echo "<td><span class='badge bg-secondary-subtle text-secondary fw-bold px-2 py-1'>{$row['id_grupo']}</span></td>";
                                        echo "<td class='fw-bold text-dark'>" . htmlspecialchars($row['grupo']) . "</td>";
                                        echo "<td class='fw-semibold text-primary'>" . htmlspecialchars($mat_tabla) . "</td>";
                                        echo "<td class='fw-semibold text-dark'>" . htmlspecialchars($nom_tabla) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center text-muted py-4'>No hay alumnos inscritos en ningún grupo.</td></tr>";
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