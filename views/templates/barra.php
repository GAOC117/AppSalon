
<div class="barra">
    <p>Hola <?php echo $nombre ?? '' ?></p>
    <?php if($nombre!=' '){?>
        <a class="boton" href="/logout">Cerrar Sesión</a>
    <?php } ?>

</div>

<?php if(isset($_SESSION['admin'])){ ?>
    <div class="barra-servicios">
        <a class="boton" href="/admin">Ver citas</a>
        <a class="boton" href="/servicios">Ver servicios</a>
        <a class="boton" href="/servicios/crear">Nuevo servicio</a>
    </div>

<?php }?>

