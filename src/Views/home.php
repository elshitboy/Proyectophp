<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8 es-Es">
<title> Home </title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>


<body style= "background-color: #c2ebc2;">
    
<div class="container mt-5" style="background-color: #ffffff; border-radius: 10px; padding: 20px;">
    <div class="row">
        <!-- Menú a la izquierda -->
        <div class="col-md-3" style="background-color: #f8f9fa; padding: 10px;">
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
            <div class="mt-auto">
                <a href="index.php?action=logout" class="btn btn-outline-danger w-100"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a>
            </div>
        </div>
        
        <!-- Mensaje de bienvenida al lado del menú -->
        <div class="col-md-9">
            <h1>Bienvenido a tu aplicación de tareas</h1>
            <p>Organiza tus tareas y listas de manera eficiente. </p>

            <hr>

            <h4>Notas </h4>

            <?php if (!empty($_SESSION['notas'])): ?>

                <div class="row g-3">

                    <?php 
                    $notas = array_slice($_SESSION['notas'], -6); // últimas 6 notas
                    foreach ($notas as $id => $nota): 
                    ?>

                        <div class="col-md-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body d-flex justify-content-between align-items-start">
                                    
                                    <p class="card-text mb-0"><?= htmlspecialchars($nota) ?></p>
                                    

                                    <form action="index.php" method="GET">
                                        <input type="hidden" name="action" value="eliminar_nota">
                                        <input type="hidden" name="id" value="<?= $id ?>">
                                        <input type="hidden" name="from" value="home">

                                        <input 
                                            type="checkbox" 
                                            onchange="this.form.submit()"
                                            style="cursor:pointer;"
                                        >
                                    </form>
                                </div>                              
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>

            <?php else: ?>

            <p>No tienes notas aún. Ve a <strong>Sticky Wall</strong> para crear una.</p>

            <?php endif; ?>

            <hr>

            <h4>Fechas</h4>

            <?php if (!empty($_SESSION['eventos'])): ?>

                <div class="row g-3 mt-2">

                    <?php 
                    // ordenar por fecha (más próximas primero)
                    $eventos = $_SESSION['eventos'] ?? [];

                    $hoy = date("Y-m-d");

                    $eventos = array_filter($eventos, function($ev) use ($hoy){
                        return strtotime($ev['fecha']) >= strtotime($hoy);
                    });

                    usort($eventos, function($a, $b){
                        return strtotime($a['fecha']) - strtotime($b['fecha']);
                    });

                    // mostrar solo los próximos 6
                    $eventos = array_slice($eventos, 0, 6);

                    foreach ($eventos as $ev): 
                    ?>

                        <div class="col-md-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">

                                    <h6 class="text-muted">
                                        <i class="bi bi-calendar"></i>
                                        <?= date("d-m-Y", strtotime($ev['fecha'])) ?>
                                    </h6>

                                    <p class="card-text mb-0">
                                        <?= htmlspecialchars($ev['nota']) ?>
                                    </p>

                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>

            <?php else: ?>

                <p>No tienes eventos aún. Ve al <strong>Calendario</strong> para crear uno.</p>

            <?php endif; ?>
        </div>  
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>