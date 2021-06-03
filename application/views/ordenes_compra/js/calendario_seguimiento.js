var dia; var cal; var idEvento;

function load(){
  /*$('.date').datetimepicker({
    format: 'hh:mm A'
  });
  */

  cal = $('#calendar').fullCalendar({
    header: {
    left: 'prev,next, today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay,listMonth'
    },
    locale: 'es',
    timeFormat: 'h(:mm)',
    events: base_url + "ordenes_compra/ajax_getAcciones_calendar",

    dayClick: function(date){
        //$("#modalNewTitle").html("Reservar sala de Juntas: " + date.format("D-MMM-Y"));
        //$('#inicia').val(date.format("h:mm A"));
        //$('#termina').val(date.format("h:mm A"));
        //dia = date.format();
        //$("#modalNew").modal();
    },

    eventClick: function(evento){
      console.log(evento.fecha_limite);
          mdlAccionFeedback(evento);
      }
    });

}



function mdlAccionFeedback(accion){

  $('#btnIr').val(accion.po);
  $('#btnIr').html('<i class="fa fa-shopping-cart"></i> Ir a PO:' + accion.po);

  var id_accion = accion.id;
  var descripcion = accion.accion;
  var estatus = accion.estatus;
  var usuario = accion.User;
  
  var limite = moment(accion.fecha_limite).format('DD/MM/YYYY h:mm A');
  var realizada = moment(accion.fecha_realizada).format('DD/MM/YYYY h:mm A');

  if(realizada == "Invalid date")
  {
      $('#divFechaRealizada').hide();
  }
  else{
      $('#divFechaRealizada').show();
  }

  $('#txtAccionFeed').text(descripcion);
  $('#txtResponsable').text(usuario);
  $('#lblFechaLimite').text(limite);
  $('#lblFechaRealizada').text(realizada);
  

  $('#btnAgregarAccionComentario').val(id_accion);
  cargarComentariosAccion(id_accion);
  $('#mdlAccionFeedback').modal();
}

function cargarComentariosAccion(id_accion){
  var URL = base_url + "ordenes_compra/ajax_getAccionComentarios";
  
  $('#ulComments').html("");
  
  $.ajax({
      type: "POST",
      url: URL,
      data: { accion : id_accion },
      success: function(result) {
          if(result)
          {
              var rs = JSON.parse(result);
              $.each(rs, function(i, elem){
                  var c = '<li>'
                  +    '<a>'
                  +        '<span>'
                  +            '<b>' + elem.User + '</b> ' + moment(elem.fecha).format('DD/MM/YYYY h:mm A') + '</span>'
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

function irAPo(btn){
  $(btn).val();

  $.redirect( base_url + "ordenes_compra/ver_po/" + $(btn).val(), { }, '', '_blank');
}





function crearEvento(){
  var inicia = $('#inicia').val();
  var termina = $('#termina').val();
  var descripcion = $('#notas').val();

  var i = new Date(dia + " " + inicia);
  var t = new Date(dia + " " + termina);
  inicia = i.getFullYear() + "-" + (i.getMonth() + 1) + "-" + paddy(i.getDate(),2) + " " + i.getHours() + ":" + paddy(i.getMinutes(),2);
  termina = t.getFullYear() + "-" + (t.getMonth() + 1) + "-" + paddy(t.getDate(),2) + " " + t.getHours() + ":" + paddy(t.getMinutes(),2);

  console.log(inicia);
  console.log(termina);

  if(moment(inicia) < moment(termina))
  {
    $.ajax({
        type: "POST",
        url: base_url + 'agenda/crearEvento',
        data: { 'titulo' : 'SALA DE JUNTAS', 'inicia' : inicia, 'termina' : termina, 'descripcion' : descripcion },
        success: function(result){
          cal.fullCalendar('renderEvent', {
            id: result,
            title: 'SALA DE JUNTAS',
            usuario: '<?= $this->session->id; ?>',
            User: '<?= $this->session->nombre; ?>',
            fecha: moment().format('YYYY-MM-D h:mm:ss a'),
            descripcion: descripcion,
            start: i,
            end: t,
            allDay: false
            },
          );
        },
        error: function(data){
          alert("Error");
          console.log(data);
        },
      });
  }
  else{
    alert("Fecha de inicio debe ser menor a la fecha de terminación")
  }
}

function borrarEvento(){
  $.ajax({
      type: "POST",
      url: base_url + 'agenda/borrarEvento',
      data: { 'id' : idEvento },
      success: function(result){
        if(result == "1"){
          cal.fullCalendar('removeEvents',idEvento);
        }
      },
      error: function(data){
        alert("Error");
        console.log(data);
      },
    });
}

  