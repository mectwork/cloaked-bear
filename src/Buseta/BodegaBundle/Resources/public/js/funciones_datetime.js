var fecha = $('#buseta_informestock_autobus_fecha').datetimepicker({
    'format': 'DD/MM/YYYY'
});

var fechaCostos = $('#data_busqueda_informe_costos_type_fecha').datetimepicker({
    'format': 'DD/MM/YYYY'
});

var fechaInformeStock = $('#data_busqueda_informe_stock_type_fecha').datetimepicker({
    'format': 'DD/MM/YYYY'
});

var fechaMovimiento = $('#bodega_albaran_type_fechaMovimiento').datetimepicker({
    'format': 'DD/MM/YYYY'
});

var fechaContable = $('#bodega_albaran_type_fechaContable').datetimepicker({
    'format': 'DD/MM/YYYY'
});

var fecha_pedido = $('#bodega_pedido_compra_fecha_pedido').datetimepicker({
    'format': 'DD/MM/YYYY'
});

var autobus_fecha_ingreso = $('#buseta_databundle_autobus_fecha_ingreso').datetimepicker({
    'format': 'DD/MM/YYYY'
});

var autobus_valido_hasta = $('#buseta_databundle_autobus_valido_hasta').datetimepicker({
    'format': 'DD/MM/YYYY'
});

var recorrido_inicio = $('#buseta_tallerbundle_tareamantenimiento_recorrido_inicio').datetimepicker({
    'format': 'DD/MM/YYYY'
});

var ultimo_cumplio = $('#buseta_tallerbundle_tareamantenimiento_ultimo_cumplio').datetimepicker({
    'format': 'DD/MM/YYYY'
});

var picker = autobus_fecha_ingreso.datetimepicker('picker');
var $fechaIngreso;

if (picker != null) {
    picker.on('close', function () {
        $fechaIngreso = this.get('select', 'dd/mm/yyyy');
        var splt = $fechaIngreso.split('/');
        var entero = parseInt(splt[2]);
        entero += 15;
        splt[2] = entero.toString();

        $fechaIngreso = splt.join('/');

        var picker2 = autobus_valido_hasta.datetimepicker('picker');
        picker2.set('select', $fechaIngreso, {format: 'dd/mm/yyyy'});
    });
}

var fecha = $('#buseta_informestock_autobus_fecha').val();
$('input:hidden[name^="buseta_informestock_autobus[fecha]_submit"]').val(fecha);

var fechaCostos = $('#data_busqueda_informe_costos_type_fecha').val();
$('input:hidden[name^="data_busqueda_informe_costos_type[fecha]_submit"]').val(fechaCostos);

var fechaInformeStock = $('#data_busqueda_informe_stock_type_fecha').val();
$('input:hidden[name^="data_busqueda_informe_stock_type[fecha]_submit"]').val(fechaInformeStock);

var valido = $('#buseta_databundle_autobus_valido_hasta').val();
$('input:hidden[name^="buseta_databundle_autobus[valido_hasta]_submit"]').val(valido);

var fechaingreso = $('#buseta_databundle_autobus_fecha_ingreso').val();
$('input:hidden[name^="buseta_databundle_autobus[fecha_ingreso]_submit"]').val(fechaingreso);

var fechamovimiento = $('#bodega_albaran_type_fechaMovimiento').val();
$('input:hidden[name^="bodega_albaran_type[fechaMovimiento]_submit"]').val(fechamovimiento);

var fechacontable = $('#bodega_albaran_type_fechaContable').val();
$('input:hidden[name^="bodega_albaran_type[fechaContable]_submit"]').val(fechacontable);

var fechapedido = $('#bodega_pedido_compra_fecha_pedido').val();
$('input:hidden[name^="bodega_pedido_compra[fecha_pedido]_submit"]').val(fechapedido);

var recorrido_inicio = $('#buseta_tallerbundle_tareamantenimiento_recorrido_inicio').val();
$('input:hidden[name^="buseta_tallerbundle_tareamantenimiento[recorrido_inicio]_submit"]').val(recorrido_inicio);

var ultimo_cumplio = $('#buseta_tallerbundle_tareamantenimiento_ultimo_cumplio').val();
$('input:hidden[name^="buseta_tallerbundle_tareamantenimiento[ultimo_cumplio]_submit"]').val(ultimo_cumplio);

/*var fecha_inicio = $('#buseta_tallerbundle_ordentrabajo_fecha_inicio').val();
 $('input:hidden[name^="buseta_tallerbundle_ordentrabajo_fecha_inicio]_submit"]').val(fecha_inicio);*/

/*var fecha_final = $('#buseta_tallerbundle_ordentrabajo_fecha_final').val();
 $('input:hidden[name^="buseta_tallerbundle_ordentrabajo_fecha_final]_submit"]').val(fecha_final);*/






