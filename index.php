<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="estilos/estilos.css">
</head>

<body>
    <div class="grid-logo">
        <img src="banner2.png" alt="">
        <div class="fecha">
            <h2 id="fechaActual"></h2>
        </div>
    </div>

    <div class="grilla">
        <div><button type="button" class="boton" id="index">Registro de Productos</button></div>
        <div><button type="button" class="boton" id="ventas">ventas</button></div>
        <div><button type="button" class="boton" id="informe">informe de ventas</button></div>
        <div><button type="button" class="boton" id="productos">lista de productos</button></div>
        <div><button type="button" class="boton" id="editar">editar productos</button></div>
        <div><button type="button" class="boton" id="cotizacion">Cotización</button></div>
    </div>

    <script src="js/jquery-3.6.0.min.js"></script>
    <script>
        const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto",
            "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ];
        const fecha = new Date();

        var fechaActual = fecha.getDate() + " de " + monthNames[fecha.getMonth()] + " de " + fecha.getFullYear();
        document.getElementById("fechaActual").innerHTML = fechaActual;

        $('#index').click(function() {
            window.location = 'index2.php'
        });
        $('#ventas').click(function() {
            window.location = 'ventas.php'
        });
        $('#informe').click(function() {
            window.location = 'informe_ventas.php'
        });
        $('#editar').click(function() {
            window.location = 'modificar.php'
        });
        $('#productos').click(function() {
            window.location = 'productos.php'
        });
        $('#refacciones').click(function() {
            window.location = 'equipo.php'
        });
        $('#componentes').click(function() {
            window.location = 'equipo.php'
        });
        $('#gastos').click(function() {
            window.location = 'gastoslocal.php'
        });
        $('#caja').click(function() {
            window.location = 'index.php'
        });
        $('#recepcion').click(function() {
            window.location = 'cliente_nuevo.php'
        });
        $('#clientes').click(function() {
            window.location = 'busqueda_cliente.php'
        });
        $('#cotizacion').click(function() {
            window.location = 'cotizacion.php'
        });
    </script>
</body>

</html>