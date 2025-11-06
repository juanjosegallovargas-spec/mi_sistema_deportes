<?php
session_start();
require_once "conexion.php"; // $pdo definido aquí

// ✅ Manejo del formulario de inscripción SOLO si hay usuario logueado
$mensaje_inscripcion = '';
if (isset($_SESSION['user_id'])) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscribir'])) {

        $nombre = trim($_POST['nombre'] ?? '');
        $curso  = trim($_POST['curso'] ?? '');
        $club   = trim($_POST['club'] ?? '');
        $observaciones = trim($_POST['observaciones'] ?? '');

        if ($nombre === '' || $curso === '') {
            $mensaje_inscripcion = '<div class="alert alert-danger text-center">Por favor completa tu nombre y curso.</div>';
        } else {
            $stmt = $pdo->prepare("INSERT INTO ajedrez_jugadores 
                (nombre, curso, club, observaciones, fecha_inscripcion, estado) 
                VALUES (?, ?, ?, ?, NOW(), 'pendiente')");
            if ($stmt->execute([$nombre, $curso, $club, $observaciones])) {
                $mensaje_inscripcion = "<div class='alert alert-success text-center'>
                ¡Gracias, <strong>" . htmlspecialchars($nombre) . "</strong>! Tu inscripción fue enviada correctamente.
                </div>";
            } else {
                $mensaje_inscripcion = '<div class="alert alert-danger text-center">Error al enviar la inscripción. Intenta de nuevo.</div>';
            }
        }
    }
}

// ✅ Obtener últimas inscripciones para mostrar (puede verlo todo el mundo)
$stmt_ranking = $pdo->query("SELECT nombre, curso, club, observaciones, estado FROM ajedrez_jugadores ORDER BY id DESC LIMIT 10");
$inscripciones = $stmt_ranking->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ajedrez - Portivoo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="assets/css/styles.css">
<style>
.card img { object-fit: cover; cursor: pointer; }
</style>
</head>
<body>

<?php include './partials/navbar.php'; ?>

<main class="container mt-5 mb-5">

  <!-- Banner -->
  <div class="text-center mb-5">
    <h1 class="fw-bold">♟️ Club de Ajedrez</h1>
    <p class="text-light opacity-75">Estrategia, lógica y competencia</p>
  </div>

  <!-- Mensaje -->
  <?php if ($mensaje_inscripcion !== ''): ?>
  <div class="row justify-content-center mb-4">
    <div class="col-md-8"><?php echo $mensaje_inscripcion; ?></div>
  </div>
  <?php endif; ?>

  <div class="row g-4">
    <div class="col-lg-8">

      <!-- Jugador destacado -->
      <div class="card bg-secondary mb-4 text-center">
        <div class="card-body">
          <h4 class="fw-bold">Jugador Destacado</h4>
          <img src="./img/Felipe_morales.png" class="rounded-circle mt-3" width="120" height="120">
          <p class="mt-2 mb-1"><strong>Felipe Morales — 11°A</strong></p>
          <span class="badge bg-warning text-dark">ELO 1420</span>
          <p class="small opacity-75 mt-1">Campeón Intercolegial 2024</p>
        </div>
      </div>

      <!-- Partida destacada -->
      <div class="card bg-dark border-light mb-4">
        <div class="card-header fw-bold">Partida destacada</div>
        <div class="card-body">
          <p class="small opacity-75">Disfruta del análisis de un final sorprendente.</p>
          <<a href="https://vt.tiktok.com/ZSyyd5Aqq//" target="_blank" class="btn btn-outline-light btn-sm">
  <i class="fa-solid fa-video"></i> Jugada destacada
</a>

            <i class="fa-solid fa-play"></i> Ver partida
          </button>
        </div>
      </div>

      <!-- Puzzles -->
      <h5 class="fw-bold mb-2">Puzzles • Entrena tu mente</h5>
      <div class="row g-3 mb-4">
        <div class="col-md-4"><img src="./img/ajedrez_!.jpg" class="img-fluid rounded" onclick="openModal('https://lichess.org/training/8z4qNQxQ')"></div>
        <div class="col-md-4"><img src="./img/Ajedrez_2.jpg" class="img-fluid rounded" onclick="openModal('https://lichess.org/training/7V0k3bZk')"></div>
        <div class="col-md-4"><img src="./img/ajedrez_3.jpg" class="img-fluid rounded" onclick="openModal('https://lichess.org/training/1N3K0W8z')"></div>
      </div>

    </div>

    <!-- Formulario -->
    <div class="col-lg-4">
      <?php if(isset($_SESSION['user_id'])): ?>
      <div class="card bg-dark border-light">
        <div class="card-body">
          <h5 class="fw-bold mb-3">Inscríbete al club</h5>
          <form method="POST">
            <input class="form-control mb-2" name="nombre" placeholder="Nombre completo" required>
            <input class="form-control mb-2" name="curso" placeholder="Curso (Ej: 9°B)" required>
            <input class="form-control mb-2" name="club" placeholder="Club / Equipo (opcional)">
            <textarea class="form-control mb-3" name="observaciones" placeholder="Observaciones (opcional)"></textarea>
            <button class="btn btn-warning w-100" name="inscribir">Enviar inscripción</button>
          </form>
        </div>
      </div>
      <?php else: ?>
      <div class="alert alert-warning text-center mt-3">
        ⚠ Debes <a href="login.php" class="text-decoration-underline text-dark"><strong>iniciar sesión</strong></a> para inscribirte al club.
      </div>
      <?php endif; ?>
    </div>

  </div>

  <!-- Ranking -->
  <div class="mt-5">
    <h4 class="fw-bold text-center mb-3">🏆 Ranking ELO Escolar</h4>
    <div class="table-responsive">
      <table class="table table-dark table-striped text-center">
        <thead>
          <tr><th>Jugador</th><th>Curso</th><th>Club</th><th>Observaciones</th><th>Estado</th></tr>
        </thead>
        <tbody>
          <?php if(!empty($inscripciones)): ?>
            <?php foreach($inscripciones as $i): ?>
              <tr>
                <td><?= htmlspecialchars($i['nombre']) ?></td>
                <td><?= htmlspecialchars($i['curso']) ?></td>
                <td><?= htmlspecialchars($i['club']) ?></td>
                <td><?= htmlspecialchars($i['observaciones']) ?></td>
                <td><?= htmlspecialchars($i['estado']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="5">No hay inscripciones aún</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</main>

<!-- Modal -->
<div class="modal fade" id="modalGame" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-body p-0">
        <iframe id="iframeGame" src="" width="100%" height="410" style="border:none;"></iframe>
      </div>
      <button class="btn btn-danger w-100 rounded-0 mt-2" data-bs-dismiss="modal">Cerrar</button>
    </div>
  </div>
</div>

<?php include './partials/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openModal(url) {
  document.getElementById('iframeGame').src = url;
  let modal = new bootstrap.Modal(document.getElementById('modalGame'));
  modal.show();
  document.getElementById('modalGame').addEventListener('hidden.bs.modal', () => {
    document.getElementById('iframeGame').src = '';
  }, {once:true});
}
</script>
</body>
</html>
