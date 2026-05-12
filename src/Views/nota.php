<?php


// Si no hay usuario logueado, redirigir al login
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?page=sesion');
    exit;
}

// Inicializar notas en sesión si no existen
if (!isset($_SESSION['notas'])) {
    $_SESSION['notas'] = [];
}

// Capturar mensaje de error o éxito
$mensaje = $_GET['mensaje'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sticky Wall</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body style="background-color: #c2ebc2;">

<div class="container mt-5" style="background-color: #ffffff; border-radius: 10px; padding: 20px;">
    <div class="row">
        <!-- Menú a la izquierda -->
        <div class="col-md-3" style="background-color: #f8f9fa; padding: 15px; border-radius: 8px;">
            <h4>Menú</h4>
            <hr>

            <div class="mb-3">
                <h6>Tareas</h6>
                <div class="d-flex flex-column gap-2">
                    <a href="?page=home" class="btn btn-outline-primary text-start"><i class="bi bi-calendar-plus me-2"></i>Upcoming</a>
                    <a href="?page=today" class="btn btn-outline-primary text-start"><i class="bi bi-calendar-day me-2"></i>Today</a>
                    <a href="?page=calendario" class="btn btn-outline-primary text-start"><i class="bi bi-calendar me-2"></i>Calendario</a>
                    <a href="?page=stickywall" class="btn btn-outline-primary text-start"><i class="bi bi-sticky me-2"></i>Sticky Wall</a>
                </div>
            </div>
            <hr>
            <div class="mb-3">
                <h6>Listas</h6>
                <div class="d-flex flex-column gap-2">
                    
                    <button type="button" class="btn btn-outline-secondary text-start"><i class="bi bi-plus me-2"></i>Agregar Nueva Lista</button>
                </div>
            </div>

            <div class="mb-3">
                <h6>Etiquetas</h6>
                <div class="d-grid gap-2 d-md-block">
                    
                    <button type="button" class="btn btn-outline" style="background-color: #cacaca;"><i class="bi bi-plus"></i> Agregar etiqueta</button>
                </div>
            </div>
            
            <hr>

            <div class="mt-auto">
                <a href="index.php?action=logout" class="btn btn-outline-danger w-100"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9">
            <h1 class="mb-4">Sticky Wall</h1>

            <?php if (!empty($mensaje)): ?>
                <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
            <?php endif; ?>

            <!-- Formulario para agregar nota -->
            <form action="index.php?action=agregar_nota" method="POST" class="mb-4">
                <div class="input-group">
                    <input type="text" name="nota" class="form-control" placeholder="Escribe tu nota..." required>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </form>

            <!-- Mostrar notas -->
            <div class="row g-3">
                <?php if (!empty($_SESSION['notas'])): ?>
                    <?php foreach ($_SESSION['notas'] as $id => $nota): ?>
                        <div class="col-sm-6 col-md-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <p class="card-text"><?= htmlspecialchars($nota) ?></p>
                                    <a href="index.php?action=eliminar_nota&id=<?= $id ?>&from=stickywall" class="btn btn-sm btn-danger mt-2">Eliminar</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No tienes notas aún. ¡Agrega la primera arriba!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>