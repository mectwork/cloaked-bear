var filtros = {
    form_id: '',
    form_name: '',
    id: '',
    _start_events: function () {
        $('a#btn_autobus_filtros_save').unbind('click');
        $('a#btn_autobus_filtros_save').on('click', filtros._save);

        filtros.form_id = $('div#filtros').find('form').attr('id');
        filtros.form_name = $('div#filtros').find('form').attr('name');

        tabs._remove_loadding('filtros');
    },
    _load: function (event) {

        if(event !== undefined) {
            event.preventDefault();
        }

        if(autobus.id == undefined)
        {
            return;
        }

        var url = Routing.generate('autobuses_autobus_filtro_new', {'id': autobus.id} );
        if($(this).hasClass('sortable') || $(this).hasClass('desc') || $(this).hasClass('asc') || $(this).hasClass('paginator-link')) {
            url = $(this).attr('href');
        }

        $.get(url).done(function (response, textStatus, jqXHR) {
            $('div#filtros').html(response);

            filtros._start_events();
        }).fail(utils._fail).always(filtros._always);

    },
    _fail: function(event) {
    },
    _save: function (event) {
        if (event != undefined) {
            event.preventDefault();
        }

        // disable btn
        button._disable('a#btn_autobus_filtros_save');

        // add spinning to show loading process
        tabs._add_loadding('filtros');

        // Autobus Id
        autobus.id = $('input[id="' + autobus.form_id + '_id"]').val();

        var filtrosForm    = $('form#' + filtros.form_id);
        
        filtrosForm.ajaxSubmit({
            success: filtros._done,
            error: utils._fail,
            complete: filtros._always,
            uploadProgress: filtros._upload,
            dataType: 'json'
        });
    },
    _done: function (response, textStatus, jqXHR) {
        $('form#' + filtros.form_id).replaceWith(response.view);
        if(jqXHR.status == 201) {
            addGlobalMessage('success', response.message);
            // Autobus Id
            autobus.id = $('input[id="' + autobus.form_id + '_id"]').val();
            // activate all tabs
            tabs._show_all_tabs();
        } else if(jqXHR.status == 202) {
            addGlobalMessage('success', response.message);
        }

        filtros._start_events();
    },
    _always: function() {
        // remove spinning
        tabs._remove_loadding('basicos');
        // remove progress bar

        button._enable('a#btn_autobus_filtros_save');
    },
    _upload: function (event, position, total, percentComplete) {
        var progressBarr = $('div#basicos').find('.progress-bar')[0];
        if (progressBarr !== undefined) {
            $(progressBarr).css('width', percentComplete + '%');
            $(progressBarr).find('span').html(percentComplete + '% Completado');
        }
    }
};