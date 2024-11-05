<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llena el formulario para crear su cuenta</p>

<?php  include_once __DIR__."/../templates/alertas.php" ; ?>

<form action="/crear-cuenta" method="POST" class="formulario">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" placeholder="Tu nombre" name="nombre" value="<?php echo s($usuario->nombre)?>">
    </div>
    <div class="campo">
        <label for="apellido">apellido</label>
        <input type="text" id="apellido" placeholder="Tu apellido" name="apellido" value="<?php echo s($usuario->apellido)?>">
    </div>
    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" id="telefono" placeholder="Tu telefono" name="telefono" value="<?php echo s($usuario->telefono)?>">
    </div>
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu email" name="email" value="<?php echo s($usuario->email)?>"> 
    </div>
    <div class="campo">
        <label for="password">Tu Password</label>
        <input type="password" id="password" placeholder="Tu password" name="password">
    </div>

    <input type="submit" value="Crear Cuenta" class="boton">
</form>

<div class="acciones">
    <a href="/">Ya tienes una cuenta? Inicia Sesion</a>
    <a href="/olvide">Olvideste tu contraseña?</a>
</div>