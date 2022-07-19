/** primera tabla */
$(document).ready(function (data) {
    $(document).on('keyup', '.quanti', function () {
        var product_id = $(this).data("id_producto");
        var product_quantity = $('#cantidad' + product_id).val();

        // deshabilita el boton si la cantidad que escribimos es mayor de las existencias               
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

    /** en la busqueda, primera tabla */
    $('.add_to_cart').click(function () {
        var producto_id = $(this).attr("id");
        var codigo_producto = $('#codigo' + producto_id).val();
        var descripcion_producto = $('#descripcion' + producto_id).val();
        var existencias_producto = $('#existencias' + producto_id).val();
        var precio_unitario = $('#precio' + producto_id).val();
        var precio_compra = $('#precioCompra' + producto_id).val();
        var cantidad_producto = $('#cantidad' + producto_id).val();
        var comentarios = $('#comentarios' + producto_id).val();
        var action = "add";

        $('.wrapper').css('z-index', '1');

        if (cantidad_producto > 0) {
            $.ajax({
                url: "consultas/action_ventas.php",
                method: "POST",
                dataType: "json",
                data: {
                    producto_id: producto_id,
                    codigo_producto: codigo_producto,
                    descripcion_producto: descripcion_producto,
                    existencias_producto: existencias_producto,
                    precio_unitario: precio_unitario,
                    precio_compra: precio_compra,
                    cantidad_producto: cantidad_producto,
                    comentarios: comentarios,
                    action: action
                },
                success: function (data) {
                    $('#shopping').html(data.tabla);
                    showToast1();
                }
            });
        }
    });

    /** Button DELETE  */
    $(document).on('click', '.delete', function () {
        var producto_id = $(this).attr("id");
        var action = "remove";
        $('.wrapper').css('z-index', '1');

        $.ajax({
            url: "consultas/action_ventas.php",
            method: "POST",
            dataType: "json",
            data: {
                producto_id: producto_id,
                action: action
            },
            success: function (data) {
                $('#shopping').html(data.tabla);
                showToast2();
            }
        });

    });

    /** en tabla ventas, segunda tabla */
    $(document).on('keyup', '.quantity', function () {
        var producto_id = $(this).data("producto_id");
        var quantity = $(this).val();
        var product_quantity = $('#quantity' + producto_id).val();
        var existencias_producto = $('#existencias' + producto_id).val();

        var action = "cambiar_cantidad";

        if (product_quantity != '') {
            $.ajax({
                url: "consultas/action_ventas.php",
                method: "POST",
                dataType: "json",
                data: {
                    producto_id: producto_id,
                    quantity: quantity,
                    existencias_producto: existencias_producto,
                    action: action
                },
                success: function (data) {
                    $('#shopping').html(data.tabla);
                }
            });
        }
    });

    /** ------------------------ mensajes tooltip  ------------------------------------- */
    let x;
    message1 = document.querySelector('#toast.success');
    message2 = document.querySelector('#toast.info');

    function showToast1() {
        clearTimeout(x);
        message1.style.transform = "translateX(0)";
        /*x = setTimeout(() => {
            message1.style.transform = "translateX(400px)";            
            $('.wrapper').css('z-index', '-1');
        }, 1500);*/
        setTimeout(function () {            
            message1.style.transform = "translateX(400px)";         
            $('.wrapper').css('z-index', '-1');
        }, 1500);

    }

    function showToast2() {
        clearTimeout(x);
        message2.style.transform = "translateX(0)";
        x = setTimeout(() => {
            message2.style.transform = "translateX(400px)";
            $('.wrapper').css('z-index', '-1');
        }, 1500);

    }

    /** --------------------------------------------- ------------------------------------- */
    /*
    Abrir nueva ventana si se hace clic en la imagen
    Primero, obtener el id del producto, en base a eso, obtenemos los datos 
    para enviarlos a la otra página, y recibirlos con GET
    */
    $(document).on('click', '.imagen', function () {
        const producto_id = $(this).data("imagen-id-producto");
        const codigo_producto = $('#codigo' + producto_id).val();
        window.open("detalles_producto.php?codigo_producto=" + codigo_producto);
    });

    /* cuando se hace la búsqueca por código de producto */
    $(document).on('click', '.imagen2', function () {
        const producto_id = $(this).data("imagen2-id-producto");
        const codigo_producto = $('#codigo' + producto_id).val();
        window.open("detalles_producto.php?codigo_producto=" + codigo_producto);
    });
});

$('.wrapper').css('z-index', '-1');

/** manda a llamar los mensajes modal para cerrarlos */
function closeToast1() {
    message1.style.transform = "translateX(400px)";
}

function closeToast2() {
    message2.style.transform = "translateX(400px)";
}







