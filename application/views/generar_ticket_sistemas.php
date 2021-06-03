<!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Generar Ticket de Servicio <small>Sistemas</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <form method="POST" id="frmTicket" action=<?= base_url('tickets_IT/registrar')?> class="form-horizontal form-label-left" novalidate>
                      
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tipo">Categoria <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="opCategoria" class="select2_single form-control">
                            <option value=""></option>
                            <option value="Correo">Correo</option>
                            <option value="Hardware">Hardware</option>
                            <option value="MLSystem">MLSystem</option>
                            <option value="Red">Red</option>
                            <option value="SIGA-MAS">SIGA-MAS</option>
                            <option value="Sistema Cotizaciones">Sistema Cotizaciones</option>
                            <option value="Telefono">Telefono</option>
                            <option value="Otro">Otro</option>
                          </select>
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="titulo">Titulo <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input maxlength="100" id="titulo" class="form-control col-md-7 col-xs-12" name="titulo" placeholder="Ej. Falla de conectividad" required="required" type="text">
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Descripción <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="textarea" required="required" name="descripcion" class="form-control col-md-7 col-xs-12"></textarea>
                        </div>
                      </div>
                      <!-- <div class="ln_solid"></div> -->
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button id="send" type="submit" onclick="return confirmar();" class="btn btn-success">Abrir Ticket</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- MODALS -->
        <div id="mdlTicketsSimultaneos" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="mdlTitle"></h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <label>Actualmente se está trabajando en los siguientes tickets relacionados, ¿Desea continuar?</label>
                            <table id="tblTickets" class="table table-striped">
                                <thead>
                                    <tr class="headings">
                                        <th>Fecha</th>
                                        <th>Usuario</th>
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" type="button" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cancelar</button>
                        <button onclick="enviarTicket()" type="button" class="btn btn-success"><i class="fa fa-check"></i> Continuar</button>
                    </div>
                </div>
            </div>
        </div>

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

    <!-- jQuery -->
    <script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js") ?>></script>
    <!-- Bootstrap -->
    <script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js") ?>></script>
    <!-- FastClick -->
    <script src=<?= base_url("template/vendors/fastclick/lib/fastclick.js") ?>></script>
    <!-- NProgress -->
    <script src=<?= base_url("template/vendors/nprogress/nprogress.js") ?>></script>
    <!-- validator -->
    <script src=<?= base_url("template/vendors/validator/validator.js") ?>></script>
    <!-- iCheck -->
    <script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
    <!-- Custom Theme Scripts -->
    <script src=<?= base_url("template/build/js/custom.min.js") ?>></script>

    <script>
    
      var bForm = true;

      function confirmar()
      {
        var valor = true;
        if(bForm)
        {
          if(!$("[name='titulo']").val() || !$("[name='descripcion']").val() || !$("[name='opCategoria']").val())
          {
            alert("Ingrese todos los campos");
            valor = false;
          }
          else
          {
            if(confirm("¿Desea continuar?"))
            {
              bForm = false;
              valor = true;
            }
            else{
              valor = false;
            }
          }
        }
        else{
          valor = false;
        }

        var categoria = $("[name='opCategoria']").val();
        if(categoria == "MLSystem" || categoria == "Sistema Cotizaciones")
        {          
          valor = false;
          comprobarTickets();
        }

        return valor
      }

      function comprobarTickets(){
        var categoria = $("[name='opCategoria']").val();
        $('#mdlTitle').text("Tickets abiertos: " + categoria);
        $('#tblTickets tbody tr').remove();

        
        var URL = base_url + 'tickets_IT/ajax_TicketsSimultaneos';

        $.ajax({
          type: "POST",
          url: URL,
          data: { categoria : categoria},
          success: function(result) {
            if(result)
            {
              var tbl = $('#tblTickets tbody')[0];
              var rs = JSON.parse(result);
              $.each(rs, function(i, elem)
              {
                var row = tbl.insertRow();
                row.insertCell().innerHTML = moment(elem.fecha).format('YYYY-MM-D h:mm a'),
                row.insertCell().innerHTML = elem.User;
                row.insertCell().innerHTML = elem.descripcion;
              });
              
              $('#mdlTicketsSimultaneos').modal();
            }
            else
            {
              $('#frmTicket').submit();
            }
          },
          error: function(data){
              console.log(data);
          },
        });
      }

      function enviarTicket(){
        $('#frmTicket').submit();
      }


    </script>
	
  </body>

  
</html>