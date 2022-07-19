/** primera tabla */
$(document).ready(function (data) {
    $(document).on('keyup', '.quanti', function () {
        var product_id = $(this).data("cotz-id-producto");
        var product_quantity = $('#cantidadProducto' + product_id).val();

        if (product_quantity > 0) {
            $.ajax({
                type: 'POST',
                url: 'consultas/verificar_stock_primera_tabla.php',
                data: {
                    product_id: product_id,
                    product_quantity: product_quantity
                },
                success: function (data) {
                    $('#infoPrincipal').fadeIn(1000).html(data);
                }
            });
        } else {
            $("#i_element" + product_id).removeClass("fa-plus");
        }
    });

    /** primera tabla */
    $('.add_cot').click(function () {
        var producto_id = $(this).attr("id");
        var codigo_producto = $('#codigo' + producto_id).val();
        var descripcion_producto = $('#descripcion' + producto_id).val();
        var factor_producto = $('#factor' + producto_id).val();
        var contenido_producto = $('#contenido' + producto_id).val();
        var existencias_producto = $('#existencias' + producto_id).val();
        var precio_unitario = $('#precio' + producto_id).val();
        var cantidad_producto = $('#cantidadProducto' + producto_id).val();

        var action = "add";

        if (cantidad_producto > 0) {
            $.ajax({
                url: "consultas/action_cotizacion.php",
                method: "POST",
                dataType: "json",
                data: {
                    producto_id: producto_id,
                    codigo_producto: codigo_producto,
                    descripcion_producto: descripcion_producto,
                    factor_producto: factor_producto,
                    contenido_producto: contenido_producto,
                    existencias_producto: existencias_producto,
                    precio_unitario: precio_unitario,
                    cantidad_producto: cantidad_producto,
                    action: action
                },
                success: function (data) {
                    $('#tabla').html(data.tabla);
                }
            });
        }
    });

    /** Button DELETE  */
    $(document).on('click', '.delete', function () {
        var producto_id = $(this).attr("id");
        var action = "remove";
        $.ajax({
            url: "consultas/action_cotizacion.php",
            method: "POST",
            dataType: "json",
            data: {
                producto_id: producto_id,
                action: action
            },
            success: function (data) {
                $('#tabla').html(data.tabla);
            }
        });

    });

    /** segunda tabla */
    $(document).on('keyup', '.quantity', function () {
        var producto_id = $(this).data("producto_id");
        var quantity = $(this).val();
        var product_quantity = $('#quantity' + producto_id).val();
        var existencias_producto = $('#existencias' + producto_id).val();

        var action = "cambiar_cantidad";

        if (product_quantity != '') {
            $.ajax({
                url: "consultas/action_cotizacion.php",
                method: "POST",
                dataType: "json",
                data: {
                    producto_id: producto_id,
                    quantity: quantity,
                    existencias_producto: existencias_producto,
                    action: action
                },
                success: function (data) {
                    $('#tabla').html(data.tabla);
                }
            });
        }
    });

    // Cuando se hace clic en el boton cliente, se abre formulario modal
    $(document).on('click', '.cliente', function () {
        $('#modform').css("display", "block");
    });

    // HACER SUBMIT
    $("#formularioCotizacion").on('submit', function (e) {
        e.preventDefault();
        var nombre_cliente = $('#nombre_cliente').val();
        var telefono = $('#telefono').val();
        var correo = $('#correo').val();
        var direccion = $('#direccion').val();
        
        const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", 
        "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        const fecha = new Date();

        var fechaActual = fecha.getDate() + " de " + monthNames[fecha.getMonth()] + " de " + fecha.getFullYear();
        let fecha_hora = fechaActual;
        $.ajax({
            type: 'POST',
            //dataType: "JSON", // para recibir el sql
            url: 'registro_cotizacion.php',
            data: $(this).serialize(),
            success: function (resultado) {
                var jsonData = JSON.parse(resultado);                
                const idCotizacion = jsonData.lastId;
                const clave = jsonData.claveAfter;
                window.open("reporte_cotizacion.php?idCotizacion="+ idCotizacion + "&claveAfter="+clave + "&nombre_cliente="+nombre_cliente + "&telefono="+telefono + "&correo="+correo + "&direccion="+direccion +"&fecha_hora="+fecha_hora);
                setTimeout(redireccion(), 2500);
                //$('#mensaje').html(resultado.mensaje);  //muestra el sql       
            },
            error: function () {
                alert("Algo ha fallado");
            }
        });        
        //return false;        
    });
});



var modal = document.getElementById('modform');
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}


function redireccion() {
    window.location.href = "index.php";
}
