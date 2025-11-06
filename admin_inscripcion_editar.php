<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$tabla = $_GET['tabla'] ?? '';
$id    = $_GET['id'] ?? '';

if (!$tabla || !$id) {
    die("Datos incompletos");
}

$stmt = $pdo->prepare("SELECT * FROM $tabla WHERE id=:id");
$stmt->execute(['id' => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) die("Registro no encontrado");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $campos = [];
    foreach ($_POST as $key => $value) {
        if ($key != "guardar") {
            $campos[$key] = $value;
        }
    }
    $setSQL = implode(", ", array_map(fn($k)=> "$k=:".$k, array_keys($campos)));
    $campos['id'] = $id;

    $update = $pdo->prepare("UPDATE $tabla SET $setSQL WHERE id=:id");
    $update->execute($campos);

    header("Location: admin_panel.php#inscripciones");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Inscripción</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f4f0ff;
        font-family: 'Segoe UI', sans-serif;
    }
    .card {
        margin-top: 40px;
        border-radius: 15px;
        padding: 25px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        background: #fff;
    }
    h2 {
        font-weight: 700;
        color: #45277e;
        text-align: center;
        margin-bottom: 20px;
    }
    label {
        font-weight: 600;
        color: #45277e;
    }
    .btn-guardar {
        background-color: #8353e2;
        color: #fff;
        font-weight: 600;
        border-radius: 10px;
        transition: .3s;
    }
    .btn-guardar:hover {
        background-color: #5e32c0;
        color: #fff;
    }
    .btn-cancelar {
        border-radius: 10px;
        font-weight: 600;
    }
</style>
</head>

<body class="p-3">
<div class="container">
    <div class="card">
        <h2>Editar Inscripción</h2>

        <form method="post">
        <?php foreach($data as $campo => $valor): ?>
        <?php if($campo=='id' || $campo=='fecha_registro' || $campo=='fecha_actualizacion') continue; ?>
        <div class="mb-3">
            <label class="form-label"><?= ucfirst($campo) ?></label>
            <input type="text" name="<?= $campo ?>" class="form-control" value="<?= htmlspecialchars($valor) ?>">
        </div>
        <?php endforeach; ?>

        <div class="text-center mt-3">
            <button type="submit" name="guardar" class="btn btn-guardar px-4">Guardar</button>
            <a href="admin_panel.php#inscripciones" class="btn btn-secondary btn-cancelar px-4 ms-2">Cancelar</a>
        </div>

        </form>
    </div>
</div>

</body>
</html>
