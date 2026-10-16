<?php
include '../conexion.php'; 
if (!isset($conexion) && isset($mysqli)) $conexion = $mysqli;

// 1. Cargar el header y la barra de navegación desde NAVEGACION
include '../NAVEGACION/header.php';
include '../NAVEGACION/navegacion.php';
?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header custom-header p-4">
                    <h4 class="mb-0 fw-bold">Registro de Profesor</h4>
                    <small class="opacity-75">Ingrese la información completa del docente</small>
                </div>
                <div class="card-body p-4">
                    <form action="../PROCESO/procesar_profesores.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nocontrol_prof" class="form-label fw-semibold">No. Control</label>
                                <input type="text" class="form-control" id="nocontrol_prof" name="nocontrol_prof" placeholder="Ej. P98765">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nombre_prof" class="form-label fw-semibold">Nombre(s)</label>
                                <input type="text" class="form-control" id="nombre_prof" name="nombre_prof" placeholder="Ingrese el nombre" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="apaterno_prof" class="form-label fw-semibold">Apellido Paterno</label>
                                <input type="text" class="form-control" id="apaterno_prof" name="apaterno_prof" placeholder="Apellido paterno">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="amaterno_prof" class="form-label fw-semibold">Apellido Materno</label>
                                <input type="text" class="form-control" id="amaterno_prof" name="amaterno_prof" placeholder="Apellido materno">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="dom_prof" class="form-label fw-semibold">Domicilio</label>
                            <input type="text" class="form-control" id="dom_prof" name="dom_prof" placeholder="Calle, Número, Colonia, Ciudad">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="mail_prof" class="form-label fw-semibold">Correo Electrónico</label>
                                <input type="email" class="form-control" id="mail_prof" name="mail_prof" placeholder="docente@correo.com">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="tel_prof" class="form-label fw-semibold">Teléfono</label>
                                <input type="tel" class="form-control" id="tel_prof" name="tel_prof" placeholder="Ej. 2299876543">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="../CRUDE/crudeprofesores.php" class="btn btn-outline-secondary">Ver Profesores</a>
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