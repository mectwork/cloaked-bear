var TreeManager = function (menuId) {
    this.menuId = menuId;
};

TreeManager.prototype = {
    init: function () {
        var self = this;
        $(this.menuId).tree({
            dataSource: this.dataSourceTree,
            multiSelect: false,
            cacheItems: false
        });
        $(this.menuId).on('selected.fu.tree', { instance: this }, this.onSelected);
        $('a[href="#add"]').off('click').on('click', function (event) {
            event.preventDefault();

            var selected = $(self.menuId).tree('selectedItems'),
                parent;
            if (selected.length == 0) {
                alert('Debe tener seleccionado al menos un elemento del árbol.');
                return;
            }

            parent = selected[0];
            $.get(Routing.generate('hatueysoft_menu_new', {parent: parent.attr.id}), function (html) {
                $('#menu_node_body').html(html);

                self.onEditEvents();
            })
        });

        $('a[href="#editCurrent"]').off('click').on('click', function (event) {
            event.preventDefault();

            var current = $('#menu_node_heading').data('current');
            if (typeof current == 'undefined' || current == 'menu') {
                return;
            }

            self.edit(current);
        });
    },

    dataSourceTree: function (options, callback) {
        var id, url;
        if (typeof options.attr !== 'undefined') {
            id = options.attr.id;
            url = Routing.generate('hatueysoft_menu_getmenu', {id: id, _format: 'json'});
        } else {
            url = Routing.generate('hatueysoft_menu_getmenu',{id: 'root', _format: 'json'});
        }

        $.getJSON(url, function (json) {
            var data = $.extend(true, [], json);
            callback({data: data});
        });
    },

    show: function (id) {
        var self = this,
            itemid,
            url = Routing.generate('hatueysoft_menu_show', {id: id}),
            selected = $(self.menuId).tree('selectedItems');

        $.getJSON(url, function (json) {
            $('#menu_node_body').html(json.view).unblock();
            itemid = json.id;

            if (selected[0].attr.id != itemid) {
                $(self.menuId).tree('selectFolder', $('#' + id));
            } else {
                $(self.menuId).tree('openFolder', $('#' + id));
            }

            self.onShowEvents();
        });
    },

    edit: function (id, type) {
        var self = this,
            url = Routing.generate('hatueysoft_menu_edit', {id: id}),
            selected = $(self.menuId).tree('selectedItems');

        if (selected[0].attr.id != id && type != "folder") {
            $(self.menuId).tree('select' + String.capitalize(type), $('#' + id));
        } else {
            $.get(url, function (html) {
                $('#menu_node_body').html(html).unblock();

                self.onEditEvents(id);
            });
        }
    },

    confirmDel: function (id) {
        var self = this,
            modal;
        $.get(Routing.generate('hatueysoft_menu_delete', {id: id}), function (html) {
            $('#modal-danger').replaceWith(html);
            modal = $('#modal-danger');
            modal.modal('show');

            modal.find('.btn.btn-danger').on('click', function (event){
                event.preventDefault();

                var form = $(this).parent().find('form');
                form.ajaxSubmit({
                    success: function (data, statusText, jqXHR) {
                        if (jqXHR.status == 202) {
                            modal.modal('hide');
                            modal.html('');

                            $btalerts.addSuccess(data);
                            self.show(id);
                        }
                    },
                    error: function (jqXHR, statusText, errorThrown) {
                        modal.modal('hide');
                        modal.html('');

                        $btalerts.addDanger(jqXHR.responseText);
                        self.show(id);
                    }
                });
            });
        });
    },

    onSelected: function (event, data) {
        var self = event.data.instance,
            text = data.target.text,
            type = data.target.type;

        $('#menu_node_heading').html(text);
        $('#menu_node_heading').data('current', data.target.attr.id);

        $('#menu_node_body').html('').block();

        if (type == 'folder') {
            self.show(data.target.attr.id);
        } else {
            self.edit(data.target.attr.id);
        }
    },

    onShowEvents: function () {
        var self = this;

        $('#menu_node_body').find('a[href="#show"]').each(function (index, element) {
            var id = $(element).data('content'),
                type = $(element).data('type');
            $(element).off('click').on('click', function (event) {
                event.preventDefault();

                self.show(id);
            });
        });
        $('#menu_node_body').find('a[href="#edit"]').each(function (index, element) {
            var id = $(element).data('content'),
                type = $(element).data('type');
            $(element).off('click').on('click', function (event) {
                event.preventDefault();

                self.edit(id, type);
            });
        });
        $('#menu_node_body').find('a[href="#delete"]').each(function (index, element) {
            var id = $(element).data('content'),
                type = $(element).data('type'),
                label = $(element).data('label');
            $(element).off('click').on('click', function (event) {
                event.preventDefault();

                self.confirmDel(id, label);
            });
        });
    },

    onEditEvents: function (id) {
        var self = this;
        if (typeof id == 'undefined') {
            id = $('#menu_node_heading').data('current');
        }

        $('#menu_node_body').find('a#menu_node_submit').first().on('click', function (event){
            event.preventDefault();

            var form = $(this).closest('form');
            form.ajaxSubmit({
                success: function (data, statusText, jqXHR) {
                    if (jqXHR.status == 200) {
                        $('#menu_node_body').html(data);
                        self.onEditEvents(id);
                    } else {
                        $btalerts.addSuccess(data);
                        self.show(id)
                    }
                },
                error: function (jqXHR, statusText, errorThrown) {
                    $btalerts.addSuccess(jqXHR.responseText);
                    self.show(id)
                }
            });
        });

        var collection = new CollectionsManager('div#hatueysoft_menu_node_type_attributes', 'a.add_attribute_link',
            'a.delete_attribute_link');
        collection.init();
    }
};
