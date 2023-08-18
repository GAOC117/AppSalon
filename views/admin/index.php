<h1 class="nombre-pagina">Pagina de administración</h1>

<?php
include_once __DIR__ . '/../templates/barra.php';
?>

<h2>Buscar citas</h2>
<div class="busqueda">
    <form action="" class="formulario">

        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
        </div>
    </form>
</div>
<!-- <input type="text" class="expediente"> 
<input type="text" class="expediente" id="X01"> -->

<!-- <select name="" id="sele">
    <option value="1">memo</option>
    <option value="2">antonio</option>
    <option value="3">ortiz</option>
    <option value="4">de los corella</option>
</select>

<p id="par">lele</p> -->


<?php if (count($citas) === 0) {

    echo '<h2>No hay citas en esta fecha</h2>';
} ?>

<div id="citas-admin">
    <ul class="citas">

        <?php
        foreach ($citas as $key => $cita) {

        ?>
            <?php if ($idCita !== $cita->id) {

                $total = 0;
            ?>
                <li>

                    <p>ID: <span><?php echo $cita->id; ?></span></p>
                    <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                    <p>Nombre: <span><?php echo $cita->cliente; ?></span></p>
                    <p>Email: <span><?php echo $cita->email; ?></span></p>
                    <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>
                    <h3>Servicios</h3>
                </li>

            <?php

                $idCita = $cita->id;
            }
            $total += $cita->precio;
            ?>


            <p class="servicio"><?php echo $cita->servicio . ' ' . $cita->precio; ?></p>

            <?php
            $actual = $cita->id;
            $proximo = $citas[$key + 1]->id ?? 0;

            if (esUltimo($actual, $proximo)) { ?>
                <p class="total">Total: <span>$<?php echo $total; ?></span></p>
                <form action="/api/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $cita->id;?>">
                    <input type="submit" class="boton-eliminar" value="Eliminar cita">
                </form>

            <?php
            }


            ?>


        <?php  } //fin foreach
        ?>
    </ul>




</div>



<?php
$script = "
   
   <script src='build/js/buscador.js'></script>
   
    
    
    "
?>