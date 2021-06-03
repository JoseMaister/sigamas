<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                <div class="x_title">
                        <h2>Bienvenido a SIGA-MAS</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                    <center>
                    <img style="width: 60%;" src=<?= base_url('template/images/logo.png') ?>>
                    <h1>SIGA-MAS</h1>
                    <h3>Sistema Inteligente de Gestión Administrativa - Mas Metrología</h3>
                    <button class='btn btn-primary' type='button' onclick='video()'>Quienes somos</button>
                    </center>
                    </div>
                </div>
            </div>
            <?php if ($tickets) { ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Tickets Pendientes</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">ID</th>
                                        <th class="column-title">Fecha de Creación</th>
                                        <th class="column-title">Ticket</th>
                                        <th class="column-title">Tipo</th>
                                        <th class="column-title">Titulo</th>
                                        <th class="column-title">Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>


                                <?php

                                  $BTN_CLASS = 'btn btn-default';
                                  foreach ($tickets->result() as $elem) {
                                      switch ($elem->estatus) {

                                          case 'ABIERTO':
                                              $BTN_CLASS = 'btn btn-primary';
                                              break;

                                          case 'EN CURSO':
                                              $BTN_CLASS = 'btn btn-info';
                                              break;

                                          case 'DETENIDO':
                                              $BTN_CLASS = 'btn btn-warning';
                                              break;

                                          case 'CANCELADO':
                                              $BTN_CLASS = 'btn btn-default';
                                              break;

                                          case 'SOLUCIONADO':
                                              $BTN_CLASS = 'btn btn-success';
                                              break;

                                          case 'CERRADO':
                                              $BTN_CLASS = 'btn btn-dark';
                                              break;
                                      }
                                      ?>
                                          <tr class="even pointer">
                                              <td><?= $elem->Prefijo . str_pad($elem->id, 6, "0", STR_PAD_LEFT) ?></td>
                                              <td>
                                                  <?php $date = date_create($elem->fecha); ?>
                                                  <a><?= date_format($date, 'd/m/Y h:i A'); ?></a>
                                              </td>
                                              <td><?= $elem->Ticket ?></td>
                                              <td><?= $elem->tipo ?></td>
                                              <td><?= $elem->titulo ?></td>
                                              <td><a href=<?= base_url($elem->Controlador . "/ver/" . $elem->id) ?>><button type="button" class=<?= "'" . $BTN_CLASS . "'" ?> ><?= $elem->estatus ?></button></a></td>
                                          </tr>
                                      <?php
                                  }
                                ?>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- /page content -->


<div id="mdl" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title mdlTitulo">Talento Humano - MAS Metrología</h4>
            </div>

            <div class="modal-body">
            <center>
                <!--<iframe width="672" height="378" src="https://www.youtube.com/embed/_DG5O1gS6Ys?autoplay=1&controls=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->

                    <div id="howToVideo"></div>
            </center>
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


<!-- SCRIPTS -->
<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>


<!-- jQuery -->
<script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
<!-- Bootstrap -->
<script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js"); ?>></script>
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

$(function(){
    $('#mdl').on('hidden.bs.modal', function () {
        player.stopVideo();
    });
})

function video(){
    $('#mdl').modal();
    player.playVideo();
}
</script>

<script type="application/javascript">

    var ga = document.createElement('script');
    ga.type = 'text/javascript';
    ga.async = false;
    ga.src = 'http://www.youtube.com/player_api';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(ga, s);

    var done = false;
    var player;

    function onYouTubePlayerAPIReady() {
        player = new YT.Player('howToVideo', {
            height: '390',
            width: '640',
            videoId: '_DG5O1gS6Ys',
        playerVars: {
            controls: 0,
            disablekb: 1
        },
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
    }
    function onPlayerReady(evt) {
        console.log('onPlayerReady', evt);
    }
    function onPlayerStateChange(evt) {
        /*console.log('onPlayerStateChange', evt);
        if (evt.data == YT.PlayerState.PLAYING && !done) {
            setTimeout(stopVideo, 6000);
            done = true;
        }*/
    }

</script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>









</body>
</html>
