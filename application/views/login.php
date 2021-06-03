<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="icon" href=<?= base_url("template/images/logo.ico"); ?>>
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Inicio de Sesión | MAS Metrología</title>

  <!-- Bootstrap -->
  <link href=<?= base_url('template/vendors/bootstrap/dist/css/bootstrap.min.css'); ?> rel="stylesheet">
  <!-- Font Awesome -->
  <link href=<?= base_url('template/vendors/font-awesome/css/font-awesome.min.css'); ?> rel="stylesheet">
  <!-- NProgress -->
  <link href=<?= base_url('template/vendors/nprogress/nprogress.css'); ?> rel="stylesheet">
  <!-- Animate.css -->
  <link href=<?= base_url('template/vendors/animate.css/animate.min.css'); ?> rel="stylesheet">
  <!-- PNotify -->
  <link href=<?= base_url("template/vendors/pnotify/dist/pnotify.css"); ?> rel="stylesheet">
  <link href=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.css"); ?> rel="stylesheet">
  <link href=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.css"); ?> rel="stylesheet">
  

  <!-- Custom Theme Style -->
  <link href=<?= base_url('template/build/css/custom.min.css'); ?> rel="stylesheet">

  <style type="text/css">
    #video {
      position: fixed;
      right: 0;
      bottom: 0;
      min-width: 100%;
      min-height: 100%;
    }
  </style>
</head>

<body class="login">
  <video onclick="myFunction()" autoplay muted loop id="video">
    <source src=<?= base_url('template/images/masmetrologia.mp4') ?> type="video/mp4">
  </video>
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div id="log" class="login_wrapper">
      <div style="background: #c7c6d096; padding: 15px; color: black;" class="animate form login_form">
        <section class="login_content">
          <form method="POST" action=<?= base_url('login/autenticar') ?>>
            <input type="hidden" name="url_actual" value="<?= $url_actual ?>"/>
            <h1>Inicio de Sesión</h1>
            <div>
              <input type="text" name="user" class="form-control" placeholder="Usuario" required="" />
            </div>
            <div>
              <input type="password" name="pass" class="form-control" placeholder="Contraseña" required="" />
            </div>
            <div>
              <input type="submit" class="btn btn-default submit" value="Iniciar Sesión">
            </div>

            <div class="clearfix"></div>

            <div class="separator">

              <br />

              <div>
                <img style="width: 100%" src=<?= base_url('template/images/logo.png') ?>>
                <p>©2019 Todos los Derechos Reservados | Equipo de Desarrollo MAS Metrología</p>
                <!--<a id="btnReloj" href="<?= str_replace("http:", "https:", base_url('reloj_checador')); ?>" style="background: transparent;" class="btn btn-default">Reloj Checador</a>-->
                <button type="button" onclick="password()" class="btn btn-primary btn-xs">Recuperar Contraseña</button>
              </div>
            </div>
          </form>
        </section>
      </div>

    </div>
  </div>

<!-- jQuery -->
<script src=<?=base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>


<script>

$(function(){
  notificaciones();
});

function notificaciones(){
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
    }


    function password(){
  window.location.href = '<?= base_url('seguridad/recuperacion_password'); ?>'
}

var cuadro = document.getElementById("log");


function myFunction() {
  if(cuadro.style.display == "none")
  {
    cuadro.style.display = "block";
  }
  else
  {
    cuadro.style.display = "none";
  }
}



</script>



  </body>
</html>
