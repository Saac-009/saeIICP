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
                <h4 class="mb-0 fw-bold">Catálogo de Materias</h4>
                <small class="opacity-75">Listado general de materias activas</small>
            </div>
            <div>
                <a href="../REGISTRO/materias.php" class="btn btn-light btn-sm fw-bold me-2">+ Nueva Materia</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light border-bottom">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4">ID</th>
                            <th>Materia</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($conexion) {
                            $resultado = mysqli_query($conexion, "SELECT * FROM materias WHERE estatus != 'BAJA' OR estatus IS NULL");

                            if ($resultado && mysqli_num_rows($resultado) > 0) {
                                while ($row = mysqli_fetch_assoc($resultado)) {
                                    $id = $row['id'];
                                    $nombre = $row['nombre'];

                                    echo "<tr>";
                                    echo "<td class='ps-4'><span class='badge bg-primary-subtle text-primary fw-bold px-2 py-1'>" . htmlspecialchars($id) . "</span></td>";
                                    echo "<td class='fw-semibold text-dark'>" . htmlspecialchars($nombre) . "</td>";
                                    echo "<td class='text-end pe-4'>";
                                    echo "<a href='../MODIFICACIONES/modif_mat.php?id=" . urlencode($id) . "' class='btn btn-outline-primary btn-sm me-1'>Editar</a>";
                                    echo "<a href='../BAJA/baja_mat.php?id=" . urlencode($id) . "' class='btn btn-outline-danger btn-sm'>Eliminar</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3' class='text-center text-muted py-4'>No hay materias activas registradas.</td></tr>";
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