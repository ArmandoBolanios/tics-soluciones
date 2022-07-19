<?php
session_start();

if (isset($_POST["producto_id"])) {
    $tabla = '';

    if ($_POST["action"] == "add") {
        if (isset($_SESSION["shopping_cart"])) {
            $is_available = 0;
            $almacen = $_POST["existencias_producto"];
            $cantidadCot = $_POST["cantidad_producto"];
            $clickpress = 0;

            foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                if ($_SESSION["shopping_cart"][$keys]['producto_id'] == $_POST["producto_id"]) {
                    $is_available++;
                    $_SESSION["shopping_cart"][$keys]['cantidad_producto'] =
                        $_SESSION["shopping_cart"][$keys]['cantidad_producto'] + $_POST["cantidad_producto"];
                    $clickpress = $_SESSION["shopping_cart"][$keys]['cantidad_producto'];
                }

                if ($almacen < $clickpress) {
                    if ($_SESSION["shopping_cart"][$keys]['producto_id'] == $_POST["producto_id"]) {
                        $_SESSION["shopping_cart"][$keys]['cantidad_producto'] = 1;
                    }
                }
            }
            if ($is_available < 1) {
                $item_array = array(
                    'producto_id' => $_POST["producto_id"],
                    'codigo_producto' => $_POST["codigo_producto"],
                    'descripcion_producto' => $_POST["descripcion_producto"],
                    'existencias_producto' => $_POST["existencias_producto"],
                    'precio_unitario' => $_POST["precio_unitario"],
                    'precio_compra' => $_POST["precio_compra"],
                    'comentarios' => $_POST["comentarios"],
                    'cantidad_producto' => $_POST["cantidad_producto"]

                );
                $_SESSION["shopping_cart"][] = $item_array;
            }
        } else {
            $item_array = array(
                'producto_id' => $_POST["producto_id"],
                'codigo_producto' => $_POST["codigo_producto"],
                'descripcion_producto' => $_POST["descripcion_producto"],
                'existencias_producto' => $_POST["existencias_producto"],
                'precio_unitario' => $_POST["precio_unitario"],
                'precio_compra' => $_POST["precio_compra"],
                'comentarios' => $_POST["comentarios"],
                'cantidad_producto' => $_POST["cantidad_producto"]
            );

            $_SESSION["shopping_cart"][] = $item_array;
        }
    } /// End POST action

    // --------------------------------------------------------------------------
    if ($_POST["action"] == "remove") {
        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
            if ($values["producto_id"] == $_POST["producto_id"]) {
                unset($_SESSION["shopping_cart"][$keys]);
            }
        }
    } // end POST REMOVE

    // --------------------------------------------------------------------------
    if ($_POST["action"] == "cambiar_cantidad") {
        $qt = intval($_POST["quantity"]);
        $bd_lm = $_POST["existencias_producto"];        

        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
            if ($_SESSION["shopping_cart"][$keys]['producto_id'] == $_POST["producto_id"]) {
                $_SESSION["shopping_cart"][$keys]['cantidad_producto'] = $_POST["quantity"];
            }

            if ($bd_lm < $qt) {
                if ($_SESSION["shopping_cart"][$keys]['producto_id'] == $_POST["producto_id"]) {
                    $_SESSION["shopping_cart"][$keys]['cantidad_producto'] = 1;
                }
            }

            if ($qt <= 0) {
                if ($_SESSION["shopping_cart"][$keys]['producto_id'] == $_POST["producto_id"]) {
                    $_SESSION["shopping_cart"][$keys]['cantidad_producto'] = 1;
                }
            }
        }
    }

    $tabla .= '        
            <table  class="table2">
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
                <tbody>';

    if (!empty($_SESSION["shopping_cart"])) {
        $total = 0;
        $cantidadArticulos = 0;

        foreach ($_SESSION["shopping_cart"] as $keys => $values) {

            $tabla .= '
                    <tr>
                        <input type="hidden" name="id_producto" id="id' . $values["producto_id"] . '" value="' . $values["producto_id"] . '">    
                        <td>' . $values["codigo_producto"] . '</td>                        
                        <input type="hidden" name="codigoProducto" id="codigo' . $values['producto_id'] . '" value="' . $values['codigo_producto'] . '">                        
                        <td>' . $values["descripcion_producto"] . '</td>
                        <input type="hidden" name="descripcion" id="descripcion' . $values["producto_id"] . '" value="' . $values['descripcion_producto'] . '">                        
                        <input type="hidden" name="existencias" id="existencias' . $values['producto_id'] . '" value="' . $values['existencias_producto'] . '">
                        <td>$' . $values["precio_unitario"] . '</td>
                        <input type="hidden" name="precio" id="precio' . $values["producto_id"] . '" value="' . $values['precio_unitario'] . '">
                        <input type="hidden" name="precioCompra" id="precioCompra' . $values["producto_id"] . '" value="' . $values['precio_compra'] . '">
                        <td data-label="observaciones">
                            <input type="hidden" name="comentarios[]" value="' . $values["comentarios"] . '"  id="comentarios'. $values['producto_id'].' 
                            data-comentarios_id="'. $values["producto_id"] .'" autocomplete="off" />
                            '.$values["comentarios"].'
                        </td>
                    ';
            // ------------------ editar cantidad del producto -----------------------------------------------------------------
            $tabla .= '
                    <td class="_tdCantidad">
                        <input type="text" name="quantity[]" id="quantity' . $values["producto_id"] . '"  value="' . $values["cantidad_producto"] . '" 
                        class="cantidad quantity" data-producto_id="' . $values["producto_id"] . '"/>
                    </td>
                    <td>$' . number_format($values['cantidad_producto'] * $values["precio_unitario"], 2) . '</td>                        
                    <td>
                        <a name="delete" class="delProduct delete" id="' . $values["producto_id"] . '">
                            <i class="fal fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>';
            // -------------------------------------------------------------------------------------
            $total = $total + ($values['cantidad_producto'] * $values["precio_unitario"]);
            $cantidadArticulos = count($_SESSION["shopping_cart"]);
        }

        $tabla .= '
                </tbody>
                <tfoot>
                    <tr>                        
                        <td colspan = "5" class="pagar"><label>TOTAL $' . number_format($total, 2) . '</label></td>
                        <td colspan = "7" class="btnPagar">
                            <form method="POST" action="registro_venta.php">
                                <input type="submit" name="registrar_venta" class="btnSubmit" value="registrar venta">
                            </form>
                        </td>
                    </tr>                          
                </tfoot>
            </table>';
    }


    $output = array(
        'tabla' => $tabla
    );

    echo json_encode($output);
}

