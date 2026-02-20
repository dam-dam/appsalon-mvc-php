<h1 class="nombre-pagina">Actualiza Servicio</h1>
<p class="descripcion-pagina">Actualiza precio, mombre o descripcion de tus servicios</p>

<?php 
    include __DIR__ ."/../templates/barra.php";
    include __DIR__ ."/../templates/alertas.php";
?>

<form  method="POST" class="formulario">
    <?php include_once __DIR__ . "/formulario.php" ?>

    <input type="submit" class="boton" value="Actualizar">
</form>
