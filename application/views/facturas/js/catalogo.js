function load(){
    buscar();
}

function buscar(){
    var URL = base_url + "facturas/ajax_getSolicitudes";
    $('#tabla tbody tr').remove();
    
    var parametro = ""//$("input[name=rbBusqueda]:checked").val();
    var texto = ""//$("#txtBusqueda").val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto, parametro : parametro },
        success: function(result) {
            if(result)
            {
                var tab = $('#tabla tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = elem.id;
                    ren.insertCell().innerHTML = elem.fecha;
                    ren.insertCell().innerHTML = elem.User;
                    ren.insertCell().innerHTML = elem.Cliente;
                    ren.insertCell().innerHTML = elem.orden_compra;
                    ren.insertCell().innerHTML = elem.reporte_servicio;
                    ren.insertCell().innerHTML = boton(elem.id, elem.estatus, elem.usuario);
                });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function boton(id, estatus, user){
    var clase = "btn dropdown-toggle btn-sm";
    opcs = "<ul role='menu' class='dropdown-menu'>"
    opcs += "<li><a onclick=verRequerimiento(this)><i class='fa fa-eye'></i> Ver</a></li>"
    

    switch(estatus){
        case "ABIERTO":
        case "RESPONDIDO":
            clase += " btn-primary";
            if(user == uid)
            {
                opcs += "<li><a onclick=cancelar(this)><i class='fa fa-close'></i> Cancelar</a></li></ul></div>";
            }
            break;

        case "RECHAZADO":
            clase += " btn-danger";
            if(user == uid)
            {
                opcs += "<li><a onclick=editar(this)><i class='fa fa-pencil'></i> Editar</a></li>";
                opcs += "<li><a onclick=cancelar(this)><i class='fa fa-close'></i> Cancelar</a></li>";
            }
            opcs += "</ul></div>";
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