/**
 * Created by julio on 13/03/15.
 */
localChange()
$("input#barras").click(localChange);
$("input#rampas").click(localChange);
$("input#camaras").click(localChange);
$("input#lector").click(localChange);
$("input#publicidad").click(localChange);
$("input#gps").click(localChange);
$("input#wifi").click(localChange);

function localChange() {
    barras = $("input#barras:checked").is(":empty");
    rampas = $("input#rampas:checked").is(":empty");
    camaras = $("input#camaras:checked").is(":empty");
    publicidad = $("input#publicidad:checked").is(":empty");
    gps = $("input#gps:checked").is(":empty");
    wifi = $("input#wifi:checked").is(":empty");
    lector = $("input#lector:checked").is(":empty");

    if (!barras) {
        $('textarea#buses_autobus_basico_barras').val("");
        $('textarea#buses_autobus_basico_barras').fadeOut();
    } else {
        $('textarea#buses_autobus_basico_barras').fadeIn();
    }

    if (!rampas) {
        $('textarea#buses_autobus_basico_rampas').val("");
        $('textarea#buses_autobus_basico_rampas').fadeOut();
    } else {
        $('textarea#buses_autobus_basico_rampas').fadeIn();
    }

    if (!camaras) {
        $('textarea#buses_autobus_basico_camaras').val("");
        $('textarea#buses_autobus_basico_camaras').fadeOut();
    } else {
        $('textarea#buses_autobus_basico_camaras').fadeIn();
    }

    if (!publicidad) {
        $('textarea#buses_autobus_basico_publicidad').val("");
        $('textarea#buses_autobus_basico_publicidad').fadeOut();
    } else {
        $('textarea#buses_autobus_basico_publicidad').fadeIn();
    }

    if (!gps) {
        $('textarea#buses_autobus_basico_gps').val("");
        $('textarea#buses_autobus_basico_gps').fadeOut();
    } else {
        $('textarea#buses_autobus_basico_gps').fadeIn();
    }

    if (!wifi) {
        $('textarea#buses_autobus_basico_wifi').val("");
        $('textarea#buses_autobus_basico_wifi').fadeOut();
    } else {
        $('textarea#buses_autobus_basico_wifi').fadeIn();
    }

    if (!lector) {
        $('textarea#buses_autobus_basico_lector_cedulas').val("");
        $('textarea#buses_autobus_basico_lector_cedulas').fadeOut();
    } else {
        $('textarea#buses_autobus_basico_lector_cedulas').fadeIn();
    }

}
