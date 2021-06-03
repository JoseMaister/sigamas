<!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Generar Ticket de Servicio <small>Edificio</small></h2>
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

                    <form method="POST" id="frmTicket" action=<?= base_url('tickets_ED/registrar')?> class="form-horizontal form-label-left" novalidate>
                      
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tipo">Tipo <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <p>
                            Mantenimiento: 
                            <input type="radio" class="flat" name="tipo" id="tipoS" value="MANTENIMIENTO" checked="" required />
                            Intendencia: 
                            <input type="radio" class="flat" name="tipo" id="TipoH" value="INTENDENCIA" />
                          </p>
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
          if(!$("[name='titulo']").val() || !$("[name='descripcion']").val())
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

        return valor
      }


    </script>
	
  </body>

  
</html>