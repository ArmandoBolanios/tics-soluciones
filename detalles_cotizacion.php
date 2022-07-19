<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles cotizacion</title>
    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="stylesheet" href="estilos/all.css">
    <link rel="stylesheet" href="estilos/modal.css">
    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
    <script src="js/modal.js"></script>
</head>

<body>
    <ul class="breadcrumb">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="cotizacion.php">Cotizaciones</a></li>
        <li>Detalles Cotizacion</li>
    </ul>

    <?php
    require('cn/cnt.php');
    $clave = $_REQUEST['claveCotizacion'];
    $cliente = "SELECT * FROM cotizacion WHERE clave = '$clave'  ORDER BY clave ASC LIMIT 1 ";
    $sql = $Oxi->query($cliente);
    while ($rows = $sql->fetch_array(MYSQLI_ASSOC)) { ?>
        <div class="datos_cliente1">
            <h3><?php echo $rows["nombre_cliente"]; ?></h3>
            <input type="hidden" value="<?php echo $rows["telefono"]; ?>">
            <input type="hidden" value="<?php echo $rows["correo"]; ?>">
            <input type="hidden" value="<?php echo $rows["direccion"]; ?>">
            <input type="hidden" value="<?php echo $clave; ?>" id="clave">
            <input type="submit" class="btnArticulo" id="edit_cliente" value="cambiar datos">
            <input type="submit" class="btnArticulo" id="add_articulo" value="agregar más">

            <?php
            // asignarlos a las variables globales para mostrarlos en el modal
            $nombre_cliente = $rows["nombre_cliente"];
            $telefono = $rows["telefono"];
            $correo = $rows["correo"];
            $direccion = $rows["direccion"];
            ?>
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
                    <th>existencias</th>
                    <th>precio unitario</th>
                    <th>cantidad</th>
                    <th>subtotal</th>
                    <th>#</th>
                </tr>
            </thead>

            <!-- consulta para mostrar la cotización del cliente que se seleccionó -->
            <?php
            $stock = 0;
            $seleccionar = "SELECT DISTINCT 
		    productos.existencias,         
		    producto_cotizacion.clave, producto_cotizacion.codigoProducto,
            producto_cotizacion.cantidad, producto_cotizacion.descripcion,
            producto_cotizacion.factor, producto_cotizacion.contenido,
            producto_cotizacion.precio_unitario, producto_cotizacion.sub_total
            FROM producto_cotizacion
            INNER JOIN productos    
            ON productos.codigoProducto = producto_cotizacion.codigoProducto 
            INNER JOIN cotizacion 
            ON cotizacion.clave = producto_cotizacion.clave 
            AND cotizacion.clave = '$clave' AND cotizacion.auxiliar = '1';
            ";

            $total = 0;
            $cantidadArticulos = 0;
            $sql_cotizacion = $Oxi->query($seleccionar);
            while ($fila = $sql_cotizacion->fetch_array(MYSQLI_ASSOC)) {
                $stock = $fila["existencias"];
                $codigoProducto = $fila["codigoProducto"];
                if ($stock > 0) {
            ?>
                    <tbody>
                        <tr>
                            <td><?php echo $fila["codigoProducto"] ?></td>
                            <td><?php echo $fila["descripcion"] ?></td>
                            <td><?php echo $fila["factor"] ?></td>
                            <td><?php echo $fila["contenido"] ?></td>
                            <td><?php echo $fila["existencias"] ?></td>
                            <td><?php echo $fila["precio_unitario"] ?></td>
                            <input type="hidden" id="precio<?php echo $fila["codigoProducto"]; ?>" value="<?php echo $fila["precio_unitario"]; ?>" name="precio_unitario">
                            <td>
                                <input type="text" name="quantity[]" class="cantidad quantity" id="quantity<?php echo $fila["codigoProducto"]; ?>" value="<?php echo $fila['cantidad']; ?>" data-producto_id="<?php echo $fila["codigoProducto"] ?>" autocomplete="off">
                            </td>
                            <td>
                                <?php echo '$' . number_format($fila["cantidad"] * $fila["precio_unitario"], 2) ?>
                            </td>
                            <td><a class="delete" id="<?php echo $fila["codigoProducto"] ?>">Eliminar</a></td>
                            <?php
                            $total = $total + ($fila["cantidad"] * $fila["precio_unitario"]);
                            $cantidadArticulos = $cantidadArticulos + $fila["cantidad"];
                            ?>
                    <?php
                } else if ($stock == 0) {
                    $eliminacion = "DELETE FROM producto_cotizacion WHERE codigoProducto = '$codigoProducto';";
                    mysqli_query($Oxi, $eliminacion);
                    //echo $eliminacion;
                }
            } // END WHILE
                    ?>
                        </tr>
                    </tbody>
        </table>
    </div>
    <!---------------------------------------BOTON DE REALIZAR VENTA ------------------------------------------->
    <?php
    if ($cantidadArticulos > 0) {
    ?>
        <div class="totalCotizacion">
            <div class="totalFooter">
                <h3>TOTAL $<?php echo number_format($total, 2); ?></h3>
                <!-- <p>Cantidad articulos <?php echo $cantidadArticulos; ?></p> -->
            </div>
            <div class="totalFooter">
                <input type="submit" class="btnVentaCotizacion" name="VentaCotizacion" value="REALIZAR VENTA">
            </div>
        </div>
    <?php
    } else { ?>
        <div class="totalCotizacion">
            <div class="totalFooter">
                <p class="advertencia">Debe agregar articulos a su cotización</p>
            </div>
        </div>
    <?php
    }
    ?>
    <!-- FORMULARIO PARA AGREGAR MÁS PRODUCTOS A LA COTIZACION -->
    <!-- ************************************************************************************************* -->
    <div id="modalCotizacion" class="background-modal">
        <div class="modal-content3 animate">
            <div class="close-button">
                <span onclick="document.getElementById('modalCotizacion').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>
            <div class="container">
                <!-- dentro del modal -->
                <div class="grillaCotizacion3">
                    <div class="form-item-cajas3">
                        <form role="form" id="agregar_articulos_CODIGO" method="POST">
                            <input type="text" name="busquedaCodigo" id="txt_busquedaCodigo" autocomplete="off" required>
                            <label for="codigoProducto">Código del Producto</label>
                            <button type="submit" name="btnCodigo" class="btnBusqueda" id="btnCodigo">Buscar</button>
                        </form>
                    </div>
                    <div class="form-item-cajas3">
                        <form role="form" id="agregar_articulos_DESCRIPCION" method="POST">
                            <input type="text" name="busquedaDescripcion" id="txt_busquedaDescripcion" autocomplete="off" required />
                            <label for="codigoProducto">Descripción del Artículo</label>
                            <button type="submit" name="btnDescripcion" class="btnBusqueda" id="btnDescripcion">Buscar</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Aquí abajo aparece la tabla de acuerdo a la búsqueda que se realizó -->
            <div id="tablaModal">
            </div> <!-- end tablaModal-->
            <span id="infoPrincipal" class="advertencia"></span>
        </div>


        <!-- ******************************************* MENSAJES TOOLTIPS **********************************  -->
        <div class="wrapper">
            <div id="toast" class="success">
                <div class="container-1">
                    <i class="fas fa-check-square"></i>
                </div>
                <div class="container-2">
                    <p>Ok</p>
                    <p>Producto agregado.</p>
                </div>
                <button onclick="closeToast1()">
                    <span><i class="fal fa-window-close"></i></span>
                </button>
            </div>
        </div>
    </div>
    <!-- sirve para que nos muestre el script SQL-->
    <!--<div id="mostrar"></div>-->
    <div id="modalCliente" class="background-modal">
        <div class="modal-content animate" id="formularioCliente">
            <div class="close-button">
                <span onclick="document.getElementById('modalCliente').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>
            <div class="container">
                <div class="grillaCotizacion1">
                    <div class="form-item">
                        <input type="text" id="nombre_cliente" autocomplete="off" required class="cotizacion" name="nombre_cliente" value="<?php echo $nombre_cliente; ?>">
                        <label for="precio">Nombre completo del cliente: </label>
                    </div>
                    <div class="form-item">
                        <input type="text" id="telefono" autocomplete="off" required class="cotizacion" name="telefono" value="<?php echo $telefono; ?>">
                        <label for="total">Teléfono:</label>
                    </div>
                    <div class="form-item">
                        <input type="text" id="correo" autocomplete="off" required class="cotizacion" name="correo" value="<?php echo $correo; ?>">
                        <label for="correo">correo:</label>
                    </div>
                </div>
                <div class="grillaCotizacion2">
                    <div class="form-item">
                        <input type="text" id="direccion" autocomplete="off" required class="cotizacion" name="direccion" value="<?php echo $direccion; ?>">
                        <label for="direccion">dirección:</label>
                    </div>
                    <div class="btnSubAlinear">
                        <input type="submit" name="updateCliente" class="btnSubmitCotizacion" id="updateCliente" value="actualizar datos">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div id="datos"></div>-->
    <div class="wrapper">
        <div id="toast" class="info">
            <div class="container-1">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="container-2">
                <p>:D</p>
                <p>Datos actualizados</p>
            </div>
            <button onclick="closeToastUser()">
                <span><i class="fal fa-window-close"></i></span>
            </button>
        </div>
    </div>
    <script type="text/javascript" src="js/radio.cotizaciones.js"></script>
</body>

</html>