    <!-- page content -->
    <div class="right_col" role="main">
      <div class="">

        <div class="clearfix"></div>

        <div class="row">
          <div class="col-md-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Calendario de Seguimiento (Ordenes de Compra)</h2>
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
<div id="mdlAccionFeedback" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Seguimiento</h4>
            </div>
           
            <div class="modal-body">
                <form>
                    
                    <div style="margin-top: 10px;" class="col-xs-12">
                        <label style="display: block;">Acción</label>
                        <p id="txtAccionFeed"></p>
                    </div>

                    <div style="margin-top: 10px;" class="col-xs-12">
                        <label style="display: block;">Responsable</label>
                        <p id="txtResponsable"></p>
                    </div>

                    <div style="margin-top: 10px;" class="col-xs-6">
                        <label style="display: block;">Fecha Limite:</label>
                        <p id="lblFechaLimite"></p>
                    </div>
                    
                    <div id="divFechaRealizada" style="margin-top: 10px; display: none;" class="col-xs-6">
                        <label style="display: block;">Fecha Realizada:</label>
                        <p id="lblFechaRealizada"></p>
                    </div>

                    <div style="margin-top: 10px;" class="col-xs-12">

                        <ul id='ulComments' class="list-unstyled msg_list">
                        <ul>
                        
                    </div>
                    
                    
                </form>
            </div>

            <div class="modal-footer">
                <button data-dismiss="modal" style="display: inline;" type="button" class="btn btn-default pull-left"><i class="fa fa-close"></i> Cerrar</button>
                <button onclick="irAPo(this)" id="btnIr" type="button" class="btn btn-success"></button>
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

<!-- jquery.redirect -->
<script src=<?= base_url("template/vendors/jquery.redirect/jquery.redirect.js"); ?>></script>
<!-- bootstrap-daterangepicker -->
<script src=<?= base_url("template/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js") ?>></script>
<!-- CUSTOM JS FILE -->
<script src=<?=base_url("template/js/custom/funciones.js"); ?>></script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
<!-- JS FILE -->
<script src=<?=base_url("application/views/ordenes_compra/js/calendario_seguimiento.js"); ?>></script>
<script>

$(function(){
  load();
});

</script>

</body>
</html>
