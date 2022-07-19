$(document).ready(function () {
    const propietario = $('input:radio[name=propietario]').val();
    $.ajax({
        type: 'POST',
        url: 'consultas/tabla_ventas.php',
        dataType: 'JSON',
        data: {
            propietario: propietario
        },
        success: function (data) {
            $('#tabla').html(data.tabla);
            $('#tfoot').html(data.tfoot);
            $('#formulario').html(data.formulario);
        }
    });

    $("#factura1").click(function () {
        const propietario = $('input:radio[name=propietario]:checked').val();
        $('#formulario').hide();
        $('#formularioLilia').hide();
        $('#formularioEduardo').hide();
        $('#sinFactura').show();
        $.ajax({
            type: 'POST',
            url: 'consultas/tabla_sin_factura.php',
            dataType: 'JSON',
            data: {
                propietario: propietario
            },
            success: function (data) {
                $('#tabla').html(data.tabla);
                $('#tfoot').html(data.tfoot);
                $('#sinFactura').html(data.sinFactura);   
            }
        });
    });

    $("#factura2").click(function () {
        const propietario = $('input:radio[name=propietario]:checked').val();
        $('#formulario').hide();
        $('#sinFactura').hide();
        $('#formularioEduardo').hide();
        $('#formularioLilia').show();
        $.ajax({
            type: 'POST',
            url: 'consultas/tabla_ventas_lilia.php',
            dataType: 'JSON',
            data: {
                propietario: propietario
            },
            success: function (data) {
                $('#tabla').html(data.tabla);
                $('#tfoot').html(data.tfoot);
                $('#formularioLilia').html(data.formularioLilia);
            }
        });
    });

    $("#factura3").click(function () {
        const propietario = $('input:radio[name=propietario]:checked').val();
        $('#formulario').hide();
        $('#sinFactura').hide();
        $('#formularioLilia').hide();
        $('#formularioEduardo').show();
        $.ajax({
            type: 'POST',
            url: 'consultas/tabla_ventas_eduardo.php',
            dataType: 'JSON',
            data: {
                propietario: propietario
            },
            success: function (data) {
                $('#tabla').html(data.tabla);
                $('#tfoot').html(data.tfoot);
                $('#formularioEduardo').html(data.formularioEduardo);
            }
        });
    });
        

    /** Modal, es independiente de los demás clics */
    $(".modal-close").on("click", function (z) {
        $('.tbCalendar').removeClass('hidden');
        $('.modal').removeClass('active');
        $('.modal').hide();  
        z.preventDefault();
    });
});