<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portivoo Reloaded</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- CSS personalizado -->
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<!-- HEADER -->
<?php include 'partials/navbar.php'; ?>

<!-- CARRUSEL -->
<div id="carouselDeportes" class="carousel slide mt-3 mx-auto" data-bs-ride="carousel" style="max-width:90%;">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/Baloncesto.jpg" class="d-block w-100" style="height:350px; object-fit:cover;" alt="Baloncesto">
    </div>
    <div class="carousel-item">
      <img src="img/Futbol.jpg" class="d-block w-100" style="height:350px; object-fit:cover;" alt="Fútbol">
    </div>
    <div class="carousel-item">
      <img src="img/Voleibol.jpg" class="d-block w-100" style="height:350px; object-fit:cover;" alt="Voleibol">
    </div>
    <div class="carousel-item">
      <img src="img/Tenis_de_mesa.jpg" class="d-block w-100" style="height:350px; object-fit:cover;" alt="Tenis de mesa">
    </div>
  
  <div class="carousel-item">
      <img src="img/Ajedrez.jpg" class="d-block w-100" style="height:350px; object-fit:cover;" alt="Ajedrez">
   </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselDeportes" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselDeportes" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- SECCIÓN DEPORTES -->
<div class="container mt-5">
  <h2 class="text-center mb-4">Deportes Destacados</h2>
  <div class="row g-4">
    <div class="col-md-3">
      <a href="baloncesto.php" class="card text-decoration-none text-white h-100">
        <img src="img/Baloncesto1.jpg" class="card-img-top" style="height:180px; object-fit:cover;" alt="Baloncesto">
        <div class="card-body text-center">
          <h5 class="card-title">Baloncesto</h5>
        </div>
      </a>
    </div>
    <div class="col-md-3">
      <a href="futbol.php" class="card text-decoration-none text-white h-100">
        <img src="img/Futbol.jpg" class="card-img-top" style="height:180px; object-fit:cover;" alt="Fútbol">
        <div class="card-body text-center">
          <h5 class="card-title">Fútbol</h5>
        </div>
      </a>
    </div>
    <div class="col-md-3">
      <a href="voleibol.php" class="card text-decoration-none text-white h-100">
        <img src="img/Voleibol.jpg" class="card-img-top" style="height:180px; object-fit:cover;" alt="Voleibol">
        <div class="card-body text-center">
          <h5 class="card-title">Voleibol</h5>
        </div>
      </a>
    </div>
    <div class="col-md-3">
      <a href="tenis.php" class="card text-decoration-none text-white h-100">
        <img src="img/Tenis_de_mesa.jpg" class="card-img-top" style="height:180px; object-fit:cover;" alt="Tenis de mesa">
        <div class="card-body text-center">
          <h5 class="card-title">Tenis de mesa</h5>
        </div>
      </a>
    </div>
    <div class="col-md-3">
      <a href="ajedrez.php" class="card text-decoration-none text-white h-100">
        <img src="img/Ajedrez.jpg" class="card-img-top" style="height:180px; object-fit:cover;" alt="Voleibol">
        <div class="card-body text-center">
          <h5 class="card-title">Ajedrez</h5>
        </div>
      </a>
    </div>
     </div>
</div>

<!-- FOOTER -->
<footer class="bg-dark text-white mt-5 py-4">
  <div class="container text-center">
    <div class="d-flex justify-content-center align-items-center mb-3 gap-3 flex-wrap">
      <img src="img/cropped-Imagotipo-horizontal_acreditados.png" alt="Logo Pascual" height="40">
      <img src="img/IESanJuanBautista.png" alt="Logo San Juan Bautista" height="40">
    </div>
    <p>Instituciones: Pascual Bravo & San Juan Bautista</p>
    <p>📧 info@colegios.edu.co | 📞 (604) 444 4444</p>
    <p>Proyecto Deportivo Académico – Creado por estudiantes</p>
    <div class="mt-2">
      <a href="https://www.facebook.com/lasallemanrique" class="text-white mx-2"><i class="fab fa-facebook-f"></i></a>
      <a href="https://www.instagram.com/lasallemanrique/?hl=es" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
      <a href="https://www.youtube.com/@lasallecomunica9495" class="text-white mx-2"><i class="fab fa-youtube"></i></a>
    </div>
    <p class="mt-3 small opacity-75">© 2025 Proyecto Deportivo Académico</p>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
