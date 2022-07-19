<?php
session_start();
require('cn/cnt.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venta</title>
    <link rel="stylesheet" href="estilos/modal.css">
    <script src="js/modal.js"></script>
</head>

<body>
    <?php
    if (isset($_POST['registrar_venta']) && !empty($_SESSION["shopping_cart"])) {
        $venta = "";
                
            foreach ($_SESSION["shopping_cart"] as $keys => $values) {

                $existenciasNuevas = (int)$values["existencias_producto"] - (int)$values["cantidad_producto"];
                $subUtilidad = (int)$values["precio_unitario"] - (int)$values["precio_compra"];
                $utilidad = (int)$subUtilidad * (int)$values["cantidad_producto"];
                $total = $values["precio_unitario"] * $values["cantidad_producto"];
                $observaciones = $values["ob"];

                if ($observaciones == '') {
                    $observaciones = 'NINGUNA';
                }
                /** ------------------------- SQL ----------------------------- */
                $venta .= "
            INSERT INTO ventas1(codigoArticulo,unidades,costoUnidades,total,fechaVenta,observaciones,utilidad) 
            VALUES(
            '" . $values["codigo_producto"]    . "',
            '" . $values["cantidad_producto"]    . "',
            '" . $values["precio_unitario"]    . "',
            '" . $total    . "',
            now(), 
            '" . $observaciones . "',
            '" . $utilidad . "');

            UPDATE productos SET existencias='" . $existenciasNuevas . "' WHERE codigoProducto='" . $values["codigo_producto"] . "';

            ";
            }
        

        if (mysqli_multi_query($Oxi, $venta)) {
            unset($_SESSION["shopping_cart"]);
            echo '<script>
                cuteAlert({
                    type: "success",
                    title: "Venta Realizada",
                    message: "tics.tlapa.com",
                    closeStyle: "circle",
                    buttonText: "Okay"
                });
                setTimeout("redireccion()", 1000);
              </script>';
        } else {
            die('Error SQL: ' . mysqli_error($Oxi));
        }
    } else {
        header('location:index.php');
    }
    ?>
</body>

</html>