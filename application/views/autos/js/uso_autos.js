var dia; var cal;

var COLORS = [
    "#800000",
    "#9A6324",
    "#808000",
    "#469990",
    "#000075",
    "#000000",
    "#e6194B",
    "#f58231",
    "#ffe119",
    "#bfef45",
    "#3cb44b",
    "#42d4f4",
    "#4363d8",
    "#911eb4",
    "#f032e6",
    "#a9a9a9",
    "#fabebe",
    '#ffd8b1',
    '#e6beff',
    "#aaffc3",
    "#fffac8",
];

function load(){
    eventos();
    cal = $('#calendar').fullCalendar({
        header: {
        left: 'prev,next, today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listMonth'
        },
        locale: 'es',
        timeFormat: 'h(:mm)',
        events: base_url + "autos/ajax_getEventos",
        //events: base_url + "agenda/geteventos",
    
        dayClick: function(date){
            mdlAlta(date);
        },
    
        eventClick: function(evento){
            verDatos(evento);
        }
    });
    
    $('.date').datetimepicker({
        format: 'hh:mm A'
    });
}

function mdlAlta(date){
    if(P == "1")
    {
        cargarAutos();
        $("#mdlAltaTitle").html("Uso de Vehículo: " + date.format("D-MMM-Y"));
        $('#inicia').val("7:30 AM");
        $('#termina').val("12:00 PM");

        $('#txtRSI').val("");
        $('#txtDestino').val("");
        $('#txtVisita').val("");
        $('#txtComentarios').val("");
        $('#txtEquipo').val("");

        $('#btnUsuarios').html("<i class='fa fa-users'></i> Usuarios");
        $('#btnUsuarios').val("[]");

        dia = date.format();
        $("#mdlAlta").modal();
    }
}

function verDatos(e){
    $('#txtInicioRO').val(moment(e.start).format('h:mm a'));
    $('#txtFinalPO').val(moment(e.end).format('h:mm a'));
    $('#txtRSIRO').val(e.rsi);
    $('#txtDestinoRO').val(e.destino);
    $('#txtVisitaRO').val(e.visita);
    $('#txtComentariosRO').val(e.comentarios);
    $('#txtEquipoRO').val(e.equipo);
    $('#lblAuto').text(e.title);
    $("#imgAuto").attr("src", base_url + "autos/photo/" + e.auto);
    
    var users = JSON.parse(e.usuarios);
    cargarUsuarios(users);

    if(UID == e.usuario)
    {
        $("#btnEliminar").show();
        $("#btnEliminar").val(e.id);
    }
    else{
        $("#btnEliminar").hide();
    }

    $("#mdlVer").modal();
}

function eventos(){
    $('#mdlUsuarios').on('keypress', function( e ) {
        if( e.keyCode === 13 ) {
            e.preventDefault();
            mdlUsuarios();
        }
    });
}

function validacion(){

    var inicia = $('#inicia').val();
    var termina = $('#termina').val();
    var i = new Date(dia + " " + inicia);
    var t = new Date(dia + " " + termina);
    inicia = i.getFullYear() + "-" + (i.getMonth() + 1) + "-" + i.getDate() + " " + i.getHours() + ":" + i.getMinutes();
    termina = t.getFullYear() + "-" + (t.getMonth() + 1) + "-" + t.getDate() + " " + t.getHours() + ":" + t.getMinutes();
    

    if(moment(inicia) >= moment(termina))
    {
        alert("Fecha de inicio debe ser menor a la fecha de terminación");   
        return false;
    }
    if(!$('#txtRSI').val().trim())
    {
        alert("Ingrese numero de RSI");
        return false;
    }
    if(!$('#txtDestino').val().trim())
    {
        alert("Ingrese destino");
        return false;
    }
    if(!$('#txtVisita').val().trim())
    {
        alert("Ingrese Visita");
        return false;
    }
    if(!$('#opAutos').val())
    {
        alert("Seleccione Automóvil");
        return false;
    }
    if(JSON.parse($('#btnUsuarios').val()).length <= 0 )
    {
        alert("Seleccione usuarios");
        return false;
    }


    return true;
}

function crearEvento(){
    var inicia = $('#inicia').val();
    var termina = $('#termina').val();

    var i = new Date(dia + " " + inicia);
    var t = new Date(dia + " " + termina);
    inicia = i.getFullYear() + "-" + (i.getMonth() + 1) + "-" + i.getDate() + " " + i.getHours() + ":" + i.getMinutes();
    termina = t.getFullYear() + "-" + (t.getMonth() + 1) + "-" + t.getDate() + " " + t.getHours() + ":" + t.getMinutes();

    var data = {};
    data.rsi = $('#txtRSI').val();
    data.destino = $('#txtDestino').val();
    data.visita = $('#txtVisita').val();
    data.comentarios = $('#txtComentarios').val();
    data.equipo = $('#txtEquipo').val();
    data.auto = $('#opAutos').val();
    data.inicio = inicia;
    data.final = termina;
    data.usuarios = $('#btnUsuarios').val();
    data.color = COLORS[data.auto % 21];

    var auto = $('#opAutos option:selected').text();

    if(validacion())
    {
        $.ajax({
            type: "POST",
            url: base_url + 'autos/ajax_crearEvento',
            data: { data : JSON.stringify(data) },
            success: function(result)
            {
                cal.fullCalendar('renderEvent', {
                id: result,
                auto: data.auto,
                title: auto,
                rsi: data.rsi,
                destino: data.destino,
                visita: data.visita,
                usuario: UID,
                usuarios: data.usuarios,
                comentarios: data.comentarios,
                equipo: data.equipo,
                User: UNAME,
                fecha: moment().format('YYYY-MM-D h:mm:ss a'),
                start: i,
                end: t,
                allDay: false,
                color: data.color,
                });

                $('#mdlAlta').modal('hide');
            },
            error: function(data){
                console.log(data);
            },
        });
    }
    
}

function borrarEvento(btn){
    if(confirm("¿Desea continuar?"))
    {
        var idEvento = $(btn).val();
        $.ajax({
            type: "POST",
            url: base_url + 'autos/ajax_borrarEvento',
            data: { 'id' : idEvento },
            success: function(result){
            if(result == "1"){
                cal.fullCalendar('removeEvents', idEvento);
                $('#mdlVer').modal('hide');
            }
            },
            error: function(data){
            console.log(data);
            },
        });
    }
}

function cargarAutos(){
    var URL = base_url + "autos/ajax_getAutos";
    $('#opAutos option').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { },
        success: function(result) {
            if(result)
            {
                //var tab = $('#tabla tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var option = new Option(elem.placas + " - " + elem.marca, elem.id);
                    $('#opAutos').append(option);
                });
                $('#opAutos').val("");
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function mdlUsuarios(){
    $('#tblUsuarios tbody tr').remove();
    var URL = base_url + "usuarios/ajax_getUsuarios";

    var notificaciones = JSON.parse($('#btnUsuarios').val());

    $.ajax({
        type: "POST",
        url: URL,
        data: { },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblUsuarios tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    var check = notificaciones.includes(parseInt(elem.id)) ? 'checked' : '';
                    ren.insertCell().innerHTML = "<input type='checkbox' value=" + elem.id + " class='flat selecc' " + check + ">";
                    ren.insertCell().innerHTML = elem.User;
                    ren.insertCell().innerHTML = elem.puesto;                    
                });

                $('.selecc').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                });

                $('#mdlUsuarios').modal();
            }
          },
    });
}

function asignarUsuarios(){
    var users = [];
    var rows = $('#tblUsuarios tbody tr');
    $.each(rows, function(i, elem){
        if($(elem).find('input').is(':checked'))
        {
            users.push(parseInt($(elem).find('input').val()));
        }
    });

    var count = users.length > 0 ? (" (" + users.length + ')') : '';
    $('#btnUsuarios').html("<i class='fa fa-users'></i> Usuarios" + count);
    $('#btnUsuarios').val(JSON.stringify(users));
    $('#mdlUsuarios').modal('hide');
    
}

function cargarUsuarios(users){
    $('#tblUsuariosRO tbody tr').remove();

    $.each(users, function(i, elem){
        $.get(base_url + 'usuarios/name/' + elem, function( data ) {
            var tab = $('#tblUsuariosRO tbody')[0];
            var ren = tab.insertRow(tab.rows.length);
            ren.insertCell(0).innerHTML = '<a href="' + base_url + 'usuarios/ver/' + elem + '" target="_blank"><img class="avatar" src="' + base_url + 'usuarios/photo/' + elem + '" alt="img" /></a>';
            ren.insertCell(1).innerHTML = data;
        });
    });

}