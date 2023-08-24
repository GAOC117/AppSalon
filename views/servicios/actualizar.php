<h1 class="noombre-pagina">Actualizar servicios</h1>
<p class="descripcion-pagina">Modifica los valores del formulario</p>


<?php
include_once __DIR__.'/../templates/barra.php';
include_once __DIR__ . '/../templates/alertas.php';

?>



<form method="POST" class="formulario"> <!--SIN ACTION PARA QUE REDIRIJA A LA MISMA PAGINA-->
    <?php include_once __DIR__ . '/formulario.php'; ?>
    <input type="submit" class="boton" value="Guardar servicio">
</form>