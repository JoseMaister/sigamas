function load(){
    eventos();
    buscar();
}

function eventos(){
    $('#txtBusqueda').on('keypress', function( e ) {
        if( e.keyCode === 13 ) {
            buscar();
        }
    });

    $('#mdlClientes').on('keypress', function( e ) {
        if( e.keyCode === 13 ) {
            e.preventDefault();
            buscarClientes();
        }
    });

    $('#mdlEjecutivos').on('keypress', function( e ) {
        if( e.keyCode === 13 ) {
            e.preventDefault();
            buscarEjecutivos();
        }
    });

    $('#cbAceptadas').on('ifChanged', function(){
        buscar();
    });
}

function buscar(){
    var URL = base_url + "facturas/ajax_getSolicitudes";
    $('#divUrgente').hide();
    $('#tabla tbody tr').remove();
    $('#tblUrgente tbody tr').remove();
    
    var parametro = $("input[name=rbBusqueda]:checked").val();
    var texto = $("#txtBusqueda").val();
    var aceptadas = $('#cbAceptadas').is(':checked') ? 1 : 0;
    var cliente = $("#txtCliente").data("id");
    var ejecutivo = $("#txtEjecutivo").data("id");

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto, parametro : parametro, aceptadas : aceptadas, cliente : cliente, ejecutivo : ejecutivo },
        success: function(result) {
            if(result)
            {
                var tab = $('#tabla tbody')[0];
                var tabUrg = $('#tblUrgente tbody')[0];

                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){

                    var ren;
                    if(elem.urgente == 1){
                        ren = tabUrg.insertRow(tabUrg.rows.length);
                        ren.style.color = "red";
                    } else {
                        ren = tab.insertRow(tab.rows.length)
                    }

                    ren.dataset.id = elem.id;
                    ren.insertCell().innerHTML = elem.id;
                    ren.insertCell().innerHTML = elem.fecha;
                    ren.insertCell().innerHTML = elem.User;
                    ren.insertCell().innerHTML = elem.Cliente;
                    ren.insertCell().innerHTML = elem.orden_compra;
                    ren.insertCell().innerHTML = elem.reporte_servicio;
                    ren.insertCell().innerHTML = boton(elem.id, elem.estatus, elem.usuario);
                });

                if(tabUrg.rows.length > 0)
                {
                    $('#divUrgente').show();
                }
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

function buscarClientes(){
    var URL = base_url + "facturas/ajax_getClientesSolicitudes";
    $('#tblClientes tbody tr').remove();
    
    var texto = $("#txtBuscarCliente").val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblClientes tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id = elem.id;
                    ren.dataset.nombre = elem.nombre;
                    ren.style.cursor = "pointer";
                    $(ren).on('click', function(){
                        seleccionarCliente(this);
                    });

                    ren.insertCell().innerHTML = elem.nombre;
                    ren.insertCell().innerHTML = elem.NumSol;
                    ren.insertCell().innerHTML = "<button type='button' class='btn btn-primary btn-xs'><i class='fa fa-check'></i> Seleccionar</button> ";
                });

                $('#mdlClientes').modal();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function seleccionarCliente(btn){
    var row = $(btn).closest('tr')[0];

    $('#txtCliente').val(row.dataset.nombre);
    $('#txtCliente').data('id', row.dataset.id);
    $('#btnRemoverCliente').show();
    $('#mdlClientes').modal('hide');

    buscar();
}

function removerCliente(){
    $('#btnRemoverCliente').hide();
    $('#txtCliente').val("TODOS");
    $('#txtCliente').data('id', 0);

    buscar();
}

function buscarEjecutivos(){
    var URL = base_url + "facturas/ajax_getEjecutivosSolicitudes";
    $('#tblEjecutivos tbody tr').remove();
    
    var texto = $("#txtBuscarEjecutivo").val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblEjecutivos tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id = elem.id;
                    ren.dataset.nombre = elem.Ejecutivo;
                    ren.style.cursor = "pointer";
                    $(ren).on('click', function(){
                        seleccionarEjecutivo(this);
                    });
                    ren.insertCell().innerHTML = elem.Ejecutivo;
                    ren.insertCell().innerHTML = elem.NumSol;
                    ren.insertCell().innerHTML = "<button onclick='seleccionarEjecutivo(this)' type='button' class='btn btn-primary btn-xs'><i class='fa fa-check'></i> Seleccionar</button> ";
                });

                $('#mdlEjecutivos').modal();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function seleccionarEjecutivo(btn){
    var row = $(btn).closest('tr')[0];

    $('#txtEjecutivo').val(row.dataset.nombre);
    $('#txtEjecutivo').data('id', row.dataset.id);
    $('#btnRemoverEjecutivo').show();
    $('#mdlEjecutivos').modal('hide');

    buscar();
}

function removerEjecutivo(){
    $('#btnRemoverEjecutivo').hide();
    $('#txtEjecutivo').val("TODOS");
    $('#txtEjecutivo').data('id', 0);

    buscar();
}

function boton(id, estatus, user){
    var clase = "btn dropdown-toggle btn-xs";
    opcs = "<ul role='menu' class='dropdown-menu'>"
    opcs += "<li><a onclick=verRequerimiento(this)><i class='fa fa-eye'></i> Ver</a></li>"
    

    switch(estatus){
        case "ABIERTO":
        case "RESPONDIDO":
            clase += " btn-primary";
            if(PRIVILEGIOS.editar_facturas == 1)
            {
                opcs += "<li><a onclick=cancelar(this)><i class='fa fa-close'></i> Cancelar</a></li></ul></div>";
            }
            break;

        case "RECHAZADO":
            clase += " btn-danger";
            if(PRIVILEGIOS.editar_facturas == 1)
            {
                opcs += "<li><a onclick=editar(this)><i class='fa fa-pencil'></i> Editar</a></li>";
                opcs += "<li><a onclick=cancelar(this)><i class='fa fa-close'></i> Cancelar</a></li>";
            }
            opcs += "</ul></div>";
            break;
        
        case "ACEPTADO":
            clase += " btn-success";
            break;

        case "PENDIENTE RECORRIDO":
        case "PENDIENTE ENTREGA":
        case "PENDIENTE RECOLECTA":
        case "EN RECORRIDO":
            clase += " btn-warning";
            break;

        case "CANCELADO":
            clase += " btn-default";
            break;

        case "NO PROCEDE":
            clase += " btn-dark";
            break;
    }
    
    
    
    var btn = "<div class='btn-group'><button type='button' data-toggle='dropdown' value=" + id + " class='" + clase + "'>" + estatus + "  <span class='caret'></span></button>";
    btn += opcs;
    return btn;


}

function verRequerimiento(a){
    var ren = $(a).closest('tr');
    var btn = $(ren).find('button');
    var id = $(btn).val();

    $.redirect( base_url + "facturas/ver_solicitud", { 'id': id });
}

function editar(a){
    var ren = $(a).closest('tr');
    var btn = $(ren).find('button');
    var id = $(btn).val();

    $.redirect( base_url + "facturas/editar_solicitud", { 'id': id });
}

function cancelar(a){
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

function verRecorridos(btn){
    var URL = base_url + "facturas/ajax_getRecorridos";
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
                    var c = elem.estatus.startsWith("EN RECORRIDO") ? 'btn-warning' : ((elem.estatus.startsWith("NO") || elem.estatus.startsWith("RECHAZAD"))  ? 'btn-danger' : 'btn-success');
                    ren.insertCell().innerHTML = '<button type="button" class="btn ' + c + ' btn-sm">' + elem.estatus + '</button>';
                    ren.insertCell().innerHTML = elem.Comentarios > 0 ? '<button type="button" onclick=verComentarios(this) value="' + elem.id + '" class="btn btn-primary btn-sm"><i class="fa fa-comments"></i> ' + elem.Comentarios + '</button>' : 'N/A';

                    
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

function verComentarios(btn){
    cargarComentarios($(btn).val());
}

function cargarComentarios(id){
    var URL = base_url + "facturas/ajax_getComentariosRecorrido";

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
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

                $('#mdlComentarios').modal();
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}