<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1f4287 !important;">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">ESCUELA IICP</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto">
        
        <!-- PROCESOS -->
        <?php if ($_SESSION['rol'] === 'ADMIN' || $_SESSION['rol'] === 'PROFESOR'): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Procesos
          </a>
          <ul class="dropdown-menu">
            <?php if ($_SESSION['rol'] === 'ADMIN'): ?>
              <li><a class="dropdown-item" href="../PROCESO/inscripcion_grupos.php">Inscripción a Grupos</a></li>
              <li><a class="dropdown-item" href="../PROCESO/asignacion_materias.php">Asignación de Materias</a></li>
            <?php endif; ?>
            <li><a class="dropdown-item" href="../PROCESO/captura_calificaciones.php">Captura de Calificaciones</a></li>
          </ul>
        </li>
        <?php endif; ?>

        <!-- CATÁLOGOS / CRUD -->
        <?php if ($_SESSION['rol'] === 'ADMIN' || $_SESSION['rol'] === 'PROFESOR'): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Catálogos
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../CRUDE/crudealumnos.php">Control de Alumnos</a></li>
            <?php if ($_SESSION['rol'] === 'ADMIN'): ?>
              <li><a class="dropdown-item" href="../CRUDE/crudeprofesores.php">Control de Profesores</a></li>
              <li><a class="dropdown-item" href="../CRUDE/crudegrupos.php">Control de Grupos</a></li>
              <li><a class="dropdown-item" href="../CRUDE/crudematerias.php">Control de Materias</a></li>
            <?php endif; ?>
          </ul>
        </li>
        <?php endif; ?>

        <!-- REPORTES / CONSULTAS -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= ($_SESSION['rol'] === 'ALUMNO') ? 'Mis Calificaciones' : 'Reportes' ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../REPORTES/alumnos.php"><?= ($_SESSION['rol'] === 'ALUMNO') ? 'Mi Boleta' : 'Reporte de Alumnos' ?></a></li>
            <?php if ($_SESSION['rol'] !== 'ALUMNO'): ?>
              <li><a class="dropdown-item" href="../REPORTES/profesores.php">Reporte de Profesores</a></li>
              <li><a class="dropdown-item" href="../REPORTES/grupos.php">Reporte de Grupos</a></li>
              <li><a class="dropdown-item" href="../REPORTES/materias.php">Reporte de Materias</a></li>
            <?php endif; ?>
          </ul>
        </li>

      </ul>

      <!-- ROL DE USUARIO Y BOTÓN SALIR -->
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item me-3 text-light small">
          <i class="bi bi-person-circle me-1"></i> 
          <strong><?= htmlspecialchars($_SESSION['nombre'] ?? $_SESSION['usuario']) ?></strong> 
          <span class="badge bg-light text-dark ms-1"><?= $_SESSION['rol'] ?></span>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold" href="../logout.php">
            <i class="bi bi-box-arrow-right me-1"></i> Salir
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>