<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../../public/index.php?page=sesion');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nota = trim($_POST['nota'] ?? '');

    if ($nota !== '') {
        if (!isset($_SESSION['notas'])) {
            $_SESSION['notas'] = [];
        }
        // Guardar nota con id único
        $_SESSION['notas'][] = $nota;
        header('Location: index.php?page=stickywall&mensaje=Nota agregada');
        exit;
    }
}

// Si algo falla, redirigir
header('Location: ../../public/index.php?page=stickywall&mensaje=Error al agregar nota');
exit;