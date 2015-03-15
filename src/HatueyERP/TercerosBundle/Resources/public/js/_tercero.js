
$('.add-btn-address').tooltip();
$('.add-btn-address').on('click', function(e) {
    e.preventDefault();
    $('#formAddressModal').modal('show');
});

$('.modal#formAddressModal a.submit').on('click', function(e) {
    e.preventDefault();

    var $form = $('.modal#formAddressModal').find('form');
    var data = $form.serialize();

    $.ajax({
        url: $form.prop('action'),
        type: 'POST',
        data: data
    }).done(function(response) {
        //console.log(response);
        //var json_response = JSON.parse(response);
        if (undefined != response.success) {
            $.gritter.add({
                title: 'Satisfactorio',
                text: response.success,
                class_name: 'gritter-light'
            });

            $('#formAddressModal').modal('hide');

            // estableciendo valor como seleccionado
            refreshAddresses(response.id);
        } else {
            $form.replaceWith($(response.form));
        }
    }).fail(function(error) {
        var json = JSON.parse(error.responseText);

        $.gritter.add({
            title: 'Error',
            text: json.error,
            class_name: 'gritter-'
        });
    })
    ;

});

function refreshAddresses(selected)
{
    $.get(Routing.generate('terceros_direccion_getall_json', {'_format': 'json'}), function(response) {
        var address_select = $('#hatueyerp_tercerosbundle_tercero_persona_direccion');
        address_select.find('option[value="\d"]').remove();

        $.each(response, function(key, options){
            var id = options.id;
            var value = options.value;
            address_select.append($('<option value="'+ id +'">'+ value +'</option>'));
        });

        if (selected != undefined) {
            address_select.find('option[value="'+selected+'"]').prop('selected','selected');
            address_select.val(selected);
        }
    });
}