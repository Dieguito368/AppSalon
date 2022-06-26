<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php';
?>
    
<div id="app">
    <nav class="tabs">
        <button type="button" data-paso="1">Servicios</button>  
        <button type="button" data-paso="2">Información Cita</button>  
        <button type="button" data-paso="3">Resumen</button>  
    </nav>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p>Elige tus servicios a continuación</p>
        
        <div id="servicios" class="lista-servicios"></div>
    </div>
    
    <div id="paso-2" class="seccion seccion-formulario">
        <h2>Tus datos y Cita</h2>
        <p>Coloca tus datos y fecha de cita</p>
        <p class="horario-atencion">Horario de Servicio: <span>Lunes a Sábado de 9:00 AM a 3:30 PM</span></p>        

        <form aclass="formulario" action="">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" value="<?php echo $nombre; ?>" disabled>
            </div> 

            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" min="<?php echo date('Y-m-d', + strtotime('+1 day')); ?>">
            </div> 

            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time" id="hora">
            </div> 

            <input type="hidden" id="id" value="<?php echo $id; ?>">
        </form>
    </div>
    
    <div id="paso-3" class="seccion seccion-resumen">
        <h2>Resumen</h2>
        <p>Verifica que la información sea correcta</p>
        <div class="contenido-resumen">
            <div class="resumen-cita"></div>

            <div class="resumen-servicios"></div>
        </div> 
    </div>  

    <div class="paginacion">
        <button id="anterior" class="boton">&laquo; Anterior</button>
        <button id="siguiente" class="boton">Siguiente &raquo;</button>
    </div>
</div>

<?php 
    $script = "
        <script src='build/js/sweetalert2.js'></script>
        <script src='build/js/app.js'></script>
    ";
?>