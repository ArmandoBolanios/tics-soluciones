$(document).ready(function () {
    $("#formulario").on('submit', function (e) {
        $.ajax({
            type: 'POST',
            url: 'modals/modal_general.php',
            dataType: 'JSON',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#tabla2').html(data.tabla2);
                $('#tfoot2').html(data.tfoot2);
            },
            error: function () {
                alert("Algo ha fallado");
            }
        });

        $('.modal').addClass('active');
        $('.modal').show();
        $('.tbCalendar').addClass('hidden');
        e.preventDefault();
        return false;
    });

    // descargar su respectivo reporte en pdf
    $(document).on('click', '.pdf_fechas', function () {        
        const fechaInicial = $('#fechaInicial').val();
        const fechaFinal = $('#fechaFinal').val();
        window.open("modals/reporte_ventas.php?fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal);
    });

    /** Consulta de ventas por fechas sin Factura */
    $("#sinFactura").on('submit', function (e) {
        $.ajax({
            type: 'POST',
            url: 'modals/modal_sinFactura.php',
            dataType: 'JSON',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#tabla2').html(data.tabla2);
                $('#tfoot2').html(data.tfoot2);
            },
            error: function () {
                alert("Algo ha fallado");
            }
        });

        $('.modal').addClass('active');
        $('.modal').show();
        $('.tbCalendar').addClass('hidden');
        e.preventDefault();
        return false;
    });

    /** Consulta ventas por fechas de Lilia */
    $("#formularioLilia").on('submit', function (e) {
        $.ajax({
            type: 'POST',
            url: 'modals/modal_lilia.php',
            dataType: 'JSON',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#tabla2').html(data.tabla2);
                $('#tfoot2').html(data.tfoot2);
            },
            error: function () {
                alert("Algo ha fallado");
            }
        });

        $('.modal').addClass('active');
        $('.modal').show();
        $('.tbCalendar').addClass('hidden');
        e.preventDefault();
        return false;
    });

    /** Consulta ventas por fechas de Lilia */
    $("#formularioEduardo").on('submit', function (e) {
        $.ajax({
            type: 'POST',
            url: 'modals/modal_eduardo.php',
            dataType: 'JSON',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#tabla2').html(data.tabla2);
                $('#tfoot2').html(data.tfoot2);
            },
            error: function () {
                alert("Algo ha fallado");
            }
        });

        $('.modal').addClass('active');
        $('.modal').show();
        $('.tbCalendar').addClass('hidden');
        e.preventDefault();
        return false;
    });
});