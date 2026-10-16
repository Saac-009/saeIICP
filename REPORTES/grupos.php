<?php
include '../conexion.php'; 
if (!isset($conexion) && isset($mysqli)) $conexion = $mysqli;

include '../NAVEGACION/header.php';
include '../NAVEGACION/navegacion.php';
?>

<div class="container my-4">
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header custom-header p-4">
            <h4 class="mb-0 fw-bold">Reporte de Grupos</h4>
            <small class="opacity-75">Total de alumnos inscritos por grupo</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4">ID Grupo</th>
                            <th>Nombre del Grupo</th>
                            <th>Total Alumnos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT g.id, g.nombre, COUNT(a.id) AS total_alumnos 
                                FROM grupo g 
                                LEFT JOIN alumnos a ON a.id_grupo = g.id 
                                GROUP BY g.id, g.nombre";
                        $res = mysqli_query($conexion, $sql);

                        if ($res && mysqli_num_rows($res) > 0) {
                            while ($r = mysqli_fetch_assoc($res)) {
                                echo "<tr>";
                                echo "<td class='ps-4'>{$r['id']}</td>";
                                echo "<td class='fw-semibold'>" . htmlspecialchars($r['nombre']) . "</td>";
                                echo "<td><span class='badge bg-primary px-3 py-2'>{$r['total_alumnos']} alumnos</span></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center text-muted py-4'>Sin registros.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../NAVEGACION/footer.php'; ?>