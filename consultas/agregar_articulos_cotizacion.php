<?php
require('../cn/cnt.php');
if (isset($_POST["busqueda_codigo"]) && !empty($_POST)) {
    $codigo = $_REQUEST['busqueda_codigo'];
    $tabla = '';

    /* --------------------------------------------------- */
    $consulta = "SELECT * FROM productos WHERE codigoProducto = '$codigo' AND auxiliar = 1";
    $dat = $Oxi->query($consulta);
    $resultCod = $dat->fetch_array(MYSQLI_ASSOC);
    /* --------------------------------------------------- */
    $tabla .= '
    <table class = "table2">
        <thead>
            <tr>
                <th>codigo</th>
                <th>Descripcion</th>
                <th>factor</th>
                <th>contenido</th>
                <th>existencias</th>
                <th>p. unitario</th>
                <th>cantidad</th>                
                <th>#</th>
            </tr>
        </thead>        
    ';
    /* ---------------------------------------------------- */
    /*  7501428727201 
        7872571441130
        7872571441512
        6942937503215
        6942937503214
        6942937521736
        7501608553002
        CRDNMTL068
    */
    if (mysqli_num_rows($dat) > 0) {
        if ($resultCod['codigoProducto']) {
            $stock = $resultCod["existencias"];
            $tabla .= '
        <tbody>
            <tr>
                <td>' . $resultCod["codigoProducto"] . '</td>
                <input type="hidden" id="codigo' . $resultCod["idProducto"] . '" value="' . $resultCod["codigoProducto"] . '"/>                
                <td>' . $resultCod["descripcion"] . '</td>
                <input type="hidden" id="descripcion' . $resultCod["idProducto"] . '" value="' . $resultCod["descripcion"] . '"/>
                <td>' . $resultCod["factor"] . '</td>
                <input type="hidden" id="factor' . $resultCod["idProducto"] . '" value="' . $resultCod["factor"] . '"/>
                <td>' . $resultCod["contenido"] . '</td>
                <input type="hidden" id="contenido' . $resultCod["idProducto"] . '" value="' . $resultCod["contenido"] . '"/>
            ';
            if ($stock <= 10) {
                $tabla .= '<td class="_tdPocoStock">' . $resultCod["existencias"] . '</td>';
            } else {
                $tabla .= '<td>' . $resultCod["existencias"] . '</td>';
            }

            $tabla .= '                
                <input type="hidden" id="existencias' . $resultCod["idProducto"] . '" value="' .  $resultCod["existencias"] . '"/>                
                <td>$ ' . $resultCod["precioUnitario"] . '</td>
                <input type="hidden" id="precio' . $resultCod["idProducto"] . '" value="' . $resultCod["precioUnitario"] . '" />
            ';
            if ($stock <= 0) {
                $tabla .= '
                <td><label class="advertencia">' . $resultCod["existencias"] . '</label></td>
                <td data-label = "#"><i class="fal fa-ban"></i></td>';
            } else {
                $tabla .= '                
                <td class="_tdCantidad">
                <input type="text" class="cantidad quanti" value="1" required id="cantidadProducto' . $resultCod["idProducto"] . '" 
                    data-add-cotz-id-producto="' . $resultCod["idProducto"] . '" />
                </td>                                    
                <td>
                    <a class="add_product_cotizacion" id="' . $resultCod["idProducto"] . '">
                        <i class="fal fa-plus" id="i_element' . $resultCod["idProducto"] . '" data-i_element="' . $resultCod["idProducto"] . '"></i>
                    </a>
                </td>
            ';
            }
            $tabla .= '       
            </tr>
        </tbody>    
        ';
            if ($resultCod["existencias"] < 11) {
                $tabla .= '<h1 class="advertencia">Solo quedan ' . $resultCod["existencias"] . ' unidades.';
            }
        }
    } // end mysqli_num_rows
    else {
        $tabla .= '<h2 class="advertencia">Articulo no encontrado</h2>';
    }
    $output =  array('tablaModal' => $tabla);
    echo json_encode($output);
} // end BUSQUEDA CODIGO

else if (isset($_POST["busqueda_descripcion"]) && !empty($_POST)) {
    $descripcion = $_REQUEST['busqueda_descripcion'];
    $tabla = '';

    $like = "";
    $e = explode(" ", $descripcion);

    for ($i = 0; $i < count($e); $i++) {
        $like .= " AND descripcion LIKE '%" . $e[$i] . "%'";
    }

    $buscar  = " SELECT * FROM  productos WHERE auxiliar = 1 $like";
    $datos = $Oxi->query($buscar);
    /* --------------------------------------------------- */
    $tabla .= '
    <table class = "table2">
        <thead>
            <tr>
                <th>codigo</th>
                <th>Descripcion</th>
                <th>factor</th>
                <th>contenido</th>
                <th>existencias</th>
                <th>p. unitario</th>
                <th>cantidad</th>                
                <th>#</th>
            </tr>
        </thead>        
    ';
    if (mysqli_num_rows($datos) > 0) {
        while ($rsBusqueda = $datos->fetch_array(MYSQLI_ASSOC)) {
            $stock = $rsBusqueda["existencias"];
            $tabla .= '
        <tbody>
            <tr>
                <td>' . $rsBusqueda["codigoProducto"] . '</td>
                <input type="hidden" id="codigo' . $rsBusqueda["idProducto"] . '" value="' . $rsBusqueda["codigoProducto"] . '"/>                
                <td>' . $rsBusqueda["descripcion"] . '</td>
                <input type="hidden" id="descripcion' . $rsBusqueda["idProducto"] . '" value="' . $rsBusqueda["descripcion"] . '"/>
                <td>' . $rsBusqueda["factor"] . '</td>
                <input type="hidden" id="factor' . $rsBusqueda["idProducto"] . '" value="' . $rsBusqueda["factor"] . '"/>
                <td>' . $rsBusqueda["contenido"] . '</td>
                <input type="hidden" id="contenido' . $rsBusqueda["idProducto"] . '" value="' . $rsBusqueda["contenido"] . '"/>
            ';
            if ($stock <= 10) {
                $tabla .= '<td class="_tdPocoStock">' . $rsBusqueda["existencias"] . '</td>';
            } else {
                $tabla .= '<td>' . $rsBusqueda["existencias"] . '</td>';
            }
            $tabla .= '                
                <input type="hidden" id="existencias' . $rsBusqueda["idProducto"] . '" value="' .  $rsBusqueda["existencias"] . '"/>                
                <td>$ ' . $rsBusqueda["precioUnitario"] . '</td>
                <input type="hidden" id="precio' . $rsBusqueda["idProducto"] . '" value="' . $rsBusqueda["precioUnitario"] . '" />
                ';
            if ($stock <= 0) {
                $tabla .= '
                <td><label class="advertencia">' . $rsBusqueda["existencias"] . '</label></td>
                <td data-label = "#"><i class="fal fa-ban"></i></td>
                ';
            } else {
                $tabla .= '
                <td class="_tdCantidad">
                <input type="text" class="cantidad quanti" value="1" required id="cantidadProducto' . $rsBusqueda["idProducto"] . '" 
                    data-add-cotz-id-producto="' . $rsBusqueda["idProducto"] . '" />
                </td>                                    
                <td>
                    <a class="add_product_cotizacion" id="' . $rsBusqueda["idProducto"] . '">
                        <i class="fal fa-plus" id="i_element' . $rsBusqueda["idProducto"] . '" data-i_element="' . $rsBusqueda["idProducto"] . '"></i>
                    </a>
                </td>
                ';
            }
            $tabla .= '
            </tr>            
        </tbody>
        ';
        }
    } else {
        $tabla .= '<h2 class="advertencia">eL ARTÍCULO NO EXISTE</h2>';
    }

    $output =  array('tablaModal' => $tabla);
    echo json_encode($output);
}
