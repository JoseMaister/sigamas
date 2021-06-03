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

            <div style="display: none;" id="divPosContruccion" class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>PO's en contrucción</h2>
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
                            <table id="tblPosContruccion" class="table table-striped">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">Fecha</th>
                                        <th class="column-title">Proveedor</th>
                                        <th class="column-title">Tipo</th>
                                        <th class="column-title">Moneda</th>
                                        <th class="column-title">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php if ($tickets) { ?>
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
                <?php } ?>

                <?php if ($prs) { ?>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>PR's Por Recibir</h2>
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
                                            <th class="column-title">Subtipo</th>
                                            <th class="column-title">Cant.</th>
                                            <th class="column-title">Descripción</th>
                                            <th class="column-title">Estatus</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    <?php

                                    $BTN_CLASS = 'btn btn-default';
                                    foreach ($prs->result() as $elem) {
                                        switch ($elem->estatus) {

                                            case 'POR RECIBIR':
                                                $BTN_CLASS = 'btn btn-warning';
                                                break;
                                        }
                                        ?>
                                            <tr class="even pointer">
                                                <td><?= $elem->id ?></td>
                                                <td>
                                                    <?php $date = date_create($elem->fecha); ?>
                                                    <a><?= date_format($date, 'd/m/Y h:i A'); ?></a>
                                                </td>
                                                <td><?= $elem->subtipo ?></td>
                                                <td><?= $elem->cantidad ?></td>
                                                <td><?= $elem->descripcion ?></td>
                                                <td><button onclick='mdlRecibir(this)' value='<?= $elem->id ?>' class='<?= $BTN_CLASS ?>'><?= $elem->estatus ?></button></td>
                                            </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                <?php } ?>
            
            </div>
            

            
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?php if ($qrs) { ?>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>QR's Pendientes</h2>
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
                                        <th class="column-title">Subtipo</th>
                                        <th class="column-title">Cant.</th>
                                        <th class="column-title">Descripción</th>
                                        <th class="column-title">Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>


                                <?php

                                  $BTN_CLASS = 'btn btn-default';
                                  foreach ($qrs->result() as $elem) {
                                      switch ($elem->estatus) {

                                          case 'RECHAZADO':
                                              $BTN_CLASS = 'btn btn-danger';
                                              break;
                                      }
                                      ?>
                                          <tr class="even pointer">
                                              <td><?= $elem->id ?></td>
                                              <td>
                                                  <?php $date = date_create($elem->fecha); ?>
                                                  <a><?= date_format($date, 'd/m/Y h:i A'); ?></a>
                                              </td>
                                              <td><?= $elem->subtipo ?></td>
                                              <td><?= $elem->cantidad ?></td>
                                              <td><?= $elem->descripcion ?></td>
                                              <td><a href=<?= base_url("compras/ver_qr/" . $elem->id) ?>><button type="button" class=<?= "'" . $BTN_CLASS . "'" ?> ><?= $elem->estatus ?></button></a></td>
                                          </tr>
                                      <?php
                                  }
                                ?>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            <?php } ?>

            <?php if ($facturas) { ?>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Facturas Pendientes</h2>
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
                                        <th class="column-title">Factura</th>
                                        <th class="column-title">Cliente</th>
                                        <th class="column-title">Estatus</th>
                                        <th class="column-title">Recorridos</th>
                                    </tr>
                                </thead>
                                <tbody>


                                <?php

                                  
                                  foreach ($facturas->result() as $elem) {
                                    $BTN_CLASS = "btn dropdown-toggle btn-sm ";
                                    $opcs = "<ul role='menu' class='dropdown-menu'>";
                                    $opcs .= "<li><a onclick=verSolicitud(this)><i class='fa fa-eye'></i> Ver</a></li>";
                                    
                                    $estatus = $elem->estatus == "ACEPTADO" ? $elem->estatus_factura : $elem->estatus;

                                    switch ($estatus) 
                                    {
                                        case "RECIBIDO EN LOGISTICA":
                                        case "DEJADA CON CLIENTE":
                                            $BTN_CLASS .= "btn-warning";
                                            break;
                                
                                        case "RECHAZADO":
                                            if(true)
                                            {
                                                $opcs .= "<li><a onclick=editarSolicitud(this)><i class='fa fa-pencil'></i> Editar</a></li>";
                                            }
                                        case "NO ENTREGADA":
                                        case "NO RECOLECTADA":
                                        case "RECHAZADO POR MENSAJERO":
                                        case "ENTREGA RECHAZADA":
                                        case "RECOLECTA RECHAZADA":
                                            $BTN_CLASS .= "btn-danger";
                                            break;
                                        
                                        case "ASIGNADO A MENSAJERO":
                                        case "ACEPTADO":
                                            $BTN_CLASS .= "btn-primary";
                                            break;
                                
                                        case "RETORNADA AUTORIZADA":        
                                            $BTN_CLASS .= "btn-success";
                                            break;
                                
                                        case "ENVIADA LOGISTICA":
                                        case "PENDIENTE RECORRIDO":
                                        case "PENDIENTE ENTREGA":
                                        case "PENDIENTE RECOLECTA":
                                        case "EN RECORRIDO":
                                            $BTN_CLASS .= "btn-warning";
                                            break;
                                    
                                      }
                                    
                                    $opcs .= "</ul></div>";
                                    $btn = "<div class='btn-group'><button type='button' data-toggle='dropdown' class='$BTN_CLASS'>$estatus  <span class='caret'></span></button>";
                                    $btn .= $opcs;
                                      ?>
                                          <tr class="even pointer" data-id="<?= $elem->id ?>">
                                              <td><?= $elem->folio == 0 ? 'N/A' : $elem->folio ?></td>
                                              <td><?= $elem->Cliente ?></td>
                                              <td><?= $btn ?></td>
                                              <td><?= $elem->Recorridos > 0 ? "<button type='button' onclick=verRecorridos(this) class='btn btn-primary btn-sm'><i class='fa fa-truck'></i> " . $elem->Recorridos . "</button>" : "N/A"; ?></td>
                                          </tr>
                                      <?php
                                  }
                                ?>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            <?php } ?>
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

<div id="mdlRecibir" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Recibir PR</h4>
            </div>
           
            <div class="modal-body">
                <form>
                    <table id="tblRecibir" class="table table-striped">
                        <thead>
                            <tr class="headings">
                                <th style='width: 8%;' class="column-title">PR #</th>
                                <th class="column-title">Tipo</th>
                                <th class="column-title">Subtipo</th>
                                <th class="column-title">Cantidad</th>
                                <th class="column-title">Descripción</th>
                                <th class="column-title">Recibir</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                </table>
                </form>
            </div>
            

        </div>
    </div>
</div>

<!-- FACTURAS PENDIENTES-->
<div id="mdlRecorridos" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Recorridos</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table id="tblRecorridos" class="table table-striped">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">Recorrido</th>
                                            <th class="column-title">Cliente</th>
                                            <th class="column-title">Acción</th>
                                            <th class="column-title">Estatus</th>
                                            <th class="column-title">Reporte de Recorrido</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div id="mdlReporte" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Reporte de Recorrido</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <label>Fecha:</label> <div id="lblRecorridoFecha" style="display: inline;"></div><br>
                            <label>Cliente:</label> <div id="lblCliente" style="display: inline;"></div><br>
                            <label>Contacto:</label> <div id="lblContacto" style="display: inline;"></div><br>
                            <label>Acción:</label> <div id="lblAccion" style="display: inline;"></div><br>
                            <label>Resultado:</label> <div id="lblResultado" style="display: inline;"></div><br><br>


                            <div id="divFirma">
                                <label>Firma:</label>
                                <center>
                                    <img id="imgFirma" style="width: 70%; border: solid;">
                                </center>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table id="tblFacturasReporte" class="table table-striped">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">#</th>
                                            <th class="column-title">Factura</th>
                                            <th class="column-title">Ejecutivo</th>
                                            <th class="column-title"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>                
                            </div>   
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <ul id='ulComments' class="list-unstyled msg_list">
                            <ul>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="display: none;">
                <button type="button" id="btnCancelar" class="btn btn-default pull-left" data-dismiss="modal"><i class='fa fa-close'></i> Cancelar</button>
                <button type="button" id="btn2" onclick="marcarComo(this)" value="NO ENTREGADO" class="btn btn-danger"><i class='fa fa-close'></i> No Entregado</button>
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
<!-- jquery.redirect -->
<script src=<?= base_url("template/vendors/jquery.redirect/jquery.redirect.js"); ?>></script>
<!-- CUSTOM JS FILE -->
<script src=<?=base_url("template/js/custom/funciones.js"); ?>></script>
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

    cargarPosContruccion();
});

function video(){
    var video = document.getElementById('vid');
    $('#mdl').modal();
    video.currentTime = 0;
    video.play();
}

function mdlRecibir(btn){
    var URL = base_url + 'compras/ajax_getPR';
    var idPR = $(btn).val();
    $('#tblRecibir tbody tr').remove();
    $.ajax({
        type: "POST",
        url: URL,
        data: { id: idPR },
        success: function (result) {
            if (result) 
            {
                tab = $('#tblRecibir tbody')[0];
                var rs = JSON.parse(result);
                var ren = tab.insertRow(tab.rows.length);
                ren.insertCell(0).innerHTML = rs.id;
                ren.insertCell(1).innerHTML = rs.tipo;
                ren.insertCell(2).innerHTML = rs.subtipo;
                ren.insertCell(3).innerHTML = rs.cantidad;
                ren.insertCell(4).innerHTML = rs.descripcion;
                ren.insertCell(5).innerHTML = "<button type='button' class='btn btn-primary' onclick='recibirPR(this)' value='" + rs.id + "'><i class='fa fa-check'></i> Recibir</button>";
                $('#mdlRecibir').modal();
            }
        }
    });
}

function recibirPR(btn){
    var URL = base_url + 'compras/ajax_setEstatusPR';
    var idPR = $(btn).val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { id: idPR, estatus : 'CERRADO' },
        success: function (result) {
            if (result) 
            {
                $('#mdlRecibir').modal('hide');
                window.location.href = "<?= base_url('inicio') ?>";
            }
        }
    });
}

//FACTURAS PENDIENTES
function verRecorridos(btn){
    var URL = base_url + "logistica/ajax_getRecorridos";
    $('#tblRecorridos tbody tr').remove();
    
    var ren = $(btn).closest('tr');
    var id = $(ren).data('id');

    var data = {};
    data.factura = id;

    $.ajax({
        type: "POST",
        url: URL,
        data: data,
        success: function(result) {
            if(result)
            {
                var tab = $('#tblRecorridos tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id = elem.id;

                    var accion = elem.accion;
                    if(accion == "ENTREGA")
                    {
                        accion += " <font color='green'><i class='fa fa-arrow-right'></i></font>";
                    }
                    else if(accion == "RECOLECTA")
                    {
                        accion += " <font color='red'><i class='fa fa-arrow-left'></i></font>";
                    }

                    ren.insertCell().innerHTML = paddy(elem.recorrido, 3);
                    ren.insertCell().innerHTML = elem.Cliente;
                    ren.insertCell().innerHTML = accion;
                    var c = elem.estatus.startsWith("EN RECORRIDO") ? 'btn-warning' : ((elem.estatus.startsWith("NO") || elem.estatus.startsWith("RECHAZAD")) ? 'btn-danger' : 'btn-success');
                    ren.insertCell().innerHTML = '<button type="button" class="btn ' + c + ' btn-sm">' + elem.estatus + '</button>';
                    ren.insertCell().innerHTML = elem.Reporte != "N/A" ? '<button type="button" onclick=verReporte(this) value="' + elem.Reporte + '" class="btn btn-primary"><i class="fa fa-file-text-o"></i> Reporte</button>' : 'N/A';

                    
                });
                $('#mdlRecorridos').modal();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function verReporte(btn){

    










    var idReporte = $(btn).val();
    var URL = base_url + "logistica/ajax_getReporte";
    
    $('#tblFacturasReporte tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : idReporte},
        success: function(result) {
            if(result)
            {
                var fecha;
                var cliente;
                var contacto;
                var accion;
                var resultado;
                var firma;

                var tab = $('#tblFacturasReporte tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);

                    ren.insertCell().innerHTML = tab.rows.length;
                    ren.insertCell().innerHTML = elem.folio;
                    ren.insertCell().innerHTML = elem.Requisitor;
                    ren.insertCell().innerHTML = elem.discrepancia == "1" ? "(Discrepancia)" : "";

                    fecha = moment(elem.fecha).format('D/MM/YYYY h:mm A');
                    cliente = elem.Cliente;
                    contacto = elem.Contacto;
                    accion = elem.accion;
                    resultado = elem.resultado;
                    firma = elem.firma;
                    
                });

                $('#lblRecorridoFecha').text(fecha);
                $('#lblCliente').text(cliente);
                $('#lblContacto').text(contacto);
                $('#lblAccion').text(accion);
                var c = resultado.startsWith("NO") ? 'red' : 'green';
                $('#lblResultado').html('<font color="' + c + '"><b>' + resultado + '</b></font>');

                (firma == 1) ? $('#divFirma').show() : $('#divFirma').hide();

                $('#imgFirma').attr('src', base_url + 'data/logistica/firmas/' + idReporte + '.jpg');


                $('#mdlReporte').modal();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

    cargarComentarios(idReporte);
}

function cargarComentarios(id){
    var URL = base_url + "logistica/ajax_getComentariosRecorrido";

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            $('#ulComments').html("");
            if(result)
            {
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var c = '<li>'
                    +    '<a>'
                    +        '<span class="image">'
                    +            '<img style="width: 65px; height: 65px;" class="avatar" src="' + base_url + 'usuarios/photo/' + elem.usuario + '" alt="img" />'
                    +        '</span>'
                    +        '<span>'
                    +            '<small>' + elem.User + '<small> ' + moment(elem.fecha).format('D/MM/YYYY h:mm A') + '</small></span>'
                    +        '</span>'
                    +        '<span class="message">' + elem.comentario + '</span>'
                    +    '</a>'
                    +'</li>';
                    $('#ulComments').append(c);
                });

                $('#mdlComentarios').modal();
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

//FACUTURAS
function verSolicitud(btn){
    var ren = $(btn).closest('tr');
    var id = $(ren).data('id');

    $.redirect( base_url + "facturas/ver_solicitud", { 'id': id });
}

function editarSolicitud(btn){
    var ren = $(btn).closest('tr');
    var id = $(ren).data('id');

    $.redirect( base_url + "facturas/editar_solicitud", { 'id': id });
}



//PO'S EN CONTRUCCION
function cargarPosContruccion(){
    var URL = base_url + "ordenes_compra/ajax_getPosContruccion";
    $('#tblPosContruccion tbody tr').remove();
    
    $.ajax({
        type: "POST",
        url: URL,
        success: function(result) {
            if(result)
            {
                var tab = $('#tblPosContruccion tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = moment(elem.fecha).format('YYYY-MM-DD h:mm A');
                    ren.insertCell().innerHTML = elem.Proveedor;
                    ren.insertCell().innerHTML = elem.tipo;
                    ren.insertCell().innerHTML = elem.moneda;
                    ren.insertCell().innerHTML = '<a href="' + base_url + 'ordenes_compra/construccion_po/' + elem.idtemp + '" class="btn btn-warning"><i class="fa fa-shopping-cart"></i> Continuar</button>';
                });
                $('#divPosContruccion').show();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR al cargar PO\'s en contrucción', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

</script>

<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>

</body>
</html>
