<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$tabla = $_GET['tabla'] ?? '';
$id    = $_GET['id'] ?? '';

if (!$tabla || !$id) die("Datos incompletos");

$stmt = $pdo->prepare("DELETE FROM $tabla WHERE id=:id");
$stmt->execute(['id'=>$id]);

header("Location: admin_panel.php#inscripciones");
exit;
