<link href=<?= base_url("template/vendors/cropper/dist/cropper.min.css"); ?> rel="stylesheet">
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Subir Foto</h3>
              </div>
            </div>

            <div class="clearfix"></div>


            <div class="row">
              <div class="col-md-6 col-md-offset-3 col-xs-12">
                <div class="container cropper">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="img-container">
                        <img id="image" src=<?= base_url("template/images/avatar.png"); ?> alt="Picture">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 docs-buttons">

                      <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
                          <span class="docs-tooltip" data-toggle="tooltip" title="Acercar">
                            <span class="fa fa-search-plus"></span>
                          </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
                          <span class="docs-tooltip" data-toggle="tooltip" title="Alejar">
                            <span class="fa fa-search-minus"></span>
                          </span>
                        </button>
                      </div>

                      <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                          <span class="docs-tooltip" data-toggle="tooltip" title="Mover a la Izquierda">
                            <span class="fa fa-arrow-left"></span>
                          </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                          <span class="docs-tooltip" data-toggle="tooltip" title="Mover a la Derecha">
                            <span class="fa fa-arrow-right"></span>
                          </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                          <span class="docs-tooltip" data-toggle="tooltip" title="Mover hacia Arriba">
                            <span class="fa fa-arrow-up"></span>
                          </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                          <span class="docs-tooltip" data-toggle="tooltip" title="Mover hacia Abajo">
                            <span class="fa fa-arrow-down"></span>
                          </span>
                        </button>
                      </div>

                      <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
                          <span class="docs-tooltip" data-toggle="tooltip" title="Girar a la Izquierda">
                            <span class="fa fa-rotate-left"></span>
                          </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
                          <span class="docs-tooltip" data-toggle="tooltip" title="Girar a la Derecha">
                            <span class="fa fa-rotate-right"></span>
                          </span>
                        </button>
                      </div>

                      <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                          <span class="docs-tooltip" data-toggle="tooltip" title="Mover Horizontal">
                            <span class="fa fa-arrows-h"></span>
                          </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
                          <span class="docs-tooltip" data-toggle="tooltip" title="Mover Vertical">
                            <span class="fa fa-arrows-v"></span>
                          </span>
                        </button>
                      </div>

                      <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
                          <span class="docs-tooltip" data-toggle="tooltip" title="Reiniciar">
                            <span class="fa fa-refresh"></span>
                          </span>
                        </button>
                        <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                          <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">
                          <span class="docs-tooltip" data-toggle="tooltip" title="Subir desde PC">
                            <span class="fa fa-upload"></span>
                          </span>
                        </label>
                      </div>

                      <div class="btn-group btn-group-crop">
                        <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 160, &quot;height&quot;: 90 }">
                          <span class="docs-tooltip" data-toggle="tooltip" title="Aceptar">
                            Aceptar
                          </span>
                        </button>
                      </div>

                        <!--
                        <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 160, &quot;height&quot;: 90 }">
                          <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getCroppedCanvas&quot;, { width: 160, height: 90 })">
                            160&times;90
                          </span>
                        </button>
                      </div>-->

                      <!-- Show the cropped image in modal -->
                      <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="getCroppedCanvasTitle">Confirmar</h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                              <form method="POST" action=<?= base_url('usuarios/subirfoto') ?>>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                              <input type="hidden" name="foto" id="download" value="javascript:void(0);">
                              <input type="submit" class="btn btn-primary" value="Aceptar">
                              <!--<a class="btn btn-primary" id="download" value="javascript:void(0);">Download</a>-->
                              </form>
                            </div>
                          </div>
                        </div>
                      </div><!-- /.modal -->


                    </div><!-- /.docs-buttons -->
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
    <script type="text/javascript">
      function subir() {
          var xhr = new XMLHttpRequest();
          var url = 'http://localhost/MASMetrologia/usuarios/subirfoto';
          xhr.open("POST", url, true);
          xhr.setRequestHeader("Content-type", "application/json");
          xhr.onreadystatechange = function () {
              if (xhr.readyState === 4 && xhr.status === 200) {
                  var json = JSON.parse(xhr.responseText);
                  console.log(json.email + ", " + json.password);
              }
          };
          var data = JSON.stringify({"email": "test", "password": "101010"});
          xhr.send(data);
      }
    </script>

    <!-- jQuery -->
    <script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
    <!-- Bootstrap -->
    <script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js"); ?>></script>
    <!-- FastClick -->
    <script src=<?= base_url("template/vendors/fastclick/lib/fastclick.js"); ?>></script>
    <!-- NProgress -->
    <script src=<?= base_url("template/vendors/nprogress/nprogress.js"); ?>></script>
    <!-- bootstrap-daterangepicker -->
    <script src=<?= base_url("template/vendors/moment/min/moment.min.js"); ?>></script>
    <script src=<?= base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.js"); ?>></script>
    <!-- bootstrap-datetimepicker -->
    <script src=<?= base_url("template/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"); ?>></script>
    <!-- Ion.RangeSlider -->
    <script src=<?= base_url("template/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js"); ?>></script>
    <!-- Bootstrap Colorpicker -->
    <script src=<?= base_url("template/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"); ?>></script>
    <!-- jquery.inputmask -->
    <script src=<?= base_url("template/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"); ?>></script>
    <!-- jQuery Knob -->
    <script src=<?= base_url("template/vendors/jquery-knob/dist/jquery.knob.min.js"); ?>></script>
    <!-- Cropper -->
    <script src=<?= base_url("template/vendors/cropper/dist/cropper.js"); ?>></script>

    <!-- Custom Theme Scripts -->
    <script src=<?= base_url("template/build/js/custom.js"); ?>></script>
  </body>
</html>
