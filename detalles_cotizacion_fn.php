<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles cotizacion</title>
    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="stylesheet" href="estilos/all.css">
</head>

<body>
    <ul class="breadcrumb">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="cotizacion.php">Cotizaciones</a></li>
        <li>Detalles Cotizacion Finalizada</li>
    </ul>

    <?php
    require('cn/cnt.php');
    $clave = $_REQUEST['claveCotizacion'];

    $cliente = "SELECT * FROM cotizacion WHERE clave = '$clave'  ORDER BY clave ASC LIMIT 1 ";

    $sql = $Oxi->query($cliente);
    while ($rows = $sql->fetch_array(MYSQLI_ASSOC)) { ?>
        <div class="datos_cliente1">
            <h3><?php echo $rows["nombre_cliente"]; ?></h3>            
            <input type="submit" class="btnArticulo" value="ver el reporte">            
            <input type="hidden" value="<?php echo $rows["id_cotizacion"];?>" id="cotizacion">
            <input type="hidden" value="<?php echo $clave; ?>" id="clave">
            <input type="hidden" value="<?php echo $rows["nombre_cliente"];?>" id="nombre_cliente">
            <input type="hidden" value="<?php echo $rows["telefono"];?>" id="telefono">
            <input type="hidden" value="<?php echo $rows["correo"];?>" id="correo">
            <input type="hidden" value="<?php echo $rows["direccion"]; ?>" id="direccion">
            <input type="hidden" value="<?php echo $rows["fecha_cot"]; ?>" id="fecha_hora">            
        </div>
    <?php
    }
    ?>
    <div id="tblCotizacionPendiente">
        <table class="table2">
            <thead>
                <tr>
                    <th>codigo</th>
                    <th>Descripcion</th>
                    <th>factor</th>
                    <th>contenido</th>                    
                    <th>precio unitario</th>
                    <th>cantidad</th>
                    <th>subtotal</th>
                </tr>
            </thead>

            <!-- consulta para mostrar la cotización del cliente que se seleccionó -->
            <?php
            $articulos = "SELECT codigoProducto, cantidad, descripcion, factor, contenido, precio_unitario, sub_total,
            producto_cotizacion.clave, auxiliar 
            FROM producto_cotizacion 
            INNER JOIN cotizacion
            ON cotizacion.clave = producto_cotizacion.clave
            WHERE cotizacion.clave = '$clave' AND cotizacion.auxiliar = '0'";

            $total = 0;
            $sql_cotizacion = $Oxi->query($articulos);
            while ($fila = $sql_cotizacion->fetch_array(MYSQLI_ASSOC)) {
            ?>
                <tbody>
                    <tr>
                        <td><?php echo $fila["codigoProducto"] ?></td>
                        <td><?php echo $fila["descripcion"] ?></td>
                        <td><?php echo $fila["factor"] ?></td>
                        <td><?php echo $fila["contenido"] ?></td>                        
                        <td><?php echo $fila["precio_unitario"] ?></td>
                        <input type="hidden" id="precio<?php echo $fila["codigoProducto"]; ?>" value="<?php echo $fila["precio_unitario"]; ?>" name="precio_unitario">
                        <td><?php echo $fila["cantidad"]; ?></td>
                        <td>
                            <?php echo '$' . number_format($fila["cantidad"] * $fila["precio_unitario"], 2) ?>
                        </td>
                        <?php $total = $total + ($fila["cantidad"] * $fila["precio_unitario"]); ?>
                    <?php
                } // END WHILE
                    ?>
                    </tr>
                </tbody>
        </table>
    </div>
    <div class="totalCotizacion">
        <div class="totalFooter">
            <h3>TOTAL $<?php echo number_format($total, 2); ?></h3>
        </div>        
    </div>    
    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/radio.cotizaciones.js"></script>
</body>

</html>