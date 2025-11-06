<?php
session_start();
require_once "conexion.php";

// ============================
// Verificar sesión admin
// ============================
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// ============================
// Tablas permitidas
// ============================
$tablasPermitidas = [
    'voleibol_jugadores',
    'basquetbol_jugadores',
    'futbol_jugadores',
    'tenis_jugadores',
    'ajedrez_jugadores'
];

$deportes = [
    'Voleibol' => 'voleibol_jugadores',
    'Baloncesto' => 'basquetbol_jugadores',
    'Fútbol FIFA' => 'futbol_jugadores',
    'Tenis de mesa' => 'tenis_jugadores',
    'Ajedrez' => 'ajedrez_jugadores'
];

// ============================
// Cambiar estado de inscripción
// ============================
if(isset($_POST['cambiar_estado'])){
    $tabla  = $_POST['tabla'];
    $id     = $_POST['id'];
    $estado = $_POST['estado'];

    if(in_array($tabla, $tablasPermitidas)){
        $stmt = $pdo->prepare("UPDATE $tabla SET estado=:estado, fecha_actualizacion=NOW() WHERE id=:id");
        $stmt->execute([':estado' => $estado, ':id' => $id]);
        header("Location: admin_panel.php#inscripciones");
        exit;
    }
}

// ============================
// Cargar inscripciones
// ============================
$inscripciones = [];
foreach($deportes as $nombre => $tabla){
    if(in_array($tabla, $tablasPermitidas)){
        $stmt = $pdo->query("SELECT * FROM $tabla ORDER BY id ASC");
        $inscripciones[$nombre] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// ============================
// Deportes
// ============================
$deportesDest = $pdo->query("SELECT * FROM deportes ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

// ============================
// Contactos
// ============================
$contactos = $pdo->query("SELECT * FROM contactos ORDER BY fecha_envio DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Admin Panel - Portivoo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* Reset y fuente */
* { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }

/* Fondo animado */
body {
    background: linear-gradient(135deg, #0f1c3f, #1e90ff, #fca311, #ff6b00);
    background-size: 400% 400%;
    animation: gradientBG 12s ease infinite;
    color: white;
}
@keyframes gradientBG {
    0% { background-position:0% 50%; }
    50% { background-position:100% 50%; }
    100% { background-position:0% 50%; }
}

/* Navbar vidrio */
.main-header {
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(10px);
    position: sticky;
    top:0;
    z-index:1000;
}
.main-nav { display:flex; gap:15px; align-items:center; }
.main-nav a {
    text-decoration:none;
    color:#fff;
    font-weight:600;
    padding:8px 14px;
    border-radius:6px;
    transition:0.3s;
}
.main-nav a:hover { background: rgba(255,255,255,0.08); }

/* Dropdown vidrio */
.glass-dropdown {
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(10px);
    border-radius:10px;
    border:1px solid rgba(255,255,255,0.2);
    z-index:5000 !important;
}
.glass-dropdown .dropdown-item { color:#fff !important; font-weight:600; }
.glass-dropdown .dropdown-item:hover { background: rgba(255,255,255,0.2) !important; color:#fca311 !important; }

/* Tarjetas */
.card {
    background: rgba(0,0,0,0.35) !important;
    border:1px solid rgba(255,255,255,0.18) !important;
    border-radius:12px;
    overflow:hidden;
    height:400px;
    display:flex;
    flex-direction:column;
}
.card:hover { transform:scale(1.03); border-color:#fca311 !important; transition:0.3s; }
.card-img-top {
    height:200px;
    object-fit:cover;
    border-top-left-radius:12px;
    border-top-right-radius:12px;
}
.card-body { flex:1; display:flex; flex-direction:column; justify-content:space-between; }
.card-title, .card-body h5, .card-text { color:#fff !important; text-shadow:0 0 5px #000; font-weight:700; }

/* Tablas */
.table, .table th, .table td { color:black; vertical-align:middle; }
.table-contactos th, .table-inscripciones th { background: rgba(252,163,17,0.85); color:#000; font-weight:700; }
.table-contactos td, .table-inscripciones td { color:#000; }
textarea, input { background: rgba(255,255,255,0.15) !important; border:none; color:#fff; }
button { background:#fca311; border:none; font-weight:700; }
</style>
</head>

<body>

<?php include './partials/navbar.php'; ?>

<div class="container my-5">
<h1 class="text-center mb-5">Panel de Administración</h1>

<!-- Deportes -->
<h2>Deportes Destacados</h2>
<a href="admin_deportes.php" class="btn btn-warning mb-3"><i class="fa fa-plus"></i> Agregar / Modificar</a>

<div class="row">
<?php foreach($deportesDest as $dep): ?>
<div class="col-md-4 mb-4">
    <div class="card">
        <img src="<?= $dep['imagen'] ?>" class="card-img-top" alt="<?= $dep['nombre'] ?>">
        <div class="card-body">
            <div>
                <h5 class="card-title"><?= $dep['nombre'] ?></h5>
                <p class="card-text"><?= $dep['descripcion'] ?></p>
            </div>
            <div class="mt-2 d-flex justify-content-between">
                <a href="admin_deportes.php?editar=<?= $dep['id'] ?>" class="btn btn-info btn-sm">
                    <i class="fa fa-edit"></i> Editar
                </a>
                <a href="admin_deportes.php?eliminar=<?= $dep['id'] ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('¿Eliminar deporte?')">
                    <i class="fa fa-trash"></i> Eliminar
                </a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
</div>

<hr class="my-5">

<!-- Inscripciones -->
<h2 id="inscripciones">Inscripciones</h2>
<a href="admin_inscripcion_nuevo.php" class="btn btn-success mb-3"><i class="fa fa-plus"></i> Nueva Inscripción</a>

<?php foreach($inscripciones as $depNombre => $registros): ?>
<h4 class="mt-4"><?= $depNombre ?></h4>
<?php if(count($registros)>0): ?>
<div class="table-responsive">
<table class="table table-bordered table-striped table-inscripciones text-center">
<thead>
<tr>
<th>Equipo / Nombre</th>
<th>Curso</th>
<?php
// Determinar máximo de jugadores para esta tabla
$maxJugadores = 0;
$sample = $registros[0] ?? [];
for($i=1;$i<=11;$i++){
    if(array_key_exists("jugador$i",$sample)) $maxJugadores=$i;
}
for($i=1;$i<=$maxJugadores;$i++){
    echo "<th>Jugador $i</th>";
}
if(array_key_exists('club', $sample)) echo "<th>Club</th>";
if(array_key_exists('observaciones', $sample)) echo "<th>Observaciones</th>";
echo "<th>Estado</th><th>Acciones</th>";
?>
</tr>
</thead>
<tbody>
<?php foreach($registros as $row): ?>
<tr>
<td><?= $row['equipo'] ?? ($row['nombre'] ?? '-') ?></td>
<td><?= $row['curso'] ?></td>
<?php for($i=1;$i<=$maxJugadores;$i++): ?>
<td><?= $row["jugador$i"] ?? '-' ?></td>
<?php endfor; ?>
<?php if(array_key_exists('club', $row)) echo "<td>{$row['club']}</td>"; ?>
<?php if(array_key_exists('observaciones', $row)) echo "<td>{$row['observaciones']}</td>"; ?>
<td>
<form method="post">
<input type="hidden" name="tabla" value="<?= $deportes[$depNombre] ?>">
<input type="hidden" name="id" value="<?= $row['id'] ?>">
<select name="estado" onchange="this.form.submit()" class="form-select form-select-sm">
<option value="pendiente" <?= ($row['estado']=='pendiente')?'selected':'' ?>>Pendiente</option>
<option value="aprobado" <?= ($row['estado']=='aprobado')?'selected':'' ?>>Aprobado</option>
<option value="rechazado" <?= ($row['estado']=='rechazado')?'selected':'' ?>>Rechazado</option>
<option value="incompleto" <?= ($row['estado']=='incompleto')?'selected':'' ?>>Incompleto</option>
</select>
</form>
</td>
<td class="d-flex gap-1 justify-content-center">
<a href="admin_inscripcion_nuevo.php?tabla=<?= $deportes[$depNombre] ?>&id=<?= $row['id'] ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
<a href="admin_inscripcion_editar.php?tabla=<?= $deportes[$depNombre] ?>&id=<?= $row['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
<a href="admin_inscripcion_eliminar.php?tabla=<?= $deportes[$depNombre] ?>&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar inscripción?')"><i class="fa fa-trash"></i></a>
<a href="admin_inscripcion_detalles.php?tabla=<?= $deportes[$depNombre] ?>&id=<?= $row['id'] ?>" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php else: ?>
<p>No hay inscripciones.</p>
<?php endif; ?>
<?php endforeach; ?>

<hr class="my-5">

<!-- Contactos -->
<h2 id="contactos">Mensajes de Contacto</h2>
<?php if(isset($_GET['enviado'])): ?>
<div class="alert alert-success text-center">✅ Respuesta enviada</div>
<?php endif; ?>

<?php if(count($contactos)>0): ?>
<div class="table-responsive">
<table class="table table-contactos table-bordered table-striped text-center">
<thead>
<tr>
<th>Nombre</th>
<th>Email</th>
<th>Mensaje</th>
<th>Fecha</th>
<th>Respuesta</th>
<th>Acciones</th>
</tr>
</thead>
<tbody>
<?php foreach($contactos as $c): ?>
<tr>
<td><?= $c['nombre'] ?></td>
<td><?= $c['email'] ?></td>
<td><?= $c['mensaje'] ?></td>
<td><?= $c['fecha_envio'] ?></td>
<td><?= $c['respuesta'] ?: '-' ?></td>
<td class="d-flex gap-1 justify-content-center">
<a href="admin_contacto_editar.php?id=<?= $c['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
<a href="admin_contacto_eliminar.php?id=<?= $c['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar mensaje?')"><i class="fa fa-trash"></i></a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php else: ?>
<p>No hay mensajes.</p>
<?php endif; ?>

</div>

<?php include './partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
