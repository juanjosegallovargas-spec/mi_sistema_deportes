<?php
require 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = md5($_POST['password']);
    $rol = $_POST['rol'] ?? 'student';

    // Validar campos vacíos
    if (empty($nombre) || empty($email) || empty($_POST['password'])) {
        $error = "Por favor completa todos los campos.";
    } else {
        // Verificar si ya existe el correo
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Este correo ya está registrado.";
        } else {
            // Insertar nuevo usuario
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, rol, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$nombre, $email, $password, $rol]);

            $_SESSION['user'] = $nombre;
            $_SESSION['rol'] = $rol;
            $_SESSION['id'] = $pdo->lastInsertId();

            // Redirigir según el rol
            if ($rol === 'admin') {
                header("Location: admin_panel.php");
            } else {
                header("Location: index.php");
            }
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro - Portivoo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #0f1c3f, #1e90ff, #fca311, #ff6b00);
      background-size: 400% 400%;
      animation: gradientBG 12s ease infinite;
      color: white;
    }
    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    .card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border: none;
      border-radius: 15px;
    }
    .btn-gold {
      background-color: #fca311;
      color: #000;
      font-weight: bold;
      border: none;
    }
    .btn-gold:hover {
      background-color: #ffb833;
    }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

<div class="card p-4" style="width: 380px;">
  <h3 class="text-center mb-3">Crear cuenta</h3>
  <?php if(isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <input type="text" name="nombre" class="form-control" placeholder="Nombre completo" required>
    </div>
    <div class="mb-3">
      <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
    </div>
    <div class="mb-3">
      <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Selecciona tu rol:</label>
      <select name="rol" class="form-select">
        <option value="student">Estudiante</option>
        <option value="admin">Administrador</option>
      </select>
    </div>
    <button class="btn btn-gold w-100">Registrarse</button>
  </form>

  <p class="text-center mt-3 text-white-50">
    ¿Ya tienes cuenta? <a href="login.php" class="text-warning text-decoration-none">Inicia sesión</a>
  </p>
</div>

</body>
</html>
