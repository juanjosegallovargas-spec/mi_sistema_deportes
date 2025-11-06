<?php
session_start();
require_once "conexion.php";

// Verificar ADMIN
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: auth.php");
    exit;
}

$id = intval($_GET['id']);

// ELIMINAR CONTACTO
$stmt = $pdo->prepare("DELETE FROM contactos WHERE id=?");
$stmt->execute([$id]);

// Mostrar mensaje antes de redirigir
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Contacto Eliminado</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {
    background: linear-gradient(135deg, #0f1c3f, #1e90ff, #fca311, #ff6b00);
    background-size: 400% 400%;
    animation: gradientBG 12s ease infinite;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    font-family: 'Poppins', sans-serif;
    flex-direction: column;
    text-align: center;
}
@keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
.card {
    background: rgba(0,0,0,0.35);
    padding: 30px;
    border-radius: 12px;
    width: 400px;
}
.btn-warning, .btn-warning:hover {
    color: #fff;
    font-weight: 700;
}
</style>
</head>
<body>
<div class="card">
    <h3 class="mb-3"><i class="fa fa-check-circle"></i> Mensaje eliminado</h3>
    <p>El contacto ha sido eliminado exitosamente.</p>
    <a href="admin_panel.php#contactos" class="btn btn-warning mt-3">
        <i class="fa fa-arrow-left"></i> Volver al Panel
    </a>
</div>
</body>
</html>
