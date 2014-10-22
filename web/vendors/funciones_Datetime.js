$(function() {
    var dates = $( "#buseta_tallerbundle_tarea_adicional_fecha_estimada" ).datepicker({
        defaultDate: "+1w",        
        maxDate: "today+1D",
        showButtonPanel: true,        
        numberOfMonths: 1,
        showOtherMonths: true,
        selectOtherMonths: true
    });
});