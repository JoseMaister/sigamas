<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="row x_title">
                        <div class="col-md-6">
                            <h3>Reporte de Tickets IT</h3>
                        </div>
                        <div class="col-md-6">
                            <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                <span id="fecha"></span> <b class="caret"></b>
                            </div>
                        </div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div id="pnlUsuarios" style="display: none;" class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel tile fixed_height_320 overflow_hidden">
                                    <div class="x_title">
                                    <h2>Usuarios</h2>
                                    <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                    <table class="" style="width:100%">
                                        <tr>
                                        <th style="width:40%;">
                                            <center><p>Usuarios: Top 5</p></center>
                                        </th>
                                        <th>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <center><p class="">Usuario</p></center>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <center><p class="">Tickets</p></center>
                                            </div>
                                        </th>
                                        </tr>
                                        <tr>
                                        <td>
                                            <center><canvas id="graUsuarios" height="180" width="180" style="margin: 15px; overflow:auto;"></canvas></center>
                                        </td>
                                        <td>
                                            <table id="tablaUsuarios" class="tile_info">
                                            </table>
                                        </td>
                                        </tr>
                                    </table>
                                    </div>
                                </div>
                            </div>

                            <div id="pnlTipo" style="display: none;" class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel tile fixed_height_320 overflow_hidden">
                                    <div class="x_title">
                                    <h2>Tipo</h2>
                                    <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                    <table class="" style="width:100%">
                                        <tr>
                                        <th style="width:40%;">
                                            <center><p></p></center>
                                        </th>
                                        <th>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <center><p class="">Tipo</p></center>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <center><p class="">Tickets</p></center>
                                            </div>
                                        </th>
                                        </tr>
                                        <tr>
                                        <td>
                                            <center><canvas id="graTipo" height="180" width="180" style="margin: 15px; overflow:auto;"></canvas></center>
                                        </td>
                                        <td>
                                            <table id="tablaTipo" class="tile_info">
                                            </table>
                                        </td>
                                        </tr>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TABLA -->
                        <div class="row">
                        <div class="table-responsive">
                            <table id="tblTickets" class="table table-striped">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">ID</th>
                                        <th class="column-title">Fecha de Creación</th>
                                        <th class="column-title">Usuario</th>
                                        <th class="column-title">Tipo</th>
                                        <th class="column-title">Titulo</th>
                                        <th class="column-title">Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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
<script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
<!-- Bootstrap -->
<script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js"); ?>></script>
<!-- Moment -->
<script src=<?=base_url("template/vendors/moment/min/moment.min.js"); ?>></script>
<!-- DateJS -->
<script src=<?=base_url("template/vendors/bootstrap-daterangepicker/daterangepicker.js") ?>></script>
<!-- Chart.js -->
<script src=<?= base_url("template/vendors/Chart.js/dist/Chart.min.js") ?>></script>
<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>

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

var fechaIni; var fechaFin;
var colores = [ "#3498DB","#26B99A","#9B59B6","#BDC3C7","#E74C3C"];
var colorSquare = [ "blue","green","purple","aero","red"];

$(function(){
    fechaIni = moment().subtract(6, 'days').format('YYYY-MM-DD 00:00:00');
    fechaFin = moment().format('YYYY-MM-DD 23:59:59');
    cargar();

    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        fechaIni = picker.startDate.format('YYYY-MM-DD 00:00:00');
        fechaFin = picker.endDate.format('YYYY-MM-DD 23:59:59');
        cargar();        
    });
});

function cargar()
{
    cargarUsuarios();
    cargarTipo();
    cargarTickets();
}

//FUNCIONES//

function cargarUsuarios(){
    var datos = []; var nombres = [];
    $.ajax({
            url: '<?= base_url('tickets_it/reporte_usuarios_ajax'); ?>',
            method: 'POST',
            data: { inicio : fechaIni, final : fechaFin },
            success: function(resultado){
                var table = $('#tablaUsuarios')[0];
                $(table).find('tr').remove();
                $("#pnlUsuarios").fadeOut('slow');

                if(resultado) {
                    $("#pnlUsuarios").fadeIn('slow');
                    var res = JSON.parse(resultado);
                    $.each(res, function(i, elem)
                    {
                        datos = datos.concat(elem.conteo);
                        nombres = nombres.concat(elem.User);

                        var ren = table.insertRow(table.rows.length);
                        ren.insertCell(0).innerHTML = '<p><i class="fa fa-square ' + colorSquare[i] + '"></i>' + elem.User + '</p>';
                        ren.insertCell(1).innerHTML = elem.conteo;
                    });
                    graUsuarios(datos, nombres);                
                }
            },

            error: function(err){
                console.log(err);
            }
        });
}

function graUsuarios(datos, nombres){

    if ($('#graUsuarios').length){

        var chart_doughnut_settings = {
            type: 'doughnut',
            data: {
                labels: nombres,
                datasets: [{
                    data: datos,
                    backgroundColor: colores,
                }]
            },
            options: {
                legend: false,
                responsive: false
            }
        }

        $('#graUsuarios').each(function(){

            var chart_element = $(this);
            var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);

        });

    }

}

function cargarTipo(){
    var datos = []; var nombres = [];
    $.ajax({
            url: '<?= base_url('tickets_it/reporte_tipo_ajax'); ?>',
            method: 'POST',
            data: { inicio : fechaIni, final : fechaFin },
            success: function(resultado){
                $("#pnlTipo").fadeOut('slow');
                var table = $('#tablaTipo')[0];
                $(table).find('tr').remove();
                if(resultado) {
                    $("#pnlTipo").fadeIn('slow');
                    var res = JSON.parse(resultado);
                    $.each(res, function(i, elem)
                    {
                        datos = datos.concat(elem.conteo);
                        nombres = nombres.concat(elem.tipo);
                        
                        var ren = table.insertRow(table.rows.length);
                        ren.insertCell(0).innerHTML = '<p><i class="fa fa-square ' + colorSquare[i] + '"></i>' + elem.tipo + '</p>';
                        ren.insertCell(1).innerHTML = elem.conteo;
                        /*
                        table.rows[i].cells[0].children[0].append(elem.tipo);
                        table.rows[i].cells[1].innerHTML = elem.conteo;*/
                    });
                    graTipo(datos, nombres);                
                }
            },

            error: function(err){
                console.log(err);
            }
        });
}

function graTipo(datos, nombres){

    if ($('#graTipo').length){

        var chart_doughnut_settings = {
            type: 'doughnut',
            data: {
                labels: nombres,
                datasets: [{
                    data: datos,
                    backgroundColor: [
                        "#3498DB",
                        "#26B99A",
                    ],
                }]
            },
            options: {
                legend: false,
                responsive: false
            }
        }

        $('#graTipo').each(function(){

            var chart_element = $(this);
            var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);

        });

    }

}

function cargarTickets(){
    $.ajax({
            url: '<?= base_url('tickets_it/reporte_tickets_ajax'); ?>',
            method: 'POST',
            data: { inicio : fechaIni, final : fechaFin },
            success: function(resultado){
                var table = $('#tblTickets')[0];
                $(table).find('tr:not(:first)').remove();
                if(resultado) {
                    var res = JSON.parse(resultado);
                    $.each(res, function(i, elem)
                    {
                        var BTN_CLASS = "btn btn-default";
                        switch (elem.estatus) 
                        {
                            case 'ABIERTO':
                                BTN_CLASS = 'btn btn-primary';
                                break;

                            case 'EN CURSO':
                                BTN_CLASS = 'btn btn-info';
                                break;

                            case 'DETENIDO':
                                BTN_CLASS = 'btn btn-warning';
                                break;

                            case 'CANCELADO':
                                BTN_CLASS = 'btn btn-default';
                                break;

                            case 'SOLUCIONADO':
                                BTN_CLASS = 'btn btn-success';
                                break;

                            case 'CERRADO':
                                BTN_CLASS = 'btn btn-dark';
                                break;
                        }
                        var ren = table.insertRow(table.rows.length);
                        ren.insertCell(0).innerHTML = "IT" + elem.id.padStart(6, '0');
                        ren.insertCell(1).innerHTML = moment(elem.fecha).format('MM/DD/YYYY hh:mm A');
                        ren.insertCell(2).innerHTML = elem.User;
                        ren.insertCell(3).innerHTML = elem.tipo;
                        ren.insertCell(4).innerHTML = elem.titulo;
                        ren.insertCell(5).innerHTML = '<a target="_blank" href="<?= base_url("tickets_IT/ver/") ?>' + elem.id + '"><button type="button" class="' + BTN_CLASS + '">' + elem.estatus + '</button></a>';
                    });           
                }
            },

            error: function(err){
                console.log(err);
            }
        });

        //var fecha = $('#fecha').html();
        //alert(fecha);
}




</script>
</body>
</html>
