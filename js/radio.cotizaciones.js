$(document).ready(function () {
    // HACER SUBMIT
    $("#updateCliente").on('click', function (e) {        
        var clave = $('#clave').val(); // clave padre de la cotizacion
        var nombre_cliente = $('#nombre_cliente').val();
        var telefono = $('#telefono').val();
        var correo = $('#correo').val();
        var direccion = $('#direccion').val();

        $.ajax({
            type: 'POST',
            dataType: "JSON", // para recibir el sql
            url: 'consultas/update_cliente.php',
            data: {clave: clave, nombre_cliente, telefono, correo, direccion},
            success: function (resultado) {                
                $('.datos_cliente1').html(resultado.mensaje);  //muestra el sql
                modal2.style.display = "none";
                showToastUser();
            },
            error: function () {
                alert("Algo ha fallado");
            }
        });
        //return false;        
    });

    $("#pendientes").click(function () {
        const propietario = $('input:radio[name=propietario]:checked').val();
        $('#tablaPendientes').show();
        $('.table-container').hide();
        $('#tablaFinalizadas').hide();
        $('#tabla').hide();
        $('.ventas').hide();

        $.ajax({
            type: 'POST',
            url: 'cotizaciones_pendientes.php',
            dataType: 'JSON',
            data: {
                propietario: propietario
            },
            success: function (data) {
                $('#tablaPendientes').html(data.tabla);
            }
        });
    });

    $("#finalizadas").click(function () {
        const propietario = $('input:radio[name=propietario]:checked').val();
        $('#tablaFinalizadas').show();
        $('#tablaPendientes').hide();
        $('.table-container').hide();
        $('#tabla').hide();
        $('.ventas').hide();

        $.ajax({
            type: 'POST',
            url: 'cotizaciones_finalizadas.php',
            dataType: 'JSON',
            data: {
                propietario: propietario
            },
            success: function (data) {
                $('#tablaFinalizadas').html(data.tabla);
            }
        });
    });

    $("#cotizacion").click(function () {
        $('.table-container').show();
        $('#tablaPendientes').hide();
        $('#tablaFinalizadas').hide();
        $('#tabla').show();
        $('.ventas').show();
    });

    /*
    Eliminar productos de la cotizacion pendiente
    */
    $(document).on('click', '.delete', function () {
        var producto_id = $(this).attr("id");
        var clave = $('#clave').val(); // clave padre de la cotizacion
        var action = "eliminar";

        $.ajax({
            url: "consultas/action_cotizacion_pendiente.php",
            method: "POST",
            dataType: "json",
            data: {
                producto_id: producto_id,
                clave: clave,
                action: action
            },
            success: function (data) {
                $('#tblCotizacionPendiente').html(data.tabla);
                $('.totalCotizacion').html(data.totalCotizacion);
            }
        });

    });

    /* Actualizar cantidad  a la cotizacion pendiente */
    $(document).on('keyup', '.quantity', function () {
        var producto_id = $(this).data("producto_id");
        var quantity = $(this).val();
        var product_quantity = $('#quantity' + producto_id).val();
        var clave = $('#clave').val(); // clave padre de la cotizacion
        var precio_unitario = $('#precio' + producto_id).val();

        var action = "cambiar_cantidad";

        if (product_quantity != '') {
            $.ajax({
                url: "consultas/action_cotizacion_pendiente.php",
                method: "POST",
                dataType: "json",
                data: {
                    producto_id: producto_id,
                    quantity: quantity,
                    precio_unitario: precio_unitario,
                    clave: clave,
                    action: action
                },
                success: function (data) {
                    $('#tblCotizacionPendiente').html(data.tabla);
                    $('.totalCotizacion').html(data.totalCotizacion);
                }
            });
        }
    });

    /*  - Se abre formulario modal
        Agregar productos a la cotizacion pendiente 
    */
    $(document).on('click', '#add_articulo', function () {
        $('#modalCotizacion').css("display", "block");
    });

    $(document).on('click', '#edit_cliente', function () {
        $('#modalCliente').css("display", "block");
    });
    /************************************************************/
    /* AJAX PARA BUSCAR ARTICULOS POR SU CÓDIGO DE PRODUCTO    */
    $("#agregar_articulos_CODIGO").on('submit', function (e) {
        e.preventDefault();
        var txt_busquedaCodigo = $('#txt_busquedaCodigo').val();

        $.ajax({
            type: 'POST',
            url: 'consultas/agregar_articulos_cotizacion.php',
            data: { busqueda_codigo: txt_busquedaCodigo },
            dataType: 'json',
            success: function (resultado) {
                $('#tablaModal').html(resultado.tablaModal);
                document.getElementById("agregar_articulos_CODIGO").reset();
            }
        });
    });

    /* AJAX PARA BUSCAR ARTICULOS POR SU DESCRIPCION DE PRODUCTO */
    $("#agregar_articulos_DESCRIPCION").on('submit', function (e) {
        e.preventDefault();
        var txt_busquedaDescripcion = $('#txt_busquedaDescripcion').val();

        $.ajax({
            type: 'POST',
            url: 'consultas/agregar_articulos_cotizacion.php',
            data: { busqueda_descripcion: txt_busquedaDescripcion },
            dataType: 'json',
            success: function (resultado) {
                $('#tablaModal').html(resultado.tablaModal);
                document.getElementById("agregar_articulos_DESCRIPCION").reset();
            }
        });
    });
    /** ----------------------- buscar stock en almacen ------------------------------ */
    $(document).on('keyup', '.quanti', function () {
        var product_id = $(this).data("add-cotz-id-producto");
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

    /* agregar articulos a la tabla original */
    $(document).on('click', '.add_product_cotizacion', function () {
        var producto_id = $(this).attr("id");
        var codigo_producto = $('#codigo' + producto_id).val();
        var existencias_producto = $('#existencias' + producto_id).val();
        var descripcion_producto = $('#descripcion' + producto_id).val();
        var factor_producto = $('#factor' + producto_id).val();
        var contenido_producto = $('#contenido' + producto_id).val();
        var precio_unitario = $('#precio' + producto_id).val();
        var cantidad_producto = $('#cantidadProducto' + producto_id).val();
        var clave = $('#clave').val(); // CLAVE DE COTIZACION (CLIENTE)
        var action = "add";

        if (cantidad_producto > 0) {
            $.ajax({
                url: "consultas/action_cotizacion_pendiente.php",
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
                    clave: clave,
                    action: action
                },
                success: function (data) {
                    $('#tblCotizacionPendiente').html(data.tabla);
                    $('.totalCotizacion').html(data.totalCotizacion);
                    showToast1();
                }
            });
        }
    });

    // realizar venta de la cotización
    $(document).on('click', '.btnVentaCotizacion', function () {
        let clave = $('#clave').val(); // CLAVE DE COTIZACION (CLIENTE) 
        let ventaCotizacion = $('.btnVentaCotizacion').val();

        $.ajax({
            url: "registro_venta2.php",
            method: "POST",
            dataType: "json",
            data: { clave: clave, ventaCotizacion: ventaCotizacion },
            success: function (data) {
                //$('#mostrar').html(data.mostrar);
                cuteAlert({
                    type: "success",
                    title: "Venta Realizada",
                    message: "tics.tlapa.com",
                    closeStyle: "circle",
                    buttonText: "Okay"
                });
            }
        });
    });

    /* VER EL REPORTE DE LA COTIZACIÓN FINALIZADA */
    $(document).on('click', '.btnArticulo', function () {
        const clave = $('#clave').val(); // CLAVE DE COTIZACION (CLIENTE) 
        const cotizacion = $('#cotizacion').val(); // ID COTIZACION DEL CLIENTE
        const nombre_cliente = $('#nombre_cliente').val();
        const telefono = $('#telefono').val();
        const correo = $('#correo').val();
        const direccion = $('#direccion').val();
        const fecha_hora = $('#fecha_hora').val();

        window.open("reporte_cotizacion2.php?clave="+clave+"&fecha_hora="+fecha_hora+"&cotizacion="+cotizacion+"&nombre_cliente="+nombre_cliente+"&telefono="+telefono+"&correo="+correo+"&direccion="+direccion);
        
    });

    /** mensajes tooltip */
    let x, w;
    message1 = document.querySelector('#toast.success');
    message2 = document.querySelector('#toast.info');

    function showToast1() {
        clearTimeout(x);
        message1.style.transform = "translateX(0)";
        x = setTimeout(() => {
            message1.style.transform = "translateX(400px)";
        }, 1500);
    }
    function showToastUser() {
        clearTimeout(w);
        message2.style.transform = "translateX(0)";
        w = setTimeout(() => {
            message2.style.transform = "translateX(400px)";
        }, 2500);
    }
});


var modal = document.getElementById('modalCotizacion');
var modal2 = document.getElementById('modalCliente');
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    } else if (event.target == modal2) {
        modal2.style.display = "none";
    }
}

/** Para cerrar los tooltip */
function closeToast1() {
    message1.style.transform = "translateX(400px)";
}
function closeToastUser() {
    message1.style.transform = "translateX(400px)";
}
