<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$tabla = $_GET['tabla'] ?? '';
$tablasPermitidas = [
    'voleibol_jugadores',
    'basquetbol_jugadores',
    'futbol_jugadores',
    'tenis_jugadores',
    'ajedrez_jugadores'
];

if (!$tabla || !in_array($tabla, $tablasPermitidas)) {
    die("Tabla inválida");
}

$columnas = [];
$stmtCols = $pdo->query("SHOW COLUMNS FROM $tabla");
while($col = $stmtCols->fetch(PDO::FETCH_ASSOC)) {
    if(in_array($col['Field'], ['id', 'fecha_registro', 'fecha_actualizacion'])) continue;
    $columnas[] = $col['Field'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [];
    foreach ($columnas as $c) {
        $datos[$c] = $_POST[$c] ?? null;
    }

    $camposSQL = implode(", ", array_keys($datos));
    $placeholders = implode(", ", array_map(fn($c)=>":$c", array_keys($datos)));

    $insert = $pdo->prepare("INSERT INTO $tabla ($camposSQL) VALUES ($placeholders)");
    $insert->execute($datos);

    header("Location: admin_panel.php#inscripciones");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Nueva Inscripción</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* ✅ TODO TU CSS COMPLETO PEGADO AQUÍ */
<?= file_get_contents("style.css") ?>

/* Estilos del formulario */
input {
  background: rgba(255,255,255,0.15);
  border-radius: 8px;
  border: none;
  color: white !important;
  padding: 10px;
}
input:focus {
  outline: 2px solid #fca311;
  background: rgba(255,255,255,0.25);
  transition: 0.3s;
}
.label-title {
  font-weight: bold;
  color: #ffffff;
}
.form-container {
  max-width: 650px;
  margin: 80px auto;
  background: rgba(0,0,0,0.35);
  padding: 25px;
  border-radius: 15px;
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255,255,255,0.18);
}
.btn-save {
  background: #fca311;
  border: none;
  color: #000;
  font-weight: bold;
  transition: 0.3s;
}
.btn-save:hover {
  background: #ffbb33;
  transform: scale(1.05);
}
.btn-back {
  background: rgba(255,255,255,0.2);
  color: #fff;
}
.btn-back:hover {
  background: rgba(255,255,255,0.35);
}
</style>
</head>

<body>

<header class="main-header bg-dark">
  <div class="header-content">
      <h4>Panel Admin - Nuevo Registro</h4>
  </div>
</header>

<div class="form-container">
<h3 class="text-center mb-3">Nueva Inscripción:</h3>
<h5 class="text-center text-warning"><?= strtoupper($tabla) ?></h5>

<form method="post">
<?php foreach ($columnas as $campo): ?>
<div class="mb-3">
<label class="label-title"><?= ucfirst($campo) ?></label>
<input type="text" name="<?= $campo ?>" class="form-control" required>
</div>
<?php endforeach; ?>

<div class="d-flex justify-content-between mt-4">
  <button type="submit" class="btn btn-save w-50 me-2">✅ Guardar</button>
  <a href="admin_panel.php#inscripciones" class="btn btn-back w-50 ms-2">🔙 Volver</a>
</div>

</form>
</div>

</body>
</html>
