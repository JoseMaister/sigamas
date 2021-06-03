<!-- page content -->
<div class="right_col" role="main">
    <div class="">

      <div class="clearfix"></div>


      <div class="row">
          <div class="col-md-3 col-sm-3 col-xs-12">
              <div class="x_panel">
                  <div class="x_title">
                      <h2>Automóvil</h2>
                      <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                      </ul>
                      <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div style="text-align: center; overflow: hidden; margin: 10px;">
                      <img width="100%" src="<?= 'data:image/bmp;base64,' . base64_encode($auto_foto); ?>">
                    </div>

                    <div>
                      <ul class="list-inline widget_tally">
                        <li>
                          <p>
                            <span style="width: 50%; float: left; text-align: left" >Marca:</span>
                            <span style="width: 50%; float: left; text-align: left;"><?= $auto_marca ?></span>
                          </p>
                        </li>
                        <li>
                          <p>
                            <span style="width: 50%; float: left; text-align: left" >Combustible:</span>
                            <span style="width: 50%; float: left; text-align: left;"><?= $auto_combustible ?></span>
                          </p>
                        </li>
                        <li>
                          <p>
                            <span style="width: 50%; float: left; text-align: left" >Placas:</span>
                            <span style="width: 50%; float: left; text-align: left;"><?= $auto_placas ?></span>
                          </p>
                        </li>
                      </ul>
                    </div>

                  </div>
              </div>
          </div>

          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Ticket # <?= substr($controlador, 8) . str_pad($ticket->id, 6, "0", STR_PAD_LEFT) ?> <small><?= $ticket->User ?></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <ul class="list-unstyled timeline">
                        <li>
                            <div class="block">
                                <div class="tags">
                                    <a href="" class="tag">
                                        <span><?= $ticket->tipo ?></span>
                                    </a>
                                </div>
                                <div class="block_content">
                                    <h2 class="title"><a><?= $ticket->titulo ?></a></h2>
                                    <div class="byline">
                                        <?php $date = date_create($ticket->fecha); ?>
                                        <span><?= date_format($date, 'd/m/Y h:i A') ?></span>
                                    </div>
                                    <p class="excerpt"><?= $ticket->descripcion ?></p>
                                    <br>
                                    <?php
                                    if ($ticket->Cierre != "0") {
                                        echo '<p> Solucionado por: ' . $ticket->Cierre . ' @ ' . date_format(date_create($ticket->fecha_cierre), 'd/m/Y h:i A') . '</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </li>

                    </ul>

                    <?php
                    $BTN_CLASS = 'btn btn-default';
                    switch ($ticket->estatus) {

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

                    <div class="btn-group">
                        <a href="<?= base_url($controlador.'/archivos/'.$ticket->id) ?>" class='<?= $BTN_CLASS ?>' type="button"><i class="fa fa-paperclip"></i> ARCHIVOS</a>
                        <button data-toggle="dropdown" class='<?= $BTN_CLASS . " dropdown-toggle" ?>' type="button"><?= $ticket->estatus ?> <span class="caret"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <?php
                            if ($ticket->Cierre == "0" && $this->session->privilegios[strtolower($controlador) . '_soporte']) {

                                switch ($ticket->estatus) {

                                    case 'ABIERTO':
                                        echo "<li><a href='" . base_url() . $controlador . "/estatus/" . $ticket->id . "/2'>En Curso</a></li>";
                                        echo "<li><a href='" . base_url() . $controlador . "/estatus/" . $ticket->id . "/3'>Detenido</a></li>";
                                        echo "<li class='divider'></li>";
                                        if($ticket->tipo == 'MANTENIMIENTO')
                                        {
                                          echo '<li><a data-toggle="modal" data-target=".bs-example-modal-sm-mtto">Solucionado</a></li>';
                                        }else
                                        {
                                          echo "<li><a href='" . base_url() . $controlador . "/estatus/" . $ticket->id . "/5'>Solucionado</a></li>";
                                        }
                                        break;

                                    case 'EN CURSO':
                                        echo "<li><a href='" . base_url() . $controlador . "/estatus/" . $ticket->id . "/3'>Detenido</a></li>";
                                        echo "<li class='divider'></li>";
                                        if($ticket->tipo == 'MANTENIMIENTO')
                                        {
                                          echo '<li><a data-toggle="modal" data-target=".bs-example-modal-sm-mtto">Solucionado</a></li>';
                                        }else
                                        {
                                          echo "<li><a href='" . base_url() . $controlador . "/estatus/" . $ticket->id . "/5'>Solucionado</a></li>";
                                        }
                                        break;

                                    case 'DETENIDO':
                                        echo "<li><a href='" . base_url() . $controlador . "/estatus/" . $ticket->id . "/2'>En Curso</a></li>";
                                        echo "<li class='divider'></li>";
                                        if($ticket->tipo == 'MANTENIMIENTO')
                                        {
                                          echo '<li><a data-toggle="modal" data-target=".bs-example-modal-sm-mtto">Solucionado</a></li>';
                                        }else
                                        {
                                          echo "<li><a href='" . base_url() . $controlador . "/estatus/" . $ticket->id . "/5'>Solucionado</a></li>";
                                        }
                                        break;

                                    case 'SOLUCIONADO':
                                        break;

                                    case 'CERRADO':
                                        break;
                                }
                            }
                            if ($ticket->usuario == $this->session->id) {
                                if ($ticket->estatus != "CANCELADO" && $ticket->estatus != "CERRADO") {
                                    echo "<li class='divider'></li>";
                                    if ($ticket->Cierre == "0") {
                                        echo "<li><a href='" . base_url() . $controlador . "/estatus/" . $ticket->id . "/4'>Cancelado</a></li>";
                                    }
                                    if ($ticket->Cierre != "0") {
                                        echo "<li><a onclick='mdlCerrar()' >Cerrar</a></li>";
                                    }
                                }
                            }
                            ?>

                        </ul>

                    </div>

                    <?php if($ticket->calificacion > 0) { ?>
                    <div class="calificacion pull-right">
                        <h2>
                            <i class='<?= $ticket->calificacion < 1 ? 'fa fa-star-o' : 'fa fa-star'?>'></i>
                            <i class='<?= $ticket->calificacion < 2 ? 'fa fa-star-o' : 'fa fa-star'?>'></i>
                            <i class='<?= $ticket->calificacion < 3 ? 'fa fa-star-o' : 'fa fa-star'?>'></i>
                            <i class='<?= $ticket->calificacion < 4 ? 'fa fa-star-o' : 'fa fa-star'?>'></i>
                            <i class='<?= $ticket->calificacion < 5 ? 'fa fa-star-o' : 'fa fa-star'?>'></i>
                        </h2>
                    </div>
                    <?php } ?>
                </div>
            </div>
          </div>


        </div>

        </div>

        <?php
          $hayArchivos = FALSE; $hayFotos = FALSE;
          if($archivos)
          {
            foreach ($archivos->Result() as $file) {
              if($this->aos_funciones->is_image($file->nombre))
              {
                $hayFotos = TRUE;
              }else {
                $hayArchivos = TRUE;
              }
            }
          }
         ?>


        <!-- INICIA SECCION DE ARCHIVOS -->
        <?php if ($hayArchivos) { ?>
          <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Archivos</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                      <?php
                          foreach ($archivos->Result() as $file) {
                            if(!$this->aos_funciones->is_image($file->nombre))
                            {?>
                              <div class="col-lg-1 col-md-2 col-sm-2 col-xs-3">
                                <a href="<?= base_url('descargas/'.$controlador.'/' . $file->id) ?>">
                                  <img style="width: 80%; margin-bottom: 10px;" title="<?= $file->nombre ?>" src="<?= $this->aos_funciones->file_image($file->nombre) ?>" />
                                  <p style="height: 41px; text-overflow: ellipsis; overflow: hidden;"><?= $file->nombre ?></p>
                                </a>
                              </div>
                            <?php }
                          }
                       ?>


                    </div>
                </div>
            </div>
            </div>
        <?php } ?>
        <!-- TERMINA SECCION DE ARCHIVOS -->




        <!-- INICIA GALERIA DE FOTOS -->
        <?php if ($hayFotos) { ?>
          <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Fotos</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row">
                            <div id="simple_gallery" class="box-content">
                                <?php foreach ($archivos->Result() as $pho) {
                                  if($this->aos_funciones->is_image($pho->nombre)) {?>
                                  <div class="col-md-55">
                                      <div class="image view view-first">
                                          <a id="single_image" href="<?= 'data:image/png;base64,' . base64_encode($pho->archivo) ?>">
                                              <img style="width: 100%; display: block;" src="<?= base_url($controlador . '/ver_foto/' . $pho->id) ?>" />
                                          </a>
                                      </div>
                                  </div>
                                <?php }
                              } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        <?php } ?>
        <!-- TERMINA GALERIA DE FOTOS -->







        <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Comentarios </h2>

                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <ul class="list-unstyled msg_list">
                        <button style="vertical-align: middle;" type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-comment"></i> Agregar Comentario</button>

                        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel2">Agregar Comentario</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action=<?= base_url($controlador . '/agregarComentario') ?>>
                                            <div class="item form-group">
                                                <div class="col-xs-12">
                                                    <input type="hidden" name="idticket" value=<?= $ticket->id ?>>
                                                    <textarea id="textarea" required="required" name="comentario" class="form-control col-xs-12"></textarea>
                                                </div>
                                            </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <input type="submit" class="btn btn-primary" value="Agregar">
                                    </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <?php
                        if ($comentarios) {
                            foreach ($comentarios->result() as $comm) {
                                ?>
                                <li>
                                    <a>
                                        <span class="image">

                                            <?php
                                            foreach ($comentarios_fotos->result() as $photo) {
                                                if ($comm->usuario == $photo->usuario) {
                                                    echo '<img style="width: 65px; height: 65px;" src="data:image/bmp;base64,' . base64_encode($photo->foto) . '" alt="img" />';
                                                    break;
                                                }
                                            }
                                            ?>

                                        </span>
                                        <span>
                                            <span><?= $comm->User ?>
                                                <?php $date2 = date_create($comm->fecha); ?>
                                                <small><?= date_format($date2, 'd/m/Y h:i A') ?></small>
                                            </span>
                                        </span>
                                        <span class="message">
                                            <?= $comm->comentario ?>
                                        </span>
                                    </a>
                                </li>

                                <?php
                            }
                        }
                        ?>


                    </ul>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Dialogo Mantenimiento -->
    <div class="modal fade bs-example-modal-sm-mtto" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <?php if($hayArchivos) { ?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Recibir Automóvil</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action=<?= base_url('tickets_AT/mtto_solucionado') ?>>
                        <div class="item form-group">
                            <div class="col-xs-12">
                              <label class="control-label col-xs-12" for="kilometraje">Kilometraje Actual</label>
                              <input id="kilometraje" onblur="comprobarKM()" type="number" required="required" name="kilometraje" class="form-control col-xs-12"/>
                              <?php $aumento = $auto_combustible == "DIESEL" ? 15000 : 10000;
                              $auto_mttoActual = $auto_mttoActual + $aumento; ?>
                              <label class="control-label col-xs-12" for="proxMtto">Prox. Mantenimiento</label>
                              <input id="proxMtto" onblur="comprobarProx()" type="number" required="required" name="proxMtto" value="<?= $auto_mttoActual ?>" class="form-control col-xs-12"/>
                              <input type="hidden" name="auto" value="<?= $auto_id ?>"/>
                              <input type="hidden" name="id_ticket" value="<?= $ticket->id ?>"/>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-primary" value="Aceptar">
                </div>
                </form>
            </div>
          <?php } else { ?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Adjuntar Archivo</h4>
                </div>
                <div class="modal-body">
                  <div style="height: 40px;" class="item form-group">
                      <div class="col-xs-12">
                        <p>
                            Es necesario adjuntar al menos un archivo para cerrar Ticket
                        </p>
                      </div>
                  </div>
                </div>
            </div>
          <?php } ?>
        </div>
    </div>

</div>
<!-- /page content -->

<div id="mdlCerrar" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Cerrar Ticket</h4>
            </div>
            <div class="modal-body">
                <form>
                    <Center>
                        <label>Califica el soporte recibido</label>
                        <h2 id='stars'>
                            <i data-rate=1 class='fa fa-star-o'></i>
                            <i data-rate=2 class='fa fa-star-o'></i>
                            <i data-rate=3 class='fa fa-star-o'></i>
                            <i data-rate=4 class='fa fa-star-o'></i>
                            <i data-rate=5 class='fa fa-star-o'></i>
                        </h2>
                        <label>Comentarios</label>
                        <textarea style="resize: none;" id="txtComentarioCerrar" required="required" class="form-control"></textarea>
                    </Center>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default btn-sm pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button id="btnCerrar" type="button" onclick="cerrarTicket(this)" value='<?= $ticket->id ?>' class="btn btn-dark btn-sm"><i class='fa fa-check'></i> Cerrar</button>
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
<!-- FancyBOX -->
<script src=<?= base_url("template/vendors/fancybox/dist/jquery.fancybox.min.js"); ?>></script>

<script>

var controlador = '<?= $controlador ?>';

  function comprobarKM()
  {
    var kmAnt = <?= $auto_kilometraje ?>;
    var inpKM = document.getElementById('kilometraje').value;

    if(inpKM < kmAnt && inpKM.length != 0)
    {
      alert('Kilometraje no puede ser menor a los ' + kmAnt.toLocaleString() + ' KM');
      document.getElementById('kilometraje').value = '';
    }
    else {
      comprobarProx();
    }
  }

  function comprobarProx()
  {
    var kmAnte = document.getElementById('kilometraje').value
    var inpKMe = document.getElementById('proxMtto').value;

    if(inpKMe < kmAnte && inpKMe.length != 0)
    {
      alert('Proximo mantenimiento no puede ser menor a los ' + kmAnte.toLocaleString() + ' KM');
      document.getElementById('proxMtto').value = '';
    }
  }

  $(document).ready(function () {

      /* This is basic - uses default settings */

      $("a#single_image").fancybox();

      /* Using custom settings */

      $("a#inline").fancybox({
          'hideOnContentClick': true
      });

      /* Apply fancybox to multiple items */

      $("a.group").fancybox({
          'transitionIn': 'elastic',
          'transitionOut': 'elastic',
          'speedIn': 600,
          'speedOut': 200,
          'overlayShow': false
      });

      $('#stars i').hover(function() {
        var i = $(this).data('rate');
        $('#stars i').attr('class', 'fa fa-star-o');
        $('#stars i').slice(0, i).attr('class', 'fa fa-star');
        $('#txtComentarioCerrar').attr('placeholder', i==5 ? '' : 'Comentarios necesarios');
    });

  });

  function mdlCerrar(){
    $('#stars i').attr('class', 'fa fa-star-o');
    $('#txtComentarioCerrar').attr('placeholder','');
    $('#mdlCerrar').modal();
}

function cerrarTicket(btn){
    var id = $(btn).val();
    var calificacion = $('#stars i.fa-star').length;
    var comentario = $('#txtComentarioCerrar').val().trim();
    var ph = $('#txtComentarioCerrar').attr('placeholder');
    if(calificacion <= 0)
    {
        alert('Por favor seleccione su calificación del servicio');
        return;
    }
    if(ph != "" && comentario == "")
    {
        alert('Es necesario ingresar comentarios del servicio');
        return;
    }


    var URL = base_url + controlador + '/ajax_cerrarTicket';
    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id, calificacion : calificacion, comentario : comentario },
        success: function(result)
        {
            $('#mdlCerrar').modal('hide');
            window.location.href = base_url + controlador + '/ver/' + id;
        },
        error: function(data){
            console.log(data);
        },
    });
}
</script>

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
</script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>

</body>
</html>
