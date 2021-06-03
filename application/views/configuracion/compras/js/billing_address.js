function load(){
    buscar();
}

function buscar(){
    var URL = base_url + "configuracion/ajax_getBillingAddresses";
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
                    var check = elem.default == '1' ? 'checked' : '';
                    ren.insertCell(0).innerHTML = "<input value='" + elem.id + "' type='checkbox' name='cbCheck' class='flat selecc' " + check + "/>";
                    ren.insertCell(1).innerHTML = tab.rows.length;
                    ren.insertCell(2).innerHTML = elem.nombre;
                    ren.insertCell(3).innerHTML = elem.direccion;
                    ren.insertCell(4).innerHTML = "<button type='button' onclick='modalModificar(this)' value='" + elem.id +"' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i> Modificar</button><button type='button' onclick='eliminar(this)' value='" + elem.id +"' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> Eliminar</button>";
                });

                $('input.selecc').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });

                $("input[name='cbCheck']:checked").prop('disabled', true);

                $('input.selecc').on('ifChecked', function(e){
                    $("input[name='cbCheck']").prop('disabled', false);
                    $(this).prop('disabled', true);
                    setDefault(this);
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
    $('#mdlDireccion').modal();

    $('#txtNombre').val("");
    $('#txtDireccion').val("");
}

function modalModificar(btn){
    var URL = base_url + "configuracion/ajax_getBillingAddresses";
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
                
                $('#txtNombre').val(rs.nombre);
                $('#txtDireccion').val(rs.direccion);

                $('#mdlDireccion').modal();
                $('#btnEditar').show();
                $('#btnAgregar').hide();
            }
          },
      });

}

function agregar(){
    if(validacion())
    {
        var URL = base_url + "configuracion/ajax_setBillingAddresses";
        var nombre = $('#txtNombre').val().trim();
        var direccion = $('#txtDireccion').val().trim();

        $.ajax({
            type: "POST",
            url: URL,
            data: { nombre : nombre, direccion : direccion },
            success: function(result) {
                if(result)
                {
                    new PNotify({ title: 'Nueva dirección', text: 'Se ha agregado nueva dirección', type: 'success', styling: 'bootstrap3' });
                    $('#mdlDireccion').modal('hide');
                    buscar();
                }
            },
        });
    }
}

function modificar(btn){
    if(validacion())
    {
        var URL = base_url + "configuracion/ajax_setBillingAddresses";

        var id = $(btn).val();
        var nombre = $('#txtNombre').val().trim();
        var direccion = $('#txtDireccion').val().trim();

        $.ajax({
            type: "POST",
            url: URL,
            data: { nombre : nombre, direccion : direccion, id : id },
            success: function(result) {
                if(result)
                {
                    new PNotify({ title: 'Edición de dirección', text: 'Se ha editado dirección', type: 'success', styling: 'bootstrap3' });
                    $('#mdlDireccion').modal('hide');
                    buscar();
                }
            },
        });
    }
}

function eliminar(btn){
    if(confirm('¿Desea eliminar dirección?'))
    {
        var URL = base_url + "configuracion/ajax_deleteBillingAddresses";
        var id = $(btn).val();
        
        $.ajax({
            type: "POST",
            url: URL,
            data: { id : id },
            success: function(result) {
                if(result)
                {
                    new PNotify({ title: 'Eliminar dirección', text: 'Se ha eliminado dirección', type: 'success', styling: 'bootstrap3' });
                    buscar();
                }
            },
        });   
    }
}

function validacion()
{
    if(!$('#txtNombre').val().trim())
    {
        alert('El campo de Nombre esta vacio');
        return false;
    }
    if(!$('#txtDireccion').val().trim())
    {
        alert('El campo de Dirección esta vacio');
        return false;
    }

    return true;
}

function setDefault(cb){
    var URL = base_url + "configuracion/ajax_setDefaultBillingAddresses";
    var id = $(cb).val();

    
    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            if(result)
            {
                buscar();
            }
        },
    });
}