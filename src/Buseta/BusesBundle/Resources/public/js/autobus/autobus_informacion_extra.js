var extra = {
    form_id: '',
    form_name: '',
    id: '',
    _start_events: function () {
        $('a#btn_autobus_extra_save').unbind('click');
        $('a#btn_autobus_extra_save').on('click', extra._save);

        extra.form_id = $('div#informacionextra').find('form').attr('id');
        extra.form_name = $('div#informacionextra').find('form').attr('name');

        tabs._remove_loadding('informacionextra');
    },
    _load: function (event) {

        if(event !== undefined) {
            event.preventDefault();
        }

        if(autobus.id == undefined)
        {
            return;
        }

        var url = Routing.generate('autobuses_autobus_informacionextra_new', {'id': autobus.id} );
        if($(this).hasClass('sortable') || $(this).hasClass('desc') || $(this).hasClass('asc') || $(this).hasClass('paginator-link')) {
            url = $(this).attr('href');
        }

        $.get(url).done(function (response, textStatus, jqXHR) {
            $('div#informacionextra').html(response);

            extra._start_events();
        }).fail(utils._fail).always(extra._always);

    },
    _fail: function(event) {
        console.log("asdasd");
    },
    _save: function (event) {
        if (event != undefined) {
            event.preventDefault();
        }

        // disable btn
        button._disable('a#btn_autobus_extra_save');

        // add spinning to show loading process
        tabs._add_loadding('informacionextra');

        // Autobus Id
        autobus.id = $('input[id="' + autobus.form_id + '_id"]').val();

        var extraForm    = $('form#' + extra.form_id);
        /*if(autobus.id !== '' && autobus.id !== undefined) {
            url = Routing.generate('autobuses_autobus_informacionextra_create', {'id': autobus.id});
        }*/

        extraForm.ajaxSubmit({
            success: extra._done,
            error: utils._fail,
            complete: extra._always,
            uploadProgress: extra._upload,
            dataType: 'json'
        });
    },
    _done: function (response, textStatus, jqXHR) {
        $('form#' + extra.form_id).replaceWith(response.view);
        if(jqXHR.status == 201) {
            $btalerts.addSuccess(response.message);
            // Autobus Id
            autobus.id = $('input[id="' + autobus.form_id + '_id"]').val();
            // activate all tabs
            tabs._show_all_tabs();
        } else if(jqXHR.status == 202) {
            $btalerts.addSuccess(response.message);
        }

        extra._start_events();
    },
    _always: function() {
        // remove spinning
        tabs._remove_loadding('basicos');
        // remove progress bar
        progressBar._remove_progressBar($('input[id="' + extra.form_id + '_foto_file"]').attr('id'));

        button._enable('a#btn_autobus_extra_save');
    },
    _upload: function (event, position, total, percentComplete) {
        var progressBarr = $('div#basicos').find('.progress-bar')[0];
        if (progressBarr !== undefined) {
            $(progressBarr).css('width', percentComplete + '%');
            $(progressBarr).find('span').html(percentComplete + '% Completado');
        }
    }
};
