<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Calendario</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
    .calendar-container{
        max-height:none;
        overflow:visible;
    }

    .calendar{
        display:grid;
        grid-template-columns: repeat(7,1fr);
    }

    .calendar-day{
        height:120px;        
        border:1px solid #ddd;
        padding:10px;
        cursor:pointer;
        position:relative;
    }

    .calendar-day:hover{
        background:#f0f0f0;
    }

    .calendar-day.selected{
        background:#cce7ff;
    }

    .calendar-day.today{
        background:#fff3cd;
    }

    .calendar-day.other-month{
        color:#ccc;
    }

    .calendar-header{
        text-align:center;
        margin-bottom:10px;
        font-weight:bold;
        font-size:28px;
    }

    .calendar-week{
        display:grid;
        grid-template-columns: repeat(7,1fr);
        text-align:center;
        font-weight:bold;
        margin-bottom:5px;
    }
</style>

</head>

<body style="background-color: #c2ebc2;">

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

        <div class="col-md-9">
            <div class="calendar-header" id="monthYear"></div>
            <div class="calendar-week">
                <div>Dom</div>
                <div>Lun</div>
                <div>Mar</div>
                <div>Mie</div>
                <div>Jue</div>
                <div>Vie</div>
                <div>Sab</div>
            </div>

            <div class="calendar-container">
                <div class="calendar" id="calendar"></div>
            </div>
        </div>
        
        <div class="mt-5">
            <h5>Agregar nota al día seleccionado</h5>

            <form method="POST" action="index.php?action=guardar_evento">
                <input type="hidden" name="fecha" id="fechaSeleccionada">

                <div class="input-group">
                    <input type="text" name="nota" class="form-control" placeholder="Escribe algo importante..." required>
                    <button class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
        
        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    
const calendar = document.getElementById("calendar")
const monthYear = document.getElementById("monthYear")

const today = new Date()

const eventos = <?php echo json_encode($_SESSION['eventos'] ?? []); ?>;

function createCalendar(){

    const year = today.getFullYear()
    const month = today.getMonth()

    const firstDay = new Date(year,month,1).getDay()
    const lastDate = new Date(year,month+1,0).getDate()

    const months = [
    "Enero","Febrero","Marzo","Abril","Mayo","Junio",
    "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"
    ]

    monthYear.innerText = months[month]+" "+year

    calendar.innerHTML=""

    for(let i=0;i<firstDay;i++){
    const empty=document.createElement("div")
    empty.classList.add("calendar-day","other-month")
    calendar.appendChild(empty)
    }

    for(let day=1;day<=lastDate;day++){

        const div=document.createElement("div")
        div.classList.add("calendar-day")

        div.innerText=day

        eventos.forEach(ev => {
            const [yearEv, monthEv, dayEv] = ev.fecha.split('-').map(Number)
            const fechaEv = new Date(yearEv, monthEv - 1, dayEv)

            if (
                fechaEv.getDate() === day &&
                fechaEv.getMonth() === month &&
                fechaEv.getFullYear() === year
            ) {
                const note = document.createElement("div")
                note.style.fontSize = "10px"
                note.style.marginTop = "5px"
                note.innerText = ev.nota

                div.appendChild(note)
            }
        })

        if(
        day===today.getDate() &&
        month===today.getMonth()
        ){
        div.classList.add("today")
        }

        div.onclick = () => {

            document.querySelectorAll(".calendar-day")
                .forEach(d => d.classList.remove("selected"))

            div.classList.add("selected")

            //GUARDAR FECHA
            const selectedDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`
            document.getElementById("fechaSeleccionada").value = selectedDate
        }

        calendar.appendChild(div)

    }

}

createCalendar()
</script>

</body>
</html>
