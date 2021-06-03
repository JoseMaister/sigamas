var DOCS_REQ;
var ESTATUS;

function load(){
    $( "#menu_toggle" ).trigger( "click" );
    eventos();
    jQuery.ajaxSetup({async:false});
    if(ID != 0)
    {
        if(EDIT == '1') //EDITAR
        {
            cargarDatos();
            cargarComentarios();   
        }
        else
        {
            cargarDatos();
            cargarComentarios();
            bloquearControles();
        }
    }
    else
    {
        $('#optFormaPago').val("");
        agregarConcepto(false);
    }

    $('#tags_1, #tags_2').tagsInput({
        width: 'auto',
        height: 'auto',
        style: '{margin-left: 15px;}',
        defaultText: '',
        allowDuplicates: true,
    });
}

function eventos(){
    $('#mdlClientes').on('keypress', function( e ) {
        if( e.keyCode === 13 ) {
            e.preventDefault();
            buscarCliente();
        }
    });

    $('#mdlRS').on('keypress', function( e ) {
        if( e.keyCode === 13 ) {
            e.preventDefault();
            buscarRS();
        }
    });

    

    $('#iptTodo').on('ifChanged', function( e ) {
        selectTodoRS();
    });
}

function cargarDatos(){
    var URL = base_url + "facturas/ajax_getSolicitudes";

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : ID },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                SOLICITUD = rs;
                $('#txtOrdenCompra').val(rs.orden_compra);
                $('#txtRS').val(rs.reporte_servicio);
                $('#optFormaPago').val(rs.forma_pago);
                $('#txtNotas').val(rs.notas);
                $('#cbPagada').iCheck(rs.pagada == "1" ? 'check' : 'uncheck');
                $('#cbUrgente').iCheck(rs.urgente == "1" ? 'check' : 'uncheck');
                $('#txtCodigoImpresion').val(rs.codigo_impresion)
                $('#lblSerie').data('valor', rs.serie);
                $('#lblFolio').data('valor', rs.folio);
                $('#lblMontoFactura').data('valor', rs.monto_factura);

                $('#lblSerie').text(rs.serie);
                $('#lblFolio').text(rs.folio);
                $('#lblMontoFactura').text(rs.monto_factura);

                if(rs.serie)
                {
                    $('#pnlFactura').show();
                }
                botonEstatus(rs.estatus);

                var conceptos = JSON.parse(rs.conceptos);

                var btn = document.createElement("button");
                
                btn.value = rs.ejecutivo;
                seleccionarRequisitor(btn);
                btn.value = rs.cliente;
                seleccionarCliente(btn);
                btn.value = rs.contacto;
                seleccionarContacto(btn);
                
                if(EDIT == '1')
                {
                    $('#btnEditar').show();
                    $('#btnEnviar').hide();
                    cargarConceptos_EDITAR(JSON.parse(rs.conceptos));
                    leerDocumentos_SOLICITUD(JSON.parse(rs.documentos_requeridos));
                }
                else
                {
                    cargarConceptos(JSON.parse(rs.conceptos));
                    leerDocumentos_RESPUESTA(JSON.parse(rs.documentos_requeridos));
                }
                

                if(rs.estatus == 'ABIERTO' && RES == "1")
                {
                    $('#rowRespuesta').show();
                }
                else if(rs.estatus == 'RESPONDIDO')// && UID == rs.usuario)
                {
                    $('#rowRespuestaDocs').show();
                }
                else if(rs.estatus == "ACEPTADO"){
                    $('#divImprimir').show();
                }

                cargarRSItems();

                $('#rowComentarios').show();
                $('#rowEstatus').show();
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function cargarConceptos(conceptos){
    $('#tblConceptos tbody tr').remove();
    var tab = $('#tblConceptos tbody')[0];
    $.each(conceptos, function(i, elem){
        var ren = tab.insertRow(tab.rows.length);
        ren.insertCell().innerHTML = (tab.rows.length + 1) / 2;
        ren.insertCell().innerHTML = elem.Tipo;
        ren.insertCell().innerHTML = elem.Partidas;

        var ren2 = tab.insertRow(tab.rows.length);
        var d = "<b>, Descripción: </b>" + elem.Descripcion;
        ren2.insertCell().innerHTML = "";
        ren2.insertCell().innerHTML = "<b>Modelo: </b>" + elem.Modelo + (elem.Descripcion != undefined ? d : '');
        ren2.insertCell().innerHTML = "<b>Series: </b>" + elem.Series;
        if(elem.Tipo != "Venta")
        {
            $(ren2).hide();
        }
    });
}

function cargarConceptos_EDITAR(conceptos){
    //////////////////////////////////
    $('#tblConceptos tbody tr').remove();
    var tab = $('#tblConceptos tbody')[0];
    $.each(conceptos, function(i, elem){
        var ren = tab.insertRow(tab.rows.length);
        ren.insertCell().innerHTML = (tab.rows.length + 1) / 2;
    var select = '<select style="width: 90%;" onchange="verDetalle(this)" required="required" name="optTipoServicio" class="select2_single form-control">'
        select +=       '<option value="Calibración">Calibración</option>'
        select +=       '<option value="Curso, entrenamiento, soporte, etc.">Curso, entrenamiento, soporte, etc.</option>'
        select +=       '<option value="Estudios Dimensionales">Estudios Dimensionales</option>'
        select +=       '<option value="Gastos de Envio">Gastos de Envio</option>'
        select +=       '<option value="Renta de Basculas">Renta de Basculas</option>'
        select +=       '<option value="Renta de Equipos">Renta de Equipos</option>'
        select +=       '<option value="Reparación">Reparación</option>'
        select +=       '<option value="Venta">Venta</option>'
        select +=       '<option value="Viatico">Viatico</option>'
        select += '</select>';
        ren.insertCell().innerHTML = select;
        $(ren).find('select[name="optTipoServicio"]').val(elem.Tipo);

        var cell3 = ren.insertCell();
        cell3.innerHTML = '<input name="txtPartidas" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 44 && event.charCode <= 45)" style="text-align:center; width: 40%; display: inline;" type="text" class="form-control" value="' + elem.Partidas + '">';
        if(tab.rows.length != 1)
        {   
            cell3.innerHTML += '<button onclick="eliminarConcepto(this)" style="margin-left: 10px;" type="button" class="btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>';
        }

        var ren2 = tab.insertRow(tab.rows.length);
        var d = elem.Descripcion == undefined ? 'Modelo:' : elem.Descripcion;
        var m = elem.Modelo == undefined ? '' : elem.Modelo;
        ren2.insertCell().innerHTML = "";
        ren2.insertCell().innerHTML = '<label name="lblModelo">' + d + '</label><input name="txtModelo" onkeyup="consultaModelo(this)" type="text" class="form-control" value="' + m + '">';
        var s = elem.Series == undefined ? 'display:none;' : 'display:block;';
        ren2.insertCell().innerHTML = '<div style="' + s + '" name="divSeries"><label>Series: </label><input name="txtSeries" type="text" class="form-control" value="' + elem.Series + '"></div>';
        if(elem.Tipo != "Venta")
        {
            $(ren2).hide();
        }
    });
}

function cargarRSItems(){
    var URL = base_url + "facturas/ajax_getRSItems";
    $('#tblConceptosRS tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { id_factura : ID },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblConceptosRS tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var row = tab.insertRow();

                    row.dataset.id = elem.id;
                    row.dataset.item_id = elem.item_id;
                    row.dataset.rs = elem.rs;
                    row.dataset.descripcion = elem.descripcion;
                    row.dataset.monto = elem.monto;

                    row.insertCell().innerHTML = tab.rows.length;
                    row.insertCell().innerHTML = elem.rs;
                    row.insertCell().innerHTML = elem.item_id;
                    row.insertCell().innerHTML = elem.descripcion;
                    row.insertCell().innerHTML = elem.monto;
                    row.insertCell().innerHTML = '<button type="button" onclick="removeRSItem(this)" class="btn btn-xs btn-danger solicitud"><i class="fa fa-trash"></i> Eliminar</button>';
                    //row.insertCell().innerHTML = '';

                });

                conteoTablaRS();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}



function cargarComentarios(){
    var URL = base_url + "facturas/ajax_getComentarios";

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : ID },
        success: function(result) {
            if(result)
            {
                $('#ulComments').html("");
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
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function bloquearControles(){
    $('.bloqueo').attr('readonly', true);
    $('select').attr('disabled', true);
    $('#cbPagada').attr('disabled', true);
    $('#cbUrgente').attr('disabled', true);
    $('#btnRequisitor').attr('disabled', true);
    $('button.solicitud').hide();
}

function botonEstatus(estatus){
    ESTATUS = estatus;
    $('#btnEstatus').text(estatus);
    switch (estatus) {
        case "ABIERTO":
        case "RESPONDIDO":
            $('#btnEstatus').addClass("btn-primary");
            break;
            
        case "RECHAZADO":
            $('#btnEstatus').addClass("btn-danger");
            break;

        case "ACEPTADO":
            $('#btnEstatus').addClass("btn-success");
            break;

        case "CANCELADO":
        case "CERRADO":
            $('#btnEstatus').addClass("btn-default");
            break;

        case "PENDIENTE RECORRIDO":
        case "PENDIENTE ENTREGA":
        case "PENDIENTE RECOLECTA":
        case "EN RECORRIDO":
            $('#btnEstatus').addClass("btn-warning");
            break;
    
        default:
            break;
    }
}

function mdlClientes(){
    $('#mdlClientes').modal();
}

function buscarRequisitores(){
    var URL = base_url + "facturas/ajax_getRequisitores";
    $('#tblRequisitor tbody tr').remove();
    
    $.ajax({
        type: "POST",
        url: URL,
        data: { },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblRequisitor tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem)
                {
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = elem.Nombre;
                    ren.insertCell().innerHTML = elem.Puesto;
                    ren.insertCell().innerHTML = "<button type='button' onclick='seleccionarRequisitor(this)' value='" + elem.id +"' class='btn btn-default btn-xs'><i class='fa fa-check'></i> Seleccionar</button>";
                });

                $('#mdlRequisitor').modal();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
      });
}

function seleccionarRequisitor(btn){
    var URL = base_url + "facturas/ajax_getRequisitores";
    var id = $(btn).val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $('#btnRequisitor').data('id', rs.id);
                $('#btnRequisitor').data('nombre', rs.Nombre);
                $('#btnRequisitor').html("<i class='fa fa-user'></i> " + rs.Nombre);
    
                $('#mdlRequisitor').modal('hide');
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function buscarCliente(){
    var URL = base_url + "clientes/ajax_getClientes";
    $('#tblClientes tbody tr').remove();
    var nombre = $('#txtBuscarCliente').val().trim();
    
    $.ajax({
        type: "POST",
        url: URL,
        data: { nombre : nombre },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblClientes tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem)
                {
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = elem.nombre;
                    ren.insertCell().innerHTML = "<button type='button' onclick='seleccionarCliente(this)' value='" + elem.id +"' class='btn btn-default btn-xs'><i class='fa fa-check'></i> Seleccionar</button>";
                });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function seleccionarCliente(btn){
    var URL = base_url + "clientes/ajax_getClientes";
    var id = $(btn).val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $('#divCliente').show();
                $('#btnClientes').data('id', rs.id);
                $('#lblRazonSocialCliente').text(rs.razon_social);
                $('#lblRFCCliente').text(rs.rfc);

                var dir = rs.calle + ' ' + rs.numero + ' ' +((rs.numero_interior ? (rs.numero_interior + ' ') : '') + rs.colonia);
                $('#lblDireccionCliente').text(dir);
                $('#lblCreditoCliente').text(rs.credito_cliente == "1" ? (rs.credito_cliente_plazo + ' Días') : 'N/A')
                $('#lblHorarioFacturas').text(rs.horario_facturas);
                $('#lblUltimoDiaFacturas').text(rs.ultimo_dia_facturas);
                $('#txtCodigoImpresion').val(rs.codigo_impresion);
                $('#mdlClientes').modal('hide');

                //CONTACTO
                $('#pnlContacto').show();
                $('#btnContacto').data('id', 0);
                $('#divContacto').hide();

                if(ID == 0)
                {
                    DOCS_REQ = rs.documentos_facturacion;
                    leerDocumentos_SOLICITUD(JSON.parse(DOCS_REQ));
                }
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function mdlRS(){
    $('#mdlRS table tbody tr').remove();
    $('#txtBuscarRS').val('');
    $('#mdlRS').modal();
    $('#divSelectTodo').hide();
    $('#divSelectTodo input').iCheck('uncheck');

    buscarRS();
}

function buscarRS(){
    var URL = base_url + "facturas/ajax_getReporteServicios";
    $('#divSelectTodo').hide();
    $('#divSelectTodo input').iCheck('uncheck');
    $('#mdlRS table tbody tr').remove();
    
    var rs = $('#lblRS').is(':visible') ? $('#lblRS').data('rs') : $('#txtBuscarRS').val();
    var texto = $('#lblRS').is(':visible') ? $('#txtBuscarRS').val() : "";

    var items = [];
    var rowsItems = $('#tblConceptosRS tbody tr');
    $.each(rowsItems, function(i, elem){
        items.push(elem.dataset.item_id);
    });
    
    $.ajax({
        type: "POST",
        url: URL,
        data: { rs : rs, texto : texto },
        success: function(result) {
            if(result)
            {
                $('#divSelectTodo').show();
                var tab = $('#mdlRS table tbody')[0];
                var rs = JSON.parse(result);
                var no_rs = 0;
                
                $.each(rs, function(i, elem)
                {
                    no_rs = elem.folio_id;

                    var ena = items.includes(elem.item_id) ? 'checked disabled' : '';
                    var ren = tab.insertRow(tab.rows.length);

                    ren.dataset.id = 0;
                    ren.dataset.item_id = elem.item_id;
                    ren.dataset.rs = elem.folio_id;
                    ren.dataset.descripcion = elem.CadenaDescripcion;
                    ren.dataset.monto = elem.Monto;

                    ren.insertCell().innerHTML = elem.Solicitud_ID == 0 ? '<input type="checkbox" class="flat" ' + ena + '>' : 'N/A';
                    ren.insertCell().innerHTML = elem.folio_id;
                    ren.insertCell().innerHTML = elem.item_id;
                    ren.insertCell().innerHTML = elem.CadenaDescripcion;
                    ren.insertCell().innerHTML = elem.Monto;
                });

                $('#txtBuscarRS').val("");
                $('#txtBuscarRS').attr('placeholder', 'Buscar Descripción...')
                $('#lblRS').html('RS: ' + no_rs + ' <button type="button" onclick="deleteRS()" class="btn btn-xs btn-danger"><b>X</b></button>');
                $('#lblRS').data('rs', no_rs);
                $('#lblRS').show();
                
                $('#mdlRS table input.flat').iCheck({
                    checkboxClass: 'icheckbox_flat-green'
                });
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function deleteRS(){
    $('#txtBuscarRS').attr('placeholder', 'Buscar RS...')
    $('#lblRS').hide();
    buscarRS();
}

function selectTodoRS(){
    var ipt = $('#iptTodo').is(':checked');
    var rows = $('#mdlRS table tbody tr');
    $.each(rows, function (i, elem) { 
         if(($(elem).data('monto') || !ipt) && $(elem).find('input').is(':enabled'))
         {
            $(elem).find('input').iCheck(ipt ? 'check' : 'uncheck');
         }
    });
}


function leerDocumentos_SOLICITUD(docs){
    $('#tblDocumentos tbody tr').remove();
    var tab = $('#tblDocumentos tbody')[0];
    $.each(docs, function(i, elem)
    {
        if(elem.requerido == "1" && elem.origen == "Adjunto-Solicitud")
        {
            if(EDIT == "1")
            {
                var ren = tab.insertRow(tab.rows.length);
                ren.insertCell().innerHTML = '<b>' + elem.documento + '</b>';
                var format = elem.documento == "XML" ? "text/xml" : "application/pdf";
                var cell1 = ren.insertCell();
                cell1.innerHTML = elem.codigo + '_' + paddy(ID, 6);
                cell1.classList.add("fileName");
                var t = '<button class="btn btn-success btn-xs" data-campo="' + elem.campo + '" onclick="verDocumento(this)"><i class="fa fa-eye"></i> Ver Documento</button>';
                //ren.insertCell().innerHTML = t;

                var s = '<label class="btn btn-primary btn-xs" for="f_' + elem.codigo + '">';
                s += '<input accept="' + format + '" onchange="fileChange(this);" type="file" class="sr-only" id="f_' + elem.codigo + '">';
                s += '<i class="fa fa-upload"></i> Subir Archivo';
                s += '</label>';

                ren.insertCell().innerHTML = t + s;
            }
            else
            {
                var ren = tab.insertRow(tab.rows.length);
                ren.insertCell().innerHTML = '<b>' + elem.documento + '</b>';
                var format = elem.documento == "XML" ? "text/xml" : "application/pdf";
                var cell1 = ren.insertCell();
                cell1.innerHTML = 'N/A';
                cell1.classList.add("fileName");
                var t = '<label class="btn btn-primary btn-xs" for="f_' + elem.codigo + '">';
                t += '<input accept="' + format + '" onchange="fileChange(this);" type="file" class="sr-only" id="f_' + elem.codigo + '">';
                t += '<i class="fa fa-upload"></i> Subir Archivo';
                t += '</label>';
                ren.insertCell().innerHTML = t;
            }
        }
    });
}

function leerDocumentos_RESPUESTA(docs){
    var adjuntos = "";
    $('#tblDocumentos tbody tr').remove();
    var tab = $('#tblDocumentos tbody')[0];
    $.each(docs, function(i, elem){
        if(elem.requerido == "1")
        {
            if(elem.origen == "Adjunto-Solicitud")
            {
                var ren = tab.insertRow(tab.rows.length);
                ren.insertCell().innerHTML = '<b>' + elem.documento + '</b>';
                var cell1 = ren.insertCell();
                cell1.innerHTML = elem.codigo + '_' + paddy(ID, 6);
                cell1.classList.add("fileName");
                var t = '<button class="btn btn-success btn-xs" data-campo="' + elem.campo + '" onclick="verDocumento(this)"><i class="fa fa-eye"></i> Ver Documento</button>';
                ren.insertCell().innerHTML = t;

                var d = elem.documento == "Orden de Compra / Cotización" ? "PO / Cotización" : elem.documento;
                adjuntos += d + ": <input type='checkbox' class='flat' value='" + elem.campo + "' checked/>";
            }
        }
    });

    $.each(docs, function(i, elem){
        if(elem.requerido == "1")
        {
            if(elem.origen == "Adjunto-Respuesta")
            {
                if(ESTATUS == "ABIERTO" && RES == "1")
                {
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = '<b>' + elem.documento + '</b>';
                    var format = elem.documento == "XML" ? "text/xml" : "application/pdf";
                    var cell1 = ren.insertCell();
                    cell1.innerHTML = 'N/A';
                    cell1.classList.add("fileName");
                    var t = '<label class="btn btn-primary btn-xs" for="f_' + elem.codigo + '">';
                    t += '<input accept="' + format + '" onchange="fileChange(this);" type="file" class="sr-only" id="f_' + elem.codigo + '">';
                    t += '<i class="fa fa-upload"></i> Subir Documento';
                    t += '</label>';
                    ren.insertCell().innerHTML = t;
                } else if(ESTATUS == "ABIERTO" && RES == "0") {
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = '<b>' + elem.documento + '</b>';
                    var cell1 = ren.insertCell();
                    cell1.innerHTML = elem.codigo + '_' + paddy(ID, 6);
                    cell1.classList.add("fileName");
                    var t = 'N/A';
                    ren.insertCell().innerHTML = t;
                } else if(ESTATUS == "RECHAZADO") {
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = '<b>' + elem.documento + '</b>';
                    var cell1 = ren.insertCell();
                    cell1.innerHTML = elem.codigo + '_' + paddy(ID, 6);
                    cell1.classList.add("fileName");
                    var t = 'N/A';
                    ren.insertCell().innerHTML = t;
                } else {
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = '<b>' + elem.documento + '</b>';
                    var cell1 = ren.insertCell();
                    cell1.innerHTML = elem.codigo + '_' + paddy(ID, 6);
                    cell1.classList.add("fileName");
                    var t = '<button class="btn btn-success btn-xs" data-campo="' + elem.campo + '" onclick="verDocumento(this)"><i class="fa fa-eye"></i> Ver Documento</button>';
                    ren.insertCell().innerHTML = t;
                }

                adjuntos += elem.documento + ": <input type='checkbox' class='flat' value='" + elem.campo + "' checked/>";
            }
        }
    });

    $.each(docs, function(i, elem){
        if(elem.requerido == "1")
        {
            if(elem.origen != "Adjunto-Solicitud" && elem.origen != "Adjunto-Respuesta" && ESTATUS == "ACEPTADO")
            {
                if(elem.origen != "Proceso")
                {
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = '<b>' + elem.documento + '</b>';
                    var cell1 = ren.insertCell();
                    cell1.innerHTML = elem.codigo + '_' + paddy(ID, 6);
                    cell1.classList.add("fileName");
                    var t = '<button class="btn btn-success btn-xs" data-campo="' + elem.campo + '" onclick="verDocumentoGlobal(this)"><i class="fa fa-eye"></i> Ver Documento</button>';
                    ren.insertCell().innerHTML = t;

                    adjuntos += elem.documento + ": <input type='checkbox' class='flat' value='" + elem.campo + "' checked/>";
                }
            }
        }
    });


    $('#divAdjuntos').append(adjuntos);
}

function buscarContactos(){
    var URL = base_url + "clientes/ajax_getContactos";
    $('#tblContactos tbody tr').remove();
    var idCliente = $('#btnClientes').data('id');
    
    $.ajax({
        type: "POST",
        url: URL,
        data: { id_cliente : idCliente },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblContactos tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem)
                {
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = elem.nombre;
                    ren.insertCell().innerHTML = elem.puesto;
                    ren.insertCell().innerHTML = "<button type='button' onclick='seleccionarContacto(this)' value='" + elem.id +"' class='btn btn-default btn-xs'><i class='fa fa-check'></i> Seleccionar</button>";
                });

                $('#mdlContactos').modal();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function seleccionarContacto(btn){
    var URL = base_url + "clientes/ajax_getContactos";
    var id = $(btn).val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $('#btnContacto').data('id', rs.id);
                $('#lblNombreContacto').text(rs.nombre);
                $('#lblTelefonoContacto').text(rs.telefono + ' ' + rs.ext);
                $('#lblCorreoContacto').text(rs.correo);
                $('#tags_1').val(rs.correo);
    
                $('#mdlContactos').modal('hide');
                $('#divContacto').show();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function agregarConcepto(boton){
    var tab = $('#tblConceptos tbody')[0];
    var ren = tab.insertRow(tab.rows.length);
    ren.insertCell().innerHTML = (tab.rows.length + 1) / 2;
    var select = '<select style="width: 90%;" onchange="verDetalle(this)" required="required" name="optTipoServicio" class="select2_single form-control">'
    select +=       '<option value="Calibración">Calibración</option>'
    select +=       '<option value="Curso, entrenamiento, soporte, etc.">Curso, entrenamiento, soporte, etc.</option>'
    select +=       '<option value="Estudios Dimensionales">Estudios Dimensionales</option>'
    select +=       '<option value="Gastos de Envio">Gastos de Envio</option>'
    select +=       '<option value="Renta de Basculas">Renta de Basculas</option>'
    select +=       '<option value="Renta de Equipos">Renta de Equipos</option>'
    select +=       '<option value="Reparación">Reparación</option>'
    select +=       '<option value="Venta">Venta</option>'
    select +=       '<option value="Viatico">Viatico</option>'
    select += '</select>';
    ren.insertCell().innerHTML = select;
    var cell3 = ren.insertCell();
    //cell3.innerHTML = '<input name="txtPartidas" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 44 && event.charCode <= 45)" style="text-align:center; width: 40%; display: inline;" type="text" class="form-control" value="0">';
    cell3.innerHTML = '<input name="txtPartidas" style="text-align:center; width: 40%; display: inline;" type="text" class="form-control" value="0">';
    if(boton)
    {
        cell3.innerHTM += '<button onclick="eliminarConcepto(this)" style="margin-left: 10px;" type="button" class="btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>'
    }

    var ren2 = tab.insertRow(tab.rows.length);
    ren2.insertCell().innerHTML = "";
    ren2.insertCell().innerHTML = '<label name="lblModelo">Modelo:</label><input name="txtModelo" onkeyup="consultaModelo(this)" type="text" class="form-control">';
    ren2.insertCell().innerHTML = '<div style="display:none;" name="divSeries"><label>Series: </label><input name="txtSeries" type="text" class="form-control"></div>';
    $(ren2).hide();
}

function consultaModelo(txt){
    var URL = base_url + "facturas/ajax_getVFPData";

    var modelo = $(txt).val();
    modelo = modelo.trim().toUpperCase();

    var ren = $(txt).closest('tr');
    var txtSer = $(ren).find("input[name='txtSeries']");
    var divSer = $(ren).find("div[name='divSeries']");
    var lblMod = $(ren).find("label[name='lblModelo']");
    
    $(lblMod).text("Modelo:");
    $(txtSer).val("");
    $(divSer).hide();
    
    if(modelo)
    {
        $.ajax({
            type: "POST",
            url: URL,
            data: { modelo : modelo },
            success: function(result) {
                if(result)
                {
                    var rs = JSON.parse(result);
                    var control = rs.Table[0].ccontrol01;
                    var desc = rs.Table[0].cnombrep01;

                    $(lblMod).text(desc);

                    if(control == 4)
                    {
                        $(divSer).show();
                    }

                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}

function eliminarConcepto(btn){
    var ren1 = $(btn).closest('tr')[0];
    var ren2 = $("#tblConceptos").find('tr').eq(ren1.rowIndex + 1);

    $(ren1).remove();
    $(ren2).remove();
}

function verDetalle(opt){
    var ren = $(opt).closest('tr')[0];
    var ren = $("#tblConceptos").find('tr').eq(ren.rowIndex + 1);

    if($(opt).val() == "Venta")
    {
        $(ren).show();
    } else {
        $(ren).hide();
    }
    
}

function fileChange(ipt){
    var ren = $(ipt).closest('tr');
    var f = $(ipt)[0];
    $(ren).find('.fileName').text(f.files[0].name);


    if(f.id == "f_X" || f.id == "f_F")
    {
        var r1 = $('#f_F').closest('tr');
        r1 = $(r1).find('.fileName').text();

        var r2 = $('#f_X').closest('tr');
        r2 = $(r2).find('.fileName').text();

        if(r1 != "N/A" && r2 != "N/A")
        {
            if(r1.split('.')[0] != r2.split('.')[0])
            {
                var r3 = $('#' + f.id).closest('tr');
                $('#' + f.id).val('');
                $(r3).find('.fileName').text('N/A');
                
                alert("Archivos PDF y XML no coinciden");
                return;
            }
        }
    }
    

    if(f.id == "f_X")
    {
        file = f.files[0];
        if(file != undefined)
        {
            var URL = base_url + "facturas/ajax_readXML";
            var formdata = new FormData();
            
            formdata.append(f.id, file);
            
            var ajax = new XMLHttpRequest();
            ajax.onload = function () {
                if (ajax.readyState === ajax.DONE) {
                    if (ajax.status === 200) {
                        setInfoFactura(JSON.parse(ajax.responseText));
                    }
                }
            };
            ajax.open("POST", URL);
            ajax.send(formdata);
        }
    }
    
    
}

function setInfoFactura(dataArr){
    $('#pnlFactura').hide();
    $('#lblSerie').text("N/A");
    $('#lblSerie').data('valor', "N/A");
    $('#lblFolio').text("N/A");
    $('#lblFolio').data('valor', "N/A");
    $('#lblMontoFactura').text("N/A");
    $('#lblMontoFactura').data('valor', "N/A");


    if(dataArr != 0)
    {
        dataArr.forEach(element => {
            if(element.hasOwnProperty("Serie"))
            {
                $('#lblSerie').text(element["Serie"]);
                $('#lblSerie').data('valor', element["Serie"]);
            }
        });

        dataArr.forEach(element2 => {
            if (element2.hasOwnProperty("Folio"))
            {
                $('#lblFolio').text(element2["Folio"]);
                $('#lblFolio').data('valor', element2["Folio"]);
            }
        });


        dataArr.forEach(element3 => {
            if (element3.hasOwnProperty("Total"))
            {
                $('#lblMontoFactura').text(element3["Total"]);
                $('#lblMontoFactura').data('valor', element3["Total"]);
            }
        });

        $('#pnlFactura').show();
    }
    else
    {
        alert("Folio ya existe");
        $('#f_X').val('');
        var r = $('#f_X').closest('tr');
        $(r).find('.fileName').text('N/A');
    }

    
}

function bitacoraEstatus(){
    $('#tblBitacora tbody tr').remove();

    var ids = [];
    $.each(JSON.parse(SOLICITUD.bitacora_estatus), function (i, elem) { 
        if(!ids.includes(parseInt(elem[2])))
        {
            ids.push(parseInt(elem[2]));
        }
    });

    var URL = base_url + "cotizaciones/ajax_getNombresUsuarios";
    var dic = {}
    $.ajax({
        type: "POST",
        url: URL,
        data: { ids : JSON.stringify(ids) },
        success: function (response) {
            if(response){
                var rs = JSON.parse(response);

                $.each(rs, function (i, elem) { 
                     dic[elem.id] = elem.User;
                });

                var tbl = $('#tblBitacora tbody')[0];
                $.each(JSON.parse(SOLICITUD.bitacora_estatus), function (i, elem) { 
                    var row = tbl.insertRow();
                    row.insertCell().innerHTML = elem[0];
                    row.insertCell().innerHTML = elem[1];
                    row.insertCell().innerHTML = dic[elem[2]];
                });

                $('#mdlBitacora').modal();
            }
        }
    });
    
}

function validacion(){

    if(!$('#btnClientes').data('id'))
    {
        alert("Seleccione Cliente");
        return false;
    }
    if(!$('#txtOrdenCompra').val().trim())
    {
        alert("Ingrese No. de orden de compra");
        return false;
    }
    if(!$('#txtRS').val().trim())
    {
        alert("Ingrese Reporte de servicio");
        return false;
    }
    if(!$('#btnContacto').data('id'))
    {
        alert("Seleccione Contacto");
        return false;
    }
    if(!$('#optFormaPago').val())
    {
        alert("Seleccione Forma de pago");
        return false;
    }

    var rows = $('#tblConceptos tbody tr');
    for (let index = 0; index < rows.length; index = index + 2)
    {
        var tipo = $(rows[index]).find("select[name='optTipoServicio']").val();
        var partidas = $(rows[index]).find("input[name='txtPartidas']").val();
        var modelo = "N/A"; var series = "N/A";

        if(tipo == "Venta")
        {
            modelo = $(rows[index + 1]).find("input[name='txtModelo']").val();
            if($(rows[index + 1]).find("input[name='txtSeries']").is(":visible"))
            {
                series = $(rows[index + 1]).find("input[name='txtSeries']").val();
            }
        }

        if(!tipo)
        {
            alert("Seleccione Tipo de Servicio en concepto de facturación");
            return false;
        }
        if(!partidas)
        {
            alert("Especifique partidas en concepto de facturación");
            return false;
        }
        if(!modelo)
        {
            alert("Ingrese Modelo en concepto de facturación");
            return false;
        }
        if(!series)
        {
            alert("Ingrese Series en concepto de facturación");
            return false;
        }
    }

    if(EDIT != 1)
    {
        var docs = $('#tblDocumentos tbody input');
        for (let index = 0; index < docs.length; index++) {
            if(!$(docs[index]).val())
            {
                alert("Es necesario adjuntar los documentos requeridos");
                return false;
            }
        }
    }

    return confirm("¿Desea continuar?");
}

function enviarSolicitud(){
    if(validacion())
    {
        var conceptos = [];
        var rows = $('#tblConceptos tbody tr');
        for (let index = 0; index < rows.length; index = index + 2)
        {
            var concepto = {};
            concepto.Tipo = $(rows[index]).find("select[name='optTipoServicio']").val();
            concepto.Partidas = $(rows[index]).find("input[name='txtPartidas']").val().trim();
            if(concepto.Tipo == "Venta")
            {
                concepto.Modelo = $(rows[index + 1]).find("input[name='txtModelo']").val().trim();
                if($(rows[index + 1]).find("label[name='lblModelo']").text() != "Modelo:")
                {
                    concepto.Descripcion = $(rows[index + 1]).find("label[name='lblModelo']").text().trim();
                }
                if($(rows[index + 1]).find("input[name='txtSeries']").is(":visible"))
                {
                    concepto.Series = $(rows[index + 1]).find("input[name='txtSeries']").val().trim();
                }
            }
            conceptos.push(concepto);
        }

        var solicitud = {};
        solicitud.id = 0;
        solicitud.conceptos = JSON.stringify(conceptos);
        solicitud.ejecutivo = $('#btnRequisitor').data('id');
        solicitud.cliente = $('#btnClientes').data('id');
        solicitud.contacto = $('#btnContacto').data('id');
        solicitud.reporte_servicio = $('#txtRS').val().trim();
        solicitud.orden_compra = $('#txtOrdenCompra').val().trim();
        solicitud.forma_pago = $('#optFormaPago').val();
        solicitud.pagada = $('#cbPagada').is(':checked') ? "1" : "0";
        solicitud.urgente = $('#cbUrgente').is(':checked') ? "1" : "0";
        solicitud.codigo_impresion = $('#txtCodigoImpresion').val().trim();
        solicitud.estatus = "ABIERTO";
        solicitud.documentos_requeridos = DOCS_REQ;
        solicitud.notas = $('#txtNotas').val().trim();
        solicitud.serie = "";
        solicitud.folio = 0;
        var bitacora = [solicitud.estatus, moment().format('D/MM/YYYY h:mm A'), ID_USER];
        solicitud.bitacora_estatus = JSON.stringify([bitacora]);


        var rs_items = [];
        rows = $('#tblConceptosRS tbody tr');
        for (let index = 0; index < rows.length; index++)
        {
            var item = {};
            item.BORRAR = $(rows[index]).is(':visible');
            item.id = $(rows[index]).data('id');
            item.item_id = $(rows[index]).data('item_id');
            item.rs = $(rows[index]).data('rs');
            item.descripcion = $(rows[index]).data('descripcion');
            item.monto = $(rows[index]).data('monto');

            rs_items.push(item);
        }



        var other = {};
        other.User = $('#btnRequisitor').data('nombre');
        other.Client = $('#lblRazonSocialCliente').text();
        other.Contact = $('#lblNombreContacto').text();

        var URL = base_url + "facturas/ajax_setSolicitud";
        /////////////////////////////////////////////////////
        var docs = $('#tblDocumentos tbody input');
        var formdata = new FormData();

        $.each(docs, function(i, e)
        {
            var f = $(e)[0];
            f = f.files[0];
            formdata.append(e.getAttribute("id"), f);
        });

        formdata.append("solicitud", JSON.stringify(solicitud));
        formdata.append("other", JSON.stringify(other));
        formdata.append("rs_items", JSON.stringify(rs_items));

        var ajax = new XMLHttpRequest();
        ajax.addEventListener("progress", updateProgress, false);
        ajax.addEventListener("load", complete, false);
        ajax.open("POST", URL);
        ajax.send(formdata);
    }

}

function editarSolicitud(){
    

    if(validacion()){
        var conceptos = [];
        var rows = $('#tblConceptos tbody tr');
        for (let index = 0; index < rows.length; index = index + 2)
        {
            var concepto = {};
            concepto.Tipo = $(rows[index]).find("select[name='optTipoServicio']").val();
            concepto.Partidas = $(rows[index]).find("input[name='txtPartidas']").val().trim();
            if(concepto.Tipo == "Venta")
            {
                concepto.Modelo = $(rows[index + 1]).find("input[name='txtModelo']").val().trim();
                if($(rows[index + 1]).find("label[name='lblModelo']").text() != "Modelo:")
                {
                    concepto.Descripcion = $(rows[index + 1]).find("label[name='lblModelo']").text().trim();
                }
                if($(rows[index + 1]).find("input[name='txtSeries']").is(":visible"))
                {
                    concepto.Series = $(rows[index + 1]).find("input[name='txtSeries']").val().trim();
                }
            }
            conceptos.push(concepto);
        }

        var solicitud = {};
        solicitud.conceptos = JSON.stringify(conceptos);
        solicitud.id = ID;
        solicitud.usuario = $('#btnRequisitor').data('id');
        solicitud.cliente = $('#btnClientes').data('id');
        solicitud.contacto = $('#btnContacto').data('id');
        solicitud.reporte_servicio = $('#txtRS').val().trim();
        solicitud.orden_compra = $('#txtOrdenCompra').val().trim();
        solicitud.forma_pago = $('#optFormaPago').val();
        solicitud.pagada = $('#cbPagada').is(':checked') ? "1" : "0";
        solicitud.urgente = $('#cbUrgente').is(':checked') ? "1" : "0";
        solicitud.codigo_impresion = $('#txtCodigoImpresion').val().trim();
        solicitud.estatus = "ABIERTO";
        solicitud.documentos_requeridos = DOCS_REQ;
        solicitud.notas = $('#txtNotas').val().trim();
        solicitud.serie = "";
        solicitud.folio = 0;
        solicitud.bitacora_estatus = JSON.parse(SOLICITUD.bitacora_estatus);
        solicitud.bitacora_estatus.push([solicitud.estatus, moment().format('D/MM/YYYY h:mm A'), ID_USER]);
        solicitud.bitacora_estatus = JSON.stringify(solicitud.bitacora_estatus);

        var other = {};
        other.User = $('#btnRequisitor').data('nombre');
        other.Client = $('#lblRazonSocialCliente').text();
        other.Contact = $('#lblNombreContacto').text();

        var rs_items = [];
        rows = $('#tblConceptosRS tbody tr');
        for (let index = 0; index < rows.length; index++)
        {
            var item = {};
            item.BORRAR = !$(rows[index]).is(':visible');
            item.id = $(rows[index]).data('id');
            item.item_id = $(rows[index]).data('item_id');
            item.rs = $(rows[index]).data('rs');
            item.descripcion = $(rows[index]).data('descripcion');
            item.monto = $(rows[index]).data('monto');
            rs_items.push(item);
        }

        var URL = base_url + "facturas/ajax_setSolicitud";
        /////////////////////////////////////////////////////////
        var docs = $('#tblDocumentos tbody input');
        var formdata = new FormData();

        $.each(docs, function(i, e)
        {
            var f = $(e)[0];
            f = f.files[0];
            if(f != undefined)
            {
                formdata.append(e.getAttribute("id"), f);
            }
        });

        formdata.append("solicitud", JSON.stringify(solicitud));
        formdata.append("other", JSON.stringify(other));
        formdata.append("rs_items", JSON.stringify(rs_items));

        var ajax = new XMLHttpRequest();
        ajax.addEventListener("progress", updateProgress, false);
        ajax.addEventListener("load", complete, false);
        ajax.open("POST", URL);
        ajax.send(formdata);
    }

}

function enviarRecorrido(){
    if(confirm("¿Desea continuar?")){

        var solicitud = {};
        solicitud.id = ID;
        solicitud.estatus = "PENDIENTE RECORRIDO";
        var URL = base_url + "facturas/ajax_setSolicitud";
        /////////////////////////////////////////////////////////
        var formdata = new FormData();


        formdata.append("solicitud", JSON.stringify(solicitud));

        var ajax = new XMLHttpRequest();
        ajax.addEventListener("progress", updateProgress, false);
        ajax.addEventListener("load", complete, false);
        ajax.open("POST", URL);
        ajax.send(formdata);
    }

}

function cerrarSolicitud(){
    if(confirm("¿Desea continuar?")){

        var solicitud = {};
        solicitud.id = ID;
        solicitud.estatus = "CERRADO";
        var URL = base_url + "facturas/ajax_setSolicitud";
        /////////////////////////////////////////////////////////
        var formdata = new FormData();


        formdata.append("solicitud", JSON.stringify(solicitud));

        var ajax = new XMLHttpRequest();
        ajax.addEventListener("progress", updateProgress, false);
        ajax.addEventListener("load", complete, false);
        ajax.open("POST", URL);
        ajax.send(formdata);
    } 

}

function actualizar(evt){
    $.redirect( base_url + "facturas/ver_solicitud", { 'id': ID });
}

function complete(evt){
    $("#btnEnviar").html("<i class='fa fa-send'></i> Enviar Solicitud");
    window.location.href = base_url + 'facturas/solicitudes';

}

 function updateProgress(evt) {
    $("#btnEnviar").html("<i class='fa fa-spinner fa-spin'></i> Procesando...");
    /*if (evt.lengthComputable) {
        var percentComplete = evt.loaded / evt.total;
    }*/
 }

function verDocumento(btn){
    var campo = $(btn).data('campo');
    if(campo == "f_xml")
    {
        $.redirect( base_url + "archivos/descarga", { 'id': ID, 'tabla' : 'solicitudes_facturas', campo : campo }, 'POST', '_blank');
    } else {
        $.redirect( base_url + "archivos/documento", { 'id': ID, 'tabla' : 'solicitudes_facturas', campo : campo }, 'POST', '_blank');
    }

    
}

function verDocumentoGlobal(btn){
    var campo = $(btn).data('campo');
    var doc;
    
    switch(campo){
        case "opinion_positiva":
            doc = "OPINION";
            break;
        
        case "emision_sua":
            doc = "EMISION";
            break;
    }

    var URL = base_url + "data/empresas/documentos_globales/" + doc + "_" + paddy(1, 6) + ".pdf";
    window.open(URL, '_blank');
}

////////////////////////

function validacionEnviarDoc(){
    var docs = $('#tblDocumentos tbody input');
    for (let index = 0; index < docs.length; index++) {
        if(!$(docs[index]).val())
        {
            alert("Es necesario adjuntar los documentos requeridos (Archivo PDF)");
            return false;
        }
    }


    return confirm("¿Desea continuar?");
}

function mdlRechazar(){
    $('#txtComentarios').val("");
    $('#btnRechazar').show();
    $('#btnComentario').hide();
    $('#mdlComentarioTitle').text('Rechazar Solicitud');
    $('#mdlComentario').modal();
}

function mdlRechazarDocs(){
    $('#txtComentarios').val("");
    $('#btnRechazar').show();
    $('#btnComentario').hide();
    $('#mdlComentarioTitle').text('Rechazar Respuesta');
    $('#mdlComentario').modal();
}

function mdlComentario(){
    $('#txtComentarios').val("");
    $('#btnComentario').show();
    $('#btnRechazar').hide();
    $('#mdlComentarioTitle').text('Agregar Comentario');
    $('#mdlComentario').modal();
}

function rechazar(){
    var URL = base_url + "facturas/ajax_editSolicitud";
    var comentario = $("#txtComentarios").val().trim();
    if(comentario.length >= 10)
    {
        if($('#mdlComentarioTitle').text() == "Rechazar Solicitud")
        {
            comentario = "<b><font color=red>SOLICITUD RECHAZADA:</font></b> " + comentario;
        }
        else if($('#mdlComentarioTitle').text() == "Rechazar Respuesta")
        {
            comentario = "<b><font color=red>RESPUESTA RECHAZADA:</font></b> " + comentario;
        }
        var solicitud = {};
        solicitud.id = ID;
        solicitud.estatus = "RECHAZADO";
        solicitud.notas = $('#txtNotas').val().trim();
        solicitud.bitacora_estatus = JSON.parse(SOLICITUD.bitacora_estatus);
        solicitud.bitacora_estatus.push([solicitud.estatus, moment().format('D/MM/YYYY h:mm A'), ID_USER]);
        solicitud.bitacora_estatus = JSON.stringify(solicitud.bitacora_estatus);
        
        var other = {};
        other.User = $('#btnRequisitor').data('nombre');
        other.Client = $('#lblRazonSocialCliente').text();
        other.Contact = $('#lblNombreContacto').text();

        $.ajax({
            type: "POST",
            url: URL,
            data: { solicitud : JSON.stringify(solicitud), other : JSON.stringify(other), comentario : comentario },
            success: function(result) {
                if(result)
                {
                    $.redirect( base_url + "facturas/ver_solicitud", { 'id': ID });
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
    else{
        alert("Ingrese motivo de rechazo (min. 10 Caracteres)");
    }
}

function agregarComentario(){
    var URL = base_url + "facturas/ajax_setComentarios";
    var comentario = $("#txtComentarios").val().trim();
    if(comentario.length > 0)
    {
        var ob = {};
        ob.solicitud = ID;
        ob.comentario = comentario;

        $.ajax({
            type: "POST",
            url: URL,
            data: { comentario : JSON.stringify(ob) },
            success: function(result) {
                if(result)
                {
                    $('#mdlComentario').modal('hide');
                    cargarComentarios();
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
    else{
        alert("Comentario en blanco");
    }
}

function enviarDoc(){

    if(validacionEnviarDoc()){
        var solicitud = {};
        solicitud.id = ID;
        solicitud.estatus = "RESPONDIDO";
        solicitud.notas = $('#txtNotas').val().trim();
        solicitud.serie = $('#lblSerie').data('valor');
        solicitud.folio = $('#lblFolio').data('valor');
        solicitud.bitacora_estatus = JSON.parse(SOLICITUD.bitacora_estatus);
        solicitud.bitacora_estatus.push([solicitud.estatus, moment().format('D/MM/YYYY h:mm A'), ID_USER]);
        solicitud.bitacora_estatus = JSON.stringify(solicitud.bitacora_estatus);

        var URL = base_url + "facturas/ajax_editSolicitud";
        /////////////////////////////////////////////////////////
        var docs = $('#tblDocumentos tbody input');
        var formdata = new FormData();

        $.each(docs, function(i, e)
        {
            var f = $(e)[0];
            f = f.files[0];
            formdata.append(e.getAttribute("id"), f);
        });


        var other = {};
        other.User = $('#btnRequisitor').data('nombre');
        other.Client = $('#lblRazonSocialCliente').text();
        other.Contact = $('#lblNombreContacto').text();

        formdata.append("solicitud", JSON.stringify(solicitud));
        formdata.append("other", JSON.stringify(other));

        var ajax = new XMLHttpRequest();
        ajax.addEventListener("progress", updateProgress, false);
        ajax.addEventListener("load", complete, false);
        ajax.open("POST", URL);
        ajax.send(formdata);
    }
}

function aceptarDocs(){

    if(confirm("¿Desea continuar?")){
        var solicitud = {};
        solicitud.id = ID;
        solicitud.estatus = "ACEPTADO";
        solicitud.estatus_factura = "ACEPTADO";
        solicitud.folio = $('#lblFolio').data('valor');
        solicitud.notas = $('#txtNotas').val().trim();
        solicitud.bitacora_estatus = JSON.parse(SOLICITUD.bitacora_estatus);
        solicitud.bitacora_estatus.push([solicitud.estatus, moment().format('D/MM/YYYY h:mm A'), ID_USER]);
        solicitud.bitacora_estatus = JSON.stringify(solicitud.bitacora_estatus);

        var URL = base_url + "facturas/ajax_editSolicitud";
        /////////////////////////////////////////////////////////
        var docs = $('#tblDocumentos tbody input');
        var formdata = new FormData();

        $.each(docs, function(i, e)
        {
            var f = $(e)[0];
            f = f.files[0];
            if(f != undefined)
            {
                formdata.append(e.getAttribute("id"), f);
            }
        });

        var other = {};
        other.User = $('#btnRequisitor').data('nombre');
        other.Client = $('#lblRazonSocialCliente').text();
        other.Contact = $('#lblNombreContacto').text();

        formdata.append("solicitud", JSON.stringify(solicitud));
        formdata.append("other", JSON.stringify(other));

        var ajax = new XMLHttpRequest();
        ajax.addEventListener("progress", updateProgress, false);
        ajax.addEventListener("load", actualizar, false);
        ajax.open("POST", URL);
        ajax.send(formdata);
    }
}

function codigoImpresion(){
    //ORIGINAL
    //var arr = [ 'F', 'X', 'R', 'O', 'P', 'A', 'V', 'S' ];
    var arr = [ 'F', 'R', 'O', 'P', 'A', 'S' ]; 

    if(!arr.includes(event.key.toUpperCase()))
    {
        event.preventDefault();
    }
}

function imprimir(){
    var codigo = $('#txtCodigoImpresion').val().trim();
    if(codigo)
    {
        $.redirect( base_url + "facturas/archivo_impresion", { 'id': ID, 'codigo' : codigo }, 'POST', '_blank');
    }
    else{
        alert("Código de impresión esta vacio");
    }
}

function mdlCorreo(){
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
        var URL = base_url + 'facturas/ajax_enviarCorreo';
        var text = $('#editor-one').html();
        var docs = $('#divAdjuntos input[type="checkbox"]:checked');
        var para = $('#tags_1').val();
        var cc = $('#tags_2').val();
        var fact = $('#lblSerie').data('valor') + "-" + $('#lblFolio').data('valor');
        var subject = "MASMetrología: CFDI " + fact;
        

        var campos = [];
        $.each(docs, function(i, elem){
            campos.push($(elem).val());
        });

        $.ajax({
            type: "POST",
            url: URL,
            data: { body : text, para : para, cc : cc, subject : subject, id : ID, campos : JSON.stringify(campos)},
            success: function (result) 
            {
                if (result) {
                }
            },
        });
    }
}

///////////////////////
function conteoTablaRS(){
    var c = 0;
    var monto = 0;
    var rowsItems = $('#tblConceptosRS tbody tr');
    $.each(rowsItems, function(i, elem){
        if($(elem).is(':visible'))
        {
            $(elem).find('td').eq(0).html(i + 1);
            monto += parseFloat($(elem).data('monto'));
            c++;
        }
    });

    $('#lblItemsCount').html("<b>" + c + " Items, Total: $" + monto.toFixed(2) + "</b>");
}

function agregarRSItems(){
    if($('#mdlRS table input:checked:enabled').length == 0){
        alert("No hay elementos seleccionados");
        return;
    }

    var tablaItems = $('#tblConceptosRS tbody')[0];

    var rows = $('#mdlRS table tbody tr');

    $.each(rows, function(i, elem){
        if($(elem).find('input').is(':checked') && $(elem).find('input').is(':enabled'))
        {
            var row = tablaItems.insertRow();
            row.dataset.id = elem.dataset.id;
            row.dataset.item_id = elem.dataset.item_id;
            row.dataset.rs = elem.dataset.rs;
            row.dataset.descripcion = elem.dataset.descripcion;
            row.dataset.monto = elem.dataset.monto;

            row.insertCell().innerHTML = tablaItems.rows.length;
            row.insertCell().innerHTML = elem.dataset.rs;
            row.insertCell().innerHTML = elem.dataset.item_id;
            row.insertCell().innerHTML = elem.dataset.descripcion;
            row.insertCell().innerHTML = elem.dataset.monto;
            row.insertCell().innerHTML = '<button type="button" onclick="removeRSItem(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Eliminar</button>';
        }
    });

    conteoTablaRS();
    $('#mdlRS').modal('hide');
}

function removeRSItem(btn){
    if(!confirm("¿Desea eliminar Item?"))
        return;


    var tr = $(btn).closest('tr');
    var id = $(tr).data('id');

    if(id == 0)
    {
        $(tr).remove();
    }
    else
    {
        $(tr).hide();
    }

    conteoTablaRS();
}