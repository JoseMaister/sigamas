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

        <!-- PNotify -->
        <link href=<?= base_url("template/vendors/pnotify/dist/pnotify.css"); ?> rel="stylesheet">
        <link href=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.css"); ?> rel="stylesheet">
        <link href=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.css"); ?> rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href=<?= base_url("template/build/css/custom.css"); ?> rel="stylesheet">

    </head>
<body style="background: #f7f7f7;">
<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel">
                  <div class="x_title">
                      <h2>Reloj Checador <small id="reloj"></small></h2>
                      <a style="float: right;" id="btnReloj" href="<?= base_url('inicio') ?>" style="background: transparent;" class="btn btn-default"><i class="fa fa-home"></i> Inicio</a>
                      <div class="clearfix"></div>
                  </div>
                  <div style="border: 2px solid;" class="x_content">
                  <center id="divFoto">
                    <img width="90%" src="<?= base_url('template/images/logo.png') ?>"></img>
                    <div id="camera"></div>
                    <div id="forma">
                        <div class="col-md-offset-3 col-md-6">
                        <h3>No. de Empleado</h3>
                        <input id="id_usuario" name="id_usuario" type="hidden">
                        <input id="tipo" name="tipo" type="hidden">
                        <input maxlength="120" style="text-transform: uppercase;" id="no_empleado" class="form-control col-md-7 col-xs-12" name="no_empleado" type="text">
                        </div>
                        <button id="btnChecar" onclick="registrarEntrada();" style="margin-top: 10px;" type="button" class="btn btn-primary btn-lg"><i class="fa fa-sign-in"></i> Checar Entrada </button>
                    </div>
                    <div style='display: none;' id="infoUsuario">
                        <h1 id='nombre'></h1>
                        <h1 id='conteo'></h1>
                    </div>
                  </center>
                  </div>
              </div>
          </div>

          <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2 id="fecha"></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <div class="table-responsive">
                    <table id="tabla" class="table table-striped">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">#</th>
                                <th class="column-title">Foto</th>
                                <th class="column-title">Nombre</th>
                                <th class="column-title">Tipo</th>
                                <th class="column-title">Hora</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        if(FALSE) {
                            foreach ($empresas->result() as $elem) { ?>

                                <tr class="even pointer">
                                    <td><a href="<?= base_url('empresas/ver/'.$elem->id) ?>"><img src=<?= base_url('data/empresas/fotos/'.$elem->foto); ?> class="avatar" alt="Avatar"></a></td>
                                    <td><?= $elem->nombre ?></td>
                                    <td><?= $elem->razon_social ?></td>
                                </tr>
                        <?php }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
          </div>
        </div>
        
    </div>
</div>
<!-- /page content -->


        <!-- MODAL -->
        <div id="modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Reloj Checador</h4>
              </div>
              <div class="modal-body">
              <form>
                <center>
                    <button onclick="descanso();" type="button" class="btn btn-warning btn-lg" data-dismiss="modal"><i class="fa fa-clock-o"></i> Descanso</button>
                    <button onclick="salida();" type="button" class="btn btn-danger btn-lg" data-dismiss="modal"><i class="fa fa-sign-out"></i> Salida</button>
                </center>
              </form>
              </div>

            </div>
          </div>
        </div>
        <!-- /MODAL -->





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
<script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
<!-- Say Cheese -->
<script src=<?= base_url("template/vendors/say-cheese/say-cheese.js"); ?>></script>
<!-- Bootstrap -->
<script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js"); ?>></script>
<!-- Moment -->
<script src=<?=base_url("template/vendors/moment/min/moment.min.js"); ?>></script>
<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>

<script>
var camara = false;
var usuario = "<?= $usuario ?>";
var idusuario = "<?= $idusuario ?>";
var sayCheese;
var dias = new Array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
var meses = new Array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');


$("#no_empleado").on('keyup', function (e) {
    if (e.keyCode == 13) {
        registrarEntrada();
    }
});

$(function() {

    var fecha = new Date();
    var year = fecha.getFullYear();
    var month = fecha.getMonth();
    var day = fecha.getDay();
    var date = fecha.getDate();


    $("#fecha").html(dias[day] + ' ' + date + ' de ' + meses[month] + ' ' + year);

    setInterval(function(){
        var hora = new Date();
        $("#reloj").html(moment(hora).format("hh:mm:ss A"));
    }, 1000);

    if(idusuario != "0")
    {
        getChecadas(idusuario);
    }

    
});

function getChecadas(usuario){
    $.ajax({
        type: "POST",
        url: '<?= base_url('reloj_checador/checadas_ajax') ?>',
        data: { 'idusuario' : idusuario },
        success: function(result){
            if(result){
                res = JSON.parse(result);
                var tab = $('#tabla')[0];
                $.each(res, function(i, elem) {
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell(0).innerHTML = tab.rows.length - 1;
                    ren.insertCell(1).innerHTML = '<img src="' + elem.foto + '" width="100" class="usuario"/>';
                    ren.insertCell(2).innerHTML = elem.User;
                    ren.insertCell(3).innerHTML = elem.tipo;
                    ren.insertCell(4).innerHTML = moment(elem.hora).format('MM/DD/YYYY hh:mm A');
                });
            } 
        },
    });
}

$(function() {

  sayCheese = new SayCheese('#camera', { width: 500 });
  sayCheese.on('start', function() {
    //this.takeSnapshot();
    $('video').css('width','95%');
    camara = true;
    if(usuario != "0")
    {
        alert('Se tomará su registro de ENTRADA');
        $('#no_empleado').val(usuario);
        registrarEntrada();
    }
  });

  sayCheese.on('error', function() {
    camara = false;
    if(usuario != "0")
    {
        alert('Se tomará su registro de ENTRADA');
        $('#no_empleado').val(usuario);
        registrarEntrada();
    }
  });

  sayCheese.on('snapshot', function(snapshot) {
    FOTO = document.createElement('img');
    FOTO.src = snapshot.toDataURL('image/png');
  });

  sayCheese.start();
});

var tipoActual;
function registrarEntrada(){
    var no_empleado = $('#no_empleado').val();

    $.ajax({
        type: "POST",
        url: '<?= base_url('reloj_checador/comprobar_usuario_ajax') ?>',
        data: { 'no_empleado' : no_empleado },
        success: function(result){
        if(result){
            var res = JSON.parse(result);
            $('#nombre').html(res.UserShort);
            $('#id_usuario').val(res.id);
            tipoActual = res.tipo;
            if(res.tipo == "N/A")
            {
                checar('ENTRADA');
            }
            if(res.tipo == "ENTRADA")
            {
                $('#modal').modal();
            }
            if(res.tipo == "DESAYUNO" | res.tipo == "COMIDA")
            {
                checar('REGRESO ' + res.tipo);
            }
            if (res.tipo.startsWith("REGRESO")) 
            {
                if(res.tipo == "REGRESO DESAYUNO"){
                    $('#modal').modal();
                } else {
                    checar('SALIDA');
                }
            }
            if(res.tipo == "SALIDA")
            {
                new PNotify({ title: 'Reloj Checado', text: 'JORNADA COMPLETA', type: 'warning', styling: 'bootstrap3' });
            }
        } else {
            new PNotify({ title: 'Usuario', text: 'No Existe Usuario', type: 'error', styling: 'bootstrap3' });
        }
        },
        error: function(data){
        new PNotify({ title: 'ERROR', text: 'Error al agregar Contacto', type: 'error', styling: 'bootstrap3' });
        console.log(data);
        },
    });
}

function checar(tipo){
    $('#tipo').val(tipo);
    $('#forma').fadeOut('slow', function(){
        $('#infoUsuario').fadeIn('slow');
        conteo();
    });
}

function descanso(){
    var d = new Date();
    var n = d.getHours();
    if(tipoActual == 'ENTRADA' && n < 12)
    {
        checar('DESAYUNO');
    } else {
        checar('COMIDA');
    }
}

function salida(){
    checar('SALIDA');
}


function conteo() {
    var cuenta = 2;
    $('#conteo').html('foto en... 3');
    var intervalo = setInterval(function(){ 
        if(cuenta != 0){
            $('#conteo').html('foto en... ' + cuenta);
        }else{
            $('#conteo').html('¡Sonrie!');
        }
        cuenta--;
        if(cuenta == -1){
            clearInterval(intervalo);
            subirFoto();
            $('#infoUsuario').fadeOut('slow',function(){
                $('#no_empleado').val('');
                $('#forma').fadeIn('slow');
            });
        }
    }, 1000);
}

function subirFoto(){
    var width = 320, height = 240;

    var src = "";
    if(camara)
    {
        sayCheese.takeSnapshot(width, height);
        src = FOTO.src;
    }

    var usuario = $('#id_usuario').val();
    var tipo = $('#tipo').val();

    $.ajax({
        type: "POST",
        url: '<?= base_url('reloj_checador/checar_ajax') ?>',
        data: { 'src' : src , 'usuario' : usuario, 'tipo' : tipo },
        success: function(result){
        if(result){
            res = JSON.parse(result);
            var tab = $('#tabla')[0]; var ren = tab.insertRow(tab.rows.length);
            ren.insertCell(0).innerHTML = tab.rows.length - 1;
            ren.insertCell(1).innerHTML = '<img src="' + res.foto + '" width="100" class="usuario"/>';
            ren.insertCell(2).innerHTML = $('#nombre').html();
            ren.insertCell(3).innerHTML = res.tipo;
            ren.insertCell(4).innerHTML = moment(res.hora).format('MM/DD/YYYY hh:mm A');
            new PNotify({ title: 'Se ha registrado ', text: 'Se ha agregado Contacto con Éxito', type: 'success', styling: 'bootstrap3' });
            if(usuario != "0")
            {
                console.log(usuario);
                //setTimeout(inicio, 2000);
            }
        } else {
            new PNotify({ title: 'ERROR', text: 'Error al agregar Contacto', type: 'error', styling: 'bootstrap3' });
        }
        },
        error: function(data){
        new PNotify({ title: 'ERROR', text: 'Error al agregar Contacto', type: 'error', styling: 'bootstrap3' });
        console.log(data);
        },
    });
}

function inicio()
{
    window.location.href = "<?= base_url('inicio') ?>";
}



</script>





</body>
</html>
