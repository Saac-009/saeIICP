<?php
include '../conexion.php'; 
if (!isset($conexion) && isset($mysqli)) $conexion = $mysqli;

include '../NAVEGACION/header.php';
include '../NAVEGACION/navegacion.php';
?>

<div class="container my-4">
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header custom-header p-4">
            <h4 class="mb-0 fw-bold">Reporte de Profesores</h4>
            <small class="opacity-75">Información completa del personal docente</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4">ID</th>
                            <th>No. Control</th>
                            <th>Nombre Completo</th>
                            <th>Domicilio</th>
                            <th>Correo Electrónico</th>
                            <th class="pe-4">Teléfono</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM profesores WHERE (estatus != 'BAJA' OR estatus IS NULL)";
                        $res = mysqli_query($conexion, $sql);

                        if ($res && mysqli_num_rows($res) > 0) {
                            while ($r = mysqli_fetch_assoc($res)) {
                                $nocontrol = !empty($r['nocontrol']) ? $r['nocontrol'] : '-';
                                $nombre_completo = trim(($r['nombre'] ?? '') . ' ' . ($r['apaterno'] ?? '') . ' ' . ($r['amaterno'] ?? ''));
                                $domicilio = !empty($r['domicilio']) ? $r['domicilio'] : '-';
                                $correo = !empty($r['correo']) ? $r['correo'] : '-';
                                $telefono = !empty($r['telefono']) ? $r['telefono'] : '-';

                                echo "<tr>";
                                echo "<td class='ps-4'>{$r['id']}</td>";
                                echo "<td class='fw-semibold text-primary'>" . htmlspecialchars($nocontrol) . "</td>";
                                echo "<td class='fw-semibold text-dark'>" . htmlspecialchars($nombre_completo) . "</td>";
                                echo "<td class='text-muted small'>" . htmlspecialchars($domicilio) . "</td>";
                                echo "<td class='text-muted small'>" . htmlspecialchars($correo) . "</td>";
                                echo "<td class='text-muted small pe-4'>" . htmlspecialchars($telefono) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center text-muted py-4'>Sin registros activos.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../NAVEGACION/footer.php'; ?>