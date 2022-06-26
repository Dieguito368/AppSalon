<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">LLena el siguiente formulario para crear crear una cuenta</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form class="formulario" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo s($usuario -> nombre_usuario ?? ''); ?>"/>      
    </div>

    <div class="campo">
        <label for="apellidoPaterno">Apellido Paterno</label>
        <input type="text" id="apellidoPaterno" name="apellidoPaterno" value="<?php echo s($usuario -> apellidoPaterno_usuario ?? ''); ?>"/>      
    </div>

    <div class="campo">
        <label for="telefono">Télefono</label>
        <input type="tel" id="telefono" name="telefono" value="<?php echo s($usuario -> telefono_usuario ?? ''); ?>"/>      
    </div>

    <div class="campo">
        <label for="usuario">Usuario</label>
        <input type="text" id="usuario" name="usuario" value="<?php echo s($usuario -> user_usuario ?? ''); ?>"/>      
    </div>

    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password"/>      
    </div>

    <input type="submit" class="boton" value="Crear Cuenta  "/>    
</form>    

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
</div>