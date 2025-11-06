<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="main-header bg-dark py-3">
  <div class="container d-flex justify-content-between align-items-center">

    <a href="index.php" class="logo">
      <img src="./img/logo.png" alt="PORTIVOO" height="45">
    </a>

    <button class="menu-btn btn btn-light d-lg-none" onclick="document.querySelector('.main-nav').classList.toggle('active')">
      ☰
    </button>

    <nav class="main-nav d-flex gap-3 align-items-center flex-column flex-lg-row">
      <a href="index.php" class="text-white">Inicio</a>

      <div class="dropdown">
        <a class="dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">Deportes</a>
        <ul class="dropdown-menu glass-dropdown">
          <li><a class="dropdown-item" href="./futbol.php">Fútbol</a></li>
          <li><a class="dropdown-item" href="./baloncesto.php">Baloncesto</a></li>
          <li><a class="dropdown-item" href="./voleibol.php">Voleibol</a></li>
          <li><a class="dropdown-item" href="./tenis.php">Tenis de Mesa</a></li>
          <li><a class="dropdown-item" href="./ajedrez.php">Ajedrez</a></li>
        </ul>
      </div>

      <a href="./deportes_destacados.php" class="text-white">Deportes Destacados</a>
      <a href="./nosotros.php" class="text-white">Nosotros</a>
      <a href="./contactanos.php" class="text-white">Contáctanos</a>

      <?php if(isset($_SESSION['rol'])): ?>
        <?php if($_SESSION['rol'] === 'admin'): ?>
          <a href="./admin_panel.php" class="btn btn-warning">Administrar</a>
        <?php endif; ?>
        <a href="./logout.php" class="btn btn-outline-light">Salir</a>
      <?php else: ?>
        <a href="./login.php" class="btn btn-outline-light">Ingresar</a>
        <a href="./register.php" class="btn btn-warning">Registrar</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
