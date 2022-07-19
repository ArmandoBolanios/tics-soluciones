<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>VENTA DE MERCANCIAS</title>
    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="stylesheet" href="estilos/all.css">
    <link rel="stylesheet" href="estilos/modal.css">
    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
</head>

<body>
    <ul class="breadcrumb">
        <li><a href="index.php">Inicio</a></li>
        <li>Venta de artículos</li>
    </ul>

    <div class="table-container">
        <table class="table1">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>imagen</th>
                    <th>descripcion</th>
                    <th>existencias</th>
                    <th>precio</th>
                    <th>observaciones</th>
                    <th>cantidad</th>
                    <th>#</th>
                </tr>
            </thead>
            <span id="infoPrincipal" class="advertencia"></span>
            <?php
            require 'cn/cnt.php';
            if (isset($_POST['btnCodigo'])) {
                $busquedaCodigo = $_REQUEST['busquedaCodigo'];
                $consultarDatos = "SELECT * FROM productos WHERE codigoProducto='$busquedaCodigo' AND auxiliar=1";

                $dat = $Oxi->query($consultarDatos);
                $resCod = $dat->fetch_array(MYSQLI_ASSOC);
                if (mysqli_num_rows($dat) > 0) {
                    if (($resCod['codigoProducto'])) {
            ?>
                        <tbody>
                            <tr>
                                <td data-label="Código"><?php echo $resCod['codigoProducto']; ?></td>
                                <input type="hidden" name="codigoProducto" id="codigo<?php echo $resCod['idProducto'] ?>" value="<?php echo $resCod['codigoProducto']; ?>">
                                <td data-label="imagen">
                                    <img src="<?php echo $resCod['imagen']; ?>" alt="imagen" width="90" height="90" class="imagen2" data-imagen2-id-producto="<?php echo $resCod["idProducto"]; ?>" />
                                </td>
                                <td data-label="descripcion"><?php echo $resCod['descripcion']; ?> </td>
                                <input type="hidden" name="descripcion" id="descripcion<?php echo $resCod['idProducto']; ?>" value="<?php echo $resCod['descripcion']; ?>">
                                <input type="hidden" name="contenido" id="contenido<?php echo $resCod['idProducto'] ?>" value="<?php echo $resCod['contenido']; ?>">
                                <?php
                                if ($resCod['existencias'] <= 10) {
                                    echo '<td data-label = "stock" class="_tdPocoStock">' . $resCod['existencias'] . '</td>';
                                } else {
                                    echo '<td data-label = "stock">' . $resCod['existencias'] . '</td>';
                                }
                                ?>
                                <input type="hidden" name="existencias" id="existencias<?php echo $resCod['idProducto']; ?>" value="<?php echo $resCod['existencias']; ?>">
                                <td data-label="precio" class="_tdPrecio"><?php echo '$' . $resCod['precioUnitario']; ?></td>
                                <input type="hidden" name="precio" id="precio<?php echo $resCod['idProducto']; ?>" value="<?php echo $resCod['precioUnitario']; ?>">
                                <input type="hidden" name="precioCompra" id="precioCompra<?php echo $resCod['idProducto']; ?>" value="<?php echo $resCod['precioDeCompra']; ?>">
                                <td data-label="observaciones">
                                    <input type="text" name="comentarios" class="comentarios" id="comentarios<?php echo $resCod["idProducto"]; ?>" data-comentarios_id="<?php echo $resCod["idProducto"]; ?>" autocomplete="off" />
                                </td>
                                <?php
                                if ($resCod['existencias'] <= 0) {
                                    echo '<td data-label = "cantidad"><label class="advertencia">' . $resCod['existencias'] . '</label></td>';
									echo '<td data-label = "#"><i class="fal fa-ban"></i></td>';
                                } else { ?>
                                    <td data-label="cantidad" class="_tdCantidad">
                                        <input type="text" name="cantidad" class="cantidad quanti" value="1" required id="cantidad<?php echo $resCod['idProducto'] ?>" data-id_producto="<?php echo $resCod['idProducto']; ?>">
                                    </td>                                    
                                    <td data-label="#">
                                            <a name="add_to_cart" class="add_to_cart" id="<?php echo $resCod['idProducto'] ?>">
                                                <i class="fal fa-plus" id="i_element<?php echo $resCod["idProducto"]; ?>" data-i_element="<?php echo $resCod["idProducto"]; ?>"></i>
                                            </a>
                                    </td>                                    
                                <?php
                                }
                                ?>
                            </tr>

                            <?php
                            if ($resCod['existencias'] < 11 && $resCod['existencias'] > 0) {
                                echo '<h1 class="advertencia">Solo quedan <b>' . $resCod['existencias'] . '</b> unidades...';
                            }
                            ?>
                        </tbody>
                    <?php
                    }
                } else {
                    echo '<h2 class="advertencia">ARTICULO NO ENCONTRADO</h2>';
                }
            } // end busquedaCodigo
            else if (isset($_POST['btnDescripcion'])) {
                $busquedaDescripcion = $_REQUEST['busquedaDescripcion'];

                $like = "";
                $e = explode(" ", $busquedaDescripcion);

                for ($i = 0; $i < count($e); $i++) {
                    $like .= " AND descripcion LIKE '%" . $e[$i] . "%'";
                }

                $buscar  = " SELECT * FROM  productos WHERE auxiliar = 1 $like";
                $datos = $Oxi->query($buscar);

                if (mysqli_num_rows($datos) > 0) {
                    while ($resB = $datos->fetch_array(MYSQLI_ASSOC)) {
                    ?>
                        <tbody>
                            <tr>
                                <td data-label="Código"><?php echo $resB['codigoProducto']; ?></td>
                                <input type="hidden" name="codigoProducto" id="codigo<?php echo $resB['idProducto'] ?>" value="<?php echo $resB['codigoProducto']; ?>">
                                <td data-label="imagen">
                                    <img src="<?php echo $resB['imagen']; ?>" alt="imagen" width="90" height="90" class="imagen" data-imagen-id-producto="<?php echo $resB["idProducto"]; ?>" />
                                </td>
                                <td data-label="nombre"><?php echo $resB['descripcion']; ?></td>
                                <input type="hidden" name="descripcion" id="descripcion<?php echo $resB["idProducto"] ?>" value="<?php echo $resB['descripcion']; ?>">
                                <input type="hidden" name="contenido" id="contenido<?php echo $resB["idProducto"] ?>" value="<?php echo $resB['contenido']; ?>">
                                <?php
                                if ($resB['existencias'] <= 10) {
                                    echo '<td data-label = "stock" class="_tdPocoStock">' . $resB['existencias'] . '</td>';
                                } else {
                                    echo '<td data-label = "stock">' . $resB['existencias'] . '</td>';
                                }
                                ?>
                                <input type="hidden" name="existencias" id="existencias<?php echo $resB['idProducto'] ?>" value="<?php echo $resB['existencias']; ?>">
                                <td data-label="precio" class="_tdPrecio"><?php echo '$' . $resB['precioUnitario']; ?></td>
                                <input type="hidden" name="precio" id="precio<?php echo $resB["idProducto"] ?>" value="<?php echo $resB['precioUnitario']; ?>">
                                <input type="hidden" name="precioCompra" id="precioCompra<?php echo $resB['idProducto']; ?>" value="<?php echo $resB['precioDeCompra']; ?>">
                                <td data-label="observaciones">
                                    <input type="text" name="comentarios" class="comentarios" id="comentarios<?php echo $resB["idProducto"]; ?>" data-comentarios_id="<?php echo $resB["idProducto"]; ?>" autocomplete="off" />
                                </td>
                                <!-- ------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                                <?php
								$stock = $resB["existencias"];
                                if ($stock <= 0) {
                                    echo '<td data-label = "cantidad"><label class="advertencia">' . $resB['existencias'] . '</label></td>';
                                    echo '<td data-label = "#"><i class="fal fa-ban"></i></td>';
                                } else { ?>
                                    <td data-label="cantidad" class="_tdCantidad">
                                        <input type="text" name="cantidad" class="cantidad quanti" value="1" required id="cantidad<?php echo $resB["idProducto"]; ?>" data-id_producto="<?php echo $resB["idProducto"]; ?>" autocomplete="off" />
                                    </td>                                    
                                    <td data-label="#">
                                            <a name="add_to_cart" class="add_to_cart" id="<?php echo $resB['idProducto'] ?>">
                                                <i class="fal fa-plus" id="i_element<?php echo $resB["idProducto"]; ?>" data-i_element="<?php echo $resB["idProducto"]; ?>"></i>
                                            </a>
                                    </td>                                    
                                <?php
                                }
                                ?>                                
                                <!-- ------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                            </tr>
                        </tbody>
            <?php

                    }
                } else {
                    echo '<h2 class="advertencia">EL PRODUCTO NO EXISTE</h2>';
                }
            } //end busquedaProducto
            ?>
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

    <!-- ------------------------------------------------------------------------------------------------------------------
        ESTA TABLA SE MUESTRA SI SALIMOS DEL MENU DE VENTAS, ES PARA MANTENER LOS CAMBIOS, ARTICULOS AGREGADOS PARA LA VENTA, 
        SU FUNCION ES VISUAL 
        ------------------------------------------------------------------------------------------------------------------
    -->
    <div id="shopping">
        <?php
        if (!empty($_SESSION["shopping_cart"])) {
            $total = 0;
            $cantidadArticulos = 0;
        ?>
            <table class="table2">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>descripcion</th>
                        <th>precio</th>
                        <th>observaciones</th>
                        <th>cantidad</th>
                        <th>subtotal</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                    ?>
                        <tr>
                            <td><?php echo $values['codigo_producto']; ?></td>
                            <input type="hidden" name="codigoProducto" id="codigo<?php echo $values['producto_id'] ?>" value="<?php echo $values['codigo_producto'] ?>">
                            <input type="hidden" name="id_producto" id="id'<?php echo $values['producto_id'] ?>" value="<?php echo $values['producto_id']; ?>">
                            <td><?php echo $values['descripcion_producto']; ?></td>
                            <input type="hidden" name="descripcion" id="descripcion<?php echo $values['producto_id'] ?>" value="<?php echo $values['descripcion_producto']; ?>">
                            <input type="hidden" name="existencias" id="existencias<?php echo $values['producto_id'] ?>" value="<?php echo $values['existencias_producto']; ?>">
                            <td><?php echo '$' . $values['precio_unitario']; ?></td>
                            <input type="hidden" name="precio" id="precio<?php echo $values['producto_id'] ?>" value="<?php echo $values['precio_unitario']; ?>">
                            <input type="hidden" name="precioCompra" id="precioCompra<?php echo $values["producto_id"] ?>" value="<?php echo $values['precio_compra'] ?>">
                            <td data-label="observaciones">
                                <input type="hidden" name="comentarios[]" id="comentarios<?php echo $values['producto_id']; ?>" value="<?php echo $values['comentarios'] ?>" data-comentarios_id="<?php echo $values["producto_id"]; ?>" autocomplete=" off" />
                                <?php echo $values['comentarios']; ?>
                            </td>
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
                        $cantidadArticulos = count($_SESSION["shopping_cart"]);
                    } // END FOREACH
                    ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="5" class="pagar"><label>TOTAL $<?php echo number_format($total, 2) ?></label></td>
                        <td colspan="7" class="btnPagar">
                            <form method="POST" action="registro_venta.php">
                                <input type="submit" name="registrar_venta" class="btnSubmit" value="registrar venta">
                            </form>
                        </td>
                    </tr>
                </tfoot>
            </table>

        <?php
        } // END EMPTY
        ?>
    </div>

    <!-- ******************************************* MENSAJES TOOLTIPS **********************************  -->
    <div class="wrapper notificacion">
        <div id="toast" class="success">
            <div class="container-1">
                <i class="fas fa-check-square"></i>
            </div>
            <div class="container-2">
                <p>:D</p>
                <p>¡Producto agregado con éxito!</p>
            </div>
            <button onclick="closeToast1()">
                <span><i class="fal fa-window-close"></i></span>
            </button>
        </div>
        <div id="toast" class="info">
            <div class="container-1">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="container-2">
                <p>:(</p>
                <p>Producto eliminado.</p>
            </div>
            <button onclick="closeToast2()">
                <span><i class="fal fa-window-close"></i></span>
            </button>
        </div>
    </div>    
    <!-- ********************* SE ENCARGA DE ACTUALIZAR LA CANTIDAD DE LOS PRODUCTOS *****************  -->
    <script type="text/javascript" src="js/modal.js"></script>
    <script type="text/javascript" src="js/ajax_productos.js"></script>
</body>

</html>