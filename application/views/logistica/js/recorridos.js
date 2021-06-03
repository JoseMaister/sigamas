function load(){


    eventos();
    buscar();
    iniciar_daterangepicker();
}

function eventos(){
    $('input[name="rbModal"]').on('ifChanged', function(){
        validacionEntrega(this);
    });

    $('input[name="rbRecolecta"]').on('ifChanged', function(){
        $('#opContactos').val(0);
        if($('#rbDejada').is(":checked"))
        {
            $("#divFecha").show();
        }
        else{
            $("#divFecha").hide();
        }
    });

    $('.busqueda').on('ifChanged', function(){
        buscar();
    });

    $('#opContactos').on('change', function(){
        if(JSON.parse($(this).val()).id == -1)
        {
            $('#nombreContacto').val("");
            $('#telefonoContacto').val("");
            $('#ext').val("");
            $('#celularContacto').val("");
            $('#celularContacto2').val("");
            $('#correoContacto').val("");
            $('#puestoContacto').val("");
            $('#red_social').val("");

            $('#mdlContacto').modal();
            $(this).val(0);
            
        }
    });
}

function validacionEntrega(ipt){
    $('input[name="rbRecolecta"]').iCheck('uncheck');

    
    if($('input[name="rbModal"]:checked').length > 0)
    {
        $("#mdlEntrega .modal-footer").show();

        if($(ipt).val() == "1")
        {
            $("#btn1").show();
            $("#btn2").hide();
            if($('#lbl1').text() == "Entregada")
            {
                $('#divReqRecolecta').show();
            }
            
        }
        else
        {
            $("#btn1").hide();
            $("#btn2").show();
            $('#divReqRecolecta').hide();
        }
    }
    else
    {
        $("#mdlEntrega .modal-footer").hide();
        $('#divReqRecolecta').hide();
    }



    


}

function marcarComo(btn){
    if(validacion())
    {
        var estat = $(btn).val();
        
        var comentario = $('#txtComentarios').val().trim();
        if(estat.startsWith("NO") && comentario.length < 10)
        {
            alert("Ingrese comentarios (Min. 10 Caracteres)");
            return;
        }

        var recorrido = {};
        recorrido.id = $('#mdlEntrega').data('recorrido');
        recorrido.cliente = $('#mdlEntrega').data('cliente')
        recorrido.contacto = $('#opContactos').val() == null ? 0 : JSON.parse($('#opContactos').val()).id;
        recorrido.NombreContacto = $('#opContactos').val() == null ? 0 : JSON.parse($('#opContactos').val()).nombre;
        recorrido.CorreoContacto = $('#opContactos').val() == null ? 0 : JSON.parse($('#opContactos').val()).correo;
        recorrido.estatus = estat;
        recorrido.accion = $('#mdlEntrega').data('accion');

        
        
        var facturas = [];
        var tbl = $('#mdlTable tbody')[0];
        $.each(tbl.rows, function(i, row){
            var fac = { 'id' : row.dataset.id, 'factura' : row.dataset.factura, 'folio' : row.dataset.folio, 'nueva' : row.dataset.nueva };
            facturas.push(fac);
        });




        /////////////////////
        var recolecta = $('#rbDejada').is(':checked') ? "1" : "0";
        var fecha = $('#dtpFecha').val();

        if($("#divFecha").is(':visible'))
        {
            //A FIRMAR
            alert("Firma Requerida");

            var data = { recorrido : JSON.stringify(recorrido), facturas : JSON.stringify(facturas), recolecta : recolecta, comentario : comentario, fecha : moment(fecha).format('YYYY-MM-D')}
            
            $.redirect( base_url + "logistica/firmar", data, 'POST');

        }
        else
        {
            var URL = base_url + "logistica/ajax_updateRecorrido";
            $.ajax({
                type: "POST",
                url: URL,
                data: { recorrido : JSON.stringify(recorrido), facturas : JSON.stringify(facturas), recolecta : recolecta, comentario : comentario, fecha : moment(fecha).format('YYYY-MM-D')},
                success: function(result) {
                    $('#mdlEntrega').modal('hide');
                    buscar();
                },
                error: function(data){
                    new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                    console.log(data);
                },
            });
        }
    }

}

function validacion(){
    if($("#divFecha").is(':visible'))
    {
        var dtpFecha = $('#dtpFecha').val() + " 23:59:59";

        if(moment() > moment(dtpFecha))
        {
            alert('Fecha invalida');
            return false;
        }

        if($('#opContactos').val() == null)
        {
            alert('Seleccione contacto');
            return false;
        }
    }
    if($('#rbRetornada').is(':visible') && (!$('#rbRetornada').is(':checked') && !$('#rbDejada').is(':checked')))
    {
        alert("¿Factura retornada o dejada?");
        return false;
    }

    return confirm("¿Desea continuar?");
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
    var URL = base_url + "logistica/ajax_getRecorridos";
    $('#paneles').empty();

    var pendientes = $('#rbPendientes').is(':checked') ? "1" : "0";
    

    $.ajax({
        type: "POST",
        url: URL,
        data: { pendientes : pendientes },
        success: function(result) {
            if(result)
            {
                var act = 0;
                var clienteAct = 0;
                var panel = '';
                
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    
                    if((clienteAct != elem.cliente && clienteAct != 0) || (act != elem.recorrido && act != 0))
                    {
                        panel += ''
                        +                    '</tbody>'
                        +                '</table>'
                        clienteAct = 0;
                    }

                    if(act != elem.recorrido)
                    {
                        if(act != 0)
                        {
                            panel += ''
                            +            '</div>'
                            +        '</div>'
                                    
                            +    '</div>'
                            + '</div>'
                            +'</div>';
                        }

                        panel += '<div class="panel">'
                        + '<a class="panel-heading collapsed" role="tab" id="heading'+ elem.recorrido +'" data-toggle="collapse" data-parent="#accordion1" href="#collapse'+ elem.recorrido +'" aria-expanded="false" aria-controls="collapse'+ elem.recorrido +'">'
                        +    '<table data-recorrido="' + elem.recorrido + '" data-accion="' + elem.accion + '" id="tblRecorrido' + elem.recorrido + '" style="margin-bottom: 0px;" class="table table-striped">'
                        +        '<thead>'
                        +            '<tr class="headings">'
                        +                '<th style="width: 7%" class="column-title">Recorrido</th>'
                        +                '<th style="width: 7%" class="column-title">Mensajero</th>'
                        +                '<th style="width: 25%" class="column-title"></th>'
                        +                '<th class="column-title">Fecha Recorrido</th>'
                        +                '<th style="width: 25%" class="column-title"></th>'
                        +            '</tr>'
                        +        '</thead>'
                        +        '<tbody>'
                        +            '<tr data-recorrido="' + elem.recorrido + '">'
                        +                '<td>' + paddy(elem.recorrido, 4) + '</td>'
                        +                '<td><img id="imgUser" src="' + base_url + 'usuarios/photo/' + elem.mensajero + '" class="avatar"></td>'
                        +                '<td>' + elem.Mensajero + '</td>'
                        +                '<td>' + elem.fecha_recorrido + '</td>';
                        
                        if(elem.mensajero == ID_USER && elem.Estatus_recorrido == 'ASIGNADO A MENSAJERO')
                        {
                            //panel +=     '<td><button onclick=mdlAceptar(this) type="button" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Aceptar Recorrido</button></td>';
                            panel += '<td><div class="btn-group"><button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-sm btn-primary">Aceptar / Rechazar <span class="caret"></span></button>'
                                    +   '<ul role="menu" class="dropdown-menu">'
                                    +       '<li><a onclick=mdlRequisitos(this)><i class="fa fa-check"></i> Aceptar Recorrido</a></li>'
                                    +       '<li><a onclick=rechazarRecorrido(this)><i class="fa fa-close"></i> Rechazar Recorrido</a></li>'
                                    +   '</ul>'
                                    + '</div></td>';
                        }
                        else if(elem.mensajero == ID_USER && elem.Estatus_recorrido != 'CERRADO' && elem.Pendientes == 0)
                        {
                            panel += '<td><button onclick=cerrarRecorrido(this) class="btn btn-warning"><i class="fa fa-close"></i> Cerrar Recorrido</button><td>';
                        }

                        panel +=      '</tr>'
                        +        '</tbody>'
                        +    '</table>'
                        + '</a>'

                        + '<div id="collapse'+ elem.recorrido +'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'+ elem.recorrido +'" aria-expanded="false">'
                        +    '<div class="panel-body">'

                        +        '<div class="row">'
                        +            '<div class="col-md-12 col-sm-12 col-xs-12">'

                    }

                    //alert(clienteAct);
                    if(clienteAct != elem.cliente)
                    {
                        
                        panel +=  '<h3 name="lblCliente" style="display: inline;">' + elem.Cliente + '</h3><button data-recorrido="' + elem.recorrido + '" data-cliente="' + elem.cliente + '" name="btn' + elem.cliente + '" type="button" style="display: none;" onclick="mdlEntrega(this)" class="btn btn-primary btn-sm pull-right entrega"><i class="fa fa-truck"></i> Entrega</button>'
                        +                '<table name="tbl' + elem.cliente + '" data-cliente="' + elem.cliente + '" class="table">'
                        +                    '<thead>'
                        +                        '<tr>'
                        +                            '<th>Selecc.</th>'
                        +                            '<th>Factura</th>'
                        +                            '<th>Acción</th>'
                        +                            '<th>Estatus</th>'
                        +                        '</tr>'
                        +                    '</thead>'
                        +                    '<tbody>';
                    }
                        
                    


                    var accion = elem.accion;
                    if(accion == "ENTREGA")
                    {
                        accion += " <font color='green'><i class='fa fa-arrow-right'></i></font>";
                    }
                    else if(accion == "RECOLECTA")
                    {
                        accion += " <font color='red'><i class='fa fa-arrow-left'></i></font>";
                    }
                    
                    panel +=                        '<tr data-id="' + elem.id + '" data-accion="' + elem.accion + '" data-factura="' + elem.factura + '" data-folio="' + elem.folio + '">'
                    panel +=                            '<td class="td-selecc">' + (elem.estatus == "EN RECORRIDO" ? '<input type="checkbox" class="flat selecc">' : 'N/A') +'</td>';
                    panel +=                            '<td>' + elem.folio + '</td>';
                    panel +=                            '<td>' + accion + '</td>';
                    if(elem.estatus == "EN RECORRIDO")
                    {
                        panel +=                            '<td><button type="button" class="btn btn-warning btn-sm btn-estatus">' + elem.estatus + '</button></td>';
                    }
                    else if(elem.estatus.startsWith("NO") || elem.estatus.startsWith("RECHAZAD"))
                    {
                        panel +=                            '<td><button type="button" class="btn btn-danger btn-sm btn-estatus">' + elem.estatus + '</button></td>';
                    }
                    else
                    {
                        panel +=                            '<td class="boton"><button type="button" class="btn btn-success btn-sm btn-estatus">' + elem.estatus + '</button></td>';
                    }
                    
                    
                    panel +=                        '</tr>';
                    
                    
                    
                    clienteAct = elem.cliente;
                                    
                    act = elem.recorrido;

                    //alert("recorrido: " + act + " / Cliente:" + clienteAct)
                        
                });

                if(rs.length > 0)
                {
                    panel += ''
                    +                    '</tbody>'
                    +                '</table>'
                }


                $('#paneles').append(panel);

                init_CheckBox();


            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}
var acc = "";

function init_CheckBox(){
    $('input.selecc').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });

    $('input.selecc').on('ifChecked', function(){
        
        var accion = $(this).closest('tr').data('accion');
        if(acc != accion)
        {
            $('input.selecc').not(this).iCheck('uncheck');    
        }
        acc = accion;

        var tab = $(this).closest('div[role="tabpanel"]');
        var tbl = $(this).closest('table');

        var client = $(tbl).data('cliente');

        $('table').not(tbl).find('input[type="checkbox"]').iCheck('uncheck');
        $('div[role="tabpanel"]').find('button.entrega').hide();
        
        $(tab).find('button[name=btn' + client + ']').show();
        $(tab).find('button[name=btn' + client + ']').data('accion', accion);
        $(tab).find('button[name=btn' + client + ']').html('<i class="fa fa-truck"></i> ' + accion + 'R');

        
    });

    $('input.selecc').on('ifChanged', function(){
        var tbl = $(this).closest('table');
        if($(tbl).find('input[type="checkbox"]:checked').length == 0)
        {
            $('div[role="tabpanel"]').find('button.entrega').hide();
        }
    });
}

function aceptarRecorrido(){
    if(!confirm("¿Desea aceptar el recorrido?"))
    {
        return;
    }

    var recorrido = $('#mdlRequisitos').data('recorrido');

    $('#collapse' + recorrido + ' table .btn-estatus')
    
    var URL = base_url + "logistica/ajax_aceptarRecorrido";


    $.ajax({
        type: "POST",
        url: URL,
        data: { recorrido : recorrido },
        success: function(result) 
        {
            $(Td).fadeOut();
            $('#collapse' + recorrido + ' table .td-selecc').html('<input type="checkbox" class="flat selecc">');
            $('#collapse' + recorrido + ' table .boton').html('<button type="button" class="btn btn-warning btn-sm">EN RECORRIDO</button>');
            init_CheckBox();
            formatoRequisitos();
            $('#mdlRequisitos').modal('hide');
            
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

var Td;
function mdlRequisitos(btn){

    Td = $(btn).closest('td');
    var tbl = $(btn).closest('table');
    var recorrido = $(tbl).data('recorrido');

    $('#mdlRequisitos').data('recorrido', recorrido);


    $('#tblEmpresasRecorrido tbody tr').remove();
    
    var URL = base_url + 'logistica/ajax_getEmpresasRecorrido';
    
    $.ajax({
        type: "POST",
        url: URL,
        data: { recorrido : recorrido },
        success: function(result)
        {
            var rs = JSON.parse(result);
            var tbl = $('#tblEmpresasRecorrido tbody')[0];
            
            $.each(rs, function(i, elem){
                var row = tbl.insertRow();
                row.dataset.id = elem.id;

                row.insertCell().innerHTML = '<input type="checkbox" class="flat" checked>';
                row.insertCell().innerHTML = elem.nombre;
            });

            $('#tblEmpresasRecorrido input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });

            $('#mdlRequisitos').modal();
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
    
}

function formatoRequisitos(){
    var arr = [];
    var rows = $('#tblEmpresasRecorrido tbody tr');

    $.each(rows, function (i, elem) {
        if($(elem).find('input').is(':checked'))
        {
            arr.push(elem.dataset.id);
        }
    });

    if(arr.length > 0)
    {
        $.redirect( base_url + "logistica/formato_requisitos", { 'empresas': JSON.stringify(arr) }, 'POST', '_blank');
    }
    
}

function rechazarRecorrido(btn){
    
    if(!confirm("¿Desea rechazar el recorrido?"))
    {
        return;
    }

    var td = $(btn).closest('td');
    var tbl = $(btn).closest('table');
    var recorrido = $(tbl).data('recorrido');
    var accion = $(tbl).data('accion');

    

    $('#collapse' + recorrido + ' table .btn-estatus')
    
    var URL = base_url + "logistica/ajax_rechazarRecorrido";


    $.ajax({
        type: "POST",
        url: URL,
        data: { recorrido : recorrido, accion : accion },
        success: function(result) 
        {
            $(td).fadeOut();
            $('#collapse' + recorrido + ' table .boton').html('<button type="button" class="btn btn-danger btn-sm">RECHAZADO POR MENSAJERO</button>');
            init_CheckBox();
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function cerrarRecorrido(btn){
    
    if(!confirm("¿Desea cerrar el recorrido?"))
    {
        return;
    }

    var td = $(btn).closest('td');
    var tbl = $(btn).closest('table');
    var recorrido = $(tbl).data('recorrido');
    
    
    var URL = base_url + "logistica/ajax_pendienteCierreRecorrido";


    $.ajax({
        type: "POST",
        url: URL,
        data: { recorrido : recorrido},
        success: function(result) 
        {
            buscar();
            /*
            $(td).fadeOut();
            $('#collapse' + recorrido + ' table .boton').html('<button type="button" class="btn btn-danger btn-sm">RECHAZADO POR MENSAJERO</button>');
            init_CheckBox();
            */
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function boton(estatus){
    var clase = "btn dropdown-toggle btn-sm";
    opcs = "<ul role='menu' class='dropdown-menu'>"
    opcs += "<li><a onclick=Entregado(this)><i class='fa fa-eye'></i> Entregado</a></li>"
    opcs += "<li><a onclick=Ver Requisitos(this)><i class='fa fa-eye'></i> Ver Requisitos</a></li>"
    

    switch(estatus){
        case "PENDIENTE ENTREGA":
        case "PENDIENTE RETORNO":
            clase += " btn-warning";
            break;

        case "RECHAZADO":
            clase += " btn-danger";
            break;
        
        case "ACEPTADO":
            clase += " btn-success";
            break;

        case "CANCELADO":
            clase += " btn-default";
            break;

        case "NO PROCEDE":
            clase += " btn-dark";
            break;
    }
    var btn = "<div class='btn-group'><button type='button' data-toggle='dropdown' class='" + clase + "'>" + estatus + "  <span class='caret'></span></button>";
    btn += opcs;
    return btn;


}

function catalogoUsuarios(){
    var URL = base_url + "usuarios/ajax_getUsuarios";
    $('#tblUsuarios tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        //data: { texto : texto, parametro : parametro },
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

                $('#mdlUsuarios').modal();
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

function continuar(){
    //Mensajero
    $('#lblUserName').text("Mensajero");
    $('#imgUser').attr('src', base_url + 'template/images/avatar.png');
    $('#tblUsuario').data('user', 0);


    $('#tblFolios tbody tr').remove();
    var rows = $("#tabla tbody tr");

    var tab = $('#tblFolios tbody')[0];
    $.each(rows, function(i, elem){
        if($(elem).find('input.flat').is(':checked'))
        {
            var ren = tab.insertRow(tab.rows.length);
            
            
            ren.dataset.id = elem.dataset.id;
            ren.dataset.recorrido = elem.dataset.recorrido;
            
            
            ren.insertCell().innerHTML = elem.dataset.id;
            ren.insertCell().innerHTML = $(elem).find('td').eq(2).text();
            ren.insertCell().innerHTML = $(elem).find('td').eq(4).text();
            ren.insertCell().innerHTML = $(elem).find('td').eq(5).text();
            ren.insertCell().innerHTML = $(elem).find('td').eq(6).text();
            ren.insertCell().innerHTML = "Entrega <font color='green'><i class='fa fa-arrow-right'></i></font>";
        }
    });

    $('#mdlRecorrido').modal();
}

function aceptar(){
    if(validacion())
    {
        var URL = base_url + "facturas/ajax_setRecorrido";
        
        var rows = $("#tblFolios tbody tr");

        var data = [];
        $.each(rows, function(i, elem){
            data.push([elem.dataset.recorrido, elem.dataset.id]);
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

var facturasNuevas;
function mdlEntrega(btn){
    facturasNuevas = [];
    $('#txtComentarios').val("");
    $('input[name="rbModal"]').iCheck('uncheck');



    var recorrido = $(btn).data('recorrido');
    var cliente = $(btn).data('cliente');
    var accion = $(btn).data('accion');

    $('#mdlEntrega').data('recorrido', recorrido);
    $('#mdlEntrega').data('cliente', cliente);
    $('#mdlEntrega').data('accion', accion);

    buscarContactos(cliente);

    $('#mdlTable tbody tr').remove();
    var tblModal = $('#mdlTable tbody')[0];



    var tab = $('#collapse' + recorrido);
    var tbl = $(tab).find('table[name="tbl' + cliente + '"] tbody')[0];
    var nombreCliente = $(btn).prev('h3[name="lblCliente"]').html();
    $('#mdlLblCliente').html("Cliente: " + nombreCliente);

    $.each(tbl.rows, function(i, row){
        var ipt = $(row).find('input[type="checkbox"]');
        if($(ipt).is(':checked'))
        {
            r = tblModal.insertRow();
            r.dataset.id = row.dataset.id;
            r.dataset.factura = row.dataset.factura;
            r.dataset.folio = row.dataset.folio;
            r.dataset.nueva = "0";
            r.insertCell().innerHTML = row.cells[1].innerHTML;
            r.insertCell().innerHTML = row.cells[2].innerHTML;
            r.insertCell().innerHTML = row.cells[3].innerHTML;
        }
    });


    //$('table').not(tbl).find('input[type="checkbox"]').iCheck('uncheck');
    


    ///////// BORRAME

    /////////
    

    if(accion == "ENTREGA")
    {
        $('#btnAgregarFactura').hide();
        $('#lbl1').text("Entregada")
        $('#lbl2').text("No Entregada")

        $('#btn2').val("NO ENTREGADA");

        
        $('#btn1').html("<i class='fa fa-check'></i> Entregada");
        $('#btn2').html("<i class='fa fa-close'></i> No Entregada");

    }
    else if(accion == "RECOLECTA")
    {
        $('#btnAgregarFactura').show();
        $('#lbl1').text("Recolectada")
        $('#lbl2').text("No Recolectada")

        $('#btn2').val("NO RECOLECTADA");

        $('#btn1').html("<i class='fa fa-check'></i> Recolectada");
        $('#btn2').html("<i class='fa fa-close'></i> No Recolectada");
    }


    $('#mdlEntrega').modal();
}

function mdlFacturas(){
    var URL = base_url + 'logistica/ajax_getFacturas';
    $('#tblFacturas tbody tr').remove();

    var data = {};
    data.cliente = $('#mdlEntrega').data('cliente');
    data.estatus_factura = "DEJADA CON CLIENTE";

    $.ajax({
        type: "POST",
        url: URL,
        data: data,
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                var tab = $('#tblFacturas tbody')[0];
                $.each(rs, function(i, elem)
                {
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id = elem.id;
                    ren.dataset.factura = elem.id;
                    ren.dataset.folio = elem.folio;
                    ren.insertCell().innerHTML = '<input type="checkbox" class="flat nuevaFactura"' + (facturasNuevas.includes(elem.id) ? 'checked' : '') +'>';
                    ren.insertCell().innerHTML = elem.folio;
                    ren.insertCell().innerHTML = '<button type="button" class="btn btn-warning btn-sm">' + elem.estatus_factura + '</button>'
                });

                $('input.nuevaFactura').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });

                $('#mdlFacturas').modal();
            }
            else{
                alert('No hay facturas pendientes de recolecta');
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function agregarFacturaNueva(){
    $('#mdlTable tbody tr[data-nueva="1"]').remove();
    facturasNuevas = [];
    var tbl = $('#tblFacturas tbody')[0];
    var tblModal = $('#mdlTable tbody')[0];

    $.each(tbl.rows, function(i, row){
        var ipt = $(row).find('input[type="checkbox"]');
        if($(ipt).is(':checked'))
        {
            facturasNuevas.push(row.dataset.id);

            r = tblModal.insertRow();
            r.dataset.id = row.dataset.id;
            r.dataset.factura = row.dataset.factura;
            r.dataset.folio = row.dataset.folio;
            r.dataset.nueva = "1";
            r.insertCell().innerHTML = row.cells[1].innerHTML;
            r.insertCell().innerHTML = "RECOLECTA <font color='red'><i class='fa fa-arrow-left'></i></font>";
            r.insertCell().innerHTML = row.cells[2].innerHTML;
        }
    });

    $('#mdlFacturas').modal('hide');

}

function buscarContactos(idCliente){
    var URL = base_url + "clientes/ajax_getContactos";
    $('#opContactos option').remove();
    $('#opContactos').append(new Option("(OTRO)", '{"id" : -1}'));
    
    
    $.ajax({
        type: "POST",
        url: URL,
        data: { id_cliente : idCliente },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem)
                {
                    $('#opContactos').append(new Option(elem.nombre, '{"id" : ' + elem.id + ', "nombre" : "' + elem.nombre + '", "correo" : "' + elem.correo + '"}'));
                });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function phoneMask(inp){
    var valor = $(inp).val();
    var numeros = valor.replace("(", "");
    var numeros = numeros.replace(")", "");
    var numeros = numeros.replace("-", "");
    if(numeros.length == 3)
    {
        $(inp).val("(" + numeros + ")");
    }
    if(numeros.length == 7)
    {
        $(inp).val("(" + numeros.substring(0,3) + ")" + numeros.substring(3,6) + "-" + numeros.substring(6,7));
    }
    if(numeros.length == 9)
    {
        $(inp).val("(" + numeros.substring(0,3) + ")" + numeros.substring(3,6) + "-" + numeros.substring(6,8) + "-" + numeros.substring(8,9));
    }
    
}

function agregarContacto(){
    var URL = base_url + 'empresas/agregarContacto';

    if(!$('#nombreContacto').val().trim())
    {
        alert("Ingrese nombre de contacto");
        return;
    }

    var empresa = $('#mdlEntrega').data('cliente');
    var nombre = $('#nombreContacto').val();
    var telefono = $('#telefonoContacto').val();
    var ext = $('#ext').val();
    var celular = $('#celularContacto').val();
    var celular2 = $('#celularContacto2').val();
    var correo = $('#correoContacto').val();
    var puesto = $('#puestoContacto').val();
    var red_social = $('#red_social').val();
    var activo = 0;
    var cotizable = 0;
    
    

    $.ajax({
        type: "POST",
        url: URL,
        data: { 'empresa' : empresa, 'nombre' : nombre, 'telefono' : telefono, 'ext' : ext, 'celular' : celular, 'celular2' : celular2, 'correo' : correo, 'puesto' : puesto, 'red_social' : red_social, activo : activo, cotizable : cotizable },
        success: function(result){
          if(result){
            var res = JSON.parse(result);
            $('#mdlContacto').modal('hide');
            $('#opContactos').append(new Option(res.nombre, '{"id" : ' + res.id + ', "nombre" : "' + res.nombre + '", "correo" : "' + res.correo + '"}'));
            $('#opContactos').val(res.id);

          } else {
            new PNotify({ title: 'ERROR', text: 'Error al agregar Contacto', type: 'error', styling: 'bootstrap3' });
          }
        },
        error: function(data){
          new PNotify({ title: 'ERROR', text: 'Error al agregar Contacto', type: 'error', styling: 'bootstrap3' });
          console.log(data);
        },
    });

      
}