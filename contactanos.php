<?php
// ============================
// INICIO DE SESIÓN Y CONEXIÓN
// ============================
session_start();
require_once "conexion.php";

// ============================
// PROCESAR FORMULARIO
// ============================
$mensajeEnviado = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = htmlspecialchars($_POST['nombre']);
    $email = htmlspecialchars($_POST['email']);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    $stmt = $pdo->prepare("INSERT INTO contactos (nombre, email, mensaje) VALUES (?, ?, ?)");
    if ($stmt->execute([$nombre, $email, $mensaje])) {
        $mensajeEnviado = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contáctanos - Portivoo</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="assets/css/styles.css">

    <!-- Estilos específicos de contacto -->
    <style>
    /* Título sección */
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 40px;
        text-shadow: 0 0 8px #000;
    }

    /* Contenedor principal */
    .contact-container {
        max-width: 1000px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
    }

    /* FORMULARIO */
    .contact-form {
        background: rgba(0,0,0,0.35);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.5);
        display: flex;
        flex-direction: column;
    }

    .contact-form input,
    .contact-form textarea {
        background: rgba(255,255,255,0.1);
        border: none;
        color: #fff;
        margin-bottom: 15px;
        padding: 12px;
        border-radius: 8px;
        transition: 0.3s;
    }

    .contact-form input:focus,
    .contact-form textarea:focus {
        outline: none;
        background: rgba(255,255,255,0.2);
        box-shadow: 0 0 10px #fca311;
    }

    .contact-form button {
        background: #fca311;
        color: #000;
        font-weight:700;
        padding: 12px;
        border:none;
        border-radius:8px;
        transition: 0.3s;
    }

    .contact-form button:hover {
        background:#ffb84d;
        transform: translateY(-2px);
    }

    /* Mensaje de éxito */
    .success-msg {
        text-align:center;
        margin-bottom:20px;
        color: #0f0;
        font-weight:700;
        animation: fadeIn 1s ease forwards;
    }
    @keyframes fadeIn {
        0% {opacity:0;}
        100% {opacity:1;}
    }

    /* Mapa */
    .contact-map iframe {
        width: 100%;
        height: 100%;
        border: none;
        border-radius: 15px;
    }

    /* Redes sociales */
    .contact-info {
        margin-top: 30px;
        text-align:center;
    }
    .contact-info a {
        color:#fff;
        margin:0 10px;
        font-size:1.5rem;
        transition: 0.3s;
    }
    .contact-info a:hover {
        color:#fca311;
    }

    /* Responsive */
    @media(max-width: 768px){
        .contact-container { grid-template-columns: 1fr; }
        .contact-map { height: 300px; }
    }
    </style>
</head>
<body>

<!-- NAVBAR -->
<?php include 'partials/navbar.php'; ?>

<!-- SECCIÓN CONTACTO -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">Contáctanos</h2>
        <div class="contact-container">

            <!-- FORMULARIO -->
            <div>
                <?php if($mensajeEnviado): ?>
                    <div class="success-msg">¡Gracias! Tu mensaje ha sido enviado.</div>
                <?php endif; ?>

                <form class="contact-form" method="POST">
                    <input type="text" name="nombre" placeholder="Tu nombre" required>
                    <input type="email" name="email" placeholder="Tu correo" required>
                    <textarea name="mensaje" rows="6" placeholder="Tu mensaje" required></textarea>
                    <button type="submit"><i class="fa fa-paper-plane"></i> Enviar Mensaje</button>
                </form>
            </div>

            <!-- MAPA + REDES SOCIALES -->
            <div class="contact-map">
                <iframe
                    src="https://www.google.com/maps?q=Colegio%20San%20Juan%20Bautista%20de%20la%20Salle%20Manrique%20Medellín&output=embed"
                    width="100%" height="400" allowfullscreen="" loading="lazy">
                </iframe>
            

        </div>
    </div>
</section>

<!-- FOOTER -->
<?php include 'partials/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
