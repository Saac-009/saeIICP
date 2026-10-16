<?php
include '../conexion.php'; 
if (!isset($conexion) && isset($mysqli)) $conexion = $mysqli;

include '../NAVEGACION/header.php';
include '../NAVEGACION/navegacion.php';
?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header custom-header p-4">
                    <h4 class="mb-0 fw-bold">Registro de Unidades</h4>
                    <small class="opacity-75">Ingrese la información completa de la unidad</small>
                </div>
                <div class="card-body p-4">
                    <form action="../PROCESO/procesar_unidades.php" method="POST">
                        <div class="mb-3">
                            <label for="id_unidad" class="form-label fw-semibold">ID / Número de Unidad</label>
                            <input type="number" class="form-control" id="id_unidad" name="id_unidad" placeholder="Ej. 1, 2, 3..." required>
                        </div>
                        <div class="mb-4">
                            <label for="descripcion" class="form-label fw-semibold">Descripción de la Unidad</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Ej. Unidad 1: Introducción a las bases de datos..." required></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary fw-bold px-4" style="background: #1e3c72; border: none;">Registrar Unidad</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../NAVEGACION/footer.php'; ?>