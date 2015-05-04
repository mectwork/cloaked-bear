var precios = {
    form_name: '',
    form_id: '',
    id: '',
    _start_events: function () {
        $('a[href="#form_precios_modal"]').on('click', precios._load_modal);
        // Paginator sort
        $('table.precios_records_list').find('a.sortable, a.asc, a.desc').on('click', precios._load);
        // Table addresses actions
        $('table.precios_records_list').find('a[href="#edit"]').on('click', precios._load_modal);
        $('table.precios_records_list').find('a[href="#delete"]').on('click', precios._load_delete_modal);
        // Paginator navigation
        $('div.precios-paginator.row ul.pagination').find('a.paginator-link').on('click', precios._load);

    },
    _load: function (event) {
        if(event !== undefined) {
            event.preventDefault();
        }

        if (producto.id == '') {
            return;
        }

        // add spinning to show loading process
        tabs._add_loadding('precios');

        var url = Routing.generate('producto_precios_list',{'producto': producto.id});
        if($(this).hasClass('sortable') || $(this).hasClass('desc') || $(this).hasClass('asc') || $(this).hasClass('paginator-link')) {
            url = $(this).attr('href');
        }

        $.get(url).done(function (response, textStatus, jqXHR) {
            $('div#precios').html(response);

            precios._start_events();
        }).fail(utils._fail).always(precios._always);
    },
    _load_modal: function(event) {
        if(event !== undefined) {
            event.preventDefault();
        }

        if(producto.id === '' || producto.id === undefined) {
            return;
        }

        var url = Routing.generate('producto_precios_new_modal', {'producto': producto.id});
        if($(this).attr('href') !== undefined && $(this).attr('href') === '#edit') {
            url = Routing.generate('producto_precios_edit_modal', {'producto': producto.id, id:$(this).data('content')});
        }

        $.get(url)
            .done(function(response, textStatus, jqXHR){

                $('div#form_precios_modal').replaceWith($(response.view));

                precios.form_id = $('div#form_precios_modal').find('form').attr('id');
                precios.form_name = $('div#form_precios_modal').find('form').attr('name');

                //$('a#btn_precios_save').on('click', precios._save_modal);
                $('a#btn_precios_save').on('click',  precios._save_modal);

                $('a#btn_precios_cancel').on('click', function(){
                    $('div#form_precios_modal').modal('hide');
                });

                $('#' + precios.form_id + '_fechaInicio').datetimepicker({
                    'format': 'DD/MM/YYYY'
                });

                var fechaInicio = $('#' + precios.form_id + '_fechaInicio').val();
                $('input:hidden[name^="data_busqueda_movimiento_producto_type[fechaInicio]_submit"]').val(fechaInicio);

                $('#' + precios.form_id + '_fechaFin').datetimepicker({
                    'format': 'DD/MM/YYYY'
                });

                var fechaFin = $('#' + precios.form_id + '_fechaFin').val();
                $('input:hidden[name^="data_busqueda_movimiento_producto_type[fechaFin]_submit"]').val(fechaFin);

                $('#' + precios.form_id + '_fechaInicio').on("dp.change", function (e) {
                    $('#' + precios.form_id + '_fechaFin').data("DateTimePicker").setMinDate(e.date);
                });
                $('#' + precios.form_id + '_fechaFin').on("dp.change", function (e) {
                    $('#' + precios.form_id + '_fechaInicio').data("DateTimePicker").setMaxDate(e.date);
                });

                $('div#form_precios_modal').modal('show');
            }).fail(utils._fail).always(function(){});
    },
    _load_delete_modal: function(event) {
        if(event !== undefined) {
            event.preventDefault();
        }

        if(producto.id === '' || producto.id === undefined) {
            return;
        }

        var id  = $(this).data('content'),
            url = Routing.generate('producto_precios_delete', {id: id});
        $.get(url)
            .done(function(response, textStatus, jqXHR){
                $('div#form_precios_delete_modal').replaceWith($(response.view));

                $('div#form_precios_delete_modal a#btn_precios_delete').on('click', precios._save_delete_modal);
                $('div#form_precios_delete_modal a#btn_precios_cancel').on('click', function(){
                    $('div#form_precios_delete_modal').modal('hide');
                });

                $('div#form_precios_delete_modal').modal('show');
            }).fail(utils._fail).always(function(){});
    },
    _save_modal: function (event) {

        if(event != undefined) {
            event.preventDefault();
        }

        $('#btn_precios_save').find('span')
            .removeClass('glyphicon')
            .removeClass('glyphicon-save')
            .addClass('fa')
            .addClass('fa-gear')
            .addClass('fa-spin');

        var url = Routing.generate('producto_precios_new_modal',{'producto': producto.id}),
            id  = $('#' + precios.form_id + '_id').val();
        if(id !== '' && id !== undefined) {
            url = Routing.generate('producto_precios_edit_modal',{'producto': producto.id, id: id});
        }

        $('form#' + precios.form_id).ajaxSubmit({
            success: precios._done,
            error: utils._fail,
            complete: precios._always,
            url: url,
            dataType: 'json'
        });
    },
    _save_delete_modal: function (event) {
        if(event != undefined) {
            event.preventDefault();
        }

        $('#btn_precios_delete').find('span')
            .removeClass('glyphicon')
            .removeClass('glyphicon-trash')
            .addClass('fa')
            .addClass('fa-gear')
            .addClass('fa-spin');

        var deleteForm = $('div#form_precios_delete_modal').find('form'),
            url = $(deleteForm).attr('action');

        deleteForm.ajaxSubmit({
            success: function (response, textStatus, jqXHR) {
                if(jqXHR.status == 202) {
                    addGlobalMessage('success', response.message);
                }
                $('div#form_precios_delete_modal').modal('hide');
                precios._load();
            },
            error: utils._fail,
            complete: precios._always,
            url: url,
            dataType: 'json'
        });
    },
    _done: function (response, textStatus, jqXHR) {
        $('form#' + precios.form_id).replaceWith($(response.view).find('form'));

        if(jqXHR.status == 201 || jqXHR.status == 202) {
            addGlobalMessage('success', response.message);

            $('div#form_precios_modal').modal('hide');
            precios._load();
        }
    },
    _always: function(jqXHR, textStatus) {
        // remove spinning
        tabs._remove_loadding('precios');
        $('a[id^="btn_precios_"]').find('span')
            .addClass('glyphicon')
            .addClass('glyphicon-save')
            .removeClass('fa')
            .removeClass('fa-gear')
            .removeClass('fa-spin');
    }
};
