<h1 class="nombre-pagina">Actualizar Servicios</h1>

<p class="descripcion-pagina">Modifica los valores del formulario</p>

<?php include_once __DIR__.'/../templates/barra.php'; ?>
<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form  method="POST" class="formulario">

    <?php include __DIR__ . '/formulario.php'; ?>

    <input type="submit" value="Guardar Cambios" class="boton">
</form>