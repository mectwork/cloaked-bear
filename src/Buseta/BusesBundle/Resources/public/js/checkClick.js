function setCheckboxsEvents() {
    var checkboxs = ['barras', 'rampas', 'camaras', 'lectorCedulas', 'publicidad', 'gps', 'wifi'];

    for(var check in checkboxs) {
        $('input#' + check).unbind('click').on('click', checkboxClick);
    }
}

function checkboxClick (e) {
    var checked = $(this).is("checked"),
        id      = $(this).attr('id'),
        textarea = $('#' + autobus.form_id + '_' + id);
    if (!checked) {
        textarea.fadeOut().val("");
    } else {
        textarea.fadeIn();
    }
}

function checkedEval() {
    var checkboxs = ['barras', 'rampas', 'camaras', 'lectorCedulas', 'publicidad', 'gps', 'wifi'];
    for(var check in checkboxs) {
        var textarea = $('#' + autobus.form_id + '_' + check);
        if(!$('input#' + check).is('checked')) {
            textarea.fadeOut().val("");
        } else {
            textarea.fadeIn();
        }
    }
}
