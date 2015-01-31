$(function(){
    //Variables Globales
    $page = 0;
    $cantResult = 10;
    $orderBy = '';
    $filter = {};

    updateReportesView();

    $('a#busqueda_tercero').click(function(){
        plegarFormulario();
    });
})

function plegarFormulario(){
    $('div#busqueda_tercero_div').slideToggle(500,function(){
        if($('a#tercero_general_filter_header').find('i').hasClass('icon-chevron-down')){
            $('a#tercero_general_filter_header').find('i').removeClass('icon-chevron-down');
            $('a#tercero_general_filter_header').find('i').addClass('icon-chevron-up');
        }else{
            $('a#tercero_general_filter_header').find('i').removeClass('icon-chevron-up');
            $('a#tercero_general_filter_header').find('i').addClass('icon-chevron-down');
        }
    });
}

function updateReportesView(){
    cargando = $('<img src="/Taller/web/images/loading.gif" />');

    $('div.terceros-result-table').html(cargando);

    $.ajax({
        url: "busqueda-avanzada/"+$page+"/"+$cantResult,
        data:{
            'filter': $filter,
            'orderBy': $orderBy,
        },
        type: "GET",
        success: function(response){
            $('div.terceros-result-table').html(response);
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

    codigo      = $('#data_busqueda_tercero_type_codigo').val();
    nombres     = $('#data_busqueda_tercero_type_nombres').val();
    apellidos   = $('#data_busqueda_tercero_type_apellidos').val();
    alias       = $('#data_busqueda_tercero_type_alias').val();
    cliente     = $('#data_busqueda_tercero_type_cliente').val();
    proveedor   = $('#data_busqueda_tercero_type_proveedor').val();
    institucion = $('#data_busqueda_tercero_type_institucion').val();

    $filter = {
        'codigo': codigo,
        'nombres': nombres,
        'apellidos': apellidos,
        'alias': alias,
        'cliente': cliente,
        'proveedor': proveedor,
        'institucion': institucion
    };

    updateReportesView();
}