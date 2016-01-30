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

    config_ruta_listar: 'bitacoraalmacen_list',

    _start_events: function () {
        $('div.paginator.row ul.pagination').find('a.paginator-link').on('click', bitacoraalmacen._load);
    },

    _load: function (event) {

        if (event !== undefined) {
            event.preventDefault();
        }

        $(bitacoraalmacen.config_form_div_listar).unblock();

        //Obtenemos el id del reporte actualmente mostrado en el show
        producto.id = $('#producto_id').val();

        if (producto.id == '') {
            return;
        }

        // add spinning to show loading process
        tabs._add_loadding(bitacoraalmacen.config_form_nombre);

        var url = Routing.generate(bitacoraalmacen.config_ruta_listar, {'id': producto.id});
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
