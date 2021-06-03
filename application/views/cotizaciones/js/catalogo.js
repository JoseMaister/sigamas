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

    $('#cbCerradasCanceladas').on('ifChanged', function( e ) {
        buscar();
    });
}

function buscar(){
    $('#lblCount').text("");
    var URL = base_url + "cotizaciones/ajax_getCotizaciones";
    $('#tabla tbody tr').remove();
    
    var parametro = $("input[name=rbBusqueda]:checked").val();
    var texto = $("#txtBusqueda").val();
    var cliente = $("#txtCliente").data("id");
    var estatus = $("#opEstatus").val();
    var tipo = $("#opTipoCotizacion").val();
    var cerradas = $("#cbCerradasCanceladas").is(':checked') ? "1" : "0";

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto, parametro : parametro, estatus : estatus, cliente : cliente, tipo : tipo, cerradas : cerradas },
        success: function(result) {
            if(result)
            {
                var tab = $('#tabla tbody')[0];
                var rs = JSON.parse(result);
                $('#lblCount').text(rs.length + (rs.length == 1 ? " Cotización" : " Cotizaciones"));
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id = elem.id;
                    ren.insertCell().innerHTML = "<button type='button' onclick='quickView(this)' class='btn btn-default btn-xs' >" + elem.id + "</button>";
                    ren.insertCell().innerHTML = elem.fecha;
                    ren.insertCell().innerHTML = elem.Cliente;
                    ren.insertCell().innerHTML = elem.Contacto;
                    ren.insertCell().innerHTML = elem.Responsable;
                    ren.insertCell().innerHTML = boton(elem.estatus, elem.usuario);
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

function buscarClientes(){
    var URL = base_url + "cotizaciones/ajax_getClientesCotizaciones";
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
                    ren.insertCell().innerHTML = elem.nombre;
                    ren.insertCell().innerHTML = elem.NumCot;
                    ren.insertCell().innerHTML = "<button onclick='seleccionarCliente(this)' type='button' class='btn btn-primary btn-xs'><i class='fa fa-check'></i> Seleccionar</button> ";
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

function boton(estatus, user){
    var clase = "btn dropdown-toggle btn-xs";
    opcs = "<ul role='menu' class='dropdown-menu'>"
    opcs += "<li><a onclick=ver(this)><i class='fa fa-eye'></i> Ver</a></li>"
    

    switch(estatus){
        case "CREADA":
        clase += " btn-primary";
        break;

        case "RECHAZADA":
            clase += " btn-danger";
            break;
        
        case "AUTORIZADA":
        case "APROBADA":
        case "ENVIADA":
        case "CONFIRMADA":
        case "APROBADO PARCIAL":
        case "APROBADO TOTAL":
            clase += " btn-success";
            break;
            
        case "PENDIENTE AUTORIZACION":
        case "EN REVISION":
        case "EN AUTORIZACION":            
        case "EN APROBACION":
            clase += " btn-warning";
            break;

        case "CANCELADA":
            clase += " btn-default";
            break;

        case "CERRADO PARCIAL":
        case "CERRADO TOTAL":
            clase += " btn-dark";
            break;
    }
    
    
    
    var btn = "<div class='btn-group'><button type='button' data-toggle='dropdown' class='" + clase + "'>" + estatus + "  <span class='caret'></span></button>";
    btn += opcs;
    return btn;


}

function ver(a){
    var ren = $(a).closest('tr');
    var id = $(ren).data('id');

    $.redirect( base_url + "cotizaciones/ver_cotizacion", { 'id': id }, "POST", "_blank");
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

function quickView(btn){
    var id = $(btn).closest('tr')[0].dataset.id;
    $('#tabQV li').remove();
    $('#tabContentQV div').remove();

    var URL = base_url + "cotizaciones/ajax_getCotizacionConceptos";

    $.ajax({
        type: "POST",
        url: URL,
        data: { cotizacion : id },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                var rev = -1;
                $.each(rs, function(i, elem){

                    if(rev != elem.revision)
                    {
                        rev = elem.revision;
                        $('#tabQV').append('<li role="presentation" id="tab-li' + elem.revision + '"><a href="#tab_content' + elem.revision + '" role="tab" id="profile-tab' + elem.revision + '" data-toggle="tab" aria-expanded="true">Revisión ' + elem.revision + '</a></li>');
                        var tab = '<div role="tabpanel" class="tab-pane fade in" id="tab_content' + elem.revision + '" aria-labelledby="profile-tab' + elem.revision + '">'
                            + '<button onclick="copiarCotizacion(this)" type="button" data-coti="' + id + '" data-revision="' + elem.revision + '" class="btn btn-xs btn-primary"><i class="fa fa-copy"></i> Copiar</button>'
                            + '<table id="tbl' + elem.revision + '" class="data table table-striped no-margin">'
                            +    '<thead>'
                            +        '<tr>'
                            +            '<th>Cant.</th>'
                            +            '<th>Descripción</th>'
                            +            '<th>Atributos</th>'
                            +            '<th>Sitio</th>'
                            +            '<th>Precio U.</th>'
                            +            '<th># PO</th>'
                            +        '</tr>'
                            +    '</thead>'
                            +    '<tbody>'
                            +    '</tbody>'
                            + '</table>'
                        +'</div>';
                        $('#tabContentQV').append(tab);
                    }
                    
                    var tab = $('#tbl' + elem.revision + ' tbody')[0];
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = elem.cantidad;
                    ren.insertCell().innerHTML = elem.descripcion;

                    var cellText = '';
                    var atr = JSON.parse(elem.atributos);
                    $.each(atr, function(i, elem){
                        cellText += '<br><b>' + i + ':</b> ' + elem + ' ';
                    });

                    ren.insertCell().innerHTML = cellText ? cellText.substring(4) : "N/A";
                    ren.insertCell().innerHTML = elem.sitio;

                    var m = ren.insertCell()
                    m.innerHTML = elem.precio_unitario;
                    $(m).formatCurrency();

                    ren.insertCell().innerHTML = elem.po ? elem.po : "N/A";

                });

                $('#tab-li' + rev).addClass('active');
                $('#tab_content' + rev).addClass('active'); 

                $('#mdlQuickView').modal();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
      });
}

function copiarCotizacion(btn){
    //var coti = $(btn).data('coti');
    var revision = $(btn).data('revision');

    var rows = $('#tbl' + revision + ' tbody tr');
    var texto = "";
    rows.toArray().forEach(elem => {
        texto += $(elem).find('td').eq(0).text() + " " + $(elem).find('td').eq(1).text() + " " + $(elem).find('td').eq(2).text() + " Sitio: " + $(elem).find('td').eq(3).text() + "\n";
    });

    $('#txtCopy').show();
    $('#txtCopy').val(texto)
    $('#txtCopy').focus();
    $('#txtCopy').select();
    document.execCommand("copy");
    $('#txtCopy').hide();
    alert("¡Información Copiada!");


    /*if(confirm("¿Desea copiar la cotización " + coti + " Rev: " +revision + "?")){
        $.redirect(base_url + 'cotizaciones/crear_cotizacion', { "id" : coti, "rev" : revision }, "POST", "_blank");
    }*/
}