$(function(){
    //Variables Globales
    $page = 0;
    $cantResult = 10;
    $orderBy = '';
    $filter = {};

    updateReportesView();

    $('a#busqueda_almacen').click(function(){
        plegarFormulario();
    });
})

function plegarFormulario(){
    $('div#busqueda_almacen_div').slideToggle(500,function(){
        if($('a#almacen_general_filter_header').find('i').hasClass('icon-chevron-down')){
            $('a#almacen_general_filter_header').find('i').removeClass('icon-chevron-down');
            $('a#almacen_general_filter_header').find('i').addClass('icon-chevron-up');
        }else{
            $('a#almacen_general_filter_header').find('i').removeClass('icon-chevron-up');
            $('a#almacen_general_filter_header').find('i').addClass('icon-chevron-down');
        }
    });
}

function updateReportesView(){
    cargando = $('<img src="/images/loading.gif" />');

    $('div.almacens-result-table').html(cargando);

    $.ajax({
        url: "busqueda-avanzada/"+$page+"/"+$cantResult,
        data:{
            'filter': $filter,
            'orderBy': $orderBy,
        },
        type: "GET",
        success: function(response){
            $('div.almacens-result-table').html(response);
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

    codigo       = $('#data_busqueda_almacen_type_codigo').val();
    nombre       = $('#data_busqueda_almacen_type_nombre').val();
    descripcion  = $('#data_busqueda_almacen_type_descripcion').val();
    direccion    = $('#data_busqueda_almacen_type_direccion').val();

    $filter = {
        'codigo': codigo,
        'nombre': nombre,
        'descripcion': descripcion,
        'direccion': direccion
    };

    updateReportesView();
}