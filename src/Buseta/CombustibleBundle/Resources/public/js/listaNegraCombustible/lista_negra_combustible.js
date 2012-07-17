$('#combustible_lista_negra_combustible_fechaInicio').datetimepicker({
    'format': 'DD/MM/YYYY',
    pickTime: false
});

var fechaInicio = $('#combustible_lista_negra_combustible_fechaInicio').val();
$('input:hidden[name^="combustible_lista_negra_combustible[fechaInicio]_submit"]').val(fechaInicio);

$('#combustible_lista_negra_combustible_fechaFinal').datetimepicker({
    'format': 'DD/MM/YYYY',
    pickTime: false
});

var fechaFinal = $('#combustible_lista_negra_combustible_fechaFinal').val();
$('input:hidden[name^="combustible_lista_negra_combustible[fechaFinal]_submit"]').val(fechaFinal);

$("#combustible_lista_negra_combustible_fechaInicio").on("dp.change", function (e) {
    $('#combustible_lista_negra_combustible_fechaFinal').data("DateTimePicker").setMinDate(e.date);
});
$("#combustible_lista_negra_combustible_fechaFinal").on("dp.change", function (e) {
    $('#combustible_lista_negra_combustible_fechaInicio').data("DateTimePicker").setMaxDate(e.date);
});


$('#combustible_lista_negra_combustible_autobus').chosen();