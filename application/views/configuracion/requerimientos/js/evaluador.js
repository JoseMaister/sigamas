var DEFAULT = 0;

function load(){
    eventos();
    cargarEvaluador();
}

function eventos(){
    $("#opEvaluadores").on('change', function(){
        $('#btnGuardar').fadeIn();
    });
}

function cargarEvaluador(){
    var URL = base_url + "configuracion/ajax_getEvaluador";
    
    $.ajax({
        type: "POST",
        url: URL,
        data: { },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                DEFAULT = rs.evaluador_default;
                cargarEvaluadores();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function cargarEvaluadores(){
    var URL = base_url + "requerimientos/ajax_getEvaluadores";
    
    $.ajax({
        type: "POST",
        url: URL,
        data: { },
        success: function(result) {
            if(result)
            {
                $('#opEvaluadores option').remove();

                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var option = new Option(elem.User, elem.id);
                    $('#opEvaluadores').append(option);
                });

                $("#opEvaluadores").val(DEFAULT);
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function guardarCambios(){
    var URL = base_url + "configuracion/ajax_setEvaluador";

    var id = $("#opEvaluadores").val();

    if(!id)
    {
        alert('Seleccione evaluador');
        return;
    }

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            if(result)
            {
                new PNotify({ title: 'Evaluador', text: 'Se han guardado los cambios', type: 'success', styling: 'bootstrap3' });
                $('#btnGuardar').fadeOut();
            }
        },
    });
}
