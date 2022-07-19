<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Ventas</title>
    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="stylesheet" href="estilos/all.css">
    <script src="js/jquery-3.6.0.min.js"></script>
</head>

<body>
    <ul class="breadcrumb">
        <li><a href="index.php">Inicio</a></li>
        <li>Reporte de ventas</li>
    </ul>

    <form>
        <fieldset class="none">
            <legend>Elige una opción:</legend>
            <label>
                <input type="radio" name="propietario" id="factura3" value="Eduardo" required> Eduardo
            </label>
            <label>
                <input type="radio" name="propietario" id="factura2" value="Lilia" required> Lilia
            </label>
            <label>
                <input type="radio" name="propietario" id="factura1" value="Sin Factura"> Sin Factura
            </label>
        </fieldset>
    </form>

    <!-- Estos datos se muestran al inicio de la página -->
    <div class="espacio tbCalendar" id="tabla"></div>
    <div class="espacio" id="tfoot"></div>


    <!-- CALENDARIO -->
    <form id="formulario"></form>
    <!-- radio buttons -->
    <form id="formularioEduardo"></form>
    <form id="formularioLilia"></form>
    <form id="sinFactura"></form>

    <!-- Estos datos son del modal / No se muestran hasta que se consulte    -->
    <div class="modal">
        <div class="modal-close">&times;</div>        
        <h3>Lista de Artículos <i class="fal fa-file-pdf pdf_fechas"></i></h3> <!-- checar esto, añadir la clase cuando se de clic en un propietario-->
        <div id="tabla2"></div>
        <div id="tfoot2" class="espacio"></div>
    </div>

    <script src="js/radio.facturas.js"></script>
    <script src="js/submit_fechas.js"></script>
</body>

</html>