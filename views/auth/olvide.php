<h1 class="nombre-pagina">Olvide mi contraseña</h1>
<p class="descripcion-pagina">Restablece tu contraseña escribiendo tu email</p>
<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form action="/olvide" method="POST" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" placeholder="Tu email" id="email" name="email">
    </div>

    <input type="submit" class="boton" value="Enviar">
</form>
<div class="acciones">
    <a href="/login">Ya tienes tu cuenta? Inicia Sesion</a>
    <a href="/crear-cuenta">Aun no tiene una cuenta? Crear cuenta</a>
</div>