<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<h1 class="nombre-pagina">Crea nueva cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>

<div class="app">

    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <P class="text-center">Elige tus servicios a continuacion</P>
        <div class="listado-servicios" id="servicios"> </div>
    </div>
    <div id="paso-2" class="seccion">
        <h2>Tus datos y Cita</h2>
        <P class="text-center">Coloca tus datos y fecha de tu Cita</P>
        <form class="formulario">
            <input type="hidden" id="id" value="<?php echo $id; ?>">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu nombre" value="<?php echo $nombre ?>" disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" min="<?php echo date('Y-m-d');    ?>">
            </div>

            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time" id="hora">
            </div>
        </form>
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la informacion sea correcta</p>
    </div>
    <div class="paginacion">
        <button id="anterior" class="boton"> &laquo; Anterior </button>
        <button id="siguiente" class="boton">Siguiente &raquo; </button>
    </div>
</div>

<?php

$script = "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src='build/js/app.js'></script>
    ";
?>