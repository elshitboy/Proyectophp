<?php
session_start();

// HANDLERS
$handlers = [
    'logout' => '../src/handlers/logout.php',
    'login' => '../src/handlers/procesar_login.php',
    'agregar_nota' => '../src/handlers/agregar_nota.php',
    'eliminar_nota' => '../src/handlers/eliminar_nota.php',
    'guardar_evento' => '../src/handlers/guardar_evento.php',
];

$action = $_GET['action'] ?? '';

if (isset($handlers[$action])) {
    include __DIR__ . '/' . $handlers[$action];
    exit;
}

// VISTAS
$views = [
    'home' => '../src/Views/home.php',
    'calendario' => '../src/Views/calendario.php',
    'sesion' => '../src/Views/iniciosesion.php',
    'stickywall' => '../src/Views/nota.php',
    'today' => '../src/Views/today.php',
];

// CONTROL DE SESIÓN
$page = isset($_SESSION['usuario']) 
    ? ($_GET['page'] ?? 'home') 
    : 'sesion';

// CARGAR VISTA
if (isset($views[$page])) {
    include __DIR__ . '/' . $views[$page];
} else {
    echo "Página no encontrada";
}