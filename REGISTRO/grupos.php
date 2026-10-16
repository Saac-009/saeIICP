<?php
include '../conexion.php'; 
if (!isset($conexion) && isset($mysqli)) $conexion = $mysqli;

// 1. Cargar el header y la barra de navegación
include '../NAVEGACION/header.php';
include '../NAVEGACION/navegacion.php';
?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header custom-header p-4">
                    <h4 class="mb-0 fw-bold">Registro de Grupo</h4>
                    <small class="opacity-75">Ingrese el nombre o clave del grupo</small>
                </div>
                <div class="card-body p-4">
                    <form action="../PROCESO/procesar_grupos.php" method="POST">
                        <div class="mb-4">
                            <label for="nombre" class="form-label fw-semibold">Nombre / Descripción del Grupo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej. 4T1, Grupo A..." required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="../CRUDE/crudegrupos.php" class="btn btn-outline-secondary">Ver Grupos</a>
                            <button type="submit" class="btn btn-primary fw-bold px-4" style="background: #1e3c72; border: none;">Guardar Registro</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
// 2. Cargar el pie de página
include '../NAVEGACION/footer.php'; 
?>