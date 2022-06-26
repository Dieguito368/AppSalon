<h1 class="nombre-pagina">Panel de Administración</h1>

<?php 
    include_once __DIR__ . '/../templates/barra.php';
?>

<h2>Buscar citas</h2>

<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="buscador" name="fecha" value="<?php echo $fecha; ?>">
        </div>
    </form>
</div>

<?php 
    if(count($citas) === 0) {
        echo '<h3>No hay citas en este fecha<h3>';
    }
?>

<div id="citas-admin">
    <ul class="citas-admin">
        <?php 
            $idCita = 0;

            forEach($citas as $key =>  $cita) {
                if($idCita !== $cita -> id_cita) { 
                    $total = 0;
        ?>

        <li>
            <p>Cita ID: <span><?php echo $cita -> id_cita?></span></p>
            <p>Hora: <span><?php echo $cita -> hora_cita ?></span></p>
            <p>Cliente: <span><?php echo $cita -> cliente ?></span></p>
            <p>Usuario: <span><?php echo $cita -> user_cliente ?></span></p>
            <p>Telefono: <span><?php echo $cita -> telefono_cliente ?></span></p>
            <h3>Servicios</h3>
            <?php 
                $idCita = $cita -> id_cita; 
                } //Fin de If
                
                $total += $cita -> precio_servicio;
            ?>
            <p class="servicio"><?php echo $cita -> nombre_servicio; ?><span> $<?php echo $cita -> precio_servicio; ?></span></p>

        <?php
            $actual = $cita -> id_cita;
            $proximo = $citas[$key + 1] -> id_cita ?? 0;

            if(esUltimo($actual, $proximo)) { 
        ?>
        
        <p class="total">Total: <span>$<?php echo $total?></span></p>

        <form action="/api/eliminar" method="POST">
            <input type="hidden" name="id_cita" value="<?php echo $cita -> id_cita ?>"/>
            <input type="submit" class="boton-eliminar" value="Eliminar"> 
        </form>
        
        <?php } ?>
        <?php } //Fin de ForEach ?>
        </li>
    </ul>
</div>

<?php 
    $script = "<script src='build/js/buscador.js'></script>"
?>