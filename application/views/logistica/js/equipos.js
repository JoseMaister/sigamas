function load(){
    buscar();

    
}

function buscar(){
    var URL = base_url + "logistica/ajax_getMLEquipos";
    $('#tblEquipos tbody tr').remove();
    
    var parametro = ""//$("input[name=rbBusqueda]:checked").val();
    var texto = ""//$("#txtBusqueda").val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto, parametro : parametro },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblEquipos tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id_solicitud = elem.Item;

                    var desc = elem.Descripcion;
                    desc += elem.Fabricante ? (" " + elem.Fabricante) : elem.Fabricante;
                    desc += elem.Modelo ? (" " + elem.Modelo) : elem.Modelo;
                    desc += elem.Serie ? (" Serie: " + elem.Serie) : elem.Serie
                    desc += elem.Equipo_ID ? (" ID: " + elem.Equipo_ID) : elem.Equipo_ID
                    
                    ren.insertCell().innerHTML = elem.Equipo_ID;
                    ren.insertCell().innerHTML = elem.RS;
                    ren.insertCell().innerHTML = elem.NombreCorto;
                    ren.insertCell().innerHTML = desc;
                    ren.insertCell().innerHTML = elem.DocStatus.startsWith("ENTREGANDO") ? "PENDIENTE DE ENTREGA" : "";
                    ren.insertCell().innerHTML = elem.Entrega.startsWith("ENTREGANDO") ? "PENDIENTE DE ENTREGA" : "";
                    //ren.insertCell().innerHTML = boton(elem.id, elem.estatus_factura, elem.usuario);
                    //ren.insertCell().innerHTML = elem.Recorridos > 0 ? "<button type='button' onclick=verRecorridos(this) class='btn btn-primary btn-sm'><i class='fa fa-truck'></i> " + elem.Recorridos + "</button>" : "N/A";
                });
            }
            else
            {
                new PNotify({ title: '¡Nada por aquí!', text: 'No se encontraron resultados', type: 'info', styling: 'bootstrap3' });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function boton(id, estatus, user){
    var clase = "btn dropdown-toggle btn-xs";
    opcs = "<ul role='menu' class='dropdown-menu'>"
    opcs += "<li><a onclick=verSolicitud(this)><i class='fa fa-eye'></i> Ver Solicitud</a></li>"
    

    switch(estatus){
        case "ACEPTADO":
            clase += " btn-success";
            if(user == uid)
            {
                opcs += "<li><a onclick=enviar(this)><i class='fa fa-send'></i> Enviar Factura</a></li></ul></div>";
            }
            break;

        case "RECHAZADO EN LOGISTICA":
            clase += " btn-danger";
            if(user == uid)
            {
                opcs += "<li><a onclick=enviar(this)><i class='fa fa-send'></i> Enviar Factura</a></li></ul></div>";
            }
            opcs += "</ul></div>";
            break;

        case "RECIBIDO EN LOGISTICA":
        case "DEJADA CON CLIENTE":
            clase += " btn-warning";
            opcs += "</ul></div>";
            break;

        case "RECHAZADO":
        case "NO ENTREGADA":
        case "NO RECOLECTADA":
        case "RECHAZADO POR MENSAJERO":
        case "ENTREGA RECHAZADA":
        case "RECOLECTA RECHAZADA":
            clase += " btn-danger";
            opcs += "</ul></div>";
            break;
        
        case "ASIGNADO A MENSAJERO":
            clase += " btn-primary";
            opcs += "</ul></div>";
            break;

        case "RETORNADA AUTORIZADA":        
            clase += " btn-success";
            opcs += "</ul></div>";
            break;

        case "ENVIADA LOGISTICA":
        case "PENDIENTE RECORRIDO":
        case "PENDIENTE ENTREGA":
        case "PENDIENTE RECOLECTA":
        case "EN RECORRIDO":
            clase += " btn-warning";
            opcs += "</ul></div>";
            break;

        case "CANCELADO":
        case "CERRADO":
            clase += " btn-default";
            opcs += "</ul></div>";
            break;

        case "NO PROCEDE":
            clase += " btn-dark";
            opcs += "</ul></div>";
            break;
    }
    
    
    
    var btn = "<div class='btn-group'><button type='button' data-toggle='dropdown' value=" + id + " class='" + clase + "'>" + estatus + "  <span class='caret'></span></button>";
    btn += opcs;
    return btn;


}

function verSolicitud(a){
    var ren = $(a).closest('tr');
    var btn = $(ren).find('button');
    var id = $(btn).val();

    $.redirect( base_url + "facturas/ver_solicitud", { 'id': id }, 'POST', '_blank');
}

function enviar(a){
    var ren = $(a).closest('tr');
    var id = $(ren).data('id_solicitud');
    var id_factura = $(ren).data('id_factura');
    var correoContacto = $(ren).data('correo_contacto');
    var correoEjecutivo = $(ren).data('correo_ejecutivo');
    

    $("#divTags_1").html('<input id="tags_1" type="text" class="form-control"/>');
    $("#divTags_2").html('<input id="tags_2" type="text" class="form-control"/>');

    $('#tags_1').val(correoContacto);
    $('#tags_2').val(correoEjecutivo);

    $('#tags_1, #tags_2').tagsInput({
        width: 'auto',
        height: 'auto',
        style: '{margin-left: 15px;}',
        defaultText: '',
        allowDuplicates: true,
    });






    $('#mdlEnviar .modal-title').text('Enviar Factura: ' + id_factura);

    $('#mdlEnviar').data('id', id);


    $('#mdlEnviar').modal();
}

function enviarLogistica(){
    if(confirm("¿Desea continuar?")){
    
        var solicitud = {};
        solicitud.id = $('#mdlEnviar').data('id');
        solicitud.estatus_factura = "ENVIADA LOGISTICA";
        var URL = base_url + "facturas/ajax_setSolicitud";
        /////////////////////////////////////////////////////////

        $.ajax({
            type: "POST",
            url: URL,
            data: { solicitud : JSON.stringify(solicitud) },
            success: function(result) {
                if(result)
                {
                    $('#mdlEnviar').modal('hide');
                    buscar();
                }
              },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}



/*function cancelar(a){
    var ren = $(a).closest('tr');
    var btn = $(ren).find('button');
    var id = $(btn).val();

    if(confirm("¿Desea cancelar Solicitud?"))
    {
        var URL = base_url + 'facturas/ajax_editSolicitud';
        
        var solicitud = { 
            id : id,
            estatus : 'CANCELADO'
        };

        $.ajax({
            type: "POST",
            url: URL,
            data: { solicitud : JSON.stringify(solicitud) },
            success: function(result) {
                if(result)
                {
                    buscar();
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}
*/

function verRecorridos(btn){
    var URL = base_url + "logistica/ajax_getRecorridos";
    $('#tblRecorridos tbody tr').remove();
    
    var ren = $(btn).closest('tr');
    var id = $(ren).data('id_solicitud');

    var data = {};
    data.factura = id;

    $.ajax({
        type: "POST",
        url: URL,
        data: data,
        success: function(result) {
            if(result)
            {
                var tab = $('#tblRecorridos tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id = elem.id;

                    var accion = elem.accion;
                    if(accion == "ENTREGA")
                    {
                        accion += " <font color='green'><i class='fa fa-arrow-right'></i></font>";
                    }
                    else if(accion == "RECOLECTA")
                    {
                        accion += " <font color='red'><i class='fa fa-arrow-left'></i></font>";
                    }

                    ren.insertCell().innerHTML = paddy(elem.recorrido, 3);
                    ren.insertCell().innerHTML = elem.Cliente;
                    ren.insertCell().innerHTML = accion;
                    ren.insertCell().innerHTML = elem.Mensajero;
                    var c = elem.estatus.startsWith("EN RECORRIDO") ? 'btn-warning' : ((elem.estatus.startsWith("NO") || elem.estatus.startsWith("RECHAZAD")) ? 'btn-danger' : 'btn-success');
                    ren.insertCell().innerHTML = '<button type="button" class="btn ' + c + ' btn-sm">' + elem.estatus + '</button>';
                    ren.insertCell().innerHTML = elem.Reporte != "N/A" ? '<button type="button" onclick=verReporte(this) value="' + elem.Reporte + '" class="btn btn-primary"><i class="fa fa-file-text-o"></i> Reporte</button>' : 'N/A';

                    
                });
                $('#mdlRecorridos').modal();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function verReporte(btn){

    
    var idReporte = $(btn).val();
    var URL = base_url + "logistica/ajax_getReporte";
    
    $('#tblFacturasReporte tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : idReporte},
        success: function(result) {
            if(result)
            {
                var fecha;
                var cliente;
                var contacto;
                var accion;
                var resultado;
                var firma;

                var tab = $('#tblFacturasReporte tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);

                    ren.insertCell().innerHTML = tab.rows.length;
                    ren.insertCell().innerHTML = elem.folio;
                    ren.insertCell().innerHTML = elem.Requisitor;
                    ren.insertCell().innerHTML = elem.discrepancia == "1" ? "(Discrepancia)" : "";

                    fecha = moment(elem.fecha).format('D/MM/YYYY h:mm A');
                    cliente = elem.Cliente;
                    contacto = elem.Contacto;
                    accion = elem.accion;
                    resultado = elem.resultado;
                    firma = elem.firma;
                    
                });

                $('#lblRecorridoFecha').text(fecha);
                $('#lblCliente').text(cliente);
                $('#lblContacto').text(contacto);
                $('#lblAccion').text(accion);
                //$('#lblMensajero').text(elem.Mensajero);
                var c = resultado.startsWith("NO") ? 'red' : 'green';
                $('#lblResultado').html('<font color="' + c + '"><b>' + resultado + '</b></font>');

                (firma == 1) ? $('#divFirma').show() : $('#divFirma').hide();

                $('#imgFirma').attr('src', base_url + 'data/logistica/firmas/' + idReporte + '.jpg');


                $('#mdlReporte').modal();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

    cargarComentarios(idReporte);
}




function cargarComentarios(id){
    var URL = base_url + "logistica/ajax_getComentariosRecorrido";

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            $('#ulComments').html("");
            if(result)
            {
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var c = '<li>'
                    +    '<a>'
                    +        '<span class="image">'
                    +            '<img style="width: 65px; height: 65px;" class="avatar" src="' + base_url + 'usuarios/photo/' + elem.usuario + '" alt="img" />'
                    +        '</span>'
                    +        '<span>'
                    +            '<small>' + elem.User + '<small> ' + moment(elem.fecha).format('D/MM/YYYY h:mm A') + '</small></span>'
                    +        '</span>'
                    +        '<span class="message">' + elem.comentario + '</span>'
                    +    '</a>'
                    +'</li>';
                    $('#ulComments').append(c);
                });

                $('#mdlComentarios').modal();
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}







////////////////////////////////// C O R R E O //////////////////////////////////

function mdlCorreo(){
    $('#mdlEnviar').modal('hide');
    $('#mdlCorreo').modal();
}

function validacionCorreo(){
    if(!$('#tags_1').val().trim())
    {
        alert('Campo de remitentes esta vacío');
        return false;
    }
    return confirm("¿Desea enviar correo?");
}

function enviarCorreo(){
    if(validacionCorreo())
    {
        $('#mdlCorreo').modal('hide');
        var URL = base_url + 'logistica/ajax_enviarCorreo';
        var text = $('#editor-one').html();
        var para = $('#tags_1').val();
        var cc = $('#tags_2').val();
        var id = $('#mdlEnviar').data('id');
        //var docs = $('#divAdjuntos input[type="checkbox"]:checked');

        /*
        var campos = [];
        $.each(docs, function(i, elem){
            campos.push($(elem).val());
        });
        */

        alert('ANTES DE ENVIAR AJAX');
        $.ajax({
            type: "POST",
            url: URL,
            data: { body : text, para : para, cc : cc, id : id},
            success: function (result) 
            {
                alert('RES SUCCESS');
            },
        });
    }
}