<h1 class="nombre-pagina">Olvdie Password</h1>
<p class="descripcion-pagina">Restablece tu password escribiendo tu email a continuacion</p>


<form class="formularo" action="/olvide" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input 
        type="email"
        id="email"
        name="email"
        placeholder="Tu email"
        >
    </div>
<input type="submit" class="boton"  value="Enviar Instrucciones">

<?php 
include_once __DIR__ . "/../templates/alertas.php";
?>
</form>
<div class="acciones">
    <a href="/crear-cuenta">¿Ya tienes una cuenta? Inicia Sesion</a>
    <a href="/crear-cuenta">¿Aun no tienes cuenta? Crear una</a>
</div>