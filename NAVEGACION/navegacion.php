<?php
$base = file_exists('conexion.php') ? '' : '../';
?>
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm mb-4" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
  <div class="container">
    <a class="navbar-brand fw-bold text-uppercase" href="<?php echo $base; ?>CRUDE/crudealumnos.php">
      🎓 ESCUELA IICP
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
        <!-- Registros -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-semibold" href="#" id="dropRegistro" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ✏️ Registros
          </a>
          <ul class="dropdown-menu shadow border-0" aria-labelledby="dropRegistro">
            <li><a class="dropdown-item" href="<?php echo $base; ?>REGISTRO/alumnos.php">Alumnos</a></li>
            <li><a class="dropdown-item" href="<?php echo $base; ?>REGISTRO/profesores.php">Profesores</a></li>
            <li><a class="dropdown-item" href="<?php echo $base; ?>REGISTRO/grupos.php">Grupos</a></li>
            <li><a class="dropdown-item" href="<?php echo $base; ?>REGISTRO/materias.php">Materias</a></li>
            <li><a class="dropdown-item" href="<?php echo $base; ?>REGISTRO/unidades.php">Unidades</a></li>
          </ul>
        </li>

        <!-- Procesos -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-semibold" href="#" id="dropProcesos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ⚙️ Procesos
          </a>
          <ul class="dropdown-menu shadow border-0" aria-labelledby="dropProcesos">
            <li><a class="dropdown-item" href="<?php echo $base; ?>PROCESO/inscripcion_grupos.php">Inscripción a grupos</a></li>
            <li><a class="dropdown-item" href="<?php echo $base; ?>PROCESO/asignacion_materias.php">Asignación de materias</a></li>
            <li><a class="dropdown-item" href="<?php echo $base; ?>PROCESO/captura_calificaciones.php">Captura de calificaciones</a></li>
          </ul>
        </li>

        <!-- Catálogos -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-semibold" href="#" id="dropCatalogos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            📋 Catálogos
          </a>
          <ul class="dropdown-menu shadow border-0" aria-labelledby="dropCatalogos">
            <li><a class="dropdown-item" href="<?php echo $base; ?>CRUDE/crudealumnos.php">Alumnos</a></li>
            <li><a class="dropdown-item" href="<?php echo $base; ?>CRUDE/crudeprofesores.php">Profesores</a></li>
            <li><a class="dropdown-item" href="<?php echo $base; ?>CRUDE/crudematerias.php">Materias</a></li>
            <li><a class="dropdown-item" href="<?php echo $base; ?>CRUDE/crudegrupos.php">Grupos</a></li>
          </ul>
        </li>

        <!-- Reportes -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-semibold" href="#" id="dropReportes" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            📊 Reportes
          </a>
          <ul class="dropdown-menu shadow border-0" aria-labelledby="dropReportes">
            <li><a class="dropdown-item" href="<?php echo $base; ?>REPORTES/alumnos.php">Alumnos</a></li>
            <li><a class="dropdown-item" href="<?php echo $base; ?>REPORTES/profesores.php">Profesores</a></li>
            <li><a class="dropdown-item" href="<?php echo $base; ?>REPORTES/materias.php">Materias</a></li>
            <li><a class="dropdown-item" href="<?php echo $base; ?>REPORTES/grupos.php">Grupos</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>