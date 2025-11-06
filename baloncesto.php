<?php 
session_start();
require_once "conexion.php"; // $pdo definido aquí

$mensaje_inscripcion = '';

// Manejo de formulario de inscripción de equipo (solo si está logueado)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscribir_equipo']) && isset($_SESSION['user_id'])) {
    $nombre_equipo = trim($_POST['nombre_equipo'] ?? '');
    $curso = trim($_POST['curso'] ?? '');
    $jugadores = [];

    if ($nombre_equipo === '' || $curso === '') {
        $mensaje_inscripcion = '<div class="alert alert-danger text-center">⚠ Debes ingresar nombre del equipo y curso.</div>';
    } else {
        for ($i=1; $i<=5; $i++) {
            $j = trim(string: $_POST["jugador$i"] ?? '');
            if ($j === '') {
                $mensaje_inscripcion = '<div class="alert alert-danger text-center">Todos los 5 jugadores son obligatorios.</div>';
                break;
            }
            $jugadores[] = $j;
        }

        if ($mensaje_inscripcion === '') {
            $stmt = $pdo->prepare(
                "INSERT INTO basquetbol_jugadores 
                (nombre_equipo, curso, jugador1, jugador2, jugador3, jugador4, jugador5, fecha_registro, puntos)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 0)"
            );
            $stmt->execute(array_merge([$nombre_equipo, $curso], $jugadores));
            $mensaje_inscripcion = '<div class="alert alert-success text-center">✅ Equipo <strong>' . htmlspecialchars($nombre_equipo) . '</strong> inscrito con éxito 🎉</div>';
        }
    }
}

// Obtener equipos inscritos
$stmt_equipos = $pdo->query("SELECT * FROM basquetbol_jugadores ORDER BY fecha_registro DESC");
$equipos = $stmt_equipos->fetchAll(PDO::FETCH_ASSOC);

// Obtener máximos anotadores
$maximos = [];
foreach ($equipos as $eq) {
    for ($i=1; $i<=5; $i++) {
        $maximos[] = [
            'nombre' => $eq["jugador$i"],
            'equipo' => $eq['nombre_equipo'],
            'curso'  => $eq['curso'],
            'puntos' => $eq['puntos'] // se puede asignar puntos individuales si lo deseas
        ];
    }
}
usort($maximos, fn($a,$b)=>$b['puntos']-$a['puntos']);
$maximos = array_slice($maximos, 0, 10);

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Baloncesto - Portivoo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="assets/css/styles.css">
<style>
.highlight-player-basket { 
    background: rgba(255,116,0,0.14); 
    border: 1px solid rgba(255,116,0,0.12); 
    padding: 18px; 
    border-radius: 12px; 
    text-align:center; 
    color:#000; 
}
.drill-card img { height: 160px; object-fit: cover; border-radius: 8px; }
.stat-bar { height: 16px; border-radius: 8px; }
.challenge-box { background: rgba(255,255,255,0.04); padding: 14px; border-radius: 10px; }
.video-thumb { cursor: pointer; border-radius: 8px; }
</style>
</head>
<body>

<?php include 'partials/navbar.php'; ?>

<main class="container mt-5 mb-5">

<header class="text-center mb-4">
  <h1 class="fw-bold">🏀 Baloncesto Escolar</h1>
  <p class="opacity-75">Habilidad, velocidad y trabajo en equipo</p>
</header>

<?php if ($mensaje_inscripcion !== ''): ?>
<div class="row justify-content-center mb-4">
  <div class="col-md-8"><?php echo $mensaje_inscripcion; ?></div>
</div>
<?php endif; ?>

<div class="row g-4">

<!-- Columna izquierda -->
<div class="col-lg-7">

  <!-- Jugador destacado -->
  <section class="mb-4 highlight-player-basket">
    <h4 class="fw-bold">Jugador Destacado del Mes</h4>
    <img src="./img/Juan_perez1.png" class="rounded-circle my-3" style="width:110px;height:110px;object-fit:cover;">
    <p class="mb-1"><strong>Juan Pérez — 10°A</strong></p>
    <p class="small">Puntos: 52 | Asistencias: 18 | Espíritu deportivo: ★★★★★</p>
    <div class="mt-2">
      <button class="btn btn-warning btn-sm" id="verPerfilBtn"><i class="fa-solid fa-user"></i> Ver perfil</button>
      <a href="https://vt.tiktok.com/ZSyyd696R/" target="_blank" class="btn btn-outline-light btn-sm">
  <i class="fa-solid fa-video"></i> Jugada destacada
</a>
  </section>

  <!-- Carrusel de entrenamientos -->
  <section class="mb-4">
    <h5 class="fw-bold mb-3">Entrenamientos destacados</h5>
    <div id="carouselBasket" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="./img/baloncesto_1.jpg" class="d-block w-100" style="height:300px;object-fit:cover;">
        </div>
        <div class="carousel-item">
          <img src="./img/baloncesto_2.jpg" class="d-block w-100" style="height:300px;object-fit:cover;">
        </div>
        <div class="carousel-item">
          <img src="./img/baloncesto_3.jpg" class="d-block w-100" style="height:300px;object-fit:cover;">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselBasket" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselBasket" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </section>

  <!-- Reto semanal -->
  <section class="mb-4">
    <h5 class="fw-bold mb-2">🏆 Reto semanal</h5>
    <div class="challenge-box">
      <p class="mb-1"><strong>Reto:</strong> 50 tiros libres en 10 minutos. Registra tu intento en el formulario de tu equipo.</p>
      <small class="text-muted">Se premiará en la clase de educación física.</small>
    </div>
  </section>

</div>

<!-- Columna derecha -->
<div class="col-lg-5">

  <?php if(isset($_SESSION['user_id'])): ?>
  <!-- Inscripción equipo -->
  <aside class="mb-4 p-3 bg-dark rounded">
    <h5 class="fw-bold">🏀 Inscribir Equipo de Baloncesto</h5>
    <form method="post" class="mt-3">
      <input class="form-control mb-2" name="nombre_equipo" placeholder="Nombre del equipo" required>
      <input class="form-control mb-2" name="curso" placeholder="Curso (Ej: 10°B)" required>
      <h6 class="fw-bold">Jugadores (5)</h6>
      <?php for ($i=1; $i<=5; $i++): ?>
        <input class="form-control mb-2" name="jugador<?= $i ?>" placeholder="Jugador <?= $i ?>" required>
      <?php endfor; ?>
      <button name="inscribir_equipo" class="btn btn-warning w-100 mt-3"><i class="fa-solid fa-users"></i> Registrar Equipo</button>
    </form>
  </aside>
  <?php else: ?>
  <div class="alert alert-warning text-center mt-3">
    ⚠ Debes <a href="login.php" class="text-decoration-underline">iniciar sesión</a> para inscribir un equipo.
  </div>
  <?php endif; ?>

</div>
</div>

<!-- Tabla de equipos inscritos -->
<section class="mt-5">
<h5 class="fw-bold text-center mb-3">📋 Equipos Inscritos</h5>
<div class="table-responsive">
<table class="table table-dark table-striped text-center">
  <thead>
    <tr>
      <th>Equipo</th>
      <th>Curso</th>
      <?php for($i=1;$i<=5;$i++): ?><th>Jugador <?= $i ?></th><?php endfor; ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach($equipos as $eq): ?>
    <tr>
      <td><?= htmlspecialchars($eq['nombre_equipo']) ?></td>
      <td><?= htmlspecialchars($eq['curso']) ?></td>
      <?php for($i=1;$i<=5;$i++): ?><td><?= htmlspecialchars($eq["jugador$i"]) ?></td><?php endfor; ?>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
</section>

<!-- Tabla de máximos anotadores -->
<section class="mt-5">
<h5 class="fw-bold text-center mb-3">🏅 Máximos Anotadores</h5>
<div class="table-responsive">
<table class="table table-dark table-striped text-center">
  <thead><tr><th>Jugador</th><th>Equipo</th><th>Curso</th><th>Puntos</th></tr></thead>
  <tbody>
    <?php foreach($maximos as $m): ?>
      <tr>
        <td><?= htmlspecialchars($m['nombre']) ?></td>
        <td><?= htmlspecialchars($m['equipo']) ?></td>
        <td><?= htmlspecialchars($m['curso']) ?></td>
        <td><?= htmlspecialchars($m['puntos']) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
</section>

</main>

<!-- Modal Video -->
<div class="modal fade" id="videoModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title">Video técnico</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-0">
        <div class="ratio ratio-16x9">
          <iframe id="videoIframe" src="" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'partials/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openVideo(url){
  const iframe = document.getElementById('videoIframe');
  iframe.src = url+'?autoplay=1&rel=0';
  const modal = new bootstrap.Modal(document.getElementById('videoModal'));
  modal.show();
  document.getElementById('videoModal').addEventListener('hidden.bs.modal', ()=>{iframe.src='';},{once:true});
}

document.getElementById('verPerfilBtn')?.addEventListener('click', ()=>{
  alert('Perfil: Juan Pérez — 10°A\nBase armador. Entrena L-M-V 2:00pm.');
});
</script>

</body>
</html>
