var
    moneda = {
        element: 'select#bodega_pedido_compra_moneda',

        restore: function () {
            $(moneda.element).removeAttr('readonly');
            $(moneda.element).find('option').removeAttr('disabled').removeAttr('selected');
            $(moneda.element).find('option[value=""]').first().attr('selected','selected');
        },

        select: function (id) {
            $(moneda.element).find('option[value="' + id + '"]').first()
                .attr('selected', 'selected')
                .removeAttr('disabled');
            // Disabled because we want to select any other if needed
            //$(moneda.element).find('option[value!="' + id + '"]')
            //    .removeAttr('selected')
            //    .attr('disabled', 'disabled');

            //if ($(moneda.element).find('option[value="' + id + '"]').size() > 0) {
            //    moneda.readonly();
            //}
        },

        readonly: function () {
            $(moneda.element).attr('readonly', 'readonly');
        }
    },

    proveedor = {
        element: 'select#bodega_pedido_compra_tercero',

        findMoneda: function () {
            var idproveedor = $(proveedor.element).val();

            if (idproveedor.length === 0 || isNaN(idproveedor)) {
                moneda.restore();
                return ;
            }

            $.ajax({
                url: Routing.generate('pedidocompra_get_moneda_by_proveedor', {id: idproveedor}),
                dataType: 'JSON',
                method: 'GET'
            }).done(function (response, textStatus, jqXHR) {
                moneda.select(response.id);
            }).fail(function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 404) {
                    $btalerts.addWarning(jqXHR.responseJSON.error);
                } else if (jqXHR.status === 500) {
                    $btalerts.addWarning('Ha ocurrido un error inesperado.');
                }
            });
        },
        getElement: function() {
            return $(proveedor.element);
        }
    };
