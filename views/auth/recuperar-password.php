<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Coloca tu nuevo Password a continuacion</p>
<?php  include_once __DIR__."/../templates/alertas.php" ; ?>

<?php  if($error) return ; ?>

<form  method="POST" class="formulario">
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Tu nueva contraseña">
    </div>
    <input type="submit" value="Restablecer" class="boton">
</form>
<div class="acciones">
    <a href="/">Ya tienes cuenta? Iniciar Sesion</a>
    <a href="/crear-cuenta">Aun no tienes cuenta? , obtener cuenta</a>
</div>