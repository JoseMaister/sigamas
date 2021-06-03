function load(){
    buscar();
}

function buscar(){
    var URL = base_url + "equipos/ajax_getEquiposTI";
    $('#tabla tbody tr').remove();
    
    var parametro = ""; //$("input[name=rbBusqueda]:checked").val();
    var texto = ""; //$("#txtBusqueda").val();

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
                    if(elem.activo != "1"){
                        ren.style = "color: red;";
                    }
                    ren.dataset.id = elem.id;
                    ren.insertCell().innerHTML = "<img src='" + base_url + "data/equipos/ti/fotos/" + elem.foto + "' class='avatar' alt='Avatar'>";
                    ren.insertCell().innerHTML = paddy(elem.id, 4);
                    ren.insertCell().innerHTML = elem.tipo;
                    ren.insertCell().innerHTML = elem.Asignado;
                    ren.insertCell().innerHTML = boton(elem.id);
                });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}



function boton(id){
    opcs = "<ul role='menu' class='dropdown-menu'>";
    opcs += "<li><a onclick=verEquipo(" + id + ")><i class='fa fa-eye'></i> Ver</a></li>";
    if(PRIVILEGIOS.administrar_equipos_it == 1)
    {
        opcs += "<li><a onclick=mdlEditar(" + id + ")><i class='fa fa-pencil'></i> Editar</a></li>";
    }
    opcs += '</ul></div>';
    var btn = "<div class='btn-group'><button type='button' data-toggle='dropdown' class='btn dropdown-toggle btn-sm btn-success'>Opciones <span class='caret'></span></button>";
    btn += opcs;
    return btn;
}

/*function verRequerimiento(a){
    var ren = $(a).closest('tr');
    var btn = $(ren).find('button');
    var id = $(btn).val();

    $.redirect( base_url + "facturas/ver_solicitud", { 'id': id });
}*/

function campos(){
    var tipo = $('#opTipo').val();
    var arreglo = [];

    switch (tipo) {
        case "Laptop":
        case "Desktop":
            arreglo = ["Marca", "Modelo", "Service Tag", "Memoria Ram", "Capacidad HDD", "Tipo HDD", "SO", "Procesador", "No. Inventario Interno", "Modelo Teclado", "Serie Teclado", "Modelo Raton"];
            break;

        case "Monitor":
            arreglo = ["Marca", "Tamaño", "Serie", "No. Inventario Interno"];
            break;
            
        case "Impresora":
            arreglo = ["Marca", "Modelo", "Serie", "No. Inventario Interno"];
            break;

        case "Bateria":
            arreglo = ["Marca", "Modelo", "Serie"];
            break;

        case "Router":
        case "Switch":
            arreglo = ["Marca", "Modelo", "Serie", "No. Inventario Interno", "Locación"];
            break;

        case "Celular":
            arreglo = ["Marca", "Modelo", "Serie", "Numero Telefonico", "IMEI", "IMEI SIM", "Cuenta Registrada", "Password Cuenta", "Password Telefono", "Password Portal TELCEL"];
            break;
    
        default:            
            break;
    }

    //return arreglo;

    $('#divCampos').html("");
    arreglo.forEach(function(elem){
        var c = '<div style="margin-top: 5px;">';
        c +=        '<label>' + elem +'</label>';
        c +=        '<input maxlength="40" data-campo="' + elem +'" type="text" class="form-control">';
        c +=    '</div>';

        $('#divCampos').append(c);
    });
}

function agregar(){

    if(validacion())
    {
        var URL = base_url + "equipos/ajax_setEquiposTI";

        var campos = {};
        var ipt = $('#divCampos input');
        $.each(ipt, function(i, elem){
            campos[elem.dataset.campo] = elem.value;
        });

        var equipo = {};
        equipo.id = 0;
        equipo.asignado = $('#tblUsuario').data('user');
        equipo.tipo = $('#opTipo').val();
        equipo.campos = JSON.stringify(campos);
        equipo.activo = $('#cbActivo').is(':checked') ? 1 : 0;
        equipo.foto = $('#imgEquipo').data('foto');

        var formdata = new FormData();
        formdata.append("iptFoto", document.getElementById("iptFoto").files[0]);
        formdata.append("equipo", JSON.stringify(equipo));

        var ajax = new XMLHttpRequest();
        ajax.addEventListener("load", function(e){
            $('#mdlAlta').modal('hide');
            buscar();
        }, false);
        ajax.open("POST", URL);
        ajax.send(formdata);
    }
}

function editar(){
    if(validacion())
    {
        var URL = base_url + "equipos/ajax_setEquiposTI";

        var campos = {};
        var ipt = $('#divCampos input');
        $.each(ipt, function(i, elem){
            campos[elem.dataset.campo] = elem.value;
        });

        var equipo = {};
        equipo.id = $('#mdlAlta').data('id');
        equipo.asignado = $('#tblUsuario').data('user');
        equipo.tipo = $('#opTipo').val();
        equipo.campos = JSON.stringify(campos);
        equipo.activo = $('#cbActivo').is(':checked') ? 1 : 0;
        equipo.foto = $('#imgEquipo').data('foto');

        var formdata = new FormData();
        formdata.append("iptFoto", document.getElementById("iptFoto").files[0]);
        formdata.append("equipo", JSON.stringify(equipo));

        var ajax = new XMLHttpRequest();
        ajax.addEventListener("load", function(e){
            $('#mdlAlta').modal('hide');
            buscar();
        }, false);
        ajax.open("POST", URL);
        ajax.send(formdata);
    }
}

function readIMG(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imgEquipo').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function fotoDefault() {
    $("#iptFoto").val("");
    $('#imgEquipo').attr('src', base_url + 'data/equipos/ti/fotos/default.png');
}

function catalogoUsuarios(){
    if(!$('#btnAgregar').is(':visible') && !$('#btnEditar').is(':visible'))
    {
        return;
    }

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
        $('#lblUserName').text("NO ASIGNADO");
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

function verEquipo(id){
    var URL = base_url + "equipos/ajax_getEquiposTI";

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $('#opTipo').val(rs.tipo);
                $('#imgEquipo').attr('src', base_url + "data/equipos/ti/fotos/" + rs.foto);
                $('#cbActivo').iCheck(rs.activo == 1 ? 'check' : 'uncheck');
                

                campos();

                $('#opTipo').attr('disabled', true);
                $('#mdlAlta input').attr('readonly', true);
                $('#mdlAlta input').css('background', 'white');
                $('#mdlAlta select').css('background', 'white');
                $('#cbActivo').attr('disabled', true);

                $('.btn-foto').hide();

                $('#btnAgregar').hide();
                $('#btnEditar').hide();

                var cmps = JSON.parse(rs.campos);
                $.each(cmps, function(i, elem){
                    $("input[data-campo='" + i + "']").val(elem);
                });

                var btn = document.createElement("button");
                btn.value = rs.asignado;
                btn.dataset.name = rs.Asignado;
                seleccionarUsuario(btn);

                $('#mdlAlta').modal();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function mdlAlta(){
    fotoDefault();
    
    //ASIGNADO
    $('#lblUserName').text("NO ASIGNADO");
    $('#imgUser').attr('src', base_url + 'template/images/avatar.png');
    $('#tblUsuario').data('user', 0);

    $('#opTipo').attr('disabled', false);
    $('#opTipo').val("");
    $('.btn-foto').show();
    $('#cbActivo').iCheck('check');
    $('#imgEquipo').data('foto', 'default.png');
    
    
    $('#btnAgregar').show();
    $('#btnEditar').hide();
    

    campos();

    $('#mdlAlta').data('id', 0);
    $('#mdlAlta').modal();
}

function mdlEditar(id){
    var URL = base_url + "equipos/ajax_getEquiposTI";

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $('#opTipo').val(rs.tipo);
                $('#imgEquipo').attr('src', base_url + "data/equipos/ti/fotos/" + rs.foto);
                $('#cbActivo').iCheck(rs.activo == 1 ? 'check' : 'uncheck');
                $('#imgEquipo').data('foto', rs.foto);

                campos();

                $('#opTipo').attr('disabled', true);
                $('#mdlAlta input').attr('readonly', false);
                $('#mdlAlta select').css('background', 'white');
                $('#cbActivo').attr('disabled', false);

                $('.btn-foto').show();

                $('#btnAgregar').hide();
                $('#btnEditar').show();

                var cmps = JSON.parse(rs.campos);
                $.each(cmps, function(i, elem){
                    $("input[data-campo='" + i + "']").val(elem);
                });

                var btn = document.createElement("button");
                btn.value = rs.asignado;
                btn.dataset.name = rs.Asignado;
                seleccionarUsuario(btn);

                $('#mdlAlta').data('id', rs.id);
                $('#mdlAlta').modal();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function validacion(){
    if(!$('#opTipo').val())
    {
        alert("Seleccione tipo de equipo");
        return false;
    }

    return true;
}

