var Totales = function () {
    this.lineas = [];
    this.total = 0;

    this.addLinea = function(monto) {
        monto = parseInt(monto);
        this.lineas.push({monto: monto});
        this.total += monto;
    };

    /*this.addLinea = function(id, monto) {
     this.lineas.push({id: id, monto: monto});
     this.monto += monto;
     };*/

    this.removeLinea = function ( id ) {
        var aux = [];
        for ( var i = 0; i < this.lineas.length; i++ ) {
            if( this.lineas[i].id !== id ) {
                aux.push(this.lineas[i]);
            } else {
                this.total -= this.lineas[i].monto;
            }
        }

        this.lineas = aux;
    };

    this.countTotal = function () {
        this.total = 0;
        for ( var i = 0 ; i < this.lineas.length ; i++ ) {
            var monto = this.lineas[i].monto;
            this.total += parseInt(monto);
        }

        return this.total;
    };

    this.getTotal = function () {
        return this.total;
    }
};
var lineastotales = new Totales();

var lineas = {
    form_name: '',
    form_id: '',
    id: '',
    /**
     * Inicia los eventos en el listado de lineas para el pedido de compra
     * @private
     */
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
    /**
     * Carga el listado de lineas para el pedido de compra
     * @param event
     * @private
     */
    _load: function (event) {
        if(event !== undefined) {
            event.preventDefault();
        }

        if (pedidocompra.id == '') {
            return;
        }

        // add spinning to show loading process
        tabs._add_loadding('lineas');

        var url = Routing.generate('pedidocompra_lineas_list',{'pedidocompra': pedidocompra.id});
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

        if(pedidocompra.id === '' || pedidocompra.id === undefined) {
            return;
        }

        var url = Routing.generate('pedidocompra_lineas_new_modal', {'pedidocompra': pedidocompra.id});
        if($(this).attr('href') !== undefined && $(this).attr('href') === '#edit') {
            url = Routing.generate('pedidocompra_lineas_edit_modal', {'pedidocompra': pedidocompra.id, id:$(this).data('content')});
        }

        $.get(url)
            .done(function(response, textStatus, jqXHR){
                $('div#form_lineas_modal').replaceWith($(response.view));

                lineas.form_id = $('div#form_lineas_modal').find('form').attr('id');
                lineas.form_name = $('div#form_lineas_modal').find('form').attr('name');

                lineas._linea_start_events();

                $('div#form_lineas_modal').modal('show');
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
        $('#' + lineas.form_id + '_producto').chosen();

        $('#' + lineas.form_id + '_cantidad_pedido').change(lineas._generar_importe_linea);
        $('#' + lineas.form_id + '_producto').change(lineas._generar_importe_linea);
        $('#' + lineas.form_id + '_impuesto').change(lineas._generar_importe_linea);
        $('#' + lineas.form_id + '_porciento_descuento').on('blur', lineas._generar_importe_linea);
    },
    /**
     * Carga el modal para eliminar una linea
     * @param event
     * @private
     */
    _load_delete_modal: function(event) {
        if(event !== undefined) {
            event.preventDefault();
        }

        if(pedidocompra.id === '' || pedidocompra.id === undefined) {
            return;
        }

        var id  = $(this).data('content'),
            url = Routing.generate('pedidocompra_lineas_delete', {id: id});
        $.get(url)
            .done(function(response, textStatus, jqXHR){
                $('div#form_pedidocompralinea_delete_modal').replaceWith($(response.view));

                $('div#form_pedidocompralinea_delete_modal a#btn_pedidocompralinea_delete').on('click', lineas._save_delete_modal);
                $('div#form_pedidocompralinea_delete_modal a#btn_pedidocompralinea_cancel').on('click', function(){
                    $('div#form_pedidocompralinea_delete_modal').modal('hide');
                });

                $('div#form_pedidocompralinea_delete_modal').modal('show');
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

        //var url = Routing.generate('pedidocompra_lineas_new_modal',{'pedidocompra': pedidocompra.id}),
        //    id  = $('#' + lineas.form_id + '_id').val();
        //if(id !== '' && id !== undefined) {
        //    url = Routing.generate('pedidocompra_lineas_edit_modal',{'pedidocompra': pedidocompra.id, id: id});
        //}

        //Actualiza las nuevas lineas insertadas
        $('form#' + lineas.form_id).ajaxSubmit({
            success: lineas._done,
            error: utils._fail,
            complete: lineas._always,
            dataType: 'json'
        });
    },
    /**
     * Envia el formulario del modal para eliminar una linea
     * @param event
     * @private
     */
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

        var deleteForm = $('div#form_pedidocompralinea_delete_modal').find('form'),
            url = $(deleteForm).attr('action');

        deleteForm.ajaxSubmit({
            success: function (response, textStatus, jqXHR) {
                if(jqXHR.status == 202) {
                    addGlobalMessage('success', response.message);
                }
                $('div#form_pedidocompralinea_delete_modal').modal('hide');

                lineas._load();
                lineas._update_pedidocompra();
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
            lineas._update_pedidocompra();
            //Actualiza los valores de los campos Importes Total y Total por Lineas
            //var monto = $('#' + lineas.form_id + '_importe_linea').val();
            //
            //lineastotales.addLinea(monto);
            //var montototal = lineastotales.getTotal();
            //$('#bodega_pedido_compra_importe_total_lineas').val(montototal);
            //$('#bodega_pedido_compra_importe_total').val(montototal);
            //--Actualiza los valores de los campos Importes Total y Total por Lineas
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
    },
    /**
     * Actualiza el PedidoCompra con los nuevos valores de los importes de lineas y totales
     */
    _update_pedidocompra: function () {
        url = Routing.generate('pedidocompra_update', {'id': pedidocompra.id});

        $('form#' + pedidocompra.form_id).ajaxSubmit({
            success: pedidocompra._done,
            error: utils._fail,
            complete: pedidocompra._always,
            url: url,
            dataType: 'json'
        });
    },
    /**
     * Obtiene por linea los valores para el costo, unidad de medida y actualiza el importe de linea por el producto
     */
    _generar_importe_linea: function (event){
        var data = {
            producto_id: $('#' + lineas.form_id + '_producto').val(),
            impuesto_id: $('#' + lineas.form_id + '_impuesto').val(),
            cantidad_pedido: $('#' + lineas.form_id + '_cantidad_pedido').val(),
            precio_unitario: $('#' + lineas.form_id + '_precio_unitario').val(),
            porciento_descuento: $('#' + lineas.form_id + '_porciento_descuento').val()
        };

        $.ajax({
            type: 'GET',
            url: Routing.generate('impuesto_ajax_productos_all'),
            data: data,
            success: function(data) {
                var values = data;
                var importe_linea_text = $('#' + lineas.form_id + '_importe_linea');
                var precio_text = $('#' + lineas.form_id + '_precio_unitario');
                var uom_select = $('#' + lineas.form_id + '_uom');

                precio_text.val(values.precio);
                importe_linea_text.val(values.importeLinea);
                uom_select.val(values.uom);

                //$('#' + pedidocompra.form_id + '_importe_total_lineas').val(montototal);
            }
        });
    }
};
