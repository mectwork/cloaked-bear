/**
 * Created by rei on 26/01/16.
 */
<!-- bitacoraseriales script -->
var bitacoraseriales = {

    form_id: '',
    id: '',

    //configuraciones
    config_form_nombre: 'bitacoraseriales',

    config_form_div_listar: 'div#bitacoraseriales',

    config_ruta_listar: 'bitacoraserial_listarpor_bitacoraalmacen',

    _start_events: function () {
        $('div.paginator.row ul.pagination').find('a.paginator-link').on('click', bitacoraseriales._load);
    },

    _load: function (event) {

        if (event !== undefined) {
            event.preventDefault();
        }

        //Obtenemos el id del reporte actualmente mostrado en el show
        bitacoraalmacen.id = $('#bitacoraalmacen_id').val();

        if (bitacoraalmacen.id == '') {
            return;
        }

        // add spinning to show loading process
        tabs._add_loadding(bitacoraseriales.config_form_nombre);

        var url = Routing.generate(bitacoraseriales.config_ruta_listar, {'id': bitacoraalmacen.id});
        if ($(this).hasClass('sortable') || $(this).hasClass('desc') || $(this).hasClass('asc') || $(this).hasClass('paginator-link')) {
            url = $(this).attr('href');
        }

        $.get(url).done(function (response, textStatus, jqXHR) {
            $(bitacoraseriales.config_form_div_listar).html(response);
            bitacoraseriales._start_events();
        }).fail(utils._fail).always(bitacoraseriales._always);
    },

    _always: function (jqXHR, textStatus) {
        // remove spinning
        tabs._remove_loadding(bitacoraseriales.config_form_nombre);
    }

};
