<?php
require('../cn/cnt.php');

if ($_REQUEST) {

	if (isset($_POST['product_id']) && ($_POST['product_quantity'])) {

		$product_id =         $_REQUEST['product_id'];
		$product_quantity =   $_REQUEST['product_quantity'];
		
		$stock   = $Oxi->query("SELECT existencias, idProducto FROM productos WHERE idProducto = '$product_id' ");

		while ($rows = mysqli_fetch_array($stock)) {
			$almacen = $rows['existencias'];

			if ($almacen < $product_quantity) {
				echo '<p class="text-danger">No disponible</p>';
				echo '
				<script type="text/javascript">			
				$(document).ready(function (data) {
					var i_element = $("#i_element" + '.$product_id.').data("i_element");
					//console.log(i_element);
					$("#i_element'.$product_id.'").removeClass("fa-plus");
				});				
				</script>
				';
			} else if($almacen >= $product_quantity){
				echo '
				<script type="text/javascript">			
				$(document).ready(function (data) {
					var i_element = $("#i_element" + '.$product_id.').data("i_element");
					//console.log(i_element);
					$("#i_element'.$product_id.'").addClass("fa-plus");
				});				
				</script>				
				';
			}
		}
				
	} //end isset

} //end REQUEST
