<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$tabla = $_GET['tabla'] ?? '';
$id = $_GET['id'] ?? '';

if(!$tabla || !$id) die("Datos inválidos");

$stmt = $pdo->prepare("SELECT * FROM $tabla WHERE id=:id");
$stmt->execute(['id' => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) die("Registro no encontrado");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Detalles de Inscripción</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f4f0ff;
        font-family: 'Segoe UI', sans-serif;
    }
    .card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        background: #fff;
    }
    th {
        background-color: #d6caff !important;
        color: #45277e;
        font-weight: bold;
    }
    .btn-regresar {
        background-color: #8353e2;
        color: #fff;
        font-weight: 600;
        border-radius: 10px;
        transition: .3s;
    }
    .btn-regresar:hover {
        background-color: #5e32c0;
        color: #fff;
    }
    h2 {
        font-weight: 700;
        color: #45277e;
        text-align: center;
        margin-bottom: 25px;
    }
</style>
</head>

<body class="p-4">
<div class="container">
    <div class="card p-4">
        <h2>Detalles de Registro</h2>
        <table class="table table-hover table-striped align-middle text-center">
            <?php foreach($data as $campo => $valor): ?>
            <tr>
                <th><?= ucfirst($campo) ?></th>
                <td><?= htmlspecialchars($valor) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <div class="text-center mt-4">
            <a href="admin_panel.php#inscripciones" class="btn btn-regresar px-4">Regresar</a>
        </div>
    </div>
</div>

</body>
</html>
