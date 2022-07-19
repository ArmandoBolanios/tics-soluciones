<?php
session_start();

if (isset($_POST["producto_id"])) {
    $tabla = '';

    if ($_POST["action"] == "add") {
        if (isset($_SESSION["sess_cotizacion"])) {
            $is_available = 0;
            $almacen = $_POST["existencias_producto"];
            $cantidadCot = $_POST["cantidad_producto"];
            $clickpress = 0;                        

            foreach ($_SESSION["sess_cotizacion"] as $keys => $values) {
                if ($_SESSION["sess_cotizacion"][$keys]['producto_id'] == $_POST["producto_id"]) {
                    $is_available++;
                    $_SESSION["sess_cotizacion"][$keys]['cantidad_producto'] =
                        $_SESSION["sess_cotizacion"][$keys]['cantidad_producto'] + $_POST["cantidad_producto"];
                    $clickpress = $_SESSION["sess_cotizacion"][$keys]['cantidad_producto'];
                }

                if ($almacen < $clickpress) {
                    if ($_SESSION["sess_cotizacion"][$keys]['producto_id'] == $_POST["producto_id"]) {
                        $_SESSION["sess_cotizacion"][$keys]['cantidad_producto'] = 1;
                    }
                }                
            }

            if ($is_available < 1) {
                $item_array = array(
                    'producto_id' => $_POST["producto_id"],
                    'codigo_producto' => $_POST["codigo_producto"],
                    'descripcion_producto' => $_POST["descripcion_producto"],
                    'factor_producto' => $_POST["factor_producto"],
                    'contenido_producto' => $_POST["contenido_producto"],
                    'existencias_producto' => $_POST["existencias_producto"],
                    'precio_unitario' => $_POST["precio_unitario"],
                    'cantidad_producto' => $_POST["cantidad_producto"]
                );
                $_SESSION["sess_cotizacion"][] = $item_array;
            }
        } else {
            $item_array = array(
                'producto_id' => $_POST["producto_id"],
                'codigo_producto' => $_POST["codigo_producto"],
                'descripcion_producto' => $_POST["descripcion_producto"],
                'factor_producto' => $_POST["factor_producto"],
                'contenido_producto' => $_POST["contenido_producto"],
                'existencias_producto' => $_POST["existencias_producto"],
                'precio_unitario' => $_POST["precio_unitario"],
                'cantidad_producto' => $_POST["cantidad_producto"]
            );

            $_SESSION["sess_cotizacion"][] = $item_array;
        }
    } /// End POST action


    if ($_POST["action"] == "cambiar_cantidad") {
        $qt = intval($_POST["quantity"]);
        $bd_lm = $_POST["existencias_producto"];        

        foreach ($_SESSION["sess_cotizacion"] as $keys => $values) {
            if ($_SESSION["sess_cotizacion"][$keys]['producto_id'] == $_POST["producto_id"]) {
                $_SESSION["sess_cotizacion"][$keys]['cantidad_producto'] = $_POST["quantity"];
            }

            if ($bd_lm < $qt) {
                if ($_SESSION["sess_cotizacion"][$keys]['producto_id'] == $_POST["producto_id"]) {
                    $_SESSION["sess_cotizacion"][$keys]['cantidad_producto'] = 1;
                }
            }

            if ($qt <= 0) {
                if ($_SESSION["sess_cotizacion"][$keys]['producto_id'] == $_POST["producto_id"]) {
                    $_SESSION["sess_cotizacion"][$keys]['cantidad_producto'] = 1;
                }
            }
        }
    }

    if ($_POST["action"] == "remove") {
        foreach ($_SESSION["sess_cotizacion"] as $keys => $values) {
            if ($values["producto_id"] == $_POST["producto_id"]) {
                unset($_SESSION["sess_cotizacion"][$keys]);
            }
        }
    }

    $tabla .= '        
            <table  class="tableCotizacion2">
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
                <tbody>';

    if (!empty($_SESSION["sess_cotizacion"])) {
        $total = 0;
        $cantidadArticulos = 0;

        foreach ($_SESSION["sess_cotizacion"] as $keys => $values) {

            $tabla .= '
                    <tr>
                        <td>' . $values["codigo_producto"] . '</td>
                        <input type="hidden" name="codigoProducto" id="codigo' . $values['producto_id'] . '" value="' . $values['codigo_producto'] . '">
                        <input type="hidden" name="id_producto" id="id' . $values["producto_id"] . '" value="' . $values["producto_id"] . '">
                        <td>' . $values["descripcion_producto"] . '</td>
                        <input type="hidden" name="descripcion" id="descripcion' . $values["producto_id"] . '" value="' . $values['descripcion_producto'] . '">
                        <td>' . $values["factor_producto"] . '</td>
                        <input type="hidden" name="factor" id="factor' . $values['producto_id'] . '" value="' . $values['factor_producto'] . '">
                        <td>' . $values["contenido_producto"] . '</td>
                        <input type="hidden" name="contenido" id="contenido' . $values["producto_id"] . '" value="' . $values['contenido_producto'] . '">
                        <input type="hidden" name="existencias" id="existencias' . $values['producto_id'] . '" value="' . $values['existencias_producto'] . '">
                        <td>$' . $values["precio_unitario"] . '</td>
                        <input type="hidden" name="precio" id="precio' . $values["producto_id"] . '" value="' . $values['precio_unitario'] . '">
                        ';
            /** ------------------------------------------------------------------------------------------------------------------------------------ */
            $tabla .= '
                        <td class="_tdCantidad">
                            <input type="text" name="quantity[]" id="quantity' . $values["producto_id"] . '"  value="' . $values["cantidad_producto"] . '" class="cantidad quantity"
						        data-producto_id="' . $values["producto_id"] . '"/>                            
                        </td>
                        <td>$' . number_format($values['cantidad_producto'] * $values["precio_unitario"], 2) . '</td>                        
                        <td>
                            <a name="delete" class="delProduct delete" id="' . $values["producto_id"] . '">
                                <i class="fal fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>';
            /** ------------------------------------------------------------------------------------------------------------------------------------------- */
            $total = $total + ($values['cantidad_producto'] * $values["precio_unitario"]);
            $cantidadArticulos = count($_SESSION["sess_cotizacion"]);
        }


        $tabla .= '
                </tbody>
                <tfoot>
                <tr>                        
                    <td colspan="4" class="pagar"><label>TOTAL $ '. number_format($total, 2) .'</label></td>
                    <td colspan="5" class="btnPagar">
                        <input type="button" value="continuar" class="cliente btnSubmit" />
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
