<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: auth.php");
    exit;
}

$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM contactos WHERE id=?");
$stmt->execute([$id]);
$contacto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$contacto) {
    echo "No existe ese contacto.";
    exit;
}

if(isset($_POST['guardar'])){
    $stmt = $pdo->prepare("UPDATE contactos SET nombre=?, email=?, mensaje=?, respuesta=? WHERE id=?");
    $stmt->execute([
        $_POST['nombre'], $_POST['email'], $_POST['mensaje'],
        $_POST['respuesta'], $id
    ]);

    header("Location: admin_panel.php?editcont=1#contactos");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Contacto</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {
    background: linear-gradient(135deg, #0f1c3f, #1e90ff, #fca311, #ff6b00);
    background-size: 400% 400%;
    animation: gradientBG 12s ease infinite;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    font-family: 'Poppins', sans-serif;
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
    width: 500px;
}

input, textarea {
    background: rgba(255,255,255,0.15)!important;
    border: none;
    color: #fff;
}

button, .btn-warning {
    font-weight: 700;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}
</style>
</head>
<body>

<div class="card">
    <h2>Editar Mensaje</h2>

    <form method="post">
        <label>Nombre:</label>
        <input class="form-control mb-2" name="nombre" value="<?= $contacto['nombre'] ?>" required>

        <label>Email:</label>
        <input class="form-control mb-2" name="email" value="<?= $contacto['email'] ?>" required>

        <label>Mensaje:</label>
        <textarea class="form-control mb-2" name="mensaje" rows="3" required><?= $contacto['mensaje'] ?></textarea>

        <label>Respuesta:</label>
        <textarea class="form-control mb-2" name="respuesta" rows="2"><?= $contacto['respuesta'] ?></textarea>

        <div class="d-flex justify-content-between mt-3">
            <button class="btn btn-success" name="guardar"><i class="fa fa-save"></i> Guardar cambios</button>
            <a href="admin_panel.php#contactos" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Volver al Panel</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
