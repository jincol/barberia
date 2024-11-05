<div class="access">
    <p class="nombre_user "> <?php echo isset($nombre) ? 'Hola ' . $nombre : ''; ?></p>
    <a class="boton cs" href="/logout">Cerrar Sesion</a>
</div>

<?php 
if(isset($_SESSION['admin'])){  ?>
    <div class="barra-servicios">
        <a class="boton" href="/admin">Ver Citas</a>
        <a class="boton" href="/servicios">Ver Servicios</a>
        <a class="boton" href="/servicios/crear">Nuevo Servicio</a>
    </div>
<?php }
    ?>