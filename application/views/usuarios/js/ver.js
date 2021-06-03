function load(){
    eventos();
    cargarPuestos();
    cargarJefes();
    cargarAprobadoresCompra();
    cargarAprobadoresCotizaciones();

    cargarDatos();
    privilegios();
}

function eventos(){
    $('#frmPrivilegios').on('submit',function(event){
        if($('#crear_qr_interno').is(':checked'))
        {
            if($('#opAprobadorCompra').val() == 0)
            {
                alert("Seleccione aprobador de compra (Consumo Interno)");
                return false;
            }
        }
        if($('#crear_qr_venta').is(':checked'))
        {
            if($('#opAprobadorCompra_venta').val() == 0)
            {
                alert("Seleccione aprobador de compra (Venta)");
                return false;
            }
        }
        if($('#generar_cotizaciones').is(':checked') || $('#administrar_cotizaciones').is(':checked'))
        {
            if($('#opAprobadorCotizacion').val() == 0)
            {
                alert("Seleccione aprobador de cotización");
                return false;
            }
        }
    });
}

function privilegios(){
    if(PRIVILEGIOS.administrar_usuarios == "1"){
        $('#tab_content1 input').attr('readonly', false);
        $('#tab_content1 select').attr('disabled', false);
        $("#tab_content1 input[type='checkbox']").attr('disabled', false);
        $('#btnGuardarDatos').show();
    }
    else{
        $('#tab_content1 input').attr('readonly', true);
        $('#tab_content1 select').attr('disabled', true);
        $("#tab_content1 input[type='checkbox']").attr('disabled', true);
        $('#btnGuardarDatos').hide();
    }
}

function cargarDatos(){
    var URL = base_url + 'usuarios/ajax_getUsuarios';

    $.ajax({
        type: "POST",
        url: URL,
        data: { parametro : 'id', texto : ID, activo : 1},
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    $('#txtNombre').val(elem.nombre);
                    $('#txtPaterno').val(elem.paterno);
                    $('#txtMaterno').val(elem.materno);
                    $('#txtDepartamento').val(elem.departamento);
                    $('#txtCorreo').val(elem.correo);

                    $('#opPuesto').val(elem.id_puesto);
                    $('#opJefeDirecto').val(elem.jefe_directo);

                    $('#cbActivo').iCheck(elem.activo == "1" ? 'check' : 'uncheck');
                });
            }
        },
    });
}

function guardarDatos(){
    var URL = base_url + 'usuarios/ajax_guardarDatos';

    if(confirm("¿Desea continuar?"))
    {
        var Usuario = {};
        Usuario.id = ID;
        Usuario.nombre = $('#txtNombre').val().toUpperCase();
        Usuario.paterno = $('#txtPaterno').val().toUpperCase();
        Usuario.materno = $('#txtMaterno').val().toUpperCase();
        Usuario.departamento = $('#txtDepartamento').val().toUpperCase();
        Usuario.correo = $('#txtCorreo').val().toLowerCase();
        Usuario.puesto = $('#opPuesto').val();
        Usuario.jefe_directo = $('#opJefeDirecto').val();
        Usuario.activo = $('#cbActivo').is(':checked') ? "1" : "0";
        //ARREGLAR AQUI - VALIDAR CORREO UNICO

        $.ajax({
            type: "POST",
            url: URL,
            data: { usuario : JSON.stringify(Usuario) },
            success: function(result) {
                if(result)
                {
                    new PNotify({ title: 'Usuario', text: 'Se han modificado los datos del usuario', type: 'success', styling: 'bootstrap3' });
                }
            },
        });
    }
}

function cargarPuestos(){
    var URL = base_url + 'usuarios/ajax_getPuestos';

    $.ajax({
        type: "POST",
        url: URL,
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var op = new Option(elem.puesto, elem.id);
                    $('#opPuesto').append(op);
                });
            }
          },
    });
}

function cargarJefes(){
    var URL = base_url + 'usuarios/ajax_getUsuarios';
    var op = new Option("N/A", 0)
    $('#opJefeDirecto').append(op);

    $.ajax({
        type: "POST",
        url: URL,
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var op = new Option(elem.User, elem.id)
                    $('#opJefeDirecto').append(op);
                });
            }
          },
    });
}

function cargarAprobadoresCompra(){
    var URL = base_url + 'compras/ajax_getLiberadoresCompra'; //LIBERADORES DE COMPRA

    $.ajax({
        type: "POST",
        url: URL,
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);

                $.each(rs, function(i, elem){
                    var sel = AC == elem.id ? 'selected' : '';
                    $('#opAprobadorCompra').append("<option " + sel + " value='"+elem.id+"'>"+elem.Name+"</option>");

                    var sel2 = ACV == elem.id ? 'selected' : '';
                    $('#opAprobadorCompra_venta').append("<option " + sel2 + " value='"+elem.id+"'>"+elem.Name+"</option>");
                });
            }
          },
    });
}

function cargarAprobadoresCotizaciones(){
    var URL = base_url + 'compras/ajax_getLiberadoresCotizacion'; //LIBERADORES DE COTIZACION

    $.ajax({
        type: "POST",
        url: URL,
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);

                $.each(rs, function(i, elem){
                    var sel = ACOT == elem.id ? 'selected' : '';
                    $('#opAprobadorCotizacion').append("<option " + sel + " value='"+elem.id+"'>"+elem.Name+"</option>");
                });
            }
          },
    });
}


