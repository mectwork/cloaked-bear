$(function(){
    //Variables Globales
    $page = 0;
    $cantResult = 10;
    $orderBy = '';
    $filter = {};

    updateReportesView();

    $('a#busqueda_pedidoCompra').click(function(){
        plegarFormulario();
    });
})

function plegarFormulario(){
    $('div#busqueda_pedidoCompra_div').slideToggle(500,function(){
        if($('a#pedidoCompra_general_filter_header').find('i').hasClass('icon-chevron-down')){
            $('a#pedidoCompra_general_filter_header').find('i').removeClass('icon-chevron-down');
            $('a#pedidoCompra_general_filter_header').find('i').addClass('icon-chevron-up');
        }else{
            $('a#pedidoCompra_general_filter_header').find('i').removeClass('icon-chevron-up');
            $('a#pedidoCompra_general_filter_header').find('i').addClass('icon-chevron-down');
        }
    });
}

function updateReportesView(){
    cargando = $('<img src="/Taller/web/images/loading.gif" />');

    $('div.pedidoCompras-result-table').html(cargando);

    $.ajax({
        url: "busqueda-avanzada/"+$page+"/"+$cantResult,
        data:{
            'filter': $filter,
            'orderBy': $orderBy,
        },
        type: "GET",
        success: function(response){
            $('div.pedidoCompras-result-table').html(response);
        }
    });
}

function setCantResult(cant){
    $cantResult = cant;
    updateReportesView();
}

function setPage(page){
    $page = page;
    updateReportesView();
}

function setFilters(){
    plegarFormulario();

    numero_documento     = $('#data_busqueda_pedido_compra_type_numero_documento').val();
    tercero              = $('#data_busqueda_pedido_compra_type_tercero').val();
    //fecha_pedido         = $('#data_busqueda_pedido_compra_type_fecha_pedido').val();
    almacen              = $('#data_busqueda_pedido_compra_type_almacen').val();
    moneda               = $('#data_busqueda_pedido_compra_type_moneda').val();
    forma_pago           = $('#data_busqueda_pedido_compra_type_forma_pago').val();
    condiciones_pago     = $('#data_busqueda_pedido_compra_type_condiciones_pago').val();
    importe_total_lineas = $('#data_busqueda_pedido_compra_type_importe_total_lineas').val();
    importe_total        = $('#data_busqueda_pedido_compra_type_importe_total').val();

    $filter = {
        'numero_documento': numero_documento,
        'tercero': tercero,
        //'fecha_pedido': fecha_pedido,
        'almacen': almacen,
        'moneda': moneda,
        'condiciones_pago': condiciones_pago,
        //'estado_documento': estado_documento,
        'importe_total_lineas': importe_total_lineas,
        'importe_total': importe_total

    };

    updateReportesView();
}