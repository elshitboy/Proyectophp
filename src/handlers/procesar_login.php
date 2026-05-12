<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        $_SESSION['usuario'] = $email;
        // Redirige a home
        header('Location: /index.php?page=home');
        exit;
    } else {
        // Error: campos vacíos
        header('Location: /index.php?page=iniciosesion&error=1');
        exit;
    }
}

// Si no es POST, redirigir al login
header('Location: /index.php?page=iniciosesion');
exit;