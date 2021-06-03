<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Requisitos de Empresas</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                        <button onclick="agregar()" type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Agregar Requisito </button>
                            <div class="table-responsive">
                                <table id="tabla" class="table table-striped">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">#</th>
                                            <th class="column-title">Requisito</th>
                                            <th class="column-title">Tipo</th>
                                            <th class="column-title">Aplica detalles</th>
                                            <th class="column-title">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    if($requisitos) { $i = 1;
                                     foreach ($requisitos->result() as $elem) { ?>

                                            <tr class="even pointer">
                                                <td><?= $i ?></td>
                                                <td><?= $elem->requisito ?></td>
                                                <td><?= $elem->tipo ?></td>
                                                <td><?= $elem->detalle == "1" ? "SI" : "NO" ?></td>
                                                <td>
                                                <button type="button" onclick="prepareEdit(this)" class="btn btn-warning btn-xs" value="<?= $elem->id ?>"><i class="fa fa-pencil"></i> Editar </button><button type="button" class="btn btn-danger btn-xs" onclick="eliminarRequisito(this)" value="<?= $elem->id ?>"><i class="fa fa-trash"></i> Eliminar </button>
                                                </td>
                                            </tr>
                                    <?php $i++; }
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
</div>


<div id="modal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Requisito</h4>
        </div>
        <form id="formContacto" class="form-horizontal form-label-left">
        <div class="modal-body">
        <input type="hidden" id="id" name="id"/>
        <input type="hidden" id="ren" name="ren"/>
        <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Requisito</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input maxlength="150" style="text-transform: uppercase;" id="requisito" class="form-control col-md-7 col-xs-12" name="requisito" placeholder="" required="required" type="text">
        </div>
        </div>
        
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tipo">Tipo</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select required="required" class="select2_single form-control" id="tipo" name="tipo">
                    <option value="FACTURACION">FACTURACIÓN</option>
                    <option value="LOGISTICA/OPERACIONES">LOGÍSTICA Y OPERACIONES</option>
                </select>
            </div>
        </div>

        <br>
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <p>
                    Aplica detalle
                    <input type="checkbox" class="flat" id="detalle" name="detalle" value="1" />
                    (Es necesario especificaciones del requisito)
                </p>
            </div>
        </div>


        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="btnModalAgregar" onclick="registrar()" type="button" class="btn btn-primary" data-dismiss="modal">Agregar</button>
        <button id="btnModalEditar" onclick="editar()" type="button" class="btn btn-warning" data-dismiss="modal">Editar</button>
        </div>
        </form>
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
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
<!-- icheck -->
<script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<script>

function limpiar(){
    $('#requisito').val('');
    $('#detalle').iCheck('uncheck');
    $('#btnModalAgregar').show();
    $('#btnModalEditar').hide();
}

function agregar(){
    limpiar();
    $('#modal').modal();
}

function registrar(){
    var requisito = $('#requisito').val();
    var tipo = $("#tipo option:selected").val();
    var detalle = $("#detalle").is(":checked") ? 1 : 0;

    $.ajax({
          type: "POST",
          url: '<?= base_url('empresas/agregarRequisito_ajax') ?>',
          data: { 'requisito' : requisito, 'tipo' : tipo, 'detalle' : detalle },
          success: function(result){
            if(result){
              var res = JSON.parse(result);
              var tab = $('#tabla tbody')[0]; var ren = tab.insertRow(tab.rows.length);
              ren.insertCell(0).innerHTML = tab.rows.length;
              ren.insertCell(1).innerHTML = res.requisito;
              ren.insertCell(2).innerHTML = res.tipo;
              ren.insertCell(3).innerHTML = res.detalle == "1" ? "SI" : "NO";
              ren.insertCell(4).innerHTML = "<button onclick='prepareEdit(this)' class='btn btn-warning btn-xs' value='" + res.id + "'><i class='fa fa-pencil'></i> Editar </button><button onclick='eliminarRequisito(this)' value='" + res.id + "' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> Eliminar </button>";
              new PNotify({ title: 'Nuevo Requisito', text: 'Se ha agregado Requisito con Éxito', type: 'success', styling: 'bootstrap3' });
            } else {
              new PNotify({ title: 'ERROR', text: 'Error al agregar Requisito', type: 'error', styling: 'bootstrap3' });
            }
          },
          error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error al agregar Requisito', type: 'error', styling: 'bootstrap3' });
            console.log(data);
          },
        });
}

function prepareEdit(btn){
    $('#btnModalAgregar').hide();
    $('#btnModalEditar').show();
    var tab = $('#tabla')[0];
    var ren = btn.parentNode.parentNode.rowIndex;
    $('#id').val(btn.value);
    $('#ren').val(ren);
    $('#requisito').val(tab.rows[ren].cells[1].innerText);
    $('#tipo').val(tab.rows[ren].cells[2].innerText);
    var check = tab.rows[ren].cells[3].innerText == "SI" ? "check" : "uncheck";
    $('#detalle').iCheck(check);
    $('#modal').modal();
}

function editar(){
    var id =  $('#id').val();
    var ren = $('#ren').val();
    var requisito = $('#requisito').val();
    var tipo = $("#tipo option:selected").val();
    var detalle = $("#detalle").is(":checked") ? 1 : 0;

    $.ajax({
          type: "POST",
          url: '<?= base_url('empresas/editarRequisito_ajax') ?>',
          data: { 'id' : id, 'requisito' : requisito, 'tipo' : tipo, 'detalle' : detalle },
          success: function(result){
            if(result){
              var res = JSON.parse(result);
              var tab = $('#tabla')[0];
              tab.rows[ren].cells[1].innerText = res.requisito;
              tab.rows[ren].cells[2].innerText = res.tipo;
              tab.rows[ren].cells[3].innerText = res.detalle == "1" ? "SI" : "NO";

              new PNotify({ title: 'Requisito', text: 'Se ha editado Requisito con Éxito', type: 'success', styling: 'bootstrap3' });
            } else {
              new PNotify({ title: 'ERROR', text: 'Error al editar Requisito', type: 'error', styling: 'bootstrap3' });
            }
          },
          error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error al editar Requisito', type: 'error', styling: 'bootstrap3' });
            console.log(data);
          },
        });
}

function eliminarRequisito(btn){
    var ren = btn.parentNode.parentNode.rowIndex;
    var id =  btn.value;
    if(confirm('¿Desea eliminar requisito?')){
        $.ajax({
            type: "POST",
            url: '<?= base_url('empresas/eliminarRequisito_ajax') ?>',
            data: { 'id' : id },
            success: function(result){
            if(result){
                var tab = $('#tabla')[0];
                tab.deleteRow(ren);

                new PNotify({ title: 'Requisito', text: 'Se ha eliminado Requisito con Éxito', type: 'success', styling: 'bootstrap3' });
            } else {
                new PNotify({ title: 'ERROR', text: 'Error al eliminar Requisito', type: 'error', styling: 'bootstrap3' });
            }
            },
            error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error al eliminar Requisito', type: 'error', styling: 'bootstrap3' });
            console.log(data);
            },
    });
    }
}






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
</body>
</html>
