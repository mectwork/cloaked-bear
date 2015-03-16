$(function(){
    //Variables Globales
    $page = 0;
    $cantResult = 10;
    $orderBy = '';
    $filter = {};

    updateReportesView();

    $('a#busqueda_producto').click(function(){
        plegarFormulario();
    });
})

function plegarFormulario(){
    $('div#busqueda_producto_div').slideToggle(500,function(){
        if($('a#producto_general_filter_header').find('i').hasClass('icon-chevron-down')){
            $('a#producto_general_filter_header').find('i').removeClass('icon-chevron-down');
            $('a#producto_general_filter_header').find('i').addClass('icon-chevron-up');
        }else{
            $('a#producto_general_filter_header').find('i').removeClass('icon-chevron-up');
            $('a#producto_general_filter_header').find('i').addClass('icon-chevron-down');
        }
    });
}

function updateReportesView(){
    cargando = $('<img src="/images/loading.gif" />');

    $('div.productos-result-table').html(cargando);

    $.ajax({
        url: "busqueda-avanzada/"+$page+"/"+$cantResult,
        data:{
            'filter': $filter,
            'orderBy': $orderBy,
        },
        type: "GET",
        success: function(response){
            $('div.productos-result-table').html(response);
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

    codigo              = $('#data_busqueda_producto_type_codigo').val();
    nombre              = $('#data_busqueda_producto_type_nombre').val();
    uom                 = $('#data_busqueda_producto_type_uom').val();
    categoriaProducto   = $('#data_busqueda_producto_type_categoriaProducto').val();
    condicion           = $('#data_busqueda_producto_type_condicion').val();
    bodega              = $('#data_busqueda_producto_type_bodega').val();
    precio_costo        = $('#data_busqueda_producto_type_precio_costo').val();
    precio_salida       = $('#data_busqueda_producto_type_precio_salida').val();

    $filter = {
        'codigo': codigo,
        'nombre': nombre,
        'uom': uom,
        'categoriaProducto': categoriaProducto,
        'condicion': condicion,
        'bodega': bodega,
        'precio_costo': precio_costo,
        'precio_salida': precio_salida
    };

    updateReportesView();
}