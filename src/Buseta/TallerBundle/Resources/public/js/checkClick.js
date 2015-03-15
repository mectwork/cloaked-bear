/**
 * Created by julio on 5/03/15.
 */

localChange()
$("#buseta_tallerbundle_reporte_esUsuario").click(localChange);

function localChange(){
    esUsuario = $("#buseta_tallerbundle_reporte_esUsuario:checked").is(":empty");

    if(!esUsuario){
        $('#buseta_tallerbundle_reporte_nombrePersona').val("");
        $('#buseta_tallerbundle_reporte_nombrePersona').fadeOut();
        $('label[for*="buseta_tallerbundle_reporte_nombrePersona"]').fadeOut();

        $('#buseta_tallerbundle_reporte_emailPersona').val("");
        $('#buseta_tallerbundle_reporte_emailPersona').fadeOut();
        $('label[for*="buseta_tallerbundle_reporte_emailPersona"]').fadeOut();

        $('#buseta_tallerbundle_reporte_telefonoPersona').val("");
        $('#buseta_tallerbundle_reporte_telefonoPersona').fadeOut();
        $('label[for*="buseta_tallerbundle_reporte_telefonoPersona"]').fadeOut();
    }else{
        $('#buseta_tallerbundle_reporte_nombrePersona').fadeIn();
        $('label[for*="buseta_tallerbundle_reporte_nombrePersona"]').fadeIn();

        $('#buseta_tallerbundle_reporte_emailPersona').fadeIn();
        $('label[for*="buseta_tallerbundle_reporte_emailPersona"]').fadeIn();

        $('#buseta_tallerbundle_reporte_telefonoPersona').fadeIn();
        $('label[for*="buseta_tallerbundle_reporte_telefonoPersona"]').fadeIn();
    }


}