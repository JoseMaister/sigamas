function load(){
    buscar();
}

function buscar(){
    var URL = base_url + "bitacora/ajax_getLog";
    $('#tabla tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { },
        success: function(result) {
            if(result)
            {
                var tab = $('#tabla tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);

                    ren.dataset.id = elem.id;
                    ren.insertCell().innerHTML = elem.id
                    ren.insertCell().innerHTML = elem.fecha;
                    ren.insertCell().innerHTML = elem.modulo;
                    ren.insertCell().innerHTML = elem.descripcion;
                });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}