<?php
require('cn/cnt.php');
$consultarVentas = "SELECT id_cotizacion, clave, nombre_cliente, telefono, correo, fecha_cot, auxiliar 
FROM cotizacion WHERE auxiliar = 1;
";


if (isset($_POST["propietario"])) {
    $pendiente = $_POST['propietario'];
    if ($pendiente == "Pendientes") {
        $tabla = '';
        $articulos = 0;
        $venta = 0;


        $tabla .= '
            <table  class="table2">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Cliente</th>
                    <th>Telefono</th>
                    <th>Correo</th>
                    <th>fecha</th>
                    <th>#</th>                    
                </tr>
            </thead>
        ';

        $consultaCotizacion = $Oxi->query($consultarVentas);
        while ($cotizacion = $consultaCotizacion->fetch_array(MYSQLI_ASSOC)) {
            $tabla .= '
                <tbody>
                    <tr>
                        <td>' . $cotizacion["id_cotizacion"] . '</td>                        
                        <td>' .  strtoupper($cotizacion["nombre_cliente"]) . '</td>
                        <td>' . $cotizacion["telefono"] . '</td>
                        <td>' . $cotizacion["correo"] . '</td>
                        <td>' . $cotizacion["fecha_cot"] . '</td>                        
                ';

            $tabla .= '
                        <td>
                            <a href="detalles_cotizacion.php?claveCotizacion=' . $cotizacion["clave"] . '" class="enlace">ver detalles</a>
                        </td>';
        }
        $tabla .= '
                </tr>
            </tbody>    
        </table>
        ';


        $output = array('tabla' => $tabla);

        echo json_encode($output);
    }
}
