var REQUERIMIENTO = {};

function load(){
    jQuery.ajaxSetup({async:false});
    eventos();
    cargarDatos();
    buscarArchivos();
}

function eventos(){
    $("input[name='rbRespuesta']").on('ifChanged', function(){
        $("#btnResponder").removeClass('btn-default btn-success btn-danger');
        if($("#rbProcede").is(":checked"))
        {
            //UA6qE4sV5G
            $("#btnResponder").addClass('btn-success');
            if(REQUERIMIENTO.tipo == "CALIBRACION")
            {
                $("#divServicios").fadeIn();
            }
        }
        else if($("#rbNoProcede").is(":checked"))
        {
            $("#divServicios").fadeOut();
            $("#btnResponder").addClass('btn-danger');
        }
        else
        {
            $("#divServicios").fadeOut();
            $("#btnResponder").addClass('btn-default');
        }
    });

    $('#txtBuscarServicio').keypress(function (e) { 
        if( e.keyCode === 13 ) {
            buscarServicios();
        }
    });
}

function cargarDatos(){
    var URL = base_url + "requerimientos/ajax_getRequerimiento";

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : ID },
        success: function(result) {
            $('#ulComments li').remove();
            $("#lblCerrado").html("");
            $("#lblCerradoPor").html("");
            $("#lblServicio").html("");
            $("#lblServicioCodigo").html("");

            if(result)
            {

                REQUERIMIENTO = JSON.parse(result);
                REQUERIMIENTO.comentarios = JSON.parse(REQUERIMIENTO.comentarios);
                REQUERIMIENTO.evaluadores = JSON.parse(REQUERIMIENTO.evaluadores);
                REQUERIMIENTO.servicio = JSON.parse(REQUERIMIENTO.servicio);

                $("#lblIdRequerimiento").html("REQ" + paddy(REQUERIMIENTO.id, 6));
                $("#lblFecha").html(REQUERIMIENTO.fecha);
                $("#lblUser").html(REQUERIMIENTO.User);
                $("#lblTipo").html(REQUERIMIENTO.tipo);
                $("#lblFabricante").html(REQUERIMIENTO.fabricante);
                $("#lblModelo").html(REQUERIMIENTO.modelo);
                
                var alcance = REQUERIMIENTO.alcance ? (REQUERIMIENTO.alcance + " " + JSON.parse(REQUERIMIENTO.unidad_alcance)[0]) : "N/A";
                $("#lblAlcance").html(alcance);

                var resolucion = REQUERIMIENTO.resolucion ? (REQUERIMIENTO.resolucion + " " + JSON.parse(REQUERIMIENTO.unidad_resolucion)[0]) : "N/A";
                $("#lblResolucion").html(resolucion);

                $("#lblDescripcion").html(REQUERIMIENTO.descripcion);
                $("#lblGrado").html(REQUERIMIENTO.grado ? REQUERIMIENTO.grado : "N/A");

                $("#lblRequisitosEspeciales").html(REQUERIMIENTO.requisitos_especiales);
                $("#lblExactitud").html(REQUERIMIENTO.exactitud);

                if(REQUERIMIENTO.despachador != 0 && REQUERIMIENTO.despachador != null)
                {
                    $("#lblCerrado").html("Cerrado por:");
                    $("#lblCerradoPor").html(REQUERIMIENTO.Cerrador + " @ " + moment(REQUERIMIENTO.fecha_cierre).format('D/MM/YYYY h:mm A'));
                }

                if(REQUERIMIENTO.servicio.length > 0)
                {
                    $("#lblServicio").html("Servicio Asignado:");
                    $("#lblServicioCodigo").html("<button type='button' onclick='verServicio(this)' value='" + JSON.stringify(REQUERIMIENTO.servicio) + "' class='btn btn-success'><i class='fa fa-spinner'></i> Servicios: " + REQUERIMIENTO.servicio.length + "</button>");
                }
                
                comboEvaluadores();
                cargarEstatus(REQUERIMIENTO.estatus);
                cargarEvaluadores(REQUERIMIENTO.evaluadores);
                cargarComentarios(REQUERIMIENTO.comentarios);
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function cargarEstatus(estatus){
    $("#btnEstatus").html(estatus);
    $("#btnEstatus").removeClass();

    $("#divEstatus :nth-child(2)").remove();

    var clase, buttons;
    if(estatus == "ABIERTO")
    {
        clase = "btn btn-primary dropdown-toggle";
        buttons = '<ul role="menu" class="dropdown-menu">'
        + '<li><a onclick=mdlComentariosRechazo()>Rechazar</a></li>'
        + '<li><a onclick=mdlComentariosCanalizar()>Canalizar</a></li>'
        + '<li><a onclick=mdlComentariosResponder()>Responder</a></li></ul>';
    }
    if(estatus == "CANALIZADO")
    {
        clase = "btn btn-info dropdown-toggle";
        buttons = '<ul role="menu" class="dropdown-menu">'
        + '<li><a onclick=mdlComentariosRechazo()>Rechazar</a></li>'
        + '<li><a onclick=mdlComentariosCanalizar()>Canalizar</a></li>'
        + '<li><a onclick=mdlComentariosResponder()>Responder</a></li></ul>';
    }
    if(estatus == "RECHAZADO")
    {
        clase = "btn btn-danger dropdown-toggle";
        buttons = '';
    }
    if(estatus == "EVALUADO"){
        clase = "btn btn-success dropdown-toggle";
        buttons = '';
    }
    if(estatus == 'NO PROCEDE'){
        clase = "btn btn-dark dropdown-toggle";
        buttons = '';
    }
    if(estatus == 'CANCELADO'){
        clase = "btn btn-default dropdown-toggle";
        buttons = '';
    }

    
    if(buttons && adm_evaluador == "1"){
        $("#btnEstatus").append(" <span class='caret'></span>");
        $("#divEstatus").append(buttons);
    }
    $("#btnEstatus").addClass(clase);
    
}

function buscarArchivos(){
    var URL = base_url + "requerimientos/ajax_getRequerimientoArchivos";
    $('#tblArchivos tbody tr').remove();
    
    $.ajax({
        type: "POST",
        url: URL,
        data: { id : ID },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblArchivos tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell(0).innerHTML = elem.fecha;
                    ren.insertCell(1).innerHTML = elem.nombre;
                    ren.insertCell(2).innerHTML = elem.User;
                    ren.insertCell(3).innerHTML = elem.comentarios;
                    ren.insertCell(4).innerHTML = "<button type='button' onclick='verArchivo(this)' value=" + elem.id + " class='btn btn-primary btn-xs'>Ver Archivo <i class='fa fa-file'></i></button>";
                });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function ordenarTabla(){
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("tblEvaluadores");
    
    switching = true;
    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) 
        {
            shouldSwitch = false;

            x = rows[i].getElementsByTagName("td")[0];
            y = rows[i + 1].getElementsByTagName("td")[0];
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) 
        {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

function cargarEvaluadores(evaluadores){
    $('#tblEvaluadores tbody tr').remove();

    $.each(evaluadores, function(i, elem){
        $.get(base_url + 'usuarios/name/' + elem, function( data ) {
            var tab = $('#tblEvaluadores tbody')[0];
            var ren = tab.insertRow(tab.rows.length);
            ren.insertCell(0).innerHTML = i + 1;
            ren.insertCell(1).innerHTML = '<a href="' + base_url + 'usuarios/ver/' + elem + '" target="_blank"><img class="avatar" src="' + base_url + 'usuarios/photo/' + elem + '" alt="img" /></a>';
            ren.insertCell(2).innerHTML = data;
            //ordenarTabla();
        });
    });

}

function comboEvaluadores(){
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
                    if(elem.id != REQUERIMIENTO.evaluadores[REQUERIMIENTO.evaluadores.length - 1]){
                        var option = new Option(elem.User, elem.id);
                        $('#opEvaluadores').append(option);
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

function cargarComentarios(comentarios){
    $.each(comentarios, function(i, elem){

        $.get(base_url + 'usuarios/name/' + elem[0], function( data ) {
            var c = '<li>'
            +    '<a>'
            +        '<span class="image">'
            +            '<img style="width: 65px; height: 65px;" class="avatar" src="' + base_url + 'usuarios/photo/' + elem[0] + '" alt="img" />'
            +        '</span>'
            +        '<span>'
            +            '<span>' + data + '<small> ' + moment(elem[1]).format('D/MM/YYYY h:mm A') + '</small></span>'
            +        '</span>'
            +        '<span class="message">' + elem[2] + '</span>'
            +    '</a>'
            +'</li>';
            $('#ulComments').append(c);
        });

    });
}

function mdlComentarios(){
    $('#mdlComentarios-title').html('Agregar Comentario');
    $("#txtComentarios").val("");
    $("#btnAgregarComentario").show();
    $("#btnResponder").hide();
    
    $("#divServicios").hide();
    $("#btnRechazar").hide();
    $("#btnCanalizar").hide();
    $("#divEvaluadores").hide();
    $("#divRespuesta").hide();
    $("#mdlComentarios").modal();
}

function setComentario(){
    var comentario = $("#txtComentarios").val().trim();
    if(comentario){
        agregarComentario(comentario)
        new PNotify({ title: 'Nuevo Comentario', text: 'Se ha insertado comentario', type: 'success', styling: 'bootstrap3' });
    }
    else{
        alert("Comentario vacio");
    }
}

function editarRequerimiento(requerimiento){
    var URL = base_url + 'requerimientos/ajax_setRequerimiento';
    
    requerimiento.id = ID;

    $.ajax({
        type: "POST",
        url: URL,
        data: { requerimiento : JSON.stringify(requerimiento) },
        success: function(result) {
            if(result)
            {
                cargarDatos();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

//// R E C H A Z A R ////
function mdlComentariosRechazo(){
    $('#mdlComentarios-title').html('Rechazar Requerimiento');
    $("#txtComentarios").val("");
    $("#btnAgregarComentario").hide();
    $("#btnRechazar").show();
    $("#btnCanalizar").hide();
    $("#btnResponder").hide();
    
    $("#divServicios").hide();
    $("#divEvaluadores").hide();
    $("#divRespuesta").hide();
    $("#mdlComentarios").modal();
}

function rechazar(){
    var comentario = $("#txtComentarios").val().trim();

    if(comentario.length >= 10){
        comentario = "<b><font color=red>RECHAZADO:</font></b> " + comentario;
        agregarComentario(comentario)
        var res = { estatus : 'RECHAZADO' };
        editarRequerimiento(res);
    }
    else{
        alert("Ingrese motivo de rechazo (min. 10 Caracteres)");
    }
}

//// C A N A L I Z A R ////
function mdlComentariosCanalizar(){
    $('#mdlComentarios-title').html('Canalizar Requerimiento');
    $("#txtComentarios").val("");
    $("#btnAgregarComentario").hide();
    $("#btnRechazar").hide();
    $("#btnCanalizar").show();
    $("#btnResponder").hide();
    
    $("#divServicios").hide();
    $("#divEvaluadores").show();
    $("#divRespuesta").hide();
    $('#opEvaluadores').val("");
    $("#mdlComentarios").modal();
}

function canalizar(){
    if(validarCanalizar())
    {
        var comentario = $("#txtComentarios").val().trim();
        comentario = "<b><font color=blue>CANALIZADO:</font></b> " + comentario;
        agregarComentario(comentario);

        REQUERIMIENTO.evaluadores.push($('#opEvaluadores').val());
        var res = { estatus : 'CANALIZADO', evaluadores : JSON.stringify(REQUERIMIENTO.evaluadores) };
        editarRequerimiento(res);
    }
}

function validarCanalizar(){
    if(!$("#txtComentarios").val().trim())
    {
        alert("Ingrese comentario");
        return false;
    }
    if(!$("#opEvaluadores").val())
    {
        alert("Seleccione Evaluador");
        return false;
    }
    return true;
}

//// R E S P O N D E R ////
function mdlComentariosResponder(){
    $('#mdlComentarios-title').html('Responder Requerimiento');
    $("#txtComentarios").val("");
    $("#btnAgregarComentario").hide();
    $("#btnRechazar").hide();
    $("#btnCanalizar").hide();
    $("#btnResponder").show();

    $("#txtServicio").val(""); $("#txtServicio").data('id', 0);

    $("input[name='rbRespuesta']").iCheck('uncheck');
    $("#divServicios").hide();
    
    $("#divEvaluadores").hide();
    $("#divRespuesta").show();
    $('#opEvaluadores').val("");
    $("#mdlComentarios").modal();
}

function responder(){
    if(validarResponder())
    {
        var estatus = ''; var colorCom = '';
        var comentario = $("#txtComentarios").val().trim();

        if($("#rbProcede").is(":checked")){
            colorCom = "<b><font color=green>EVALUADO:</font></b> ";
            estatus = "EVALUADO";
        } else {
            colorCom = "<b><font color=red>NO PROCEDE:</font></b> ";
            estatus = "NO PROCEDE";
        }

        if(comentario)
        {
            comentario = colorCom + comentario;
            agregarComentario(comentario);   
        } 
        else 
        {
            $("#mdlComentarios").modal('hide');
        }

        var servs = [];
        
        if($('#divServicios').is(":visible"))
        {
            var rows = $('#tblServices tbody tr');
            $.each(rows, function(i, row){
                servs.push($(row).data('id'));
            });
        }
        

        var res = { estatus : estatus, servicio : JSON.stringify(servs), despachador : IDU };
        editarRequerimiento(res);
        
    }
}

function validarResponder(){
    if($("input[name='rbRespuesta']:checked").length == 0)
    {
        alert("Seleccione tipo de respuesta");
        return false;
    }
    if($("#rbProcede").is(":checked"))
    {
        var rows = $('#tblServices tbody tr');
        if(rows.length <= 0 && REQUERIMIENTO.tipo == "CALIBRACION")
        {
            alert("Seleccione servicios asignados");
            return false;
        }
    }
    else
    {
        var comentario = $("#txtComentarios").val().trim();
        if(comentario.length < 10){
            alert("Ingrese motivo de improcedencia (min. 10 Caracteres)");
            return false;
        }
    }
    return true;
}

//// S E R V I C I O S ////
function mdlServicios(){    
    buscarServicios();
    $('#mdlServicios').modal();
}

function buscarServicios(){
    var URL = base_url + "servicios/ajax_getServicios";
    var parametro = "contenido";
    var texto = $('#txtBuscarServicio').val().trim();

    var rows = $('#tblServices tbody tr');
    var servs = [];
    $.each(rows, function(i, row){
        servs.push($(row).data('id'));
    });

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto, parametro : parametro, tipo : "[]" },
        success: function(result) {
            $('#tblServicios tbody tr').remove();
            if(result)
            {
                var tab = $('#tblServicios tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id = elem.id;
                    ren.dataset.codigo = elem.codigo;
                    ren.dataset.descripcion = elem.descripcion;

                    ren.insertCell().innerHTML = elem.codigo;
                    ren.insertCell().innerHTML = elem.descripcion; 
                    var b;

                    if(servs.includes(parseInt(elem.id)))
                    {
                        b = "<button type='button' class='btn btn-success btn-xs'><i class='fa fa-spinner'></i> Asignado</button>";
                    }
                    else{
                        b = "<button type='button' onclick='asignarServicio(this)' class='btn btn-primary btn-xs'><i class='fa fa-check'></i> Asignar</button>";
                    }

                    ren.insertCell().innerHTML = b;
                    
                });
                
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function asignarServicio(btn){
    var ren = $(btn).closest('tr');

    var id = $(ren).data('id');
    var codigo = $(ren).data('codigo');
    var descripcion = $(ren).data('descripcion');    

    var tab = $('#tblServices tbody')[0];
    var ren = tab.insertRow(tab.rows.length);
    ren.dataset.id = id;
    ren.dataset.codigo = codigo;
    ren.dataset.descripcion = descripcion;

    ren.insertCell(0).innerHTML = "<button type='button' onclick='removerServicio(this)' class='btn btn-danger btn-xs'><i class='fa fa-minus'></i></button>" + codigo;
    ren.insertCell(1).innerHTML = descripcion;

    $('#mdlServicios').modal('hide');
}

function removerServicio(btn){
    $(btn).closest('tr').remove();
}

function verServicio(btn){
    var URL = base_url + "servicios/ajax_getServicios";
    $('#tblServicio tbody tr').remove();
    
    var parametro = "id";
    var texto = $(btn).val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto, parametro : parametro, tipo : '[]' },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblServicio tbody')[0];
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
                });
                $('#mdlServicio').modal();

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

function agregarComentario(comentario){
    var URL = base_url + "requerimientos/ajax_setRequerimientoComentario";

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : ID, comentario : comentario },
        success: function(result) {
            if(result)
            {
                cargarComentarios(Array(Array(IDU, moment(), comentario)));
                $("#mdlComentarios").modal('hide');
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}


//////// A R C H I V O S ////////

function _(el){
    return document.getElementById(el);
}

function uploadFile(){
    //alert(file.name+" | "+file.size+" | "+file.type);
    var file = _("userfile").files[0];
    var n = file.name;
    $("#txtNombreArchivo").val(n.substr(0, n.length - 4));
    $("#txtComentarioArchivo").val("");
    $("#mdlArchivo").modal();
}


function subirArchivo(){
    if(validacionArchivo())
    {
        var file = _("userfile").files[0];
        var URL = base_url + 'requerimientos/ajax_subirArchivo';

        var nombre = $("#txtNombreArchivo").val().trim() + ".pdf";
        var comentarios = $("#txtComentarioArchivo").val().trim();

        var formdata = new FormData();
        formdata.append("requerimiento", ID);
        formdata.append("nombre", nombre);
        formdata.append("comentarios", comentarios);
        formdata.append("file", file);

        var ajax = new XMLHttpRequest();
        ajax.open("POST", URL);
        ajax.addEventListener("load", buscarArchivos, false);
        ajax.send(formdata);

        $("#mdlArchivo").modal('hide');
    }
}

function validacionArchivo(){
    if(!$("#txtNombreArchivo").val().trim())
    {
        alert("Ingrese nombre del archivo");
        return false;
    }
    return true;
}

function verArchivo(btn){
    var id = $(btn).val();
    $.redirect( base_url + "archivos/pdf", { 'tabla' : 'requerimiento_archivos', 'id': id }, 'POST', '_blank');
}