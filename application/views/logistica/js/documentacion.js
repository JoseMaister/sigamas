function load(){
    buscar();
}

function buscar(){

    buscarRecepcion();
}

function buscarRecepcion(){
    var URL = base_url + "logistica/ajax_getSolicitudes";
    $('#tblRecepcion tbody tr').remove();
    
    var data = {};
    data.estatus_factura = "ENVIADA LOGISTICA";

    $.ajax({
        type: "POST",
        url: URL,
        data: data,
        success: function(result) {
            if(result)
            {
                var tab = $('#tblRecepcion tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id = elem.id;

                    ren.insertCell().innerHTML = elem.folio;
                    ren.insertCell().innerHTML = elem.User;
                    ren.insertCell().innerHTML = elem.Cliente;
                    ren.insertCell().innerHTML = elem.orden_compra;
                    ren.insertCell().innerHTML = elem.reporte_servicio;
                    ren.insertCell().innerHTML = boton(elem.estatus_factura);
                });
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
    opcs = "<ul role='menu' class='dropdown-menu'>"
    opcs += "<li><a onclick=ver(this)><i class='fa fa-eye'></i> Ver Solicitud</a></li>"
    

    switch(estatus){

        case "ENVIADA LOGISTICA":
            clase += " btn-warning";
            opcs += "<li><a onclick=aceptarDoc(this)><i class='fa fa-check'></i> Aceptar Documentación</a></li>";
            opcs += "<li><a onclick=rechazarDoc(this)><i class='fa fa-close'></i> Rechazar Documentación</a></li>";
            break;
    }
    var btn = "<div class='btn-group'><button type='button' data-toggle='dropdown' class='" + clase + "'>" + estatus + "  <span class='caret'></span></button>";
    btn += opcs;
    return btn;
}

function ver(a){
    var ren = $(a).closest('tr');
    var id = $(ren).data('id');

    $.redirect( base_url + "facturas/ver_solicitud", { 'id': id }, 'POST', '_blank');
}

function aceptarDoc(a){
    if(confirm("¿La documentación es correcta?"))
    {
        var ren = $(a).closest('tr');
        var id = $(ren).data('id');

        var URL = base_url + "facturas/ajax_setSolicitud";

        var solicitud = {};
        solicitud.id = id;
        solicitud.estatus_factura = "RECIBIDO EN LOGISTICA";

        $.ajax({
            type: "POST",
            url: URL,
            data: { solicitud : JSON.stringify(solicitud) },
            success: function(result) {
                //new PNotify({ title: 'Documentación', text: 'Se han aceptado Documentos', type: 'success', styling: 'bootstrap3' });
                buscar();
              },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}

function rechazarDoc(a){
    if(confirm("¿Desea rechazar la documentación?"))
    {
        var ren = $(a).closest('tr');
        var id = $(ren).data('id');

        var URL = base_url + "facturas/ajax_setSolicitud";

        var solicitud = {};
        solicitud.id = id;
        solicitud.estatus_factura = "RECHAZADO EN LOGISTICA";

        $.ajax({
            type: "POST",
            url: URL,
            data: { solicitud : JSON.stringify(solicitud) },
            success: function(result) {
                //new PNotify({ title: 'Documentación', text: 'Se han aceptado Documentos', type: 'success', styling: 'bootstrap3' });
                buscar();
              },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}
