var lineas = {
    form_name: '',
    form_id: '',
    id: '',
    _start_events: function () {
        $('a[href="#form_lineas_modal"]').on('click', lineas._load_modal);
        // Paginator sort
        $('table.lineas_records_list').find('a.sortable, a.asc, a.desc').on('click', lineas._load);
        // Table addresses actions
        $('table.lineas_records_list').find('a[href="#edit"]').on('click', lineas._load_modal);
        $('table.lineas_records_list').find('a[href="#delete"]').on('click', lineas._load_delete_modal);
        // Paginator navigation
        $('div.lineas-paginator.row ul.pagination').find('a.paginator-link').on('click', lineas._load);
    },
    _load: function (event) {

        if(event !== undefined) {
            event.preventDefault();
        }

        if (albaran.id == '') {
            return;
        }

        // add spinning to show loading process
        tabs._add_loadding('lineas');

        var url = Routing.generate('albaran_lineas_list',{'albaran': albaran.id});
        if($(this).hasClass('sortable') || $(this).hasClass('desc') || $(this).hasClass('asc') || $(this).hasClass('paginator-link')) {
            url = $(this).attr('href');
        }

        $.get(url).done(function (response, textStatus, jqXHR) {
            $('div#lineas').html(response);

            lineas._start_events();
        }).fail(utils._fail).always(lineas._always);
    },
    /**
     * Carga el modal para crear/editar una linea
     * @param event
     * @private
     */
    _load_modal: function(event) {
        if(event !== undefined) {
            event.preventDefault();
        }

        if(albaran.id === '' || albaran.id === undefined) {
            return;
        }

        var url = Routing.generate('albaran_lineas_new_modal', {'albaran': albaran.id});
        if($(this).attr('href') !== undefined && $(this).attr('href') === '#edit') {
            url = Routing.generate('albaran_lineas_edit_modal', {'albaran': albaran.id, id:$(this).data('content')});
        }

        $.get(url)
            .done(function(response, textStatus, jqXHR){
                $('div#form_lineas_modal').replaceWith($(response.view));

                lineas.form_id = $('div#form_lineas_modal').find('form').attr('id');
                lineas.form_name = $('div#form_lineas_modal').find('form').attr('name');

                $('div#form_lineas_modal').modal('show');
                lineas._linea_start_events();
            }).fail(utils._fail).always(function(){});
    },
    /**
     * Actualiza los eventos para el modal de lineas
     * @private
     */
    _linea_start_events: function () {
        $('a#btn_lineas_save').unbind('click');
        $('a#btn_lineas_save').on('click',  lineas._save_modal);

        $('a#btn_lineas_cancel').unbind('click');
        $('a#btn_lineas_cancel').on('click', function(){
            $('div#form_lineas_modal').modal('hide');
        });

        // Chosen
        $('#' + lineas.form_id + '_producto').chosen({ alt_search: true });
        $('#' + lineas.form_id + '_almacen').chosen({ alt_search: true });
    },
    _load_delete_modal: function(event) {
        if(event !== undefined) {
            event.preventDefault();
        }

        if(albaran.id === '' || albaran.id === undefined) {
            return;
        }

        var id  = $(this).data('content'),
            url = Routing.generate('albaran_lineas_delete', {id: id});
        $.get(url)
            .done(function(response, textStatus, jqXHR){
                $('div#form_albaranlinea_delete_modal').replaceWith($(response.view));

                $('div#form_albaranlinea_delete_modal a#btn_albaranlinea_delete').on('click', lineas._save_delete_modal);
                $('div#form_albaranlinea_delete_modal a#btn_albaranlinea_cancel').on('click', function(){
                    $('div#form_albaranlinea_delete_modal').modal('hide');
                });

                $('div#form_albaranlinea_delete_modal').modal('show');
            }).fail(utils._fail).always(function(){});
    },
    /**
     * Salva el modal para crear/editar una linea
     * @param event
     * @private
     */
    _save_modal: function (event) {
        if(event != undefined) {
            event.preventDefault();
        }

        $('#btn_lineas_save').find('span')
            .removeClass('glyphicon')
            .removeClass('glyphicon-save')
            .addClass('fa')
            .addClass('fa-gear')
            .addClass('fa-spin');

        //Actualiza las nuevas lineas insertadas
        $('form#' + lineas.form_id).ajaxSubmit({
            success: lineas._done,
            error: utils._fail,
            complete: lineas._always,
            dataType: 'json'
        });
    },
    _save_delete_modal: function (event) {
        if(event != undefined) {
            event.preventDefault();
        }

        $('#btn_lineas_delete').find('span')
            .removeClass('glyphicon')
            .removeClass('glyphicon-trash')
            .addClass('fa')
            .addClass('fa-gear')
            .addClass('fa-spin');

        var deleteForm = $('div#form_albaranlinea_delete_modal').find('form'),
            url = $(deleteForm).attr('action');

        deleteForm.ajaxSubmit({
            success: function (response, textStatus, jqXHR) {
                if(jqXHR.status == 202) {
                    addGlobalMessage('success', response.message);
                }
                $('div#form_albaranlinea_delete_modal').modal('hide');

                lineas._load();
            },
            error: utils._fail,
            complete: lineas._always,
            url: url,
            dataType: 'json'
        });
    },
    _done: function (response, textStatus, jqXHR) {

        $('form#' + lineas.form_id).replaceWith($(response.view).find('form'));

        if(jqXHR.status == 201 || jqXHR.status == 202) {
            addGlobalMessage('success', response.message);

            $('div#form_lineas_modal').modal('hide');
            lineas._load();
        } else {
            lineas._linea_start_events();
        }

    },
    _always: function(jqXHR, textStatus) {
        // remove spinning
        tabs._remove_loadding('lineas');
        $('a[id^="btn_lineas_"]').find('span')
            .addClass('glyphicon')
            .addClass('glyphicon-save')
            .removeClass('fa')
            .removeClass('fa-gear')
            .removeClass('fa-spin');
    }
};