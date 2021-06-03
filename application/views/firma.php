<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                <div class="x_title">
                    <h2>Firma Correo</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-4">
                        <img src=<?= base_url('template/images/logo_firma.png') ?>>
                        </div>  
                        <div class="col-md-4">
                        <h2 style="color: #11386f">Alejandro Ortiz</h2>
                        <h2 style="color: #11386f">Programador de Sistemas</h2>
                        <h3 style="color: #80bc09">Tel: 656 980.0800</h3>
                        <h4 style="color: #80bc09">Buscanos en:</h4>
                        <a href="https://www.masmetrologia.com.mx/" target="_blank"><img style="width:40px;" src=<?= base_url('template/images/icon_web.png') ?>></a>
                        <a href="https://www.facebook.com/masmetrologia/" target="_blank"><img style="width:40px;" src=<?= base_url('template/images/icon_fb.png') ?>></a>
                        <a href="https://twitter.com/masmetrologia?lang=en" target="_blank"><img style="width:40px;" src=<?= base_url('template/images/icon_twitter.png') ?>></a>
                        <a href="https://www.instagram.com/masmetrologia/?hl=en" target="_blank"><img style="width:40px;" src=<?= base_url('template/images/icon_instagram.png') ?>></a>
                        <a href="https://www.youtube.com/channel/UCG4dWF3vZpfQLdGrFaAFQQQ/" target="_blank"><img style="width:40px;" src=<?= base_url('template/images/icon_youtube.png') ?>></a>
                        <a href="https://www.google.com.mx/maps/place/Metrologia+Aplicada+y+Servicios+S+de+RL+de+CV/@31.7107542,-106.4106989,17z/data=!3m1!4b1!4m5!3m4!1s0x86e75c5774096439:0xccdf9ccf12d45307!8m2!3d31.7107542!4d-106.4085102" target="_blank"><img style="width:40px;" src=<?= base_url('template/images/icon_maps.png') ?>></a>
                        </div>  
                    </div>
                </div>
                </div>
            </div>
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
                    <video id="vid" width="672" height="378">
                        <source src="<?= base_url('template/files/videos/talento_humano2019.mp4') ?>" type="video/mp4">
                    </video>
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
    var video = document.getElementById('vid');
    $('#mdl').on('hidden.bs.modal', function () {
        video.pause();
    });
});

function video(){
    var video = document.getElementById('vid');
    $('#mdl').modal();
    video.currentTime = 0;
    video.play();
}

</script>

<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>

</body>
</html>
