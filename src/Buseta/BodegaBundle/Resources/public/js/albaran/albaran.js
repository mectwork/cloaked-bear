var albaran = {
    form_id: $('div#basicos').find('form').attr('id'),
    form_name: $('div#basicos').find('form').attr('name'),
    id: '',
    _load: function () {
        $('#bodega_albaran_type_fechaMovimiento').datetimepicker({
            'format': 'DD/MM/YYYY'
        });

        $('#bodega_albaran_type_fechaContable').datetimepicker({
            'format': 'DD/MM/YYYY'
        });

        $('#bodega_albaran_type_tercero').chosen();
        $('#bodega_albaran_type_almacen').chosen();

        $('a#btn_albaran_save').on('click', albaran._save);
        albaran.id = $('input[id="' + albaran.form_id + '_id"]').val();
        if (albaran.id === '' || albaran.id === undefined) {
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

            if (href === '#lineas') {
                lineas._load();
            }
        });
    },
    _save: function (event) {
        if (event != undefined) {
            event.preventDefault();
        }

        // disable btn
        button._disable('a#btn_albaran_save');

        // add spinning to show loading process
        tabs._add_loadding('basicos');

        // PedidoCompra Id
        albaran.id = $('input[id="' + albaran.form_id + '_id"]').val();

        var albaransForm    = $('form#' + albaran.form_id),
            url             = Routing.generate('albarans_albaran_create',{});
        if(albaran.id !== '' && albaran.id !== undefined) {
            url = Routing.generate('albarans_albaran_update', {'id': albaran.id});
        }

        albaransForm.ajaxSubmit({
            success: albaran._done,
            error: utils._fail,
            complete: albaran._always,
            uploadProgress: albaran._upload,
            url: url,
            dataType: 'json'
        });
    },
    _done: function (response, textStatus, jqXHR) {
        $('form#' + albaran.form_id).replaceWith(response.view);

        if(jqXHR.status == 201) {
            $btalerts.addSuccess(response.message);
            // PedidoCompra Id
            albaran.id = $('input[id="' + albaran.form_id + '_id"]').val();
            // activate all tabs
            tabs._show_all_tabs();
        } else if(jqXHR.status == 202) {
            $btalerts.addSuccess(response.message);
        }
        $('a#btn_albaran_save').on('click', albaran._save);
    },
    _always: function() {
        // remove spinning
        tabs._remove_loadding('basicos');
        // remove progress bar
        progressBar._remove_progressBar($('input[id="' + albaran.form_id + '_foto_file"]').attr('id'));

        button._enable('a#btn_albaran_save');
    },
    _upload: function (event, position, total, percentComplete) {
        var progressBarr = $('div#basicos').find('.progress-bar')[0];
        if (progressBarr !== undefined) {
            $(progressBarr).css('width', percentComplete + '%');
            $(progressBarr).find('span').html(percentComplete + '% Completado');
        }
    }
};
