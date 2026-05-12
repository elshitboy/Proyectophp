<?php

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?page=sesion');
    exit;
}

$hoy = date("Y-m-d");

//Eventos de hoy
$eventos = $_SESSION['eventos'] ?? [];

$eventosHoy = array_filter($eventos, function($ev) use ($hoy){
    return $ev['fecha'] === $hoy;
});

//Notas (si quieres mostrarlas también)
$notas = $_SESSION['notas'] ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Today</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>

<body style="background-color: #c2ebc2;">

<div class="container mt-5" style="background-color: #ffffff; border-radius: 10px; padding: 20px;">
    <div class="row">

        <!-- MENÚ -->
        <div class="col-md-3" style="background-color: #f8f9fa; padding: 10px;">
            <h4>Menú</h4>
            <hr>
            <div class="d-flex flex-column gap-2">
                <a href="?page=home" class="btn btn-outline-primary text-start">
                    <i class="bi bi-house"></i> Home
                </a>

                <a href="?page=today" class="btn btn-primary text-start">
                    <i class="bi bi-calendar-day"></i> Today
                </a>

                <a href="?page=calendario" class="btn btn-outline-primary text-start">
                    <i class="bi bi-calendar"></i> Calendario
                </a>

                <a href="?page=stickywall" class="btn btn-outline-primary text-start">
                    <i class="bi bi-sticky"></i> Sticky Wall
                </a>
            </div>

            <hr>

            <div class="mb-3">
                <h6>Listas</h6>
                <div class="d-flex flex-column  gap-2">
                    
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

            <div class="mt-4">
                <a href="index.php?action=logout" class="btn btn-outline-danger w-100">
                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                </a>
            </div>
        </div>

        <!-- CONTENIDO -->
        <div class="col-md-9">

            <h2 class="mb-4">
                <i class="bi bi-calendar-day"></i> Hoy (<?= date("d-m-Y") ?>)
            </h2>

            <!-- EVENTOS -->
            <h5>Eventos de hoy</h5>

            <?php if (!empty($eventosHoy)): ?>

                <div class="row g-3 mb-4">

                    <?php foreach ($eventosHoy as $ev): ?>

                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <p class="mb-0"><?= htmlspecialchars($ev['nota']) ?></p>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>

            <?php else: ?>

                <p>No tienes eventos para hoy.</p>

            <?php endif; ?>

            <hr>

            <!-- NOTAS (opcional) -->
            <h5>Notas</h5>

            <?php if (!empty($notas)): ?>

                <div class="row g-3">

                    <?php 
                    $ultimasNotas = array_slice($notas, -6);
                    foreach ($ultimasNotas as $nota): 
                    ?>

                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <p class="mb-0"><?= htmlspecialchars($nota) ?></p>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>

            <?php else: ?>

                <p>No tienes notas aún.</p>

            <?php endif; ?>

        </div>

    </div>
</div>

</body>
</html>