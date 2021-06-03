        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Reservaciones Sala de Juntas</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id='calendar'></div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Equipo de Desarrollo | MAS Metrología
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- calendar modal -->
    <div id="modalNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="modalNewTitle">Agendar Sala de Juntas</h4>
          </div>
          <div class="modal-body">
            <div id="testmodal" style="padding: 5px 20px;">
              <form id="antoform" class="form-horizontal calender" role="form">

                <div class="form-group">
                    <label class="col-sm-3 control-label">Inicia:</label>
                    <div class='col-sm-3 input-group date' id='timeInicia'>
                        <input id="inicia" type='text' class="form-control" />
                        <span class="input-group-addon">
                           <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Termina:</label>
                    <div class='col-sm-3 input-group date' id='timeTermina'>
                        <input id="termina" type='text' class="form-control"/>
                        <span class="input-group-addon">
                           <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Notas:</label>
                    <div class='col-sm-9 input-group date'>
                        <textarea id="notas" class="form-control" ></textarea>
                    </div>
                </div>

              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Cerrar</button>
            <button type="button" onclick="crearEvento()" data-dismiss="modal" class="btn btn-primary">Agendar</button>
          </div>
        </div>
      </div>
    </div>
    <div id="modalView" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="modalViewTitle"></h4>
          </div>
          <div class="modal-body" style="height: 100%;" >
            <form>
            <div class="form-group" >
              <center style="font-size: 20px;">
                <label style="font-size: 15px;" class="col-sm-12 control-label" id="modalViewDate"></label>
                <label class="col-sm-12 control-label" id="modalViewUsuario">Usuario</label>
                <label class="col-sm-12 control-label" id="modalViewInicia">Inicia</label>
                <label class="col-sm-12 control-label" id="modalViewTermina">Termina</label>
                <label class="col-sm-12 control-label" id="modalViewNotes">Notas</label>
              </center>
            </div>
          </form>
          </div>
          <div class="modal-footer">
            <button id="modalCancel" onclick="borrarEvento()" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-default antoclose2" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- /calendar modal -->

    <!-- jQuery -->
    <script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
    <!-- Bootstrap -->
    <script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js"); ?>></script>
    <!-- FastClick -->
    <script src=<?= base_url("template/vendors/fastclick/lib/fastclick.js"); ?>></script>
    <!-- NProgress -->
    <script src=<?= base_url("template/vendors/nprogress/nprogress.js"); ?>></script>
    <!-- FullCalendar -->
    <script src=<?= base_url("template/vendors/moment/min/moment.min.js"); ?>></script>
    <script src=<?= base_url("template/vendors/fullcalendar/dist/fullcalendar.min.js"); ?>></script>
    <script src=<?= base_url("template/vendors/fullcalendar/dist/locale-all.js"); ?>></script>


    <!-- bootstrap-daterangepicker -->
    <script src=<?= base_url("template/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js") ?>></script>

    <!-- CUSTOM JS FILE -->
    <script src=<?=base_url("template/js/custom/funciones.js"); ?>></script>

    <!-- Custom Theme Scripts -->
    <script src=<?= base_url("template/build/js/custom.js"); ?>></script>
    <script>


    var dia; var cal; var idEvento;

    cal = $('#calendar').fullCalendar({
      header: {
      left: 'prev,next, today',
      center: 'title',
      right: 'month,agendaWeek,agendaDay,listMonth'
      },
      locale: 'es',
      timeFormat: 'h(:mm)',
      events: "<?= base_url("agenda/getEventos"); ?>",

      dayClick: function(date){
          $("#modalNewTitle").html("Reservar sala de Juntas: " + date.format("D-MMM-Y"));
          $('#inicia').val(date.format("h:mm A"));
          $('#termina').val(date.format("h:mm A"));
          dia = date.format();
          $("#modalNew").modal();
      },

      eventClick: function(evento){
          $("#modalViewTitle").html(evento.title + ": " + evento.start.format("D-MMM-Y"));
          $("#modalViewUsuario").html("Usuario: " + evento.User);
          $("#modalViewInicia").html("Inicia: " + evento.start.format("hh:mm A"));
          $("#modalViewTermina").html("Termina: " + evento.end.format("hh:mm A"));
          $("#modalViewDate").html("Creado: " + moment(evento.fecha).format('YYYY-MM-D h:mm:ss a'));
          idEvento = evento.id;
          if(evento.usuario == "<?= $this->session->id ?>")
          {
            $("#modalCancel").show();
          }else{
            $("#modalCancel").hide();
          }
          if(evento.descripcion.length == 0){
            $("#modalViewNotes").html("");
          }else{
            $("#modalViewNotes").html("Notas: " + evento.descripcion);
          }
          $("#modalView").modal();
      }
    });

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
            url: '<?= base_url('agenda/crearEvento') ?>',
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
          url: '<?= base_url('agenda/borrarEvento') ?>',
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

    $('.date').datetimepicker({
        format: 'hh:mm A'
    });

    </script>

  </body>
</html>
