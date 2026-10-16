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
                    <h4 class="mb-0 fw-bold">Registro de Materia</h4>
                    <small class="opacity-75">Ingrese la información de la asignatura</small>
                </div>
                <div class="card-body p-4">
                    <form action="../PROCESO/procesar_materias.php" method="POST">
                        <div class="mb-4">
                            <label for="nombre" class="form-label fw-semibold">Nombre / Descripción de la Materia</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej. Programación II, Bases de Datos..." required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="../CRUDE/crudematerias.php" class="btn btn-outline-secondary">Ver Materias</a>
                            <button type="submit" class="btn btn-primary fw-bold px-4" style="background: #1e3c72; border: none;">Guardar Registro</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../NAVEGACION/footer.php'; ?>