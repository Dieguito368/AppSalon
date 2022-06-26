<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia Sesión con tus datos</p> 

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="usuario">Usuario</label>
        <input type="text" id="usuario" name="usuario"/>      
    </div>

    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password"/>      
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión"/>    
</form>    

<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una</a>
</div>