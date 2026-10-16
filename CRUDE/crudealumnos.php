<?php
include '../conexion.php'; 
if (!isset($conexion) && isset($mysqli)) $conexion = $mysqli;

include '../NAVEGACION/header.php';
include '../NAVEGACION/navegacion.php';
?>

<div class="container my-4">
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header custom-header p-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0 fw-bold">Control de Alumnos</h4>
                <small class="opacity-75">Listado general de alumnos activos</small>
            </div>
            <div>
                <a href="../REGISTRO/alumnos.php" class="btn btn-light btn-sm fw-bold me-2">+ Nuevo Alumno</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light border-bottom">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4">ID</th>
                            <th>No. Control</th>
                            <th>Nombre Completo</th>
                            <th>Domicilio</th>
                            <th>Correo Electrónico</th>
                            <th>Teléfono</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($conexion) {
                            // Filtro para excluir alumnos en estatus 'BAJA'
                            $resultado = mysqli_query($conexion, "SELECT * FROM alumnos WHERE estatus != 'BAJA' OR estatus IS NULL");

                            if ($resultado && mysqli_num_rows($resultado) > 0) {
                                while ($row = mysqli_fetch_assoc($resultado)) {
                                    $id = $row['id'];
                                    $nocontrol = $row['nocontrol'] ?? '-';
                                    $nombre_completo = trim(($row['nombre'] ?? '') . ' ' . ($row['apaterno'] ?? '') . ' ' . ($row['amaterno'] ?? ''));
                                    $domicilio = $row['domicilio'] ?? '-';
                                    $correo = $row['correo'] ?? '-';
                                    $telefono = $row['telefono'] ?? '-';

                                    echo "<tr>";
                                    echo "<td class='ps-4'><span class='badge bg-primary-subtle text-primary fw-bold px-2 py-1'>" . htmlspecialchars($id) . "</span></td>";
                                    echo "<td class='fw-semibold text-dark'>" . htmlspecialchars($nocontrol) . "</td>";
                                    echo "<td class='fw-semibold text-dark'>" . htmlspecialchars($nombre_completo) . "</td>";
                                    echo "<td class='text-muted small'>" . htmlspecialchars($domicilio) . "</td>";
                                    echo "<td class='text-muted small'>" . htmlspecialchars($correo) . "</td>";
                                    echo "<td class='text-muted small'>" . htmlspecialchars($telefono) . "</td>";
                                    echo "<td class='text-end pe-4'>";
                                    echo "<a href='../MODIFICACIONES/modif_alum.php?id=" . urlencode($id) . "' class='btn btn-outline-primary btn-sm me-1'>Editar</a>";
                                    echo "<a href='../BAJA/baja_alum.php?id=" . urlencode($id) . "' class='btn btn-outline-danger btn-sm'>Eliminar</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center text-muted py-4'>No hay alumnos activos registrados.</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../NAVEGACION/footer.php'; ?>