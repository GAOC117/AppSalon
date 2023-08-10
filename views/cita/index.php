<h1 class="nombre-pagina">Crear nueva cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>


<div id="app">

    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Información Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>



    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>

    <div id="paso-2" class="seccion">
        <h2>Tus datos y cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita</p>

        <form class="formulario">

            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu nombre" value="<?php echo $nombre; ?>" disabled>
            </div>

            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" min="<?php echo date('Y-m-d'); //strtotime('+1 day) suma un dia mas ?>">
            </div>



            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time" id="hora">
            </div>

        </form>
    </div>

    <div id="paso-3" class="seccion">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la información sea correcta</p>

    </div>

    <div class="paginacion">
        <button id="anterior" class="boton">
            &laquo; Anterior
        </button>

        <button id="siguiente" class="boton">
            Siguiente &raquo;
        </button>

    </div>

</div>
<!-- 
<form  onchange="prueba()">


<select name="id" id="cars">
    <option value="" disabled selected>--Seleccionar--</option>
   <?php ""// foreach ($valor as $value ) {?>

    <option value = "<?php //echo $value->id?>"><?php //echo $value->nombre.' '.$value->precio?></option>


<?php //} ?>    
</select>

<select name="modelo" id="modelo">
    
    </select>
    

</form> -->



<?php
$script = "
    <script src='build/js/app.js'></script>
    
    
    "
?>