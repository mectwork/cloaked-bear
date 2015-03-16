$(function(){
    //Variables Globales
    $page = 0;
    $cantResult = 10;
    $orderBy = '';
    $filter = {};

    updateReportesView();

    $('a#busqueda_albaran').click(function(){
        plegarFormulario();
    });
})

function plegarFormulario(){
    $('div#busqueda_albaran_div').slideToggle(500,function(){
        if($('a#albaran_general_filter_header').find('i').hasClass('icon-chevron-down')){
            $('a#albaran_general_filter_header').find('i').removeClass('icon-chevron-down');
            $('a#albaran_general_filter_header').find('i').addClass('icon-chevron-up');
        }else{
            $('a#albaran_general_filter_header').find('i').removeClass('icon-chevron-up');
            $('a#albaran_general_filter_header').find('i').addClass('icon-chevron-down');
        }
    });
}

function updateReportesView(){
    cargando = $('<img src="/images/loading.gif" />');

    $('div.albarans-result-table').html(cargando);

    $.ajax({
        url: "busqueda-avanzada/"+$page+"/"+$cantResult,
        data:{
            'filter': $filter,
            'orderBy': $orderBy,
        },
        type: "GET",
        success: function(response){
            $('div.albarans-result-table').html(response);
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

    numeroReferencia   = $('#data_busqueda_albaran_type_numeroReferencia').val();
    consecutivoCompra  = $('#data_busqueda_albaran_type_consecutivoCompra').val();
    almacen            = $('#data_busqueda_albaran_type_almacen').val();
    tercero            = $('#data_busqueda_albaran_type_tercero').val();

    $filter = {
        'numeroReferencia': numeroReferencia,
        'consecutivoCompra': consecutivoCompra,
        'almacen': almacen,
        'tercero': tercero
    };

    updateReportesView();
}