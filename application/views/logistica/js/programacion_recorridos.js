function load(){
    buscar();
    eventos();
    iniciar_daterangepicker();
}

function eventos(){
    $('input[name="rbUsuarios"]').on('ifChecked', function(){
        buscarMensajeros();
    });
}

function iniciar_daterangepicker() {

    if( typeof ($.fn.daterangepicker) === 'undefined'){ return; }

    $('#dtpFecha').daterangepicker({
        singleDatePicker: true,
        singleClasses: "picker_4",
        startDate: moment(),
    }, function(start, end, label) {

    });
    


}

function buscar(){
    $('#btnContinuar').hide();

    buscarEntregaFacturas();
    buscarRecolectaFacturas();
    buscarCierre();
}

function buscarEntregaFacturas(){
    var URL = base_url + "logistica/ajax_getSolicitudes";
    $('#tblEntregaFacturas tbody tr').remove();
    
    var data = {};
    data.estatus_factura = "ENTREGA";

    $.ajax({
        type: "POST",
        url: URL,
        data: data,
        success: function(result) {
            if(result)
            {
                var tab = $('#tblEntregaFacturas tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    
                    ren.dataset.tipo = 'FACTURA';
                    ren.dataset.id_concepto = elem.id;
                    ren.dataset.rs = elem.reporte_servicio;
                    ren.dataset.cliente = "CLIENTE FACTURA";
                    ren.dataset.descripcion = "FACTURA: " + elem.serie + "-" + elem.folio;
                    ren.dataset.accion = 'ENTREGA';

                    ren.insertCell().innerHTML = "<input type='checkbox' class='flat selecc'>";
                    ren.insertCell().innerHTML = elem.folio;
                    ren.insertCell().innerHTML = elem.User;
                    ren.insertCell().innerHTML = elem.Cliente;
                    ren.insertCell().innerHTML = elem.orden_compra;
                    ren.insertCell().innerHTML = elem.reporte_servicio;
                    ren.insertCell().innerHTML = boton(elem.estatus_factura);
                    ren.insertCell().innerHTML = elem.Recorridos > 0 ? "<button type='button' onclick=verRecorridos(this) class='btn btn-primary btn-sm'><i class='fa fa-truck'></i> " + elem.Recorridos + "</button>" : "N/A";
                });

                $('input.selecc').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });

                $('input.selecc').on('ifChanged', function (e) { 

                    if($('input.selecc:checked').length > 0){
                        $('#btnContinuar').show();
                    }else{
                        $('#btnContinuar').hide();
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

function buscarRecolectaFacturas(){
    var URL = base_url + "logistica/ajax_getSolicitudes";
    $('#tblRecolectaFacturas tbody tr').remove();
    
    var data = {};
    data.estatus_factura = "RECOLECTA";

    $.ajax({
        type: "POST",
        url: URL,
        data: data,
        success: function(result) {
            if(result)
            {
                var tab = $('#tblRecolectaFacturas tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id = elem.id;
                    ren.dataset.recorrido = 'RECOLECTA';

                    ren.insertCell().innerHTML = "<input type='checkbox' class='flat selecc'>";
                    ren.insertCell().innerHTML = elem.folio;
                    ren.insertCell().innerHTML = elem.User;
                    ren.insertCell().innerHTML = elem.Cliente;
                    ren.insertCell().innerHTML = elem.orden_compra;
                    ren.insertCell().innerHTML = elem.reporte_servicio;
                    ren.insertCell().innerHTML = boton(elem.estatus_factura);
                    ren.insertCell().innerHTML = elem.fecha_retorno;
                    ren.insertCell().innerHTML = elem.Recorridos > 0 ? "<button type='button' onclick=verRecorridos(this) class='btn btn-primary btn-sm'><i class='fa fa-truck'></i> " + elem.Recorridos + "</button>" : "N/A";
                });

                $('input.selecc').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });

                $('input.selecc').on('ifChanged', function (e) { 

                    if($('input.selecc:checked').length > 0){
                        $('#btnContinuar').show();
                    }else{
                        $('#btnContinuar').hide();
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

function buscarCierre(){
    $('#divCierreRecorridos').hide();
    var URL = base_url + "logistica/ajax_getRecorridosPendienteCierre";
    
    $('#tblCierre tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        success: function(result) {
            if(result)
            {
                var tab = $('#tblCierre tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id = elem.id;

                    ren.insertCell().innerHTML = paddy(elem.id, 4);
                    ren.insertCell().innerHTML = elem.Mensajero;
                    ren.insertCell().innerHTML = elem.fecha_recorrido;
                    
                    var btn = "<div class='btn-group'><button type='button' data-toggle='dropdown' class='btn btn-warning dropdown-toggle btn-sm'>" + elem.estatus + "  <span class='caret'></span></button>";
                    btn += "<ul role='menu' class='dropdown-menu'>";
                    btn += "<li><a onclick=aceptarCierre(this)><i class='fa fa-check'></i> Aceptar Cierre</a></li>";
                    btn += "<li><a onclick=mdlRechazarCierre(this)><i class='fa fa-close'></i> Rechazar Cierre</a></li></ul></div>";
                    ren.insertCell().innerHTML = btn;
                    ren.insertCell().innerHTML = '<button type="button" onclick="verRecorrido(this)" class="btn btn-primary"><i class="fa fa-truck"></i> Ver Recorrido</button>';
                });

                $('#divCierreRecorridos').show();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function boton(estatus){
    var clase = "btn dropdown-toggle btn-sm";
    opcs = "<ul role='menu' class='dropdown-menu'>";
    opcs += "<li><a onclick=ver(this)><i class='fa fa-eye'></i> Ver Solicitud</a></li>";
    

    switch(estatus){
        case "RECIBIDO EN LOGISTICA":
            clase += " btn-primary";
            break;

        case "DEJADA CON CLIENTE":
            clase += " btn-success";
            break;
            
        case "NO ENTREGADA":
        case "NO RECOLECTADA":
        case "ENTREGA RECHAZADA":
        case "RECOLECTA RECHAZADA":
            clase += " btn-danger";
            break;
    }
    var btn = "<div class='btn-group'><button type='button' data-toggle='dropdown' class='" + clase + "'>" + estatus + "  <span class='caret'></span></button>";
    btn += opcs;
    return btn;


}

function catalogoUsuarios(){
    buscarMensajeros();
    $('#mdlUsuarios').modal();
}

function buscarMensajeros(){
    var URL = base_url + "logistica/ajax_getMensajeros";
    $('#tblUsuarios tbody tr').remove();

    var mensajeros = $('input[name="rbUsuarios"]:checked').val();


    $.ajax({
        type: "POST",
        url: URL,
        data: { mensajeros : mensajeros },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblUsuarios tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = '<img class="avatar" src="' + base_url + 'usuarios/photo/' + elem.id + '" alt="img" />';
                    ren.insertCell().innerHTML = elem.CompleteName;
                    ren.insertCell().innerHTML = "<button type='button' data-name='" + elem.CompleteName + "' value='"+ elem.id +"' onclick='seleccionarUsuario(this)' class='btn btn-primary btn-xs'><i class='fa fa-check'></i> Seleccionar</button>";
                });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function seleccionarUsuario(btn){

    var idUser = $(btn).val();
    var name = $(btn).data('name');

    if(idUser == 0)
    {
        $('#lblUserName').text("Mensajero");
        $('#imgUser').attr('src', base_url + 'template/images/avatar.png');
    }
    else
    {
        $('#lblUserName').text(name);
        $('#imgUser').attr('src', base_url + 'usuarios/photo/' + idUser);
    }

    $('#tblUsuario').data('user', idUser);
    $('#mdlUsuarios').modal('hide');

}

function ver(a){
    var ren = $(a).closest('tr');
    var id = $(ren).data('id');

    $.redirect( base_url + "facturas/ver_solicitud", { 'id': id }, 'POST', '_blank');
}

function verRecorridos(btn){
    var URL = base_url + "logistica/ajax_getRecorridos";
    $('#tblRecorridos tbody tr').remove();
    
    var ren = $(btn).closest('tr');
    var id = $(ren).data('id');

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

function continuar(){
    //Mensajero
    $('#lblUserName').text("Mensajero");
    $('#imgUser').attr('src', base_url + 'template/images/avatar.png');
    $('#tblUsuario').data('user', 0);


    $('#tblFolios tbody tr').remove();
    var rows = $("#tblEntregaFacturas tbody tr");
    var rows2 = $("#tblRecolectaFacturas tbody tr");

    var tab = $('#tblFolios tbody')[0];
    $.each(rows, function(i, elem){
        if($(elem).find('input.selecc').is(':checked'))
        {
            var ren = tab.insertRow(tab.rows.length);
            
            ren.dataset.tipo = elem.dataset.tipo;
            ren.dataset.id_concepto = elem.dataset.id_concepto;
            ren.dataset.rs = elem.dataset.rs;
            ren.dataset.cliente = elem.dataset.cliente;
            ren.dataset.descripcion = elem.dataset.descripcion;
            ren.dataset.accion = elem.dataset.accion;
            

            ren.insertCell().innerHTML = $(elem).find('td').eq(1).text();
            ren.insertCell().innerHTML = $(elem).find('td').eq(3).text();
            ren.insertCell().innerHTML = $(elem).find('td').eq(4).text();
            ren.insertCell().innerHTML = $(elem).find('td').eq(5).text();
            ren.insertCell().innerHTML = "Entrega <font color='green'><i class='fa fa-arrow-right'></i></font>";
        }
    });

    $.each(rows2, function(i, elem){
        if($(elem).find('input.selecc').is(':checked'))
        {
            var ren = tab.insertRow(tab.rows.length);
            
            
            ren.dataset.id = elem.dataset.id;
            ren.dataset.recorrido = elem.dataset.recorrido;
            

            ren.insertCell().innerHTML = $(elem).find('td').eq(1).text();
            ren.insertCell().innerHTML = $(elem).find('td').eq(3).text();
            ren.insertCell().innerHTML = $(elem).find('td').eq(4).text();
            ren.insertCell().innerHTML = $(elem).find('td').eq(5).text();
            ren.insertCell().innerHTML = "Recolecta <font color='red'><i class='fa fa-arrow-left'></i></font>";
        }
    });

    $('#mdlRecorrido').modal();
}

function aceptar(){
    if(validacion())
    {
        var URL = base_url + "logistica/ajax_setRecorrido";
        
        var rows = $("#tblFolios tbody tr");

        var data = [];
        $.each(rows, function(i, elem){
            data.push([elem.dataset.tipo, elem.dataset.id_concepto, elem.dataset.rs, elem.dataset.cliente, elem.descripcion, elem.accion]);
        });

        var mensajero = $('#tblUsuario').data('user')
        var fecha = $('#dtpFecha').val();

        $.ajax({
            type: "POST",
            url: URL,
            data: { mensajero : mensajero, fecha : moment(fecha).format('YYYY-MM-D'), recorrido : JSON.stringify(data) },
            success: function(result) {
                $('#mdlRecorrido').modal('hide');
                new PNotify({ title: 'Recorrido', text: 'Se ha generado nuevo recorrido', type: 'success', styling: 'bootstrap3' });
                buscar();
              },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}

function validacion(){
    var dtpFecha = $('#dtpFecha').val() + " 23:59:59";

    if(moment() > moment(dtpFecha))
    {
        alert('Fecha invalida');
        return false;
    }
    if($('#tblUsuario').data('user') == 0)
    {
        alert('Seleccione mensajero');
        return false;
    }

    return confirm("¿Desea continuar?");

    
}

function verRecorrido(btn){
    var URL = base_url + "logistica/ajax_getFacturasRecorrido";
    $('#tblVerRecorrido tbody tr').remove();
    
    var ren = $(btn).closest('tr');
    var id = $(ren).data('id');

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblVerRecorrido tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow();

                    var accion = elem.accion;
                    if(accion == "ENTREGA")
                    {
                        accion += " <font color='green'><i class='fa fa-arrow-right'></i></font>";
                    }
                    else if(accion == "RECOLECTA")
                    {
                        accion += " <font color='red'><i class='fa fa-arrow-left'></i></font>";
                    }

                    ren.insertCell().innerHTML = "N/A";
                    ren.insertCell().innerHTML = elem.folio;
                    ren.insertCell().innerHTML = accion;
                    ren.insertCell().innerHTML = elem.estatus;

                    
                });
                $('#mdlVerRecorrido .modal-title').text("Recorrido: " + paddy(id, 4));
                $('#mdlVerRecorrido .modal-footer').hide();
                $('#mdlVerRecorrido').modal();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function aceptarCierre(btn){
    if(!confirm("¿Acepta el cierre de recorrido?"))
    {
        return;
    }
    var URL = base_url + "logistica/ajax_aceptarCierreRecorrido";
    
    var ren = $(btn).closest('tr');

    var recorrido = {};
    recorrido.id = $(ren).data('id');
    recorrido.estatus = "CERRADO";
    
    $.ajax({
        type: "POST",
        url: URL,
        data: { recorrido : JSON.stringify(recorrido) },
        success: function(result) {
            buscar();
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function rechazarCierre(btn){
    if($('#tblVerRecorrido input.cierre:checked').length <= 0)
    {
        alert('Seleccione al menos 1 factura');
        return;
    }
    if(!confirm("¿Desea continuar?"))
    {
        return;
    }

    var URL = base_url + "logistica/ajax_rechazarCierreRecorrido";

    var recorrido = {};
    recorrido.id = $(btn).data('id');
    recorrido.estatus = "CERRADO CON DISCREPANCIA";

    var facturas = [];
    $.each($('#tblVerRecorrido tbody tr'), function(i, row){
        if($(row).find('input.cierre').is(':checked'))
        {
            facturas.push(row.dataset.id);
        }
    });


    
    $.ajax({
        type: "POST",
        url: URL,
        data: { recorrido : JSON.stringify(recorrido), facturas : JSON.stringify(facturas) },
        success: function(result) {
            $('#mdlVerRecorrido').modal('hide');
            buscar();
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function mdlRechazarCierre(btn){
    var URL = base_url + "logistica/ajax_getFacturasRecorrido";
    $('#tblVerRecorrido tbody tr').remove();
    
    var ren = $(btn).closest('tr');
    var id = $(ren).data('id');

    $('#btnRechazarRecorrido').data('id', id);

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblVerRecorrido tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow();
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

                    ren.insertCell().innerHTML = "<input type='checkbox' class='flat cierre'>";
                    ren.insertCell().innerHTML = elem.folio;
                    ren.insertCell().innerHTML = accion;
                    ren.insertCell().innerHTML = elem.estatus;

                    
                });
                $('input.cierre').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });

                $('#mdlVerRecorrido .modal-title').text("Recorrido: " + paddy(id, 4) + "... Seleccione factura con discrepancia");
                $('#mdlVerRecorrido .modal-footer').show();
                $('#mdlVerRecorrido').modal();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}