<?php
include '../conexion.php'; 
if (!isset($conexion) && isset($mysqli)) $conexion = $mysqli;

include '../NAVEGACION/header.php';
include '../NAVEGACION/navegacion.php';
?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header custom-header p-4">
                    <h4 class="mb-0 fw-bold">Registro de Alumno</h4>
                    <small class="opacity-75">Ingrese la información completa del alumno</small>
                </div>
                <div class="card-body p-4">
                    <form action="../PROCESO/procesar_alumnos.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nocontrol_alum" class="form-label fw-semibold">No. Control</label>
                                <input type="text" class="form-control" id="nocontrol_alum" name="nocontrol_alum" placeholder="Ej. A12345">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nombre_alum" class="form-label fw-semibold">Nombre(s)</label>
                                <input type="text" class="form-control" id="nombre_alum" name="nombre_alum" placeholder="Ingrese el nombre" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="apaterno_alum" class="form-label fw-semibold">Apellido Paterno</label>
                                <input type="text" class="form-control" id="apaterno_alum" name="apaterno_alum" placeholder="Apellido paterno">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="amaterno_alum" class="form-label fw-semibold">Apellido Materno</label>
                                <input type="text" class="form-control" id="amaterno_alum" name="amaterno_alum" placeholder="Apellido materno">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="dom_alum" class="form-label fw-semibold">Domicilio</label>
                            <input type="text" class="form-control" id="dom_alum" name="dom_alum" placeholder="Calle, Número, Colonia, Ciudad">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="mail_alum" class="form-label fw-semibold">Correo Electrónico</label>
                                <input type="email" class="form-control" id="mail_alum" name="mail_alum" placeholder="alumno@correo.com">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="tel_alum" class="form-label fw-semibold">Teléfono</label>
                                <input type="tel" class="form-control" id="tel_alum" name="tel_alum" placeholder="Ej. 2291234567">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="../CRUDE/crudealumnos.php" class="btn btn-outline-secondary">Ver Alumnos</a>
                            <button type="submit" class="btn btn-primary fw-bold px-4" style="background: #1e3c72; border: none;">Guardar Registro</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../NAVEGACION/footer.php'; ?>