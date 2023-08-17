
<div class="barra">
    <p>Hola <?php echo $nombre ?? '' ?></p>
    <?php if($nombre!=' '){?>
        <a class="boton" href="/logout">Cerrar Sesión</a>
    <?php } ?>

</div>