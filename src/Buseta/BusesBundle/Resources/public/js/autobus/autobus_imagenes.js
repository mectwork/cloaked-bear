var imagenes = {
    form_id: '',
    form_name: '',
    id: '',
    _start_events: function () {
        $('a#btn_autobus_imagenes_save').unbind('click');
        $('a#btn_autobus_imagenes_save').on('click', imagenes._save);

        imagenes.form_id = $('div#imagenes').find('form').attr('id');
        imagenes.form_name = $('div#imagenes').find('form').attr('name');

        tabs._remove_loadding('imagenes');

        $('a.thumbnail').on('click', function (e) {
            e.preventDefault();

            var nombre = $(this).attr('id');

            $('input[type="file"][id="' + imagenes.form_id + '_' + nombre + '_file"]').trigger('click');
        });

    },
    _load: function (event) {
        if(event !== undefined) {
            event.preventDefault();
        }

        if(autobus.id == undefined)
        {
            return;
        }

        var url = Routing.generate('autobuses_autobus_imagenes_new', {'id': autobus.id} );
        if($(this).hasClass('sortable') || $(this).hasClass('desc') || $(this).hasClass('asc') || $(this).hasClass('paginator-link')) {
            url = $(this).attr('href');
        }

        $.get(url).done(function (response, textStatus, jqXHR) {
            $('div#imagenes').html(response);

            imagenes._start_events();
        }).fail(utils._fail).always(imagenes._always);

    },
    _fail: function(event) {
    },
    _save: function (event) {
        if (event != undefined) {
            event.preventDefault();
        }

        // disable btn
        button._disable('a#btn_autobus_imagenes_save');

        // add spinning to show loading process
        tabs._add_loadding('imagenes');

        // Autobus Id
        autobus.id = $('input[id="' + autobus.form_id + '_id"]').val();

        var imagenesForm    = $('form#' + imagenes.form_id);

        imagenesForm.ajaxSubmit({
            success: imagenes._done,
            error: utils._fail,
            complete: imagenes._always,
            uploadProgress: imagenes._upload,
            dataType: 'json'
        });
    },
    _done: function (response, textStatus, jqXHR) {
        $('form#' + imagenes.form_id).replaceWith(response.view);
        if(jqXHR.status == 201) {
            $btalerts.addSuccess(response.message);
            // Autobus Id
            autobus.id = $('input[id="' + autobus.form_id + '_id"]').val();
            // activate all tabs
            tabs._show_all_tabs();
        } else if(jqXHR.status == 202) {
            $btalerts.addSuccess(response.message);
        }

        imagenes._start_events();
    },
    _always: function() {
        // remove spinning
        tabs._remove_loadding('basicos');
        // remove progress bar

        button._enable('a#btn_autobus_imagenes_save');
    },
    _upload: function (event, position, total, percentComplete) {
        var progressBarr = $('div#basicos').find('.progress-bar')[0];
        if (progressBarr !== undefined) {
            $(progressBarr).css('width', percentComplete + '%');
            $(progressBarr).find('span').html(percentComplete + '% Completado');
        }
    }
};
