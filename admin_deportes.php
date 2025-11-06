<?php
session_start();
require_once "conexion.php";

// Verificar ADMIN
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: auth.php");
    exit;
}

// Procesar imagen
function subirImagen($file) {
    if ($file['error'] === UPLOAD_ERR_OK) {
        $dir = "uploads/";
        if (!is_dir($dir)) mkdir($dir);

        $nombreArchivo = time() . "_" . basename($file["name"]);
        $ruta = $dir . $nombreArchivo;

        if (move_uploaded_file($file["tmp_name"], $ruta)) {
            return $ruta;
        }
    }
    return null;
}

// EDITAR - cargar datos
$deporteEditar = null;
if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    $stmt = $pdo->prepare("SELECT * FROM deportes WHERE id=?");
    $stmt->execute([$id]);
    $deporteEditar = $stmt->fetch(PDO::FETCH_ASSOC);
}

// GUARDAR NUEVO
if (isset($_POST['guardar'])) {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $imagen = subirImagen($_FILES['imagen']);

    $stmt = $pdo->prepare("INSERT INTO deportes (nombre, descripcion, imagen) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $descripcion, $imagen]);

    header("Location: admin_deportes.php?add=1");
    exit;
}

// ACTUALIZAR
if (isset($_POST['actualizar'])) {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);

    $imagen = subirImagen($_FILES['imagen']);
    if ($imagen === null) $imagen = $deporteEditar['imagen'];

    $stmt = $pdo->prepare("UPDATE deportes SET nombre=?, descripcion=?, imagen=? WHERE id=?");
    $stmt->execute([$nombre, $descripcion, $imagen, $id]);

    header("Location: admin_deportes.php?edit=1");
    exit;
}

// ELIMINAR
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $pdo->prepare("DELETE FROM deportes WHERE id=?")->execute([$id]);
    header("Location: admin_deportes.php?del=1");
    exit;
}

// Obtener deportes
$deportes = $pdo->query("SELECT * FROM deportes ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Admin Deportes</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {
    background: linear-gradient(135deg, #0f1c3f, #1e90ff, #fca311, #ff6b00);
    background-size: 400% 400%;
    animation: gradientBG 12s ease infinite;
    color: white;
    padding: 20px;
}
@keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.card, form {
    background: rgba(0, 0, 0, 0.35);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
}

input, textarea {
    background: rgba(255,255,255,0.15)!important;
    border: none;
    color: #fff;
}

button {
    font-weight: 700;
}

.table, .table th, .table td { 
    color: black; 
    vertical-align: middle; 
}
img { border-radius: 8px; }
</style>
</head>

<body>

<div class="container">
<h2 class="text-center mb-4">Administrar Deportes</h2>

<!-- Botón Volver -->
<div class="mb-3">
    <a href="admin_panel.php" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Volver al Panel</a>
</div>

<!-- Formulario -->
<form method="post" enctype="multipart/form-data" class="card">
    <?php if($deporteEditar): ?>
        <input type="hidden" name="id" value="<?= $deporteEditar['id'] ?>">
    <?php endif; ?>

    <input class="form-control mb-2" name="nombre" placeholder="Nombre del deporte"
           value="<?= $deporteEditar['nombre'] ?? '' ?>" required>

    <textarea class="form-control mb-2" name="descripcion" placeholder="Descripción" required><?= $deporteEditar['descripcion'] ?? '' ?></textarea>

    <input type="file" name="imagen" class="form-control mb-3">

    <button class="btn btn-success" name="<?= $deporteEditar?'actualizar':'guardar' ?>">
        <?= $deporteEditar?'Actualizar':'Guardar' ?>
    </button>
</form>

<!-- Tabla de deportes -->
<table class="table table-bordered text-center">
<tr class="table-dark">
    <th>ID</th>
    <th>Nombre</th>
    <th>Imagen</th>
    <th>Acciones</th>
</tr>

<?php foreach($deportes as $d): ?>
<tr>
    <td><?= $d['id'] ?></td>
    <td><?= $d['nombre'] ?></td>
    <td><img src="<?= $d['imagen'] ?>" height="60"></td>
    <td>
        <a class="btn btn-info btn-sm" href="admin_deportes.php?editar=<?= $d['id'] ?>">
            <i class="fa fa-edit"></i> Editar
        </a>
        <a class="btn btn-danger btn-sm" href="admin_deportes.php?eliminar=<?= $d['id'] ?>"
           onclick="return confirm('¿Seguro de eliminar?')">
           <i class="fa fa-trash"></i> Eliminar
        </a>
    </td>
</tr>
<?php endforeach; ?>
</table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
