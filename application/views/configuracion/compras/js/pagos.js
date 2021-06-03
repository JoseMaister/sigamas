function load(){
    iniciar_daterangepicker();
    buscar();
}

function buscar(){
    var URL = base_url + "configuracion/ajax_getPagos";
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
                    if(elem.activo != "1"){
                        ren.style = "color: red;";
                    }
                    ren.insertCell().innerHTML = tab.rows.length;
                    ren.insertCell().innerHTML = elem.tipo;
                    ren.insertCell().innerHTML = elem.nombre;
                    ren.insertCell().innerHTML = paddy(elem.dia_corte, 2);
                    ren.insertCell().innerHTML = elem.fecha_vencimiento;
                    ren.insertCell().innerHTML = elem.comentarios;
                    var btns = ren.insertCell();
                    btns.innerHTML = "<button type='button' onclick='modalModificar(this)' value='" + elem.id +"' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i> Modificar</button>";
                    if(priv_gestion == "1")
                    {
                        btns.innerHTML += "<button type='button' onclick='modalFondeo(this)' value='" + elem.id +"' class='btn btn-info btn-xs'><i class='fa fa-usd'></i> Fondear</button>";
                    }
                    
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
    $('#mdlDatos').modal();

    $('#txtNombre').val("");
    $('#txtComentarios').val("");
    $('#txtDiaCorte').val(1);

    $('#single_cal').data('daterangepicker').setStartDate(moment());
    $('#single_cal').data('daterangepicker').setEndDate(moment());

    $('#txtMinimo').val("0.00");

    $('#btnNotificaciones').html("<i class='fa fa-bell'></i> Usuarios");
    $('#btnNotificaciones').val("[]");

    $('#cbActivo').iCheck('check');
}

function modalModificar(btn){
    var URL = base_url + "configuracion/ajax_getPagos";
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
                $('#txtComentarios').val(rs.comentarios);
                $('#opTipo').val(rs.tipo);
                $('#txtDiaCorte').val(rs.dia_corte);

                var notificaciones = JSON.parse(rs.notificaciones);
                var users = notificaciones.length > 0 ? (" (" + notificaciones.length + ')') : '';
                $('#btnNotificaciones').html("<i class='fa fa-bell'></i> Usuarios" + users);
                $('#txtMinimo').val(rs.minimo);
                $('#btnNotificaciones').val(rs.notificaciones);
                
                $('#single_cal').data('daterangepicker').setStartDate(moment(rs.fecha_vencimiento));
                $('#single_cal').data('daterangepicker').setEndDate(moment(rs.fecha_vencimiento));
                
                $('#cbActivo').iCheck(rs.activo == '1' ? 'check' : 'uncheck');

                $('#mdlDatos').modal();
                $('#btnEditar').show();
                $('#btnAgregar').hide();
            }
          },
    });

}

function agregar(){
    if(validacion())
    {
        var URL = base_url + "configuracion/ajax_setPagos";
        var metodo_pago = {};
        metodo_pago.id = 0;
        metodo_pago.tipo = $('#opTipo').val();
        metodo_pago.nombre = $('#txtNombre').val().trim();
        metodo_pago.comentarios = $('#txtComentarios').val().trim();
        metodo_pago.dia_corte = $('#txtDiaCorte').val();
        metodo_pago.fecha_vencimiento = $('#single_cal').val();
        metodo_pago.minimo = $('#txtMinimo').val();
        metodo_pago.notificaciones = $('#btnNotificaciones').val();
        metodo_pago.activo = $('#cbActivo').is(':checked') ? "1" : "0";

        $.ajax({
            type: "POST",
            url: URL,
            data: { metodo_pago : JSON.stringify(metodo_pago) },
            success: function(result) {
                if(result)
                {
                    new PNotify({ title: 'Nuevo Método', text: 'Se ha agregado nueva Método de Pago', type: 'success', styling: 'bootstrap3' });
                    $('#mdlDatos').modal('hide');
                    buscar();
                }
            },
        });
    }
}

function modificar(btn){
    if(validacion())
    {
        var URL = base_url + "configuracion/ajax_setPagos";
        var metodo_pago = {};
        metodo_pago.id = $(btn).val();
        metodo_pago.tipo = $('#opTipo').val();
        metodo_pago.nombre = $('#txtNombre').val().trim();
        metodo_pago.comentarios = $('#txtComentarios').val().trim();
        metodo_pago.dia_corte = $('#txtDiaCorte').val();
        metodo_pago.fecha_vencimiento = $('#single_cal').val();
        metodo_pago.minimo = $('#txtMinimo').val();
        metodo_pago.notificaciones = $('#btnNotificaciones').val();
        metodo_pago.activo = $('#cbActivo').is(':checked') ? "1" : "0";

        $.ajax({
            type: "POST",
            url: URL,
            data: { metodo_pago : JSON.stringify(metodo_pago) },
            success: function(result) {
                if(result)
                {
                    new PNotify({ title: 'Edición de método', text: 'Se ha editado Método de Pago', type: 'success', styling: 'bootstrap3' });
                    $('#mdlDatos').modal('hide');
                    buscar();
                }
            },
        });
    }
}

function modalFondeo(btn){
    var id = $(btn).val();
    $('#btnFondeo').val(id);
    $('#mdlFondeo').modal();
}

function fondear(btn){
    if(validacionFondeo())
    {
        var URL = base_url + "recursos/ajax_setFondeo";

        var id = $(btn).val();
        var monto = $('#txtMonto').val();
        
        var reg = { metodo : id, monto : monto, tipo : 'ABONO'}

        $.ajax({
            type: "POST",
            url: URL,
            data: { registro : JSON.stringify(reg) },
            success: function(result) {
                if(result)
                {
                    new PNotify({ title: 'Fondeo de Cuenta', text: 'Se ha fondeado Método de Pago', type: 'success', styling: 'bootstrap3' });
                    $('#mdlFondeo').modal('hide');
                }
            },
        });
    }
}

function mdlUsuarios(btn){
    //$('#mdlDatos').modal('hide');
    $('#tblUsuarios tbody tr').remove();
    var URL = base_url + "usuarios/ajax_getUsuarios";
    var notificaciones = JSON.parse($(btn).val());

    $.ajax({
        type: "POST",
        url: URL,
        data: { },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblUsuarios tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    var check = notificaciones.includes(parseInt(elem.id)) ? 'checked' : '';
                    ren.insertCell().innerHTML = "<input type='checkbox' value=" + elem.id + " class='flat selecc' " + check + ">";
                    ren.insertCell().innerHTML = elem.User;
                    ren.insertCell().innerHTML = elem.puesto;                    
                });

                $('.selecc').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                });

                $('#mdlUsuarios').modal();
            }
          },
    });
}

/*function eliminar(btn){
    if(confirm('¿Desea eliminar método de pago?'))
    {
        var URL = base_url + "configuracion/ajax_deletePagos";
        var id = $(btn).val();
        
        $.ajax({
            type: "POST",
            url: URL,
            data: { id : id },
            success: function(result) {
                if(result)
                {
                    new PNotify({ title: 'Eliminar Método de Pago', text: 'Se ha eliminado Método de Pago', type: 'success', styling: 'bootstrap3' });
                    buscar();
                }
            },
        });   
    }
}*/

function validacion()
{
    if(!$('#txtNombre').val().trim())
    {
        alert('El campo Nombre esta vacio');
        return false;
    }
    if(!$('#txtMinimo').val().trim())
    {
        alert('El campo Minimo esta vacio');
        return false;
    }
    if(!$('#txtComentarios').val().trim())
    {
        $('#txtComentarios').val("N/A");
    }

    return true;
}

function validacionFondeo()
{
    var monto = $('#txtMonto').val();
    /*if(monto <= 0)
    {
        alert('Ingrese una cantidad valida');
        return false;
    }*/

    return true;
}

function iniciar_daterangepicker() {

    if( typeof ($.fn.daterangepicker) === 'undefined'){ return; }
    console.log('init_daterangepicker_single_call');

    $('#single_cal').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_4"
    }, function(start, end, label) {
      console.log(start.toISOString(), end.toISOString(), label);
    });


}

function asignarNotificaciones(){
    var users = [];
    var rows = $('#tblUsuarios tbody tr');
    $.each(rows, function(i, elem){
        if($(elem).find('input').is(':checked'))
        {
            users.push(parseInt($(elem).find('input').val()));
        }
    });

    var count = users.length > 0 ? (" (" + users.length + ')') : '';
    $('#btnNotificaciones').html("<i class='fa fa-bell'></i> Usuarios" + count);
    $('#btnNotificaciones').val(JSON.stringify(users));
    $('#mdlUsuarios').modal('hide');
    
}