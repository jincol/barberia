<h1 class="nombre-pagina">Crear Servicios</h1>

<p class="descripcion-pagina">Llena los campos para añadir el servicio</p>

<!-- <?php include_once __DIR__ . '/../templates/barra.php'; ?> -->
<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form action="/servicios/crear" method="POST" class="formulario">

    <?php include __DIR__ . '/formulario.php'; ?>

    <input type="submit" value="Guardar Servicio" class="boton">
</form>