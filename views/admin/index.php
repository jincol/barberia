<h1 class="nombre-pagina margin">Panel de Administracion</h1>
<div class="">
    <?php include_once __DIR__ . '/../templates/barra.php'; ?>
</div>
<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
        </div>
    </form>
</div>

<?php if (count($citas) === 0) : ?>
    <h2>No hay citas</h2>
<?php endif ?>

<div class="citas-admin">
    <ul class="citas">
        <?php
        $existeId = 0;
        foreach ($citas as $key => $cita) {

            if ($existeId !== $cita->id) {
                $total = 0;
        ?>
                <li>
                    <p> N° <span><?php echo $cita->id ?></span></p>
                    <p> Cliente: <span><?php echo $cita->cliente ?></span></p>
                    <p> Email : <span><?php echo $cita->email ?></span></p>
                    <p> Telefono: <span><?php echo $cita->telefono ?></span></p>
                    <h3>Servicios</h3>
                <?php
                $existeId = $cita->id;
            } #fin-if
            $total += $cita->precio;
                ?>
                <p class="servicio"> <?php echo $cita->servicio . " " . $cita->precio ?></p>

                <?php
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;

                if (esUltimo($actual, $proximo)) { ?>
                    <p class="total">Total : <span> <?php echo $total; ?></span></p>

                    <form action="/api/eliminar" method="post" id="formEliminar" >
                        <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                        <input type="submit" value="Eliminar" class="boton" onclick="confirmaEliminacion(event)">
                    </form>
                <?Php }  ?>

            <?php } #fin-foreach  
            ?>

    </ul>
</div>

<?php
$script = "<script src='build/js/buscador.js'></script> 
<script src='//cdn.jsdelivr.net/npm/sweetalert2@10'></script> "
?>