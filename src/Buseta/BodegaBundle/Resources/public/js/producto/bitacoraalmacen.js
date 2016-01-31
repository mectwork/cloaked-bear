/**
 * Created by rei on 26/01/16.
 */
<!-- bitacoraalmacen script -->
var bitacoraalmacen = {

    form_id: '',
    id: '',

    //configuraciones
    config_form_nombre: 'bitacoraalmacen',

    config_form_div_listar: 'div#bitacoraalmacen',

    config_ruta_listar: 'bitacoraalmacen_listarpor_producto',

    _start_events: function () {
        $('div.paginator.row ul.pagination').find('a.paginator-link').on('click', bitacoraalmacen._load);

        //esto es para el formulario de busqueda dentro del TAB
        /*$('form#filter_form').on('submit', bitacoraalmacen._load );*/
    },

    _load: function (event) {

        if (event !== undefined) {
            event.preventDefault();
        }

        //Obtenemos el id del reporte actualmente mostrado en el show
        producto.id = $('#producto_id').val();

        if (producto.id == '') {
            return;
        }

        // add spinning to show loading process
        tabs._add_loadding(bitacoraalmacen.config_form_nombre);

        var url = Routing.generate(bitacoraalmacen.config_ruta_listar, {'id': producto.id});

         //esto es para el formulario de busqueda dentro del TAB
         /* var str = $( "#buseta_bitacoraalmacen_filter__token" ).querystring();
            alert( str );
         var busqueda =  '?buseta_bitacoraalmacen_filter[tipoMovimiento]=V+' +
                        '&buseta_bitacoraalmacen_filter[alma]='+ document.getElementById("buseta_bitacoraalmacen_filter_alma").text +
                        '&buseta_bitacoraalmacen_filter[producto]='+
                        '&buseta_bitacoraalmacen_filter[fechaInicio]='+
                        '&buseta_bitacoraalmacen_filter[fechaFin]='+
                        '&buseta_bitacoraalmacen_filter[_token]=_D222_QWC60UyJN_vs_pAL4T4UJgTkUoEg4ycpWTqaw';*/
        //url += encodeURI(busqueda);
        //url += '?buseta_bitacoraalmacen_filter[tipoMovimiento]=V%2B&buseta_bitacoraalmacen_filter[alma]=1&buseta_bitacoraalmacen_filter[producto]=1663&buseta_bitacoraalmacen_filter[fechaInicio]=22%2F01%2F2016&buseta_bitacoraalmacen_filter[fechaFin]=&buseta_bitacoraalmacen_filter[_token]=yVJbRU9WCl9cLi7X8OzqhllHUwN4Lj1AL71VC9NSxeI';
        if ($(this).hasClass('sortable') || $(this).hasClass('desc') || $(this).hasClass('asc') || $(this).hasClass('paginator-link')) {
            url = $(this).attr('href');
        }

        $.get(url).done(function (response, textStatus, jqXHR) {
            $(bitacoraalmacen.config_form_div_listar).html(response);
            bitacoraalmacen._start_events();
        }).fail(utils._fail).always(bitacoraalmacen._always);
    },

    _always: function (jqXHR, textStatus) {
        // remove spinning
        tabs._remove_loadding(bitacoraalmacen.config_form_nombre);
    }

};
