<?php
session_start();
require 'conexion.php'; // conexión PDO $pdo

$mensaje_inscripcion = '';

// Manejo de formulario de inscripción (solo usuarios logueados)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscribir']) && isset($_SESSION['user_id'])) {
    $equipo   = trim($_POST['equipo'] ?? '');
    $curso    = trim($_POST['curso'] ?? '');
    $jugador1 = trim($_POST['jugador1'] ?? '');
    $jugador2 = trim($_POST['jugador2'] ?? '');

    if ($jugador1 === '' || $curso === '') {
        $mensaje_inscripcion = '<div class="alert alert-danger">Por favor completa el nombre del jugador 1 y el curso.</div>';
    } else {
        $stmt = $pdo->prepare("INSERT INTO tenis_jugadores (equipo, curso, jugador1, jugador2) VALUES (:equipo, :curso, :jugador1, :jugador2)");
        $stmt->execute([
            ':equipo'   => $equipo ?: 'Equipo ' . rand(1,100),
            ':curso'    => $curso,
            ':jugador1' => $jugador1,
            ':jugador2' => $jugador2,
        ]);
        $mensaje_inscripcion = "<div class='alert alert-success'>¡Inscripción recibida para <strong>" . htmlspecialchars($jugador1) . "</strong>!</div>";
    }
}

// Obtener equipos inscritos
$equipos = [];
$stmt = $pdo->query("SELECT * FROM tenis_jugadores ORDER BY id ASC");
while ($row = $stmt->fetch()) {
    $key = $row['equipo'] . '|' . $row['curso'];
    if (!isset($equipos[$key])) $equipos[$key] = [];
    $equipos[$key][] = $row['jugador1'];
    if (!empty($row['jugador2'])) $equipos[$key][] = $row['jugador2'];
}

// Obtener máximos puntajes
$maximos = $pdo->query("SELECT jugador1, equipo, curso, puntos FROM tenis_jugadores ORDER BY puntos DESC LIMIT 10")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Tenis de Mesa - Portivoo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="assets/css/styles.css">
<style>
.highlight-player-mesa {
  background: linear-gradient(135deg, rgba(30,144,255,0.12), rgba(255,255,255,0.06));
  border: 1px solid rgba(30,144,255,0.12);
  padding: 18px;
  border-radius: 12px;
}
.drill-card img { height: 160px; object-fit: cover; border-radius: 8px; }
.stat-bar { height: 16px; border-radius: 8px; }
.video-thumb { cursor: pointer; border-radius: 8px; }
.challenge-box { background: rgba(255,255,255,0.05); padding: 14px; border-radius: 10px; }
</style>
</head>
<body class="bg-dark text-white">

<?php include 'partials/navbar.php'; ?>

<main class="container mt-5 mb-5">
<header class="text-center mb-4">
<h1 class="fw-bold">🏓 Tenis de Mesa Escolar</h1>
<p class="opacity-75">Reflejos, precisión y mente fría</p>
</header>

<?php if ($mensaje_inscripcion !== ''): ?>
<div class="row justify-content-center mb-4">
  <div class="col-md-8"><?php echo $mensaje_inscripcion; ?></div>
</div>
<?php endif; ?>

<div class="row g-4">
<div class="col-lg-7">
  <!-- Jugador destacado -->
  <section class="mb-4 highlight-player-mesa text-center text-dark">
    <h4 class="fw-bold">Jugador destacado del mes</h4>
    <img src="./img/Laura_torres.png" alt="Jugador destacado" class="rounded-circle my-3" style="width:110px;height:110px;object-fit:cover;">
    <p class="mb-1"><strong>Laura Torres — 9°B</strong></p>
    <p class="small text-dark">Victorias: 12 | Servicios ganadores: 26 | Espíritu deportivo: ★★★★★</p>
    <div class="mt-2">
      <button class="btn btn-primary btn-sm" id="verPerfilBtn"><i class="fa-solid fa-user"></i> Ver perfil</button>
     <a href="https://vt.tiktok.com/ZSyydGmt1//" target="_blank" class="btn btn-outline-light btn-sm">
  <i class="fa-solid fa-video"></i> Jugada destacada
</a>

    </div>
  </section>

  <!-- Carrusel -->
  <section class="mb-4">
    <h5 class="fw-bold mb-3">Entrenamientos destacados</h5>
    <div id="carouselMesa" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="./img/tenis_1.jpg" class="d-block w-100" style="height:300px;object-fit:cover;">
          <div class="carousel-caption d-none d-md-block"><h6>Servicio con efecto</h6></div>
        </div>
        <div class="carousel-item">
          <img src="./img/tenis_2.jpg" class="d-block w-100" style="height:300px;object-fit:cover;">
          <div class="carousel-caption d-none d-md-block"><h6>Bloqueo defensivo</h6></div>
        </div>
        <div class="carousel-item">
          <img src="./img/tenis_3.jpg" class="d-block w-100" style="height:300px;object-fit:cover;">
          <div class="carousel-caption d-none d-md-block"><h6>Smash ganador</h6></div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselMesa" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselMesa" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </section>

  <!-- Tabla equipos inscritos -->
  <section class="mb-4">
    <h5 class="fw-bold">📋 Equipos Inscritos</h5>
    <div class="table-responsive">
      <table class="table table-dark table-striped">
        <thead>
          <tr><th>Equipo</th><th>Curso</th><th>Jugador 1</th><th>Jugador 2</th></tr>
        </thead>
        <tbody>
          <?php foreach($equipos as $key => $jugadores_equipo): 
            list($equipo, $curso) = explode('|', $key);
          ?>
          <tr>
            <td><?= htmlspecialchars($equipo) ?></td>
            <td><?= htmlspecialchars($curso) ?></td>
            <td><?= $jugadores_equipo[0] ?? '-' ?></td>
            <td><?= $jugadores_equipo[1] ?? '-' ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

  <!-- Máximos puntajes -->
  <section class="mb-4">
    <h5 class="fw-bold">🏅 Máximos puntajes</h5>
    <div class="table-responsive">
      <table class="table table-dark table-striped">
        <thead><tr><th>Jugador</th><th>Equipo</th><th>Curso</th><th>Puntos</th></tr></thead>
        <tbody>
          <?php foreach($maximos as $m): ?>
          <tr>
            <td><?= htmlspecialchars($m['jugador1']) ?></td>
            <td><?= htmlspecialchars($m['equipo']) ?></td>
            <td><?= htmlspecialchars($m['curso']) ?></td>
            <td><?= htmlspecialchars($m['puntos']) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>
</div>

<!-- Columna derecha: Inscripción -->
<div class="col-lg-5">
  <?php if(isset($_SESSION['user_id'])): ?>
  <aside class="mb-4 p-3 bg-dark rounded">
    <h5 class="fw-bold">Inscripción rápida</h5>
    <form method="post" class="mt-2">
      <div class="mb-2"><input class="form-control" name="equipo" placeholder="Nombre del equipo"></div>
      <div class="mb-2"><input class="form-control" name="curso" placeholder="Curso"></div>
      <div class="mb-2"><input class="form-control" name="jugador1" placeholder="Jugador 1"></div>
      <div class="mb-2"><input class="form-control" name="jugador2" placeholder="Jugador 2"></div>
      <div class="d-grid"><button class="btn btn-primary" name="inscribir" type="submit"><i class="fa-solid fa-table-tennis-paddle-ball"></i> Inscribirme</button></div>
    </form>
  </aside>
  <?php else: ?>
  <div class="alert alert-warning text-center mt-3">
    ⚠ Debes <a href="login.php" class="text-decoration-underline">iniciar sesión</a> para inscribir un equipo.
  </div>
  <?php endif; ?>
</div>
</div>
</main>

<?php include 'partials/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openVideo(url){
  const iframe = document.getElementById('videoIframe');
  iframe.src = url + '?autoplay=1';
  const modal = new bootstrap.Modal(document.getElementById('videoModal'));
  modal.show();
  document.getElementById('videoModal').addEventListener('hidden.bs.modal', () => { iframe.src=''; }, {once:true});
}
document.getElementById('verPerfilBtn')?.addEventListener('click', () => {
  alert('Perfil: Laura Torres — 9°B\nMano hábil: Diestro');
});
</script>

<!-- Modal Video -->
<div class="modal fade" id="videoModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title">Jugadas destacadas</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-0">
        <div class="ratio ratio-16x9"><iframe id="videoIframe" src="" allowfullscreen></iframe></div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
