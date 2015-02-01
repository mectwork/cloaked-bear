$(function(){
    //Variables Globales
    $page = 0;
    $cantResult = 10;
    $orderBy = '';
    $filter = {};

    updateReportesView();

    $('a#busqueda_informeStock').click(function(){
        plegarFormulario();
    });
})

function plegarFormulario(){
    $('div#busqueda_informeStock_div').slideToggle(500,function(){
        if($('a#informeStock_general_filter_header').find('i').hasClass('icon-chevron-down')){
            $('a#informeStock_general_filter_header').find('i').removeClass('icon-chevron-down');
            $('a#informeStock_general_filter_header').find('i').addClass('icon-chevron-up');
        }else{
            $('a#informeStock_general_filter_header').find('i').removeClass('icon-chevron-up');
            $('a#informeStock_general_filter_header').find('i').addClass('icon-chevron-down');
        }
    });
}

function updateReportesView(){
    cargando = $('<img src="/Taller/web/images/loading.gif" />');

    $('div.informeStocks-result-table').html(cargando);

    $.ajax({
        url: "busqueda-avanzada/"+$page+"/"+$cantResult,
        data:{
            'filter': $filter,
            'orderBy': $orderBy,
        },
        type: "GET",
        success: function(response){
            $('div.informeStocks-result-table').html(response);
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

    almacen   = $('#data_busqueda_informe_stock_type_almacen').val();
    producto  = $('#data_busqueda_informe_stock_type_producto').val();
    fecha     = $('#data_busqueda_informe_stock_type_fecha').val();

    $filter = {
        'almacen': almacen,
        'producto': producto,
        'fecha': fecha
    };

    updateReportesView();
}