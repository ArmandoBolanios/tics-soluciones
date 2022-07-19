<?php
require('../cn/cnt.php');
$consultarVentas = "
    SELECT idVenta, codigoArticulo, unidades, costoUnidades, total, fechaVenta, utilidad, 
    descripcion, existencias, precioUnitario, propietario 
    FROM ventas1 INNER JOIN productos 
    ON ventas1.codigoArticulo = productos.codigoProducto 
    and propietario = 'Eduardo'
    WHERE DATE(fechaVenta) = CURDATE() ORDER BY idVenta ASC;
";


if (isset($_POST["propietario"])) {
    $tabla = '';
    $tfoot = '';
    $formularioEduardo = '';

    $articulos = 0;
    $venta = 0;
    $utilidad = 0;

    $tabla .= '
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

    $ejecutarConsultaVentas = $Oxi->query($consultarVentas);
    while ($ventas = $ejecutarConsultaVentas->fetch_array(MYSQLI_ASSOC)) {
        $articulos += $ventas['unidades'];
        $venta += $ventas['total'];
        $utilidad += $ventas['utilidad'];

        $tabla .= '
                <tbody>
                    <tr>
                        <td>' . $ventas["idVenta"] . '</td>
                        <td>' . $ventas["fechaVenta"] . '</td>
                        <td>' . $ventas["codigoArticulo"] . '</td>
                        <td>' . $ventas["descripcion"] . '</td>
                ';

        if ($ventas["existencias"] <= 10) {
            $tabla .= '<td class="stock">' . $ventas["existencias"] . '</td>';
        } else {
            $tabla .= '<td>' . $ventas["existencias"] . '</td>';
        }

        $tabla .= '
                        <td>' . $ventas["precioUnitario"] . '</td>
                        <td>' . $ventas["unidades"] . '</td>
                        <td>' . $ventas["total"] . '</td>
                        <td>' . $ventas["utilidad"] . '</td>
                        <td class="inge">' . $ventas["propietario"] . '</td>
                ';
    }
    $tabla .= '
                    </tr>
            </tbody> 
        </table>
        ';

    $reponer = $venta - $utilidad;
    $tfoot .= '
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
        </div>
        ';

    $formularioEduardo = '
    <div class="grilla_calendar">
            <input type="date" name="date1" required>
            <input type="date" name="date2" required>
            <input type="submit" value="CONSULTAR">
    </div>
    ';

    $output = array('tabla' => $tabla, 'tfoot' => $tfoot, 'formularioEduardo' => $formularioEduardo);

    echo json_encode($output);
}
