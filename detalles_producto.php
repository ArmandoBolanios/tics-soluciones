<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del producto</title>
    <link rel="stylesheet" href="estilos/estilos.css">
</head>

<body>
    <?php
    require 'cn/cnt.php';
    $codigoProducto = $_GET['codigo_producto'];    

    $consultarImagen = "SELECT DISTINCT imagen, descripcion FROM productos WHERE codigoProducto = '$codigoProducto' ";
    $detalle_imagen = $Oxi->query($consultarImagen);

    ?>

    <div class="detalles">
        <div class="detalle_imagen">
            <?php
            while ($row = $detalle_imagen->fetch_assoc()) {
                echo '<img src="' . $row['imagen'] . '" alt="none">';
                echo '<h3>' . $row['descripcion'] . '</h3>';
            }
            ?>
        </div>
        <div class="panel_detalle">
            <?php
            $detalles = "SELECT DISTINCT idProducto, categoria, codigoProducto, noDeParte, descripcion, marca, modelo, 
            factor, contenido, existencias, precioDeCompra, precioUnitario, observaciones, ubicacion, fechaDeCompra, 
            propietario, fechaDeRegistro FROM productos WHERE codigoProducto = '$codigoProducto' ";

            $detalles_producto = $Oxi->query($detalles);


            while ($rows = mysqli_fetch_array($detalles_producto)) {
            ?>
                <div class="headerPanel">
                <p><< <?php echo $rows['codigoProducto']; ?> >></p>
                </div>                
                <p class="linea">ID PRODUCTO: <?php echo $rows['idProducto']; ?></p>
                <p class="linea">CATEGORÍA: <?php echo $rows['categoria']; ?></p>
                <p class="linea">MARCA: <?php echo $rows['marca']; ?></p>
                <p class="linea">MODELO: <?php echo $rows['modelo']; ?></p>
                <p class="linea">NÚMERO DE PARTE: <?php echo $rows['noDeParte']; ?></p>
                <p class="linea">FACTOR: <?php echo $rows['factor']; ?></p>
                <p class="linea">CONTENIDO: <?php echo $rows['contenido']; ?></p>
                <p class="linea">EXISTENCIAS: <?php echo $rows['existencias']; ?></p>
                <p class="linea">PRECIO DE COMPRA: <span>$ <?php echo $rows['precioDeCompra']; ?></span></p>
                <p class="linea alerta">PRECIO DE VENTA: <span>$ <?php echo $rows['precioUnitario']; ?></span></p>
                <p class="linea observaciones">OBSERVACIONES: <span> <?php echo $rows['observaciones']; ?></span></p>
                <p class="linea">UBICACIÓN: <?php echo $rows['ubicacion']; ?></p>
                <p class="linea">FECHA DE COMPRA: <?php echo $rows['fechaDeCompra']; ?></p>
                <p class="footerPanel">PROPIETARIO (A): <?php echo $rows['propietario']; ?></p>                
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>