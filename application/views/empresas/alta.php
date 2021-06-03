<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Alta de Empresa</h2>
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
                        <form method="POST" action=<?= base_url('empresas/registrar') ?> class="form-horizontal form-label-left" novalidate>

                             <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nombre</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input maxlength="100" id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="" required="required" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Razón Social</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input maxlength="100" id="razon_social" class="form-control col-md-7 col-xs-12" name="razon_social" placeholder="" required="required" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">RFC</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input maxlength="15" id="rfc" class="form-control col-md-7 col-xs-12" name="rfc" placeholder="" required="required" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Calle</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input maxlength="45" id="calle" class="form-control col-md-7 col-xs-12" name="calle" placeholder="" required="required" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Numero</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input maxlength="20" id="numero" class="form-control col-md-7 col-xs-12" name="numero" placeholder="" required="required" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Numero Int</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input maxlength="20" id="numero_interior" class="form-control col-md-7 col-xs-12" name="numero_interior" placeholder="" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Colonia</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input maxlength="45" id="colonia" class="form-control col-md-7 col-xs-12" name="colonia" placeholder="" required="required" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="calles_aux">Entre Calles</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input maxlength="150" id="calles_aux" class="form-control col-md-7 col-xs-12" name="calles_aux" placeholder="" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">CP</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input maxlength="10" id="cp" class="form-control col-md-7 col-xs-12" name="cp" placeholder="" required="required" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">País</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select onchange="estados()" required="required" class="select2_single form-control" name="pais" id="pais">
                                    <option value="MEXICO">MEXICO</option>
                                    <option value="USA">USA</option>
                                    <option value="CANADA">CANADA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Estado</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select required="required" class="select2_single form-control" name="estado" id="estado">
                                    </select>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Ciudad</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input list="lstCiudades" maxlength="45" id="ciudad" class="form-control col-md-7 col-xs-12" name="ciudad" required="required" placeholder="" type="text">
                                    <datalist id="lstCiudades">
                                    </datalist>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="txtGiro">Giro</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input maxlength="45" id="txtGiro" class="form-control col-md-7 col-xs-12" name="giro" placeholder="" type="text">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="txtClasificacion">Clasificación</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input maxlength="45" id="txtClasificacion" class="form-control col-md-7 col-xs-12" name="clasificacion" placeholder="" type="text">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="txtNombreCorto">Nombre Corto</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input maxlength="48" id="txtNombreCorto" class="form-control col-md-7 col-xs-12" name="nombre_corto" placeholder="" type="text">
                                </div>
                            </div>

                            <br>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <p>
                                        Cliente
                                        <input type="checkbox" class="flat" name="cliente" value="1"/>
                                        Proveedor
                                        <input type="checkbox" class="flat" name="proveedor" value="1"/>
                                    </p>
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button id="send" type="submit" class="btn btn-success">Registrar Empresa</button>
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
<script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js") ?>></script>
<!-- Bootstrap -->
<script src=<?= base_url("template/vendors/bootstrap/dist/js/bootstrap.min.js") ?>></script>
<!-- FastClick -->
<script src=<?= base_url("template/vendors/fastclick/lib/fastclick.js") ?>></script>
<!-- NProgress -->
<script src=<?= base_url("template/vendors/nprogress/nprogress.js") ?>></script>
<!-- validator -->
<script src=<?= base_url("template/vendors/validator/validator.js") ?>></script>
<!-- iCheck -->
<script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>

<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/empresas/js/alta.js"); ?>></script>
<script>

$(function(){
    load();
    estados();
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
