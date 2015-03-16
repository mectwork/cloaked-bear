$(function(){
    //Variables Globales
    $page = 0;
    $cantResult = 10;
    $orderBy = '';
    $filter = {};

    updateReportesView();

    $('a#busqueda_movimiento').click(function(){
        plegarFormulario();
    });
})

function plegarFormulario(){
    $('div#busqueda_movimiento_div').slideToggle(500,function(){
        if($('a#movimiento_general_filter_header').find('i').hasClass('icon-chevron-down')){
            $('a#movimiento_general_filter_header').find('i').removeClass('icon-chevron-down');
            $('a#movimiento_general_filter_header').find('i').addClass('icon-chevron-up');
        }else{
            $('a#movimiento_general_filter_header').find('i').removeClass('icon-chevron-up');
            $('a#movimiento_general_filter_header').find('i').addClass('icon-chevron-down');
        }
    });
}

function updateReportesView(){
    cargando = $('<img src="/images/loading.gif" />');

    $('div.movimientos-result-table').html(cargando);

    $.ajax({
        url: "busqueda-avanzada/"+$page+"/"+$cantResult,
        data:{
            'filter': $filter,
            'orderBy': $orderBy
        },
        type: "GET",
        success: function(response){
            $('div.movimientos-result-table').html(response);
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

    fechaInicio         = $('#data_busqueda_movimiento_producto_type_fechaInicio').val();
    fechaFin            = $('#data_busqueda_movimiento_producto_type_fechaFin').val();
    categoriaProducto   = $('#data_busqueda_movimiento_producto_type_categoriaProducto').val();
    almacenOrigen       = $('#data_busqueda_movimiento_producto_type_almacenOrigen').val();
    almacenDestino      = $('#data_busqueda_movimiento_producto_type_almacenDestino').val();

    $filter = {
        'fechaInicio': fechaInicio,
        'fechaFin': fechaFin,
        'categoriaProducto': categoriaProducto,
        'almacenOrigen': almacenOrigen,
        'almacenDestino': almacenDestino
    };

    updateReportesView();
}