var autobus = {
    form_id: $('div#basicos').find('form').attr('id'),
    form_name: $('div#basicos').find('form').attr('name'),
    id: '',
    _start_evens: function () {
        $('#buses_autobus_basico_fechaIngreso').datetimepicker({
            'format': 'DD/MM/YYYY'
        });
        $('#buses_autobus_basico_validoHasta').datetimepicker({
            'format': 'DD/MM/YYYY'
        });

    },
    _load: function () {
        $('a#btn_autobus_save').on('click', autobus._save);
        autobus.id = $('input[id="' + autobus.form_id + '_id"]').val();
        if (autobus.id === '' || autobus.id === undefined) {
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

            if (href === '#kilometraje') {
                kilometraje._load();
            }
        });

        autobus._start_evens();
    },
    _save: function (event) {
        if (event != undefined) {
            event.preventDefault();
        }

        // disable btn
        button._disable('a#btn_autobus_save');

        // add spinning to show loading process
        tabs._add_loadding('basicos');

        // Autobus Id
        autobus.id = $('input[id="' + autobus.form_id + '_id"]').val();

        var autobusesForm    = $('form#' + autobus.form_id),
            url             = Routing.generate('autobuses_autobus_basicos_create',{});
        if(autobus.id !== '' && autobus.id !== undefined) {
            url = Routing.generate('autobus_basico_update', {'id': autobus.id});
        }

        autobusesForm.ajaxSubmit({
            success: autobus._done,
            error: utils._fail,
            complete: autobus._always,
            uploadProgress: autobus._upload,
            url: url,
            dataType: 'json'
        });
    },
    _done: function (response, textStatus, jqXHR) {
        $('form#' + autobus.form_id).replaceWith(response.view);
        if(jqXHR.status == 201) {
            addGlobalMessage('success', response.message);
            // Autobus Id
            autobus.id = $('input[id="' + autobus.form_id + '_id"]').val();
            // activate all tabs
            tabs._show_all_tabs();
        } else if(jqXHR.status == 202) {
            addGlobalMessage('success', response.message);
        }
        $('a#btn_autobus_save').on('click', autobus._save);

        autobus._start_evens();
    },
    _always: function() {
        // remove spinning
        tabs._remove_loadding('basicos');
        // remove progress bar
        progressBar._remove_progressBar($('input[id="' + autobus.form_id + '_foto_file"]').attr('id'));

        button._enable('a#btn_autobus_save');
    },
    _upload: function (event, position, total, percentComplete) {
        var progressBarr = $('div#basicos').find('.progress-bar')[0];
        if (progressBarr !== undefined) {
            $(progressBarr).css('width', percentComplete + '%');
            $(progressBarr).find('span').html(percentComplete + '% Completado');
        }
    }
};