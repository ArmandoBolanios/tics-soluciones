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
                    <td data-label="nombre" class="desc"><?php echo $resCod['descripcion']; ?> </td>
                    <input type="hidden" name="descripcion" id="descripcion<?php echo $resCod['idProducto']; ?>" value="<?php echo $resCod['descripcion']; ?>">
                    <td data-label="factor"><?php echo $resCod['factor'] ?></td>
                    <input type="hidden" name="factor" id="factor<?php echo $resCod['idProducto'] ?>" value="<?php echo $resCod['factor']; ?>">
                    <td data-label="contenido" class="cont"><?php echo $resCod['contenido']; ?></td>
                    <input type="hidden" name="contenido" id="contenido<?php echo $resCod['idProducto'] ?>" value="<?php echo $resCod['contenido']; ?>">
                    <td><?php echo $resCod['existencias']; ?></td>
                    <input type="hidden" name="existencias" id="existencias<?php echo $resCod['idProducto'] ?>" value="<?php echo $resCod['existencias']; ?>">
                    <td data-label="precio" class="_tdPrecio"><?php echo '$' . $resCod['precioUnitario']; ?></td>
                    <input type="hidden" name="precio" id="precio<?php echo $resCod['idProducto'] ?>" value="<?php echo $resCod['precioUnitario']; ?>">
                    <td data-label="cantidad">
                        <input type="text" name="cantidad" class="cantidad quanti" min="1" max="1000" value="1" required id="cantidadProducto<?php echo $resCod['idProducto'] ?>" data-cotz-id-producto="<?php echo $resCod['idProducto']; ?>">
                    </td>
                    <form>
                        <td data-label="#">
                            <a name="add_cotz" class="add_cot" id="<?php echo $resCod['idProducto'] ?>">
                                <i class="fal fa-plus" id="i_element<?php echo $resCod["idProducto"]; ?>" data-i_element="<?php echo $resCod["idProducto"]; ?>"></i>
                            </a>
                        </td>
                    </form>

                </tr> <!-- end content body -->

                <?php
                if ($resCod['existencias'] < 11 && $resCod['existencias'] > 0) {
                    echo '<h1 class="advertencia">Solo quedan <b>' . $resCod['existencias'] . '</b> unidades...';
                }
                ?>
            </tbody>
            <!--end body table -->
        <?php
        }
    } else { //end CodigoProducto
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
                    <td data-label="nombre" class="desc"><?php echo $resB['descripcion']; ?></td>
                    <input type="hidden" name="descripcion" id="descripcion<?php echo $resB["idProducto"] ?>" value="<?php echo $resB['descripcion']; ?>">
                    <td data-label="factor"><?php echo $resB['factor']; ?></td>
                    <input type="hidden" name="factor" id="factor<?php echo $resB['idProducto'] ?>" value="<?php echo $resB['factor']; ?>">
                    <td data-label="contenido" class="cont"><?php echo $resB['contenido']; ?></td>
                    <input type="hidden" name="contenido" id="contenido<?php echo $resB["idProducto"] ?>" value="<?php echo $resB['contenido']; ?>">
                    <td><?php echo $resB['existencias']; ?></td>
                    <input type="hidden" name="existencias" id="existencias<?php echo $resB['idProducto'] ?>" value="<?php echo $resB['existencias']; ?>">
                    <td data-label="precio" class="_tdPrecio"><?php echo '$' . $resB['precioUnitario']; ?></td>
                    <input type="hidden" name="precio" id="precio<?php echo $resB["idProducto"] ?>" value="<?php echo $resB['precioUnitario']; ?>">
                    <!-- ------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                    <td data-label="cantidad" class="_tdCantidad">
                        <input type="text" name="cantidad" class="cantidad quanti" min="1" max="1000" value="1" required id="cantidadProducto<?php echo $resB["idProducto"]; ?>" data-cotz-id-producto="<?php echo $resB["idProducto"]; ?>" />
                    </td>
                    <form>
                        <td data-label="#">
                            <a name="add_cotz" class="add_cot" id="<?php echo $resB['idProducto'] ?>">
                                <i class="fal fa-plus" id="i_element<?php echo $resB["idProducto"]; ?>" data-i_element="<?php echo $resB["idProducto"]; ?>"></i>
                            </a>
                        </td>
                    </form>

                    <!-- ------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                </tr>
            </tbody>
<?php

        }
    } else {
        echo '<h2 class="advertencia">EL PRODUCTO NO EXISTE</h2>';
    }
} //end busquedaProducto