<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?page=sesion');
    exit;
}

$id = $_GET['id'] ?? null;

if ($id !== null && isset($_SESSION['notas'][$id])) {
    unset($_SESSION['notas'][$id]);
    $_SESSION['notas'] = array_values($_SESSION['notas']);
}

// SIEMPRE REDIRIGES DESDE AQUÍ
$from = $_GET['from'] ?? 'home';

header("Location: index.php?page=$from&mensaje=Nota eliminada");
exit;