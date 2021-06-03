<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Crear Usuario</h2>
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
                      <div id="wizard" class="form_wizard wizard_horizontal">
                        <ul class="wizard_steps">
                          <li>
                            <a href="#step-1">
                              <span class="step_no">1</span>
                              <span class="step_descr"><small>Usuario</small></span>
                            </a>
                          </li>
                          <li>
                            <a href="#step-2">
                              <span class="step_no">2</span>
                              <span class="step_descr"><small>Usuario</small></span>
                            </a>
                          </li>
                        </ul>

                        <div id="step-1">
                          <form method="POST" id="formulario" action=<?= base_url('usuarios/registrar') ?> class="form-horizontal form-label-left" novalidate>
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">No. Empleado <span class="required">*</span>
                                  </label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input class="form-control col-md-7 col-xs-12" name="no_empleado" placeholder="" required="required" type="text">
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nombre(s) <span class="required">*</span>
                                  </label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input class="form-control col-md-7 col-xs-12" name="nombre" placeholder="" required="required" type="text">
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Apellido Paterno <span class="required">*</span>
                                  </label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input class="form-control col-md-7 col-xs-12" name="paterno" placeholder="" required="required" type="text">
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Apellido Materno <span class="required">*</span>
                                  </label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input class="form-control col-md-7 col-xs-12" name="materno" placeholder="" required="required" type="text">
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Correo <span class="required">*</span>
                                  </label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input type="email" id="email" name="correo" required="required" class="form-control col-md-7 col-xs-12">
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Departamento <span class="required">*</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input id="name" class="form-control col-md-7 col-xs-12" name="departamento" placeholder="" required="required" type="text">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Puesto <span class="required">*</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <select required="required" class="select2_single form-control" name="privilegio">
                                          <?php foreach ($privilegios as $elem) { ?>
                                              <option value=<?= $elem->id ?>><?= $elem->puesto ?></option>
                                          <?php } ?>
                                      </select>
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label for="password" class="control-label col-md-3">Contraseña</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input id="password" type="password" name="password" class="form-control col-md-7 col-xs-12" required="required">
                                  </div>
                              </div>
                              <div class="item form-group">
                                  <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">Confirmar Contraseña</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input id="password2" type="password" name="password2" data-validate-linked="password" class="form-control col-md-7 col-xs-12" required="required">
                                  </div>
                              </div>
                        </div>
                        </form>
                        <div id="step-2">

                        </div>

                      </div>
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
<!-- jQuery Smart Wizard -->
<script src=<?= base_url("template/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js") ?>></script>

<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<script>
<?php
if (isset($this->session->errores)) {
    foreach ($this->session->errores as $error) {
        echo "new PNotify({ title: '" . $error['titulo'] . "', text: '" . $error['detalle'] . "', type: 'error', styling: 'bootstrap3' });";
    }
    $this->session->unset_userdata('errores');
}
if (isset($this->session->aciertos)) {
    foreach ($this->session->aciertos as $acierto) {
        echo "new PNotify({ title: '" . $acierto['titulo'] . "', text: '" . $acierto['detalle'] . "', type: 'success', styling: 'bootstrap3' });";
    }
    $this->session->unset_userdata('aciertos');
}
?>

$('#wizard').smartWizard({
  // Properties
    selected: 0,  // Selected Step, 0 = first step
    keyNavigation: true, // Enable/Disable key navigation(left and right keys are used if enabled)
    enableAllSteps: false,  // Enable/Disable all steps on first load
    transitionEffect: 'fade', // Effect on navigation, none/fade/slide/slideleft
    contentURL:null, // specifying content url enables ajax content loading
    contentURLData:null, // override ajax query parameters
    contentCache:true, // cache step contents, if false content is fetched always from ajax url
    cycleSteps: false, // cycle step navigation
    enableFinishButton: false, // makes finish button enabled always
	  hideButtonsOnDisabled: true, // when the previous/next/finish buttons are disabled, hide them instead
    errorSteps:[],    // array of step numbers to highlighting as error steps
    labelNext:'Siguiente', // label for Next button
    labelPrevious:'Volver', // label for Previous button
    labelFinish:'Crear Usuario',  // label for Finish button
    noForwardJumping:false,
    // Events
    onLeaveStep: null, // triggers when leaving a step
    onShowStep: null,  // triggers when showing a step
    onFinish: enviar  // triggers when Finish button is clicked
});
function enviar()
{
  $('#wizard').smartWizard('goToStep', 1);
  $("#formulario").delay(3000).submit();
}

</script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>

</body>
</html>
