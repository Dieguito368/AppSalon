<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administración de Servicios</p>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<div class=tabla-servicios>
    <table>
        <thead>
            <tr class="encabezado">
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach($servicios as $servicio) { ?>
                <tr class="datos">
                    <td><?php echo $servicio -> id_servicio ?></td>
                    <td><?php echo $servicio -> nombre_servicio ?></td>
                    <td>$<?php echo $servicio -> precio_servicio ?></td>
                    <td>
                        <div class="acciones">
                            <a class="btn-accion btn-actualizar" href="/servicios/actualizar?id=<?php echo $servicio -> id_servicio; ?>">Actualizar</a>

                            <form action="/servicios/eliminar" method="POST">
                                <input type="hidden" name="id_servicio" value="<?php echo $servicio -> id_servicio; ?>"/>
                                <input class="btn-accion btn-eliminar" type="submit" href="/" value="Eliminar">
                            </form>    
                        </div>
                    </td>
                </tr>
            <?php } ?>
        <tbody>
    </table>


