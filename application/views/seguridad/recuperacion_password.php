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
<body style="background: #fff;">
<div  style="height: 100%;" class="right_col" role="main">
    <div  class="">
        <div class="row">
            <div  class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Recuperación de Contraseña</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <form class="form-horizontal form-label-left" novalidate>
                          <div class="item form-group">
                            <center>
                                <h3>Ingresa los siguentes datos para iniciar la recuperación</h3>
                            </center>
                            </div>
                            <div class="item form-group">
                                <label for="txtNoEmpleado" class="control-label col-md-4">No. de Empleado</label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input id="txtNoEmpleado" style="text-transform: uppercase;" type="text" name="txtNoEmpleado" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            
                            <div class="item form-group">
                                <label for="txtCorreo" class="control-label col-md-4">Correo</label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input id="txtCorreo" style="text-transform: lowercase;" type="text" name="txtCorreo" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button id="btnAceptar" onclick="aceptar()" type="button" class="btn btn-primary">Aceptar</button>
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

<script>
    const base_url = '<?= base_url(); ?>';
</script>

<!-- jQuery -->
<script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js") ?>></script>
<!-- Bootstrap -->
<script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js") ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/seguridad/js/recuperacion_password.js"); ?>></script>
<script>
    $(function(){
        load();
    });
</script>
</body>
</html>
