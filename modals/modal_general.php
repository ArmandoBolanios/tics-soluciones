<?php
require('../cn/cnt.php');

if (!empty($_POST)) {
    $tabla2 = '';
    $tfoot2 = '';
    
    $articulos = 0;
    $venta = 0;
    $utilidad = 0;

    $fechaInicial = $_POST['date1'];
    $fechaFinal = $_POST['date2'];

    $consultarCalendario = "
    SELECT idVenta, codigoArticulo, unidades, costoUnidades, total, fechaVenta, utilidad, 
    descripcion, existencias, precioUnitario, propietario 
    FROM ventas1 INNER JOIN productos ON ventas1.codigoArticulo = productos.codigoProducto 
    WHERE DATE(fechaVenta) >= '$fechaInicial' AND DATE(fechaVenta)<= '$fechaFinal' ORDER BY idVenta ASC; 
    ";

    $tabla2 .= '    
    <table  class="table2">
            <thead>
                <tr>
                    <th>venta</th>
                    <th>fecha</th>
                    <th>codigo</th>
                    <th>descripcion</th>
                    <th>exis</th>
                    <th>precio</th>
                    <th>u. ven.</th>
                    <th>p. ven.</th>
                    <th>util.</th>
                    <th>propietario</th>
                </tr>
            </thead>
    ';
    $ejecutarConsultaVentas = $Oxi->query($consultarCalendario);
    while ($ventas = $ejecutarConsultaVentas->fetch_array(MYSQLI_ASSOC)) {
        $propietarioX = $ventas["propietario"];
        $articulos += $ventas['unidades'];
        $venta += $ventas['total'];
        $utilidad += $ventas['utilidad'];

        $tabla2 .= '
                <tbody>
                    <tr>
                        <td>' . $ventas["idVenta"] . '</td>
                        <td>' . $ventas["fechaVenta"] . '</td>
                        <td>' . $ventas["codigoArticulo"] . '</td>
                        <td>' . $ventas["descripcion"] . '</td>
                ';
        if ($ventas["existencias"] <= 10) {
            $tabla2 .= '<td class="stock">' . $ventas["existencias"] . '</td>';
        } else {
            $tabla2 .= '<td>' . $ventas["existencias"] . '</td>';
        }

        $tabla2 .= '
        <td>' . $ventas["precioUnitario"] . '</td>
        <td>' . $ventas["unidades"] . '</td>
        <td>' . $ventas["total"] . '</td>
        <td>' . $ventas["utilidad"] . '</td>
        ';

        if ($propietarioX == 'Sin Factura') {
            $tabla2 .= '<td class="sn">' . $ventas["propietario"] . '</td>';
        } else if ($propietarioX == 'Lilia') {
            $tabla2 .= '<td class="doc">' . $ventas["propietario"] . '</td>';
        } else if ($propietarioX == 'Eduardo') {
            $tabla2 .= '<td class="inge">' . $ventas["propietario"] . '</td>';
        }
    }
    $tabla2 .= '
                </tr>
            </tbody>
        </table>
    ';

    $reponer = $venta - $utilidad;
    $tfoot2 .= '
    <div class="grilla2">
            <div class="stat borde">
                <h3>Total de artículos: <span>' . $articulos . '</span></h3>                
            </div>
            <div class="stat borde">
                <h3>Total de ventas: <span>$' . number_format($venta, 2) . '</span></h3>                
            </div>
            <div class="stat borde">
                <h3>Utilidad: <span>$' . number_format($utilidad, 2) . '</span></h3>                
            </div>
            <div class="stat">
                <h3>Reponer: <span>$' . number_format($reponer, 2) . '</span></h3>                
            </div>
            <input type="hidden" value = "'.$fechaInicial.'" id = "fechaInicial">
            <input type="hidden" value = "'.$fechaFinal.'" id = "fechaFinal">            
    </div>
    ';
    
    $salida = array('tabla2' => $tabla2, 'tfoot2' => $tfoot2);

    echo json_encode($salida);
}


