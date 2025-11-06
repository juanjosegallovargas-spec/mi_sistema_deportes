<?php
session_start();
require_once "conexion.php";

// ============================
// Verificar sesión de administrador
// ============================
$isAdmin = isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';

// ============================
// Obtener todos los deportes
// ============================
$stmt = $pdo->query("SELECT * FROM deportes ORDER BY id DESC");
$deportes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ============================
// Mapeo de nombres a páginas
// ============================
$urls = [
    'Baloncesto' => 'baloncesto.php',
    'Fútbol FIFA' => 'futbol.php',
    'Voleibol' => 'voleibol.php',
    'Tenis de mesa' => 'tenis.php',
    'Ajedrez' => 'ajedrez.php'
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portivoo Reloaded</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="assets/css/styles.css">

    <style>
    /* ----------------------------
       Fondo animado
    ---------------------------- */
    body {
        background: linear-gradient(135deg, #0f1c3f, #1e90ff, #fca311, #ff6b00);
        background-size: 400% 400%;
        animation: gradientBG 12s ease infinite;
        color: white;
        font-family: 'Poppins', sans-serif;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* ----------------------------
       Sección Deportes Destacados
    ---------------------------- */
    .deportes-destacados {
        padding: 60px 0;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #fff;
        text-shadow: 0 0 5px #000;
    }

    .deportes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 25px;
        perspective: 1200px;
        margin-top: 40px;
    }

    /* TARJETA CLICKEABLE */
    .deporte-card {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.4s, box-shadow 0.4s;
        box-shadow: 0 6px 15px rgba(0,0,0,0.4);
        background: rgba(0,0,0,0.35);
        display: block;
        text-decoration: none;
        color: inherit;
    }

    .deporte-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .deporte-card:hover {
        transform: rotateY(5deg) rotateX(3deg) scale(1.05);
        box-shadow: 0 12px 25px rgba(0,0,0,0.6);
    }

    .deporte-card:hover img {
        transform: scale(1.1);
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.55);
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s;
        text-align: center;
        padding: 15px;
        border-radius: 15px;
    }

    .deporte-card:hover .overlay {
        opacity: 1;
    }

    .overlay h5 {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 10px;
        text-shadow: 0 0 8px #000;
    }

    .overlay p {
        font-size: 0.95rem;
    }

    .admin-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .admin-actions a {
        font-size: 0.8rem;
    }

    /* Responsive */
    @media(max-width: 768px) {
        .deporte-card img {
            height: 150px;
        }
    }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <?php include 'partials/navbar.php'; ?>

    <!-- BOTÓN ADMIN -->
    <?php if ($isAdmin): ?>
    <div class="container my-4 text-center">
        <a href="admin_deportes.php" class="btn btn-warning">
            <i class="fa fa-plus"></i> Agregar/Modificar Deportes
        </a>
    </div>
    <?php endif; ?>

    <!-- SECCIÓN DEPORTES DESTACADOS -->
    <section class="deportes-destacados">
        <div class="container">
            <h2 class="section-title text-center">Deportes Destacados</h2>
            <div class="deportes-grid">
                <?php foreach ($deportes as $dep): ?>
                <!-- TARJETA CLICKEABLE -->
                <a href="<?= $urls[$dep['nombre']] ?? '#' ?>" class="deporte-card">
                    <img src="<?= htmlspecialchars($dep['imagen']) ?>" alt="<?= htmlspecialchars($dep['nombre']) ?>">
                    <div class="overlay">
                        <h5><?= htmlspecialchars($dep['nombre']) ?></h5>
                        <p><?= htmlspecialchars($dep['descripcion']) ?></p>
                        <?php if ($isAdmin): ?>
                        <div class="admin-actions">
                            <a href="admin_deportes.php?editar=<?= $dep['id'] ?>" class="btn btn-sm btn-info">
                                <i class="fa fa-edit"></i> Editar
                            </a>
                            <a href="admin_deportes.php?eliminar=<?= $dep['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar deporte?')">
                                <i class="fa fa-trash"></i> Eliminar
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <?php include 'partials/footer.php'; ?>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
