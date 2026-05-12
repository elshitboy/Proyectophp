<?php
session_start();

if (!isset($_SESSION['eventos'])) {
    $_SESSION['eventos'] = [];
}

$fecha = $_POST['fecha'] ?? null;
$nota = $_POST['nota'] ?? null;

if ($fecha && $nota) {
    $_SESSION['eventos'][] = [
        "fecha" => $fecha,
        "nota" => $nota
    ];
}

header("Location: index.php?page=calendario");
exit;