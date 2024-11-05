<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia Sesion con tus datos</p>
<?php  include_once __DIR__."/../templates/alertas.php" ; ?>
<form method="POST" action="/" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Correo@gmail.com" name="email" required>
    </div>
<form method="POST" action="/" class="formulario">
    <div class="campo">
        <label for="password">Email</label>
        <input type="password" id="password" placeholder="***********" name="password" required>
    </div>
    <input type="submit" value="Iniciar Sesion" class="boton">
</form>
<div class="acciones">
    <a href="/crear-cuenta">Aun no tienes una cuenta?</a>
    <a href="/olvide">Olvideste tu contraseña?</a>
</div>