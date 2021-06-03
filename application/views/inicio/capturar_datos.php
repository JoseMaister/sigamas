<?php
if (!isset($this->session->activo)) {
    $this->session->sess_destroy();
    redirect(base_url('login'));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="icon" href="<?= base_url("template/images/logo.ico"); ?>">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MAS Metrología</title>

        <!-- Bootstrap -->
        <link href=<?= base_url("template/vendors/bootstrap/dist/css/bootstrap.css"); ?> rel="stylesheet">
        <!-- Font Awesome -->
        <link href=<?= base_url("template/vendors/font-awesome/css/font-awesome.min.css") ?> rel="stylesheet">
        <!-- NProgress -->
        <link href=<?= base_url("template/vendors/nprogress/nprogress.css") ?> rel="stylesheet">
        <!-- iCheck -->
        <link href=<?= base_url("template/vendors/iCheck/skins/flat/green.css") ?> rel="stylesheet">

        <!-- bootstrap-progressbar -->
        <link href=<?= base_url("template/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css") ?> rel="stylesheet">
        <!-- JQVMap -->
        <link href=<?= base_url("template/vendors/jqvmap/dist/jqvmap.min.css") ?> rel="stylesheet"/>
        <!-- bootstrap-daterangepicker -->
        <link href=<?= base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.css"); ?> rel="stylesheet">

        <!-- PNotify -->
        <link href=<?= base_url("template/vendors/pnotify/dist/pnotify.css"); ?> rel="stylesheet">
        <link href=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.css"); ?> rel="stylesheet">
        <link href=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.css"); ?> rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href=<?= base_url("template/build/css/custom.css"); ?> rel="stylesheet">
        <!-- Dropzone.js -->
        <link href=<?= base_url("template/vendors/dropzone/dist/min/dropzone.min.css"); ?> rel="stylesheet">
        <!-- FancyBox -->
        <link href=<?= base_url("template/vendors/fancybox/dist/jquery.fancybox.min.css"); ?> rel="stylesheet">
        <!-- Bootstrap Colorpicker -->
        <link href=<?= base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.css") ?> rel="stylesheet">

    </head>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>¡HOLA <?= $this->session->nombre; ?>!</h2>
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

                        <form method="POST" action=<?= base_url('inicio/confirmar_datos') ?> class="form-horizontal form-label-left" novalidate>
                          <div class="item form-group">
                            <center>
                            <h3>¡Bienvenido! Por favor captura los siguientes datos por ser tu primera vez en SIGA-MAS</h3>
                            </center
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Correo</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="email" id="email" name="correo" class="form-control col-md-7 col-xs-12" required>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label for="password" class="control-label col-md-3">Constraseña</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="password" type="password" name="password" class="form-control col-md-7 col-xs-12" required>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">Confirmar Constraseña</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="password2" type="password" name="password2" data-validate-linked="password" class="form-control col-md-7 col-xs-12" required="required">
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button id="send" type="submit" class="btn btn-success">Confirmar Datos</button>
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

<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<script>

var noem = '<?= $this->session->no_empleado; ?>'
$('#password').blur(function(){
  if(this.value == noem)
  {
    alert('Tu password NO puede ser tu Numero de Empleado');
    this.value= '';
  }
});


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
</script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>

</body>
</html>
