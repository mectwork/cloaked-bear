localChange()
$("#hatueysoft_secuencia_type_tipo").change(localChange);


function localChange() {

    var tipo = $("#hatueysoft_secuencia_type_tipo");

    if(tipo.val() == 'incremental') {
        $('#fija').fadeOut();
        $('#hatueysoft_secuencia_type_relleno').val("");
        $('#hatueysoft_secuencia_type_siguienteValor').val("");
        $('#hatueysoft_secuencia_type_cantidadIncrementar').val("");
        $('#hatueysoft_secuencia_type_cantidadRelleno').val("");
        $('#incremental').fadeIn();

    }
    else if (tipo.val() == 'fija') {
        $('#incremental').fadeOut();
        $('#hatueysoft_secuencia_type_codigo').val("");
        $('#fija').fadeIn();
    }
    else {
        $('#hatueysoft_secuencia_type_relleno').val("");
        $('#hatueysoft_secuencia_type_siguienteValor').val("");
        $('#hatueysoft_secuencia_type_cantidadIncrementar').val("");
        $('#hatueysoft_secuencia_type_cantidadRelleno').val("");
        $('#hatueysoft_secuencia_type_codigo').val("");
        $('#incremental').fadeOut();
        $('#fija').fadeOut();
    }
}
