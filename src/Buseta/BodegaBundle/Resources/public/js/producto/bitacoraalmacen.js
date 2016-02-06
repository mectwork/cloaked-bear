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
        //$('form#filter_form').on('submit', bitacoraalmacen._load );
        $('form#filter_form').on( 'submit',bitacoraalmacen._load );
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

        //Aqui todo lo del formulario de busqueda interno del tab
        //la query es un string con los parametros del formulario a pasar por GET para el filtro
        var query =  $('form#filter_form').serialize();
        if ( query !== undefined && query != '' ) {
            url += '?' + query;
        }

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
