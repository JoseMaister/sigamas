var CODIGO;

function load(){
    buscar();
}

function buscar(){
    var URL = base_url + "requerimientos/ajax_getRequerimientos";
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
                    ren.insertCell(0).innerHTML = elem.id;
                    ren.insertCell(1).innerHTML = elem.fecha;
                    ren.insertCell(2).innerHTML = elem.User;
                    ren.insertCell(3).innerHTML = elem.tipo;
                    ren.insertCell(4).innerHTML = elem.descripcion;
                    ren.insertCell(5).innerHTML = boton(elem.id, elem.estatus, elem.usuario);
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
    var clase = "btn dropdown-toggle btn-sm";
    opcs = "<ul role='menu' class='dropdown-menu'>"
    opcs += "<li><a onclick=verRequerimiento(this)><i class='fa fa-eye'></i> Ver</a></li>"
    

    switch(estatus){
        case "ABIERTO":
            clase += " btn-primary";
            if(user == uid)
            {
                opcs += "<li><a onclick=cancelarRequerimiento(this)><i class='fa fa-close'></i> Cancelar</a></li></ul></div>";
            }
            break;

        case "CANALIZADO":
            clase += " btn-info";
            if(user == uid)
            {
                opcs += "<li><a onclick=cancelarRequerimiento(this)><i class='fa fa-close'></i> Cancelar</a></li></ul></div>";
            }
            break;

        case "RECHAZADO":
            clase += " btn-danger";
            opcs += "<li><a onclick=editarRequerimiento(this)<i class='fa fa-pencil'></i> Editar</a></li>";
            if(user == uid)
            {
                opcs += "<li><a onclick=cancelarRequerimiento(this)><i class='fa fa-close'></i> Cancelar</a></li></ul></div>";
            }
            break;
        
        case "EVALUADO":
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

    $.redirect( base_url + "requerimientos/ver", { 'id': id });
}

function editarRequerimiento(a){
    var ren = $(a).closest('tr');
    var btn = $(ren).find('button');
    var id = $(btn).val();

    $.redirect( base_url + "requerimientos/editar", { 'id': id });
}

function cancelarRequerimiento(a){
    var ren = $(a).closest('tr');
    var btn = $(ren).find('button');
    var id = $(btn).val();

    if(confirm("¿Desea cancelar Requerimiento?"))
    {
        var URL = base_url + 'requerimientos/ajax_setRequerimiento';
        
        var requerimiento = { 
            id : id,
            estatus : 'CANCELADO'
        };

        $.ajax({
            type: "POST",
            url: URL,
            data: { requerimiento : JSON.stringify(requerimiento) },
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