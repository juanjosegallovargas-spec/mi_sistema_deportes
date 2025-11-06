<?php
session_start();
require_once "conexion.php"; // $pdo definido aquí

$mensaje_inscripcion = '';

// --- Manejo del formulario de inscripción ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscribir_equipo']) && isset($_SESSION['user_id'])) {
    $nombre_equipo = trim($_POST['nombre_equipo'] ?? '');
    $curso = trim($_POST['curso'] ?? '');
    $jugadores = [];

    if ($nombre_equipo === '' || $curso === '') {
        $mensaje_inscripcion = '<div class="alert alert-danger text-center">⚠ Debes ingresar nombre del equipo y curso.</div>';
    } else {
        for ($i=1; $i<=11; $i++) {
            $j = trim($_POST["jugador$i"] ?? '');
            if ($j === '') {
                $mensaje_inscripcion = '<div class="alert alert-danger text-center">Todos los 11 jugadores son obligatorios.</div>';
                break;
            }
            $jugadores[] = $j;
        }

        if ($mensaje_inscripcion === '') {
            $stmt = $pdo->prepare(
                "INSERT INTO futbol_jugadores 
                (nombre_equipo, curso, jugador1, jugador2, jugador3, jugador4, jugador5, jugador6, jugador7, jugador8, jugador9, jugador10, jugador11, fecha_registro, goles)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)"
            );
            $stmt->execute(array_merge([$nombre_equipo, $curso], $jugadores, [0]));
            $mensaje_inscripcion = '<div class="alert alert-success text-center">✅ Equipo <strong>' . htmlspecialchars($nombre_equipo) . '</strong> inscrito con éxito 🎉</div>';
        }
    }
}

// --- Obtener equipos inscritos ---
$stmt_equipos = $pdo->query("SELECT * FROM futbol_jugadores ORDER BY fecha_registro DESC");
$equipos = $stmt_equipos->fetchAll(PDO::FETCH_ASSOC);

// --- Calcular máximos goleadores ---
$maximos = [];
foreach($equipos as $eq){
    for($i=1; $i<=11; $i++){
        if(!empty($eq["jugador$i"])){
            $maximos[] = [
                'nombre' => $eq["jugador$i"],
                'equipo' => $eq['nombre_equipo'],
                'curso' => $eq['curso'],
                'goles' => intval($eq['goles'] ?? 0)
            ];
        }
    }
}
usort($maximos, function($a,$b){ return $b['goles'] <=> $a['goles']; });
$maximos = array_slice($maximos, 0, 10);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Fútbol - Portivoo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="assets/css/styles.css">
<style>
.highlight-player-foot { background: linear-gradient(135deg, rgba(0,116,255,0.14), rgba(50,50,50,0.1)); border: 1px solid rgba(0,116,255,0.12); padding: 18px; border-radius: 12px; }
.drill-card img { height: 160px; object-fit: cover; border-radius: 8px; }
.stat-bar { height: 16px; border-radius: 8px; }
.challenge-box { background: rgba(255,255,255,0.04); padding: 14px; border-radius: 10px; }
.video-thumb { cursor: pointer; border-radius: 8px; }
</style>
</head>
<body class="bg-dark text-white">

<?php include 'partials/navbar.php'; ?>

<main class="container mt-5 mb-5">
<header class="text-center mb-4">
  <h1 class="fw-bold">⚽ Fútbol Escolar</h1>
  <p class="opacity-75">Habilidad, estrategia y trabajo en equipo</p>
</header>

<?php if ($mensaje_inscripcion !== ''): ?>
<div class="row justify-content-center mb-4">
  <div class="col-md-8"><?php echo $mensaje_inscripcion; ?></div>
</div>
<?php endif; ?>

<div class="row g-4">
<div class="col-lg-7">
  <!-- Jugador destacado -->
  <section class="mb-4 highlight-player-foot text-center text-dark">
    <h4 class="fw-bold">Jugador Destacado del Mes</h4>
    <img src="img/Carlos_Gomez.png" class="rounded-circle my-3" style="width:110px;height:110px;object-fit:cover;">
    <p class="mb-1"><strong>Carlos Gómez — 11°C</strong></p>
    <p class="small text-dark">Goles: 10 | Asistencias: 7 | Espíritu deportivo: ★★★★★</p>
    <div class="mt-2">
      <button class="btn btn-primary btn-sm" id="verPerfilBtn"><i class="fa-solid fa-user"></i> Ver perfil</button>
<a href="https://vt.tiktok.com/ZSyydJX17/" target="_blank" class="btn btn-outline-light btn-sm">
  <i class="fa-solid fa-video"></i> Jugada destacada
</a>
    </div>
  </section>

  <!-- Entrenamientos y reto semanal -->
  <section class="mb-4">
    <h5 class="fw-bold mb-3">Entrenamientos destacados</h5>
    <div id="carouselFutbol" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="img/tirosporteria.png" class="d-block w-100" style="height:300px;object-fit:cover;">
          <div class="carousel-caption d-none d-md-block"><h6>Tiros a portería</h6></div>
        </div>
        <div class="carousel-item">
          <img src="img/Pases.png" class="d-block w-100" style="height:300px;object-fit:cover;">
          <div class="carousel-caption d-none d-md-block"><h6>Pases y estrategia</h6></div>
        </div>
        <div class="carousel-item">
          <img src="img/entrenamientos.png" class="d-block w-100" style="height:300px;object-fit:cover;">
          <div class="carousel-caption d-none d-md-block"><h6>Defensa y bloqueos</h6></div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselFutbol" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselFutbol" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </section>

  <!-- Tabla de equipos inscritos -->
<section class="mt-5">
<h5 class="fw-bold text-center mb-3">📋 Equipos Inscritos</h5>
<div class="table-responsive">
<table class="table table-dark table-striped text-center align-middle">
  <thead class="table-primary text-dark">
    <tr>
      <th>Equipo</th>
      <th>Curso</th>
      <?php for($i=1;$i<=11;$i++): ?><th>Jugador <?= $i ?></th><?php endfor; ?>
      <th>Goles</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($equipos as $eq): ?>
    <tr>
      <td><?= htmlspecialchars($eq['nombre_equipo']) ?></td>
      <td><?= htmlspecialchars($eq['curso']) ?></td>
      <?php for($i=1;$i<=11;$i++): ?><td><?= htmlspecialchars($eq["jugador$i"]) ?></td><?php endfor; ?>
      <td><?= htmlspecialchars($eq['goles']) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
</section>

<!-- Tabla máximos goleadores -->
<section class="mt-5">
<h5 class="fw-bold text-center mb-3">🏅 Máximos Goleadores</h5>
<div class="table-responsive">
<table class="table table-dark table-striped text-center align-middle">
  <thead class="table-primary text-dark">
    <tr>
      <th>#</th>
      <th>Jugador</th>
      <th>Equipo</th>
      <th>Curso</th>
      <th>Goles</th>
      <th>⚽</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($maximos as $index => $m):
        $badgeClass = '';
        if($index==0) $badgeClass='bg-warning text-dark fw-bold';
        elseif($index==1) $badgeClass='bg-secondary text-white fw-bold';
        elseif($index==2) $badgeClass='bg-info text-dark fw-bold';
    ?>
    <tr class="<?= $badgeClass ?>">
      <td><?= $index + 1 ?></td>
      <td><?= htmlspecialchars($m['nombre']) ?></td>
      <td><?= htmlspecialchars($m['equipo']) ?></td>
      <td><?= htmlspecialchars($m['curso']) ?></td>
      <td><?= htmlspecialchars($m['goles']) ?></td>
      <td><?= str_repeat('⚽', min($m['goles'],10)) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
</section>

</div>

<!-- Columna derecha -->
<div class="col-lg-5">
  <?php if (isset($_SESSION['user_id'])): ?>
  <!-- Inscripción equipo -->
  <aside class="mb-4 p-3 bg-dark rounded">
    <h5 class="fw-bold">⚽ Inscribir Equipo de Fútbol</h5>
    <form method="post" class="mt-3">
      <input class="form-control mb-2" name="nombre_equipo" placeholder="Nombre del equipo" required>
      <input class="form-control mb-2" name="curso" placeholder="Curso (Ej: 11°C)" required>
      <h6 class="fw-bold">Jugadores (11)</h6>
      <?php for($i=1;$i<=11;$i++): ?>
        <input class="form-control mb-2" name="jugador<?= $i ?>" placeholder="Jugador <?= $i ?>" required>
      <?php endfor; ?>
      <button name="inscribir_equipo" class="btn btn-primary w-100 mt-3"><i class="fa-solid fa-users"></i> Registrar Equipo</button>
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
  const iframe=document.getElementById('videoIframe');
  iframe.src=url+'?autoplay=1&rel=0';
  const modal=new bootstrap.Modal(document.getElementById('videoModal'));
  modal.show();
  document.getElementById('videoModal').addEventListener('hidden.bs.modal',()=>{iframe.src='';},{once:true});
}
document.getElementById('verPerfilBtn')?.addEventListener('click',()=>{
  alert('Perfil: Carlos Gómez — 11°C\nDelantero. Entrena L-M-V 3:00pm.');
});
</script>
