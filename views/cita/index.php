<h1 class="nombre-pagina">Nueva cita</h1>

<p class="descripcion-pagina">Elige tus servicios a continuacion</p>
<?php 
include_once __DIR__ . "/../templates/barra.php";

?>

<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1"> Servicios</button>
        <button type="button" data-paso="2"> Informacion cita</button>
        <button type="button" data-paso="3"> resumen</button>
    </nav>
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuacion</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>


    <div id="paso-2" class="seccion">
        <h2>Tus datos y cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita</p>

        <form action="" class="formularios">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                id="nombre"
                type="text"
                placeholder="Tu nombre"
                value="<?php echo $nombre; ?>"
                >
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input 
                id="fecha"
                type="date"
                min="<?php echo date(('Y-m-d')); ?>"
              
                >
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input 
                id="hora"
                type="time"
            
                >
            </div>
        </form>
        <input type="hidden" id="id" value=" <?php echo $id; ?>">

    
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p>Verifica que sea correcto</p>
       

    
    </div>

    <div class="paginacion">
        <button
        id="anterior"
        class="boton"
        >&laquo; Anterior</button>

        <button
        id="siguiente"
        class="boton"
        > Siguiente &raquo;</button>
    </div>
    
</div>

<?php 
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src = 'build/js/app.js'></script>
    ";
 ?>