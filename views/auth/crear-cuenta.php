<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>

<form action="/crear-cuenta" method="POST" class="formulario">

<div class="campo">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" value=""> 
</div>


<div class="campo">
    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="apellido" placeholder="Tu apellido" value="">
</div>

<div class="campo">
    <label for="telefono">Telefono:</label>
    <input type="tel" id="telefono" name="telefono" placeholder="Tu Telefono" value="">
</div>

<div class="campo">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" placeholder="Tu E-mail" value="">
</div>

<div class="campo">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" placeholder="Tu Password" value="">
</div>

<input type="submit" value="Crear cuenta" class="boton">

</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>