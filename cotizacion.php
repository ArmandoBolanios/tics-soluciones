<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizacion</title>
    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="stylesheet" href="estilos/all.css">
    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
</head>

<body>
    <ul class="breadcrumb">
        <li><a href="index.php">Inicio</a></li>
        <li>Cotizaciones</li>
    </ul>

    <form>
        <fieldset class="none">
            <legend>Elige una opción:</legend>
            <label>
                <input type="radio" name="propietario" id="cotizacion" value="Cotizacion" required checked> Cotizacion
            </label>
            <label>
                <input type="radio" name="propietario" id="pendientes" value="Pendientes" required> En espera
            </label>
            <label>
                <input type="radio" name="propietario" id="finalizadas" value="Finalizadas"> Finalizados
            </label>
        </fieldset>
    </form>

    <div class="table-container">
        <table class="tableCotizacion">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>descripción</th>
                    <th>factor</th>
                    <th>contenido</th>
                    <th>existencias</th>
                    <th>p. unitario</th>
                    <th>cantidad</th>
                    <th>#</th>
                </tr>
            </thead>

            <?php require 'busqueda_cotizacion.php'; ?>
            <span id="infoPrincipal" class="advertencia"></span>
        </table>
    </div>
    <!-- ******************************************* FORMULARIO DE BÚSQUEDA  ****************************  -->
    <div class="ventas">
        <div class="form-item-cajas">
            <form name="frmVentas" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type=" text" name="busquedaCodigo" autocomplete="off" required>
                <label for="codigoProducto">Código del Producto</label>
                <button type="submit" name="btnCodigo" class="btnBusqueda">buscar</button>
            </form>
        </div>
        <div class="form-item-cajas">
            <form name="frmVentas" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input autofocus type=" text" name="busquedaDescripcion" autocomplete="off" required />
                <label for="codigoProducto">Descripción del Artículo</label>
                <button type="submit" name="btnDescripcion" class="btnBusqueda">Buscar</button>
            </form>
        </div>
    </div>
    <!-- *******************************************************************************************************
    SEGUNDA TABLA ES PARA MANTENER LOS CAMBIOS, ARTICULOS AGREGADOS PARA LA VENTA, SU FUNCION ES VISUAL 
    ************************************************************************************************************  
    -->
    <div id="tabla">
        <?php
        if (!empty($_SESSION["sess_cotizacion"])) {
            $total = 0;
            $cantidadArticulos = 0;
        ?>
            <table class="tableCotizacion2">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>descripción</th>
                        <th>factor</th>
                        <th>contenido</th>
                        <th>p. unitario</th>
                        <th>cantidad</th>
                        <th>subtotal</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($_SESSION["sess_cotizacion"] as $keys => $values) {
                    ?>
                        <tr>
                            <td><?php echo $values['codigo_producto']; ?></td>
                            <input type="hidden" name="codigoProducto" id="codigo<?php echo $values['producto_id'] ?>" value="<?php echo $values['codigo_producto'] ?>">
                            <input type="hidden" name="id_producto" id="id'<?php echo $values['producto_id'] ?>" value="<?php echo $values['producto_id']; ?>">
                            <td><?php echo $values['descripcion_producto']; ?></td>
                            <input type="hidden" name="descripcion" id="descripcion<?php echo $values['producto_id'] ?>" value="<?php echo $values['descripcion_producto']; ?>">
                            <td><?php echo $values['factor_producto']; ?></td>
                            <input type="hidden" name="factor" id="factor<?php echo $values['producto_id'] ?>" value="<?php echo $values['factor_producto']; ?>">
                            <td><?php echo $values['contenido_producto']; ?></td>
                            <input type="hidden" name="contenido" id="contenido<?php echo $values['producto_id'] ?>" value="<?php echo $values['contenido_producto']; ?>">
                            <input type="hidden" name="existencias" id="existencias<?php echo $values['producto_id'] ?>" value="<?php echo $values['existencias_producto']; ?>">
                            <td><?php echo '$' . $values['precio_unitario']; ?></td>
                            <input type="hidden" name="precio" id="precio<?php echo $values['producto_id'] ?>" value="<?php echo $values['precio_unitario']; ?>">
                            <!-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                            <td class="_tdCantidad">
                                <input type="text" name="quantity[]" class="cantidad quantity" required id="quantity<?php echo $values["producto_id"]; ?>" value="<?php echo $values['cantidad_producto'] ?>" data-producto_id="<?php echo $values["producto_id"]; ?>" autocomplete="off">
                            </td>
                            <td><?php echo '$ ' . number_format($values["cantidad_producto"] * $values["precio_unitario"], 2) ?></td>
                            <td>
                                <a name="delete" class="delete" id="<?php echo $values["producto_id"] ?>">
                                    <i class="fal fa-trash-alt"></i>
                                </a>
                            </td>
                            <!-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                        </tr>
                    <?php
                        $total = $total + ($values['cantidad_producto'] * $values["precio_unitario"]);
                        $cantidadArticulos = count($_SESSION["sess_cotizacion"]);
                    } // END FOREACH
                    ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="4" class="pagar"><label>TOTAL $ <?php echo number_format($total, 2) ?></label></td>
                        <td colspan="5" class="btnPagar">
                            <input type="button" value="continuar" class="cliente btnSubmit" />
                        </td>
                    </tr>
                </tfoot>
            </table>

        <?php
        } // END EMPTY
        ?>
    </div>
    <div id="mensaje"></div>
    <!-- ************************************************************************************************* -->
    <div id="modform" class="background-modal">
        <form class="modal-content animate" id="formularioCotizacion" enctype="multipart/form-data" role="form">
            <div class="close-button">
                <span onclick="document.getElementById('modform').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>
            <div class="container">
                <div class="grillaCotizacion1">
                    <div class="form-item">
                        <input type="text" id="nombre_cliente" autocomplete="off" required class="cotizacion" name="nombre_cliente">
                        <label for="precio">Nombre completo del cliente: </label>
                    </div>
                    <div class="form-item">
                        <input type="text" id="telefono" autocomplete="off" required class="cotizacion" name="telefono">
                        <label for="total">Teléfono:</label>
                    </div>
                    <div class="form-item">
                        <input type="text" id="correo" autocomplete="off" required class="cotizacion" name="correo">
                        <label for="correo">correo:</label>
                    </div>
                </div>
                <div class="grillaCotizacion2">
                    <div class="form-item">
                        <input type="text" id="direccion" autocomplete="off" required class="cotizacion" name="direccion">
                        <label for="direccion">dirección:</label>
                    </div>
                    <div class="btnSubAlinear">                        
                        <input type="submit" name="submitCotizacion" class="btnSubmitCotizacion" value="REGISTRAR COTIZACION">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- ==============================  TABLA DE COTIZACIONES  PENDIENTES ===================================================== -->
    <div id="tablaPendientes"></div>
    <div id="tablaFinalizadas"></div>
    <!-- ======================================================================================================================= -->
    <script src="js/radio.cotizaciones.js"></script>
    <script type="text/javascript" src="js/ajax_cotizacion.js"></script>
</body>

</html>