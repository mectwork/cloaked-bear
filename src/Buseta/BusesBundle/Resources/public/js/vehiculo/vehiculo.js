var vehiculo = {
    form_id: $('div#basicos').find('form').attr('id'),
    form_name: $('div#basicos').find('form').attr('name'),
    id: '',
    _start_evens: function () {
        $('a#btn_vehiculo_save')
            .unbind('click')
            .on('click', vehiculo._save);

    },
    _load: function () {
        vehiculo.id = $('input[id="' + vehiculo.form_id + '_id"]').val();
        if (vehiculo.id === '' || vehiculo.id === undefined) {
            // hide all tabs on page load
            $('a[data-toggle="tab"]').each(function(key, item) {
                if($(item).attr('href') != '#basicos') {
                    $(item).parent().hide();
                }
            });
        }

        // on show tab events
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            var href = $(e.target).attr('href');
            var relhref = $(e.relatedTarget).attr('href');

            if (href === '#informacionextra') {
                extra._load();
            } else if (href === '#filtros') {
                filtros._load();
            } else if (href === '#imagenes') {
                imagenes._load();
            } else if (href === '#archivosadjuntos') {
                archivoadjunto._load();
            } else if(href !== '#basicos') {
                console.error('No es una pestaña válida!!!')
            }
        });

        vehiculo._start_evens();
    },
    _save: function (event) {
        if (event != undefined) {
            event.preventDefault();
        }

        // disable btn
        button._disable('a#btn_vehiculo_save');

        // add spinning to show loading process
        tabs._add_loadding('basicos');

        // vehiculo Id
        vehiculo.id = $('input[id="' + vehiculo.form_id + '_id"]').val();

        var vehiculoesForm    = $('form#' + vehiculo.form_id),
            url             = Routing.generate('vehiculo_create',{});
        if(vehiculo.id !== '' && vehiculo.id !== undefined) {
            url = Routing.generate('vehiculo_update', {'id': vehiculo.id});
        }

        vehiculoesForm.ajaxSubmit({
            success: vehiculo._done,
            error: utils._fail,
            complete: vehiculo._always,
            uploadProgress: vehiculo._upload,
            url: url,
            dataType: 'json'
        });
    },
    _done: function (response, textStatus, jqXHR) {
        $('form#' + vehiculo.form_id).replaceWith(response.view);
        if(jqXHR.status == 201) {
            addGlobalMessage('success', response.message);
            // vehiculo Id
            vehiculo.id = $('input[id="' + vehiculo.form_id + '_id"]').val();
            // activate all tabs
            tabs._show_all_tabs();
        } else if(jqXHR.status == 202) {
            addGlobalMessage('success', response.message);
        }
        $('a#btn_vehiculo_save').on('click', vehiculo._save);

        vehiculo._start_evens();
    },
    _always: function() {
        // remove spinning
        tabs._remove_loadding('basicos');
        // remove progress bar
        progressBar._remove_progressBar($('input[id="' + vehiculo.form_id + '_foto_file"]').attr('id'));

        button._enable('a#btn_vehiculo_save');
    },
    _upload: function (event, position, total, percentComplete) {
        var progressBarr = $('div#basicos').find('.progress-bar')[0];
        if (progressBarr !== undefined) {
            $(progressBarr).css('width', percentComplete + '%');
            $(progressBarr).find('span').html(percentComplete + '% Completado');
        }
    }

};
