var $switchconfig = {
    'onText': 'Sí',
    'offText': 'No'
};

var $pickadateconfig = {
    today: 'Hoy',
    clear: 'Limpiar',
    format: 'dd/mm/yyyy',
    formatSubmit: 'dd/mm/yyyy'
};

var $pickatimeconfig = {
    format: 'h:i A',
    formatLabel: 'h:i A',
    formatSubmit: 'HH:i',
    interval:10,
    clear: 'Limpiar'
};

/**
 * Actualiza el evento onclick para el link eliminar de la colección entrada por parámetros.
 *
 * @param collectionHolder
 * @param deleteLink
 */
function updateDeleteLinks(collectionHolder, deleteLink){
    $(deleteLink).on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $(this).parent().parent().remove();

        updateView(collectionHolder, deleteLink);
    });
}

/**
 * Verifica si existen elementos en la colección, en caso de ser cero muestra el tr de que la colección esta vacía.
 *
 * @param collectionHolder
 * @param deleteLink
 */
function updateView(collectionHolder, deleteLink){
    counter = collectionHolder.find(deleteLink).length;
    if(counter == 0){
        collectionHolder.find('tr.no-elements-tr').show();
    }else{
        collectionHolder.find('tr.no-elements-tr').hide();
    }
}

/**
 * Adiciona una nueva fila a la collección entrada por parámetros.
 *
 * @param collectionHolder
 */
function addCollectionForm(collectionHolder, deleteLink) {
    // Get the data-prototype explained earlier
    var prototype = collectionHolder.data('prototype');

    // get the new index
    var index = collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormDiv = $('<tr></tr>').append(newForm);
    collectionHolder.find('tbody').append($newFormDiv);

    updateDeleteLinks(collectionHolder, deleteLink);
    updateView(collectionHolder, deleteLink);
}

/**
 * Adiciona mensajes globales
 * @param type
 * @param message
 */
function addGlobalMessage(type, message) {
    var messagesHolder  = $('div#global-messages');
    var index = messagesHolder.data('index');
    if(index == undefined) {
        index = 0;
    }

    var template = '<div class="alert alert-__type__ alert-dismissable fade in" id="alert__index__"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>__message__</div>'

    var _message    = template.replace(/__type__/g, type);
    _message        = _message.replace(/__message__/g, message);
    _message        = _message.replace(/__index__/g, index);

    messagesHolder.data('index', index + 1);
    messagesHolder.append($(_message));

    $("#alert" + index).alert().delay(5000).slideToggle(500);

    setTimeout(function(){
        $("#alert" + index).remove();
    }, 6000)
}
