var ID_SERVICIO = 0;
var EVALUADOR = 0;

function load(){
    $("#opTipo").val("");
    eventos();
    cargarEvaluador();

    if(ID != 0){
        cargarRequerimiento();
    }
}

function eventos(){
    $('#txtFabricante, #txtModelo').on( 'keyup', function( e ) {
        if($('#txtFabricante').val().trim() && $('#txtModelo').val().trim())
        {
            buscarServicio();
        }
    });

    $("#cbDescatalogado").on('ifChanged', function(e){
        if($(this).is(':checked'))
        {
            $("#divFabricante").fadeOut();
            $("#tblServicios tbody tr").fadeOut();
        }else{
            $("#divFabricante").fadeIn();
            $("#tblServicios tbody tr").fadeIn();
        }
    });
}

function cargarRequerimiento(){
    var URL = base_url + "requerimientos/ajax_getRequerimiento";

    $("#btnRegistrar").hide();
    $("#btnEditar").show();
    
    $.ajax({
        type: "POST",
        url: URL,
        data: { id : ID },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $('#opTipo').val(rs.tipo);
                $('#txtCantidad').val(rs.cantidad);
                $('#txtFabricante').val(rs.fabricante);
                $('#txtModelo').val(rs.modelo);
                $('#txtDescripcion').val(rs.descripcion);
                $('#opGrado').val(rs.grado);
                $('#txtExactitud').val(rs.exactitud);
                $('#txtRequisitosEspeciales').val(rs.requisitos_especiales);


                if(rs.alcance)
                {
                    $('#txtAlcance').val(rs.alcance);
                    $('#opAlcance').val(JSON.parse(rs.unidad_alcance)[0]);
                }
                if(rs.resolucion)
                {
                    $('#txtResolucion').val(rs.resolucion);
                    $('#opResolucion').val(JSON.parse(rs.unidad_resolucion)[0]);
                }

                $("#cbDescatalogado").iCheck(rs.catalogado == "0" ? 'check' : 'uncheck')

                if(rs.catalogado == "1"){
                    buscarServicio();
                }
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
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
                EVALUADOR = rs.evaluador_default;
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function validacion(){
    if(!$('#opTipo').val().trim())
    {
        alert("Seleccione tipo de servicio");
        return false;
    }
    if(!$('#txtCantidad').val() | $('#txtCantidad').val() <= 0)
    {
        alert("Ingrese campo Cantidad mayor a 0");
        return false;
    }
    if(!$("#cbDescatalogado").is(":checked"))
    {
        if(!$('#txtFabricante').val().trim())
        {
            alert("Ingrese el campo Fabricante");
            return false;
        }
        if(!$('#txtModelo').val().trim())
        {
            alert("Ingrese el campo Modelo");
            return false;
        }
    }
    if(!$('#txtDescripcion').val().trim())
    {
        alert("Ingrese descripción del instrumento");
        return false;
    }
    if( ($('#txtAlcance').val().trim() == "") != ($('#opAlcance').val().trim() =="") )
    {
        alert("Ingrese campo Alcance / Unidades");
        return false;
    }

    if( ($('#txtResolucion').val().trim() == "") != ($('#opResolucion').val().trim() =="") )
    {
        alert("Ingrese campo Resolución / Unidades");
        return false;
    }

    if(EVALUADOR == 0)
    {
        alert("No existe evaluador asignado");
        return false;
    }

    return true;
}

function registrar(){
    if(validacion())
    {
        var URL = base_url + "requerimientos/ajax_setRequerimiento"

        var requerimiento = {};

        requerimiento.tipo = $('#opTipo').val();
        requerimiento.cantidad = $('#txtCantidad').val();
        requerimiento.fabricante = $('#txtFabricante').val().trim();
        requerimiento.modelo = $('#txtModelo').val().trim();
        requerimiento.descripcion = $('#txtDescripcion').val().trim();
        requerimiento.grado = $('#opGrado').val();
        requerimiento.evaluadores = '[' + EVALUADOR + ']';
        requerimiento.exactitud = $('#txtExactitud').val().trim();
        requerimiento.requisitos_especiales = $('#txtRequisitosEspeciales').val().trim();

        if($('#txtAlcance').val())
        {
            requerimiento.alcance = $('#txtAlcance').val();
            requerimiento.unidad_alcance = '["' + $('#opAlcance').val() + '","' + $('#opAlcance :selected').text() + '"]';
        }
        if($('#txtResolucion').val())
        {
            requerimiento.resolucion = $('#txtResolucion').val();
            requerimiento.unidad_resolucion = '["' + $('#opResolucion').val() + '","' + $('#opResolucion :selected').text() + '"]';
        }
        requerimiento.catalogado = $("#cbDescatalogado").is(":checked") ? '0' : '1';
        requerimiento.comentarios = '[]';
        if($("#cbDescatalogado").is(":checked"))
        {
            requerimiento.fabricante = "N/A";
            requerimiento.modelo = "N/A";
        }
        requerimiento.servicio = '[]';
        requerimiento.estatus = "ABIERTO";
        

        $.ajax({
            type: "POST",
            url: URL,
            data: { requerimiento : JSON.stringify(requerimiento) },
            success: function(result) {
                if(result)
                {
                    window.location.href = base_url + 'requerimientos';
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}

function editar(){
    if(validacion())
    {
        var URL = base_url + "requerimientos/ajax_setRequerimiento"

        var requerimiento = {};

        requerimiento.id = ID;
        requerimiento.tipo = $('#opTipo').val();
        requerimiento.cantidad = $('#txtCantidad').val();
        requerimiento.fabricante = $('#txtFabricante').val().trim();
        requerimiento.modelo = $('#txtModelo').val().trim();
        requerimiento.descripcion = $('#txtDescripcion').val().trim();
        requerimiento.grado = $('#opGrado').val();
        requerimiento.evaluadores = '[' + EVALUADOR + ']';
        requerimiento.exactitud = $('#txtExactitud').val().trim();
        requerimiento.requisitos_especiales = $('#txtRequisitosEspeciales').val().trim();

        if($('#txtAlcance').val())
        {
            requerimiento.alcance = $('#txtAlcance').val();
            requerimiento.unidad_alcance = '["' + $('#opAlcance').val() + '","' + $('#opAlcance :selected').text() + '"]';
        }
        if($('#txtResolucion').val())
        {
            requerimiento.resolucion = $('#txtResolucion').val();
            requerimiento.unidad_resolucion = '["' + $('#opResolucion').val() + '","' + $('#opResolucion :selected').text() + '"]';
        }
        requerimiento.catalogado = $("#cbDescatalogado").is(":checked") ? '0' : '1';
        if($("#cbDescatalogado").is(":checked"))
        {
            requerimiento.fabricante = "N/A";
            requerimiento.modelo = "N/A";
        }
        requerimiento.servicio = 0;
        requerimiento.estatus = "ABIERTO";
        

        $.ajax({
            type: "POST",
            url: URL,
            data: { requerimiento : JSON.stringify(requerimiento) },
            success: function(result) {
                if(result)
                {
                    window.location.href = base_url + 'requerimientos';
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}

function buscarServicio(){
    var fabricante = $('#txtFabricante').val().trim();
    var modelo = $('#txtModelo').val().trim();

    var URL = base_url + "requerimientos/ajax_getServicios";

    $.ajax({
        type: "POST",
        url: URL,
        data: { fabricante : fabricante, modelo : modelo },
        success: function(result) {
            ID_SERVICIO = 0;
            $('#tblServicios tbody tr').remove();

            if(result)
            {
                var tab = $('#tblServicios tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell(0).innerHTML = elem.codigo;
                    ren.insertCell(1).innerHTML = elem.magnitud;
                    ren.insertCell(2).innerHTML = elem.descripcion;
                    ren.insertCell(3).innerHTML = elem.sitio;
                    ren.insertCell(4).innerHTML = elem.tipo;
                    ren.insertCell(5).innerHTML = elem.tipo_calibracion;
                    ren.insertCell(6).innerHTML = "<button type='button' onclick='verRequerimiento(this)' value=" + elem.IdReq + " data-servicio=" + elem.id + " class='btn btn-primary btn-sm'>Ver Requerimiento <i class='fa fa-eye'></i></button>";
                    $("#txtDescripcion").val(elem.descripcion);
                });
                $("#divButtons").fadeOut();
            }
            else
            {
                $("#divButtons").fadeIn();
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function verRequerimiento(btn){
    var IdReq = $(btn).val();

    $.redirect( base_url + "requerimientos/ver", { 'id': IdReq }, 'POST', '_blank');
}