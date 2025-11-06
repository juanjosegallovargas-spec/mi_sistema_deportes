<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nosotros - Sistema Deportivo</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="assets/css/styles.css">

<style>
/* TITULOS */
.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    text-align:center;
    margin-bottom: 50px;
    text-shadow:0 0 10px #000;
    color:#fff;
}

/* MISION Y VISION */
.mission-container {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    justify-content: center;
    margin-bottom: 60px;
}
.mission-card {
    background: rgba(0,0,0,0.35);
    padding: 30px;
    border-radius: 15px;
    flex: 1 1 300px;
    transition: transform 0.3s;
}
.mission-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.6);
}
.mission-card h3 {
    color:#fca311;
    margin-bottom: 15px;
}
.mission-card p {
    color:#fff;
    font-size:1.1rem;
    line-height:1.6;
}

/* TIMELINE */
.timeline {
    position: relative;
    max-width: 900px;
    margin: 0 auto 60px auto;
}
.timeline::after {
    content: '';
    position: absolute;
    width: 4px;
    background-color: #fca311;
    top: 0;
    bottom: 0;
    left: 50%;
    margin-left: -2px;
}
.timeline-event {
    padding: 20px 40px;
    position: relative;
    width: 50%;
}
.timeline-event.left {
    left:0;
}
.timeline-event.right {
    left:50%;
}
.timeline-event::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    right: -10px;
    background-color:#fca311;
    border: 4px solid #fff;
    top: 20px;
    border-radius: 50%;
    z-index:1;
}
.timeline-event.right::after {
    left: -10px;
}
.timeline-event h4 {
    color:#fca311;
    margin-bottom: 10px;
}
.timeline-event p {
    color:#fff;
    line-height:1.5;
}

/* EQUIPO */
.team-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
}
.team-card {
    background: rgba(0,0,0,0.35);
    padding:20px;
    border-radius:15px;
    text-align:center;
    width:200px;
    transition: 0.3s;
}
.team-card:hover {
    transform: translateY(-5px);
    box-shadow:0 8px 25px rgba(0,0,0,0.6);
}
.team-card img {
    width:100px;
    height:100px;
    border-radius:50%;
    margin-bottom:15px;
}
.team-card h5 {
    color:#fff;
    font-weight:700;
}
.team-card p {
    color:#fca311;
    font-weight:600;
}

/* RESPONSIVE */
@media(max-width:768px){
    .mission-container { flex-direction: column; }
    .timeline-event {
        width:100%;
        padding-left:70px;
        padding-right:25px;
        margin-bottom:30px;
    }
    .timeline-event.left, .timeline-event.right { left:0; }
    .timeline-event::after { left:30px; }
}
</style>
</head>
<body>

<!-- Navbar -->
<?php include 'partials/navbar.php'; ?>

<section class="py-5">
    <div class="container">

        <!-- Titulo -->
        <h2 class="section-title">Nosotros</h2>

        <!-- Misión y Visión -->
        <div class="mission-container">
            <div class="mission-card">
                <h3>Misión</h3>
                <p>Brindar un espacio deportivo de excelencia donde estudiantes y comunidad disfruten de actividades físicas, fomentando valores, disciplina y trabajo en equipo.</p>
            </div>
            <div class="mission-card">
                <h3>Visión</h3>
                <p>Ser reconocidos como un sistema deportivo innovador y completo, que impulse el desarrollo integral de todos los participantes, promoviendo la salud y el bienestar.</p>
            </div>
        </div>

        <!-- Timeline -->
        <h3 class="section-title">Nuestra Historia</h3>
        <div class="timeline">
            <div class="timeline-event left">
                <h4>2015</h4>
                <p>Se funda el Sistema Deportivo con el objetivo de fomentar el deporte en la comunidad estudiantil.</p>
            </div>
            <div class="timeline-event right">
                <h4>2017</h4>
                <p>Se incorporan nuevos deportes y se amplían instalaciones para mayor comodidad de los participantes.</p>
            </div>
            <div class="timeline-event left">
                <h4>2020</h4>
                <p>Se implementa un sistema de inscripciones online y control administrativo moderno.</p>
            </div>
            <div class="timeline-event right">
                <h4>2025</h4>
                <p>Se consolida como uno de los sistemas deportivos más completos y dinámicos de la ciudad.</p>
            </div>
        </div>

        <!-- Equipo -->
        <h3 class="section-title">Nuestro Equipo</h3>
        <div class="team-container">
            <div class="team-card">
                <img src="./img/henry.jpg" alt="Entrenador 1">
                <h5>Henry Adolfo Montoya</h5>
                <p>Entrenador Fútbol</p>
            </div>
            <div class="team-card">
                <img src="./img/henry.jpg" alt="Entrenador 2">
                <h5>Henry Adolfo Montoya</h5>
                <p>Entrenadora Baloncesto</p>
            </div>
            <div class="team-card">
                <img src="./img/henry.jpg" alt="Entrenador 3">
                <h5>Henry Adolfo Montoya</h5>
                <p>Entrenador Voleibol</p>
            </div>
            <div class="team-card">
                <img src="./img/henry.jpg" alt="Entrenador 3">
                <h5>Henry Adolfo Montoya</h5>
                <p>Entrenadora de Ajedrez</p>
            </div>
            <div class="team-card">
                <img src="./img/henry.jpg" alt="Entrenador 3">
                <h5>Henry Adolfo Montoya</h5>
                <p>Entrenador de Tenis</p>
            </div>
        </div>

    </div>
</section>

<!-- Footer -->
<?php include 'partials/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
