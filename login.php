<?php
session_start();
require 'conexion.php';

// Si ya está logueado, redirigir según su rol
if (isset($_SESSION['rol'])) {
    if ($_SESSION['rol'] === 'admin') {
        header("Location: admin_panel.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!$email || !$password) {
        $error = "Por favor ingresa tu correo y contraseña.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Validar usuario
        if ($usuario && $usuario['password'] === md5($password)) {

            // Guardar datos de sesión ✅
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_name'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            // Redirección según el rol
            if ($usuario['rol'] === 'admin') {
                header("Location: admin_panel.php");
            } else {
                header("Location: index.php");
            }
            exit;

        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login - Portivoo</title>
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
  <h3 class="text-center mb-3">Iniciar sesión</h3>

  <?php if(!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
    </div>
    <div class="mb-3">
      <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
    </div>
    <button class="btn btn-gold w-100">Ingresar</button>
  </form>

  <p class="text-center mt-3 text-white-50">
    ¿No tienes cuenta?
    <a href="register.php" class="text-warning text-decoration-none">Regístrate</a>
  </p>
</div>

</body>
</html>
