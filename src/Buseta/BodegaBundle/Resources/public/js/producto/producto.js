var producto = {
    form_id: $('div#basicos').find('form').attr('id'),
    form_name: $('div#basicos').find('form').attr('name'),
    id: '',
    _load: function () {
        $('a#btn_producto_save').on('click', producto._save);

        producto.id = $('input[id="' + producto.form_id + '_id"]').val();
        if (producto.id === '' || producto.id === undefined) {
            // hide all tabs on page load
            $('a[data-toggle="tab"]').each(function(key, item) {
                if($(item).attr('href') != '#basicos') {
                    $(item).parent().hide();
                }
            });
        } else {
            tabs._show_all_tabs();
        }

        // on show tab events
        $('a[data-toggle="tab"]').unbind('show.bs.tab');
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            var href = $(e.target).attr('href');
            var relhref = $(e.relatedTarget).attr('href');

            if (href === '#precios') {
                precios._load();
            }
            if (href === '#costos') {
                costos._load();
            }

        });

        $('#' + producto.form_id + '_grupo').on('change', function () {
            var data = {
                grupo_id: $(this).val()
            };

            //Select dependientes entre Grupos y Subgrupos
            $.ajax({
                type: 'GET',
                url: Routing.generate('producto_ajax_grupos_subgrupos'),
                data: data,
                success: function(data) {
                    var values = $.parseJSON(data);
                    var $subgrupo_selector = $('#' + producto.form_id + '_subgrupo');

                    $subgrupo_selector.html('<option value="">---Seleccione---</option>');

                    for (var i=0, total = values.length; i < total; i++) {
                        $subgrupo_selector.append('<option value="' + values[i].id + '">' + values[i].valor + '</option>');
                    }
                }
            });
        });
    },
    _save: function (event) {
        if (event != undefined) {
            event.preventDefault();
        }

        // disable btn
        button._disable('a#btn_producto_save');

        // add spinning to show loading process
        tabs._add_loadding('basicos');

        // Producto Id
        producto.id = $('input[id="' + producto.form_id + '_id"]').val();

        var productosForm    = $('form#' + producto.form_id),
            url             = Routing.generate('productos_producto_create',{});
        if(producto.id !== '' && producto.id !== undefined) {
            url = Routing.generate('productos_producto_update', {'id': producto.id});
        }

        productosForm.ajaxSubmit({
            success: producto._done,
            error: utils._fail,
            complete: producto._always,
            uploadProgress: producto._upload,
            url: url,
            dataType: 'json'
        });
    },
    _done: function (response, textStatus, jqXHR) {
        $('form#' + producto.form_id).replaceWith(response.view);

        if(jqXHR.status == 201 || jqXHR.status == 202) {
            addGlobalMessage('success', response.message);
        }
        producto._load();
    },
    _always: function() {
        // remove spinning
        tabs._remove_loadding('basicos');
        // remove progress bar

        button._enable('a#btn_producto_save');
    },
    _upload: function (event, position, total, percentComplete) {
        var progressBarr = $('div#basicos').find('.progress-bar')[0];
        if (progressBarr !== undefined) {
            $(progressBarr).css('width', percentComplete + '%');
            $(progressBarr).find('span').html(percentComplete + '% Completado');
        }
    }
};
