var PREFIJO;

function load(){
    buscar();
}

function buscar(){
    var URL = base_url + "configuracion/ajax_getMagnitudes";
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
                    ren.insertCell(0).innerHTML = tab.rows.length;
                    ren.insertCell(1).innerHTML = elem.magnitud;
                    ren.insertCell(2).innerHTML = elem.prefijo;
                    ren.insertCell(3).innerHTML = "<button type='button' onclick='modalModificar(this)' value='" + elem.id +"' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i> Modificar</button><button type='button' onclick='eliminar(this)' value='" + elem.id +"' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> Eliminar</button>";
                });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
      });
}

function modalAgregar(){
    $('#btnEditar').hide();
    $('#btnAgregar').show();
    $('#mdl').modal();

    PREFIJO = "";
    $('#txtMagnitud').val("");
    $('#txtPrefijo').val("");
}

function agregar(){
    if(validacion())
    {
        var URL = base_url + "configuracion/ajax_setMagnitudes";
        var magnitud = $('#txtMagnitud').val().trim();
        var prefijo = $('#txtPrefijo').val().trim();

        $.ajax({
            type: "POST",
            url: URL,
            data: { magnitud : magnitud, prefijo : prefijo },
            success: function(result) {
                if(result)
                {
                    new PNotify({ title: 'Nueva Magnitud', text: 'Se ha agregado nueva Magnitud', type: 'success', styling: 'bootstrap3' });
                    $('#mdl').modal('hide');
                    buscar();
                }
            },
        });
    }
}

function modalModificar(btn){
    var URL = base_url + "configuracion/ajax_getMagnitudes";
    var id = $(btn).val();

    $('#btnAgregar').hide();
    $('#btnEditar').show();
    $('#btnEditar').val(id);

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                PREFIJO = rs.prefijo;
                
                $('#txtMagnitud').val(rs.magnitud);
                $('#txtPrefijo').val(PREFIJO);

                $('#mdl').modal();
                $('#btnEditar').show();
            }
          },
      });

}

function modificar(btn){
    if(validacion())
    {
        var URL = base_url + "configuracion/ajax_setMagnitudes";

        var id = $(btn).val();
        var magnitud = $('#txtMagnitud').val();
        var prefijo = $('#txtPrefijo').val();

        $.ajax({
            type: "POST",
            url: URL,
            data: { id : id, magnitud : magnitud, prefijo : prefijo },
            success: function(result) {
                if(result)
                {
                    new PNotify({ title: 'Edición de Magnitud', text: 'Se ha editado magnitud', type: 'success', styling: 'bootstrap3' });
                    $('#mdl').modal('hide');
                    buscar();
                }
            },
        });
    }
}

function eliminar(btn){
    if(confirm('¿Desea eliminar magnitud?'))
    {
        var URL = base_url + "configuracion/ajax_deleteMagnitudes";
        var id = $(btn).val();

        $.ajax({
            type: "POST",
            url: URL,
            data: { id : id },
            success: function(result) {
                if(result)
                {
                    new PNotify({ title: 'Eliminar Magnitud', text: 'Se ha eliminado Magnitud', type: 'success', styling: 'bootstrap3' });
                    buscar();
                }
            },
        });   
    }
}

function prefijoExist(prefijo){
    var URL = base_url + "configuracion/ajax_prefijoExists";
    var prefijo = $('#txtPrefijo').val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { prefijo : prefijo },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                if(rs.Qty > 0)
                {
                    new PNotify({ title: 'Prefijo Existente', text: 'Prefijo: ' + prefijo + ' ya existe', type: 'warning', styling: 'bootstrap3' });
                    return true;
                }
                else{
                    return false;
                }
            }
        },
    });
}

function validacion()
{
    if(!$('#txtMagnitud').val().trim())
    {
        alert('El campo de Magnitud esta vacio');
        return false;
    }
    if($('#txtPrefijo').val().length != 3)
    {
        alert('El campo Prefijo debe contener 3 caracteres');
        return false;
    }

    var prefijo = $('#txtPrefijo').val().trim();

    if(prefijo != PREFIJO)
    {
        return !prefijoExist(prefijo);
    }
    else{
        return true;
    }
}
