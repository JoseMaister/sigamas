var CODIGO;

function load(){
    eventos();
    leerPrecios();
    buscar();

}

function eventos(){
    $('#tags_1').tagsInput({
        width: 'auto',
        height: '60px',
        defaultText: 'etiquetas',
      });

    $( '#txtBusqueda' ).on( 'keypress', function( e ) {
        if( e.keyCode === 13 ) {
            buscar();
        }
    });

    $('.cbType').on( 'ifChanged', function( e ) {
        buscar();
    });

    $("input[name='rbIntExt']").on('ifChanged', function(e){
        if($("#cbExterno").is(':checked')){
            $('#divProveedor').show();
        } else {
            $('#divProveedor').hide();
        }
        
    });

    $("#rbEspecial").on('ifChanged', function(e){

        if($(this).is(':checked')){
            if(!$('#opMagnitud').val())
            {
                alert("Seleccione Magnitud");
                $("#divServicioLigado").hide();
                setTimeout(function(){ $("#rbEspecial").iCheck('uncheck');}, 1);
            }
            else 
            {
                $("#divServicioLigado").show();
            }
            
        } else {
            $("#divServicioLigado").hide();
        }
        
    });
}

function mdlServiciosEstandar(){
    var URL = base_url + "servicios/ajax_getServicios";
    var parametro = "magnitud";
    var texto = $('#opMagnitud option:selected').text();

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto, parametro : parametro, tipo : "[]" },
        success: function(result) {
            $('#tblServiciosEstandar tbody tr').remove();
            if(result)
            {
                var tab = $('#tblServiciosEstandar tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell(0).innerHTML = elem.codigo;
                    ren.insertCell(1).innerHTML = elem.descripcion;
                    ren.insertCell(2).innerHTML = "<button type='button' data-codigo='" + elem.codigo + "' onclick='asignarEstandar(this)' value=" + elem.id + " class='btn btn-primary btn-xs'><i class='fa fa-check'></i> Asignar</button>";
                });
                $('#mdlServiciosEstandar').modal();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
    
}

function privilegios(priv){
    
    if(priv == "1"){
        $('#tabla tr th:nth-child(8), #tabla tr td:nth-child(8)').show();
        $('#btnAlta').show();
    }
    else{
        $('#tabla tr th:nth-child(8), #tabla tr td:nth-child(8)').hide();
        $('#btnAlta').hide();
    }
    
}

function buscar(){
    var URL = base_url + "servicios/ajax_getServicios";
    $('#tabla tbody tr').remove();
    
    var parametro = $("input[name=rbBusqueda]:checked").val();
    var texto = $("#txtBusqueda").val();

    var tipo = [];
    if($('#cbEstandar').is(':checked') != $('#cbEspecial').is(':checked'))
    {
        if($('#cbEstandar').is(':checked'))
        {
            tipo.push('ESTANDAR');
        }
        if($('#cbEspecial').is(':checked'))
        {
            tipo.push('ESPECIAL');
        }
    }

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto, parametro : parametro, tipo : JSON.stringify(tipo) },
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
                    ren.insertCell(0).innerHTML = elem.codigo;
                    ren.insertCell(1).innerHTML = elem.magnitud;
                    var btnComen = elem.observaciones ? "<button type='button' onclick='verObservaciones(this)' value='" + elem.observaciones + "' class='btn btn-primary btn-xs'><i class='fa fa-comments'></i></button> " : "";
                    ren.insertCell(2).innerHTML = btnComen + elem.descripcion;
                    ren.insertCell(3).innerHTML = elem.sitio;
                    ren.insertCell(4).innerHTML = elem.tipo;
                    ren.insertCell(5).innerHTML = elem.tipo_calibracion;
                    ren.insertCell(6).innerHTML = elem.interno == '1' ? 'SI' : 'NO';
                    ren.insertCell(7).innerHTML = "<button type='button' onclick='mdlModificar(this)' value=" + elem.id + " class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i> Editar</button><button tipe='button' onclick='eliminar(this)' value=" + elem.id + " class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> Eliminar</button>";
                });

                //$('div.nivelPrecio').formatCurrency();
            }
            else
            {
                new PNotify({ title: '¡Nada por aquí!', text: 'No se encontraron resultados', type: 'info', styling: 'bootstrap3' });
            }
            privilegios(adm_ser);
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function leerPrecios(){
    var URL = base_url + "configuracion/ajax_getClavesPrecio";
    $('#opPrecios option').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    //var op = new Option("<div class='nivelPrecio'>" + elem.bajo + "</div> - <div class='nivelPrecio'>" + elem.alto + "</div>", elem.id);
                    var op = new Option(elem.bajo + ' - ' + elem.alto, elem.id);
                    $('#opPrecios').append(op);
                });

            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
      });
}

function leerMagnitudes(){
    var URL = base_url + "configuracion/ajax_getMagnitudes";
    $('#opMagnitud option').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var op = new Option(elem.magnitud, elem.prefijo);
                    $('#opMagnitud').append(op);
                });

            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
      });
}

function verObservaciones(btn){
    var observaciones = $(btn).val();

    $('#lblObservaciones').text(observaciones);
    $('#mdlObservaciones').modal();
}

function mdlModificar(btn){
    var URL = base_url + "servicios/ajax_getServicio";
    var id = $(btn).val();

    $('#opMagnitud option').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                CODIGO = rs.codigo;

                var op = new Option(rs.magnitud, rs.prefijo);
                $('#opMagnitud').append(op);

                $('#lblCodigo').text(CODIGO);
                $('#txtDescripcion').val(rs.descripcion);
                $('#txtObservaciones').val(rs.observaciones);
                $('#txtProveedor').val(rs.proveedor);
                $('#opPrecios').val(rs.clave_precio);
                $('#tags_1').importTags(rs.tags);

                if(rs.tipo == 'ESTANDAR')
                {
                    $('#rbEstandar').iCheck('check');
                }
                else if(rs.tipo == 'ESPECIAL')
                {
                    $('#rbEspecial').iCheck('check');
                }

                if(rs.tipo_calibracion == 'ACREDITADA')
                {
                    $('#rbCalAcreditada').iCheck('check');
                }
                else if(rs.tipo_calibracion == 'TRAZABLE')
                {
                    $('#rbCalTrazable').iCheck('check');
                }

                $('#cbInterno').iCheck(rs.interno == "1" ? 'check' : 'uncheck');
                $('#cbActivo').iCheck(rs.activo == "1" ? 'check' : 'uncheck');


                if(rs.IdEst == 0)
                {
                    $("#divServicioLigado").hide();
                    $('#lblServicioLigado').data('id', 0);
                    $('#lblServicioLigado').data('codigo', "");
                    $('#lblServicioLigado').text('');
                }
                else{
                    $("#divServicioLigado").show();
                    $('#lblServicioLigado').data('id', rs.IdEst);
                    $('#lblServicioLigado').data('codigo', rs.CodeEst);
                    $('#lblServicioLigado').text(rs.CodeEst);
                }
                

                if(rs.sitio == 'OS/LAB')
                {
                    $('#cbOS').iCheck('check');
                    $('#cbLab').iCheck('check');
                }
                else if (rs.sitio == 'OS'){
                    $('#cbOS').iCheck('check');
                    $('#cbLab').iCheck('uncheck');
                }
                else if (rs.sitio == 'LAB'){
                    $('#cbOS').iCheck('uncheck');
                    $('#cbLab').iCheck('check');
                }

                

                
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

    $('#btnEditar').val(id);
    $('#btnEditar').show();
    $('#btnAgregar').hide();
    $('#mdlAlta').modal();
}

function modalAgregar(){
    leerMagnitudes();

    $('#btnEditar').hide();
    $('#btnAgregar').show();
    $('#mdlAlta').modal();

    CODIGO = "";
    $('#lblCodigo').text("Nuevo Servicio");
    $('#opMagnitud').val("");
    $('#rbEstandar').iCheck('uncheck');
    $('#rbEspecial').iCheck('uncheck');
    $('#rbCalAcreditada').iCheck('uncheck');
    $('#rbCalTrazable').iCheck('uncheck');

    $("#divServicioLigado").hide();
    $('#lblServicioLigado').data('id', 0);
    $('#lblServicioLigado').data('codigo', "");
    $('#lblServicioLigado').text('');

    $('#txtDescripcion').val("");
    $('#txtObservaciones').val("");
    
    $('#cbInterno').iCheck('uncheck');
    $("#txtProveedor").val("");
    $('#cbOS').iCheck('uncheck');
    $('#cbLab').iCheck('uncheck');

    $('#opPrecios').val(0);

    $("#tags_1").val("");
    $('#tags_1_tagsinput .tag').remove();

    $('#cbActivo').iCheck('uncheck');
    
}

function agregar(){
    if(validacion())
    {
        var URL = base_url + "servicios/ajax_setServicio";
        var servicio = {};
        
        servicio.id = 0;
        servicio.magnitud = $('#opMagnitud option:selected').text();
        servicio.prefijo = $('#opMagnitud').val();
        servicio.descripcion = $('#txtDescripcion').val();
        servicio.observaciones = $('#txtObservaciones').val();
        servicio.proveedor = $('#txtProveedor').val();
        servicio.tags = $('#tags_1').val();


        if($('#cbOS').is(':checked') && $('#cbLab').is(':checked'))
        {
            servicio.sitio = 'OS/LAB';
        }
        else if($('#cbOS').is(':checked'))
        {
            servicio.sitio = 'OS';
        }
        else
        {
            servicio.sitio = 'LAB';
        }        
        servicio.tipo = $("input[name='rbTipo']:checked").val();
        if(servicio.tipo == 'ESTANDAR'){
            servicio.estandar = 0;
        }
        else if(servicio.tipo == 'ESPECIAL'){
            servicio.estandar = $('#lblServicioLigado').data('id');
        }

        servicio.tipo_calibracion = $("input[name='rbTipoCal']:checked").val();
        servicio.interno = $('#cbInterno').is(':checked') ? '1' : '0';
        if(servicio.interno == '1'){
            servicio.proveedor = ""
        }
        else{
            servicio.proveedor = $('#txtProveedor').val();
        }
        servicio.clave_precio = $('#opPrecios').val();
        servicio.activo = $('#cbActivo').is(':checked') ? '1' : '0';

        $.ajax({
            type: "POST",
            url: URL,
            data: { servicio : JSON.stringify(servicio) },
            success: function(result) {
                if(result)
                {
                    new PNotify({ title: 'Nuevo Servicio', text: 'Se ha agregado nuevo Servicio', type: 'success', styling: 'bootstrap3' });
                    $('#mdlAlta').modal('hide');
                    buscar();
                }
            },
        });
    }
}

function modificar(btn){
    if(validacion())
    {
        var URL = base_url + "servicios/ajax_setServicio";
        var servicio = {};

        servicio.id = $(btn).val();
        //var magnitud = $('#opMagnitud option:selected').text();
        //var prefijo = $('#opMagnitud').val();

        servicio.descripcion = $('#txtDescripcion').val();
        servicio.observaciones = $('#txtObservaciones').val();
        servicio.proveedor = $('#txtProveedor').val();
        servicio.tags = $('#tags_1').val();


        if($('#cbOS').is(':checked') && $('#cbLab').is(':checked'))
        {
            servicio.sitio = 'OS/LAB';
        }
        else if($('#cbOS').is(':checked'))
        {
            servicio.sitio = 'OS';
        }
        else
        {
            servicio.sitio = 'LAB';
        }        
        servicio.tipo = $("input[name='rbTipo']:checked").val();
        if(servicio.tipo == 'ESTANDAR'){
            servicio.estandar = 0;
        }
        else if(servicio.tipo == 'ESPECIAL'){
            servicio.estandar = $('#lblServicioLigado').data('id');
        }
        servicio.tipo_calibracion = $("input[name='rbTipoCal']:checked").val();
        servicio.interno = $('#cbInterno').is(':checked') ? '1' : '0';
        if(servicio.interno == '1')
        {
            servicio.proveedor = ""
        }
        else 
        {
            servicio.proveedor = $('#txtProveedor').val();
        }
        servicio.clave_precio = $('#opPrecios').val();
        servicio.activo = $('#cbActivo').is(':checked') ? '1' : '0';

        $.ajax({
            type: "POST",
            url: URL,
            data: { servicio : JSON.stringify(servicio) },
            success: function(result) {
                if(result)
                {
                    new PNotify({ title: 'Edición de Servicio', text: 'Se ha editado Servicio', type: 'success', styling: 'bootstrap3' });
                    $('#mdlAlta').modal('hide');
                    buscar();
                }
            },
        });
    }
}

function eliminar(btn){
    if(confirm('¿Desea eliminar Servicio?'))
    {
        var URL = base_url + "servicios/ajax_deleteServicio";
        var id = $(btn).val();
        
        $.ajax({
            type: "POST",
            url: URL,
            data: { id : id },
            success: function(result) {
                if(result)
                {
                    new PNotify({ title: 'Eliminar Servicio', text: 'Se ha eliminado Servicio', type: 'success', styling: 'bootstrap3' });
                    buscar();
                }
            },
        });   
    }
}

function codeExist(codigo){
    var URL = base_url + "servicios/ajax_codeExists";
    var codigo = $('#txtCodigo').val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { codigo : codigo },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                if(rs.CodeCount > 0)
                {
                    new PNotify({ title: 'Codigo Existente', text: 'Código: ' + codigo + ' ya existe', type: 'warning', styling: 'bootstrap3' });
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
    if(!$('#opMagnitud').val())
    {
        alert('Seleccione magnitud');
        return false;
    }
    if(!$("input[name='rbTipo']:checked").val())
    {
        alert('Seleccione tipo de servicio');
        return false;
    }
    if($('#rbEspecial').is(':checked') && $('#lblServicioLigado').data('id') == 0)
    {
        alert('Seleccione servicio estandar asociado');
        return false;
    }
    if(!$("input[name='rbTipoCal']:checked").val())
    {
        alert('Seleccione tipo de calibración');
        return false;
    }
    if(!$('#txtDescripcion').val().trim())
    {
        alert('El campo de descripción esta vacio');
        return false;
    }
    if(!$('#txtProveedor').val().trim() && !$('#cbInterno').is(':checked'))
    {
        alert('Capture proveedor de servicio');
        return false;
    }
    if(!$('#cbOS').is(':checked') && !$('#cbLab').is(':checked'))
    {
        alert('Seleccione sitio de operación');
        return false;
    }
     
    if(!$('#opPrecios').val())
    {
        alert('Seleccione rango de precios');
        return false;
    }


    return true;

    
}

function asignarEstandar(btn){
    $("#mdlServiciosEstandar").modal('hide');
    var id = $(btn).val();
    var cod = $(btn).data('codigo');
    
    $('#lblServicioLigado').data('id', id);
    $('#lblServicioLigado').data('codigo', cod);
    $('#lblServicioLigado').text(cod);
    //setTimeout(function(){ $("#rbEspecial").iCheck('check');}, 1);
}