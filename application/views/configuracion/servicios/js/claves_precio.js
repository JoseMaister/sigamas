function load(){
    buscar();
}

/*
function buscar(){
    var URL = base_url + "configuracion/ajax_getClavesPrecio";
    $('#tabla tbody tr').remove();
    
    $.ajax({
        type: "POST",
        url: URL,
        success: function(result) {
            if(result)
            {
                var tab = $('#tabla tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell(0).innerHTML = elem.id;
                    baj = ren.insertCell(1);
                    baj.innerHTML = elem.bajo;
                    alt = ren.insertCell(2);
                    alt.innerHTML = elem.alto;
                    ren.insertCell(3).innerHTML = "<button type='button' onclick='modalModificar(this)' value='" + elem.id +"' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i> Modificar</button>";

                    $(baj).formatCurrency();
                    $(alt).formatCurrency();
                });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
      });
}
*/

function buscar(){
    var URL = base_url + "configuracion/ajax_getClavesPrecio";
    $('#tabla tbody tr').remove();
    
    $.ajax({
        type: "POST",
        url: URL,
        success: function(result) {
            if(result)
            {
                var tab = $('#tabla tbody')[0];
                var rs = JSON.parse(result);
                console.log(rs);
                console.log(Object.keys(rs[0]));

                for (let index = 1; index < Object.keys(rs[0]).length; index = index + 2) {
                    var zona = Object.keys(rs[0])[index].slice(-1).toUpperCase();
                    var active = index == 1 ? 'active' : '';

                    var li = '<li class="' + active + '"><a href="#' + zona + '" data-toggle="tab">Zona ' + zona + '</a></li>';
                    $('#ulControls').append(li);

                    var p = '<div class="tab-pane ' + active + '" id="tbl' + zona + '">';
                    p +=        '<table class="table table-striped">';
                    p +=            '<thead>';
                    p +=                '<tr class="headings">';
                    p +=                    '<th style="width: 7%;" class="column-title">Nivel</th>';
                    p +=                    '<th class="column-title">Bajo</th>';
                    p +=                    '<th class="column-title">Alto</th>';
                    p +=                    '<th class="column-title">Opciones</th>';
                    p +=                '</tr>';
                    p +=            '</thead>';
                    p +=            '<tbody>';
                    p +=            '</tbody>';
                    p +=        '</table>';
                    p +=    '</div>';

                    $('#divTabs').append(p);
                }

                $.each(rs, function(i, elem){
                    
                });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function modalModificar(btn){
    var URL = base_url + "configuracion/ajax_getClavesPrecio";
    var id = $(btn).val();
    $('#btnEditar').val(id);

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                
                $('#mdlTitulo').text('Nivel ' + rs.id);
                $('#txtBajo').val(rs.bajo);
                $('#txtAlto').val(rs.alto);

                $('#mdl').modal();
                $('#btnEditar').show();
            }
          },
      });

}

function modificar(btn){
    var URL = base_url + "configuracion/ajax_setClavesPrecio";

    var id = $(btn).val();
    var bajo = $('#txtBajo').val()
    var alto = $('#txtAlto').val()

    
    if(parseInt(alto) < parseInt(bajo))
    {
        alert('Precio alto debe ser mayor que precio bajo');
        return;
    }

    $.ajax({
        type: "POST",
        url: URL,
        data: { bajo : bajo, alto : alto, id : id },
        success: function(result) {
            if(result)
            {
                new PNotify({ title: 'Edición de Precios', text: 'Se ha editado nivel de precio', type: 'success', styling: 'bootstrap3' });
                $('#mdl').modal('hide');
                buscar();
            }
        },
    });
}
