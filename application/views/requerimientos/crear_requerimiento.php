<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Crear Requerimiento</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label>Tipo de Servicio</label>
                                <select class="form-control" id="opTipo">
                                    <option value="CALIBRACION">CALIBRACIÓN</option>
                                    <option value="REVISION">REVISIÓN</option>
                                    <option value="REPARACION">REPARACIÓN</option>
                                    <option value="CURSO">CURSO</option>
                                    <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                                </select>
                                
                                <label style="margin-top: 10px;">Cantidad</label>
                                <input min="1" class="form-control" style="width: 40%; text-align: center;" id="txtCantidad" type="number">
                                
                                <label style="margin-top: 15px;">Instrumento descatalogado</label>
                                <input type="checkbox" class="flat" id="cbDescatalogado" /><br>

                                <div id="divFabricante">
                                    <label style="margin-top: 10px;">Fabricante</label>
                                    <input class="form-control" id="txtFabricante" type="text">
                                    

                                    <label style="margin-top: 10px;">Modelo</label>
                                    <input class="form-control" id="txtModelo" type="text">
                                </div>

                                <label style="margin-top: 10px;">Descripción del instrumento</label>
                                <textarea rows="3" style="resize: none;" class="form-control" id="txtDescripcion"></textarea>

                                <label style="display: block; margin-top: 10px;">Alcance Maximo</label>
                                <div class="row">
                                    <div class="col-md-5 col-sm-12">
                                        <input class="form-control" style="margin-right: 10px; display: inline;" id="txtAlcance" type="number">
                                    </div>

                                    <div class="col-md-7 col-sm-12">
                                        <select style="display: inline;" class="form-control" id="opAlcance">
                                            <option selected value=""></option>
                                            <option value='%RH'>% de humedad relativa</option>
                                            <option value='pH'>Acides o alcalinidad</option>
                                            <option value='A'>Amperio</option>
                                            <option value='cd'>candela</option>
                                            <option value='cP'>centipoise</option>
                                            <option value='cm'>centrimetro</option>
                                            <option value='cm3/min'>centrimetro cubico por minuto</option>
                                            <option value='dB'>decibelio</option>
                                            <option value='HR30N'>Dureza Rockwell 30N</option>
                                            <option value='HRB'>Dureza Rockwell B</option>
                                            <option value='HRC'>Dureza Rockwell C</option>
                                            <option value='G'>Gauss (Magnetismo)</option>
                                            <option value='GHz'>gigahertz (frecuencia)</option>
                                            <option value='GΩ'>gigaohms</option>
                                            <option value='°'>grado (circunferencia)</option>
                                            <option value='°C'>grados celcius</option>
                                            <option value='°F'>grados farenheit</option>
                                            <option value='g'>gramo</option>
                                            <option value='Hz'>Hertz (frecuencia)</option>
                                            <option value='h'>hora</option>
                                            <option value='Lux'>Iluminancia </option>
                                            <option value='K'>Kelvin</option>
                                            <option value='kA'>kiloamperio</option>
                                            <option value='kg'>kilogramo</option>
                                            <option value='kHz'>kilohertz (frecuencia)</option>
                                            <option value='kΩ'>kilohm</option>
                                            <option value='kN'>kilonewton</option>
                                            <option value='kPa'>kilopascal</option>
                                            <option value='kV'>kilovoltio</option>
                                            <option value='kW'>kilowatt</option>
                                            <option value='lb'>libra (masa)</option>
                                            <option value='lbf'>libra fuerza</option>
                                            <option value='lbf·ft'>libra-pie (Par torcional)</option>
                                            <option value='psi'>libras sobre pulgada cuadrada</option>
                                            <option value='L'>Litros (volumen)</option>
                                            <option value='l/min'>Litros por minuto (flujo)</option>
                                            <option value='X'>magnificacion</option>
                                            <option value='MHz'>megahertz (frecuencia)</option>
                                            <option value='MPa'>megapascal</option>
                                            <option value='MW'>megawatt</option>
                                            <option value='MΩ'>megohms</option>
                                            <option value='m'>metro</option>
                                            <option value='μA'>microamperio</option>
                                            <option value='μg'>microgramo</option>
                                            <option value='μlb'>microlibra</option>
                                            <option value='μL'>microlitros</option>
                                            <option value='μm'>micrometro</option>
                                            <option value='μΩ'>microohms</option>
                                            <option value='μin'>micropulgada</option>
                                            <option value='μs'>microsegundo</option>
                                            <option value='μS'>microsiemens (Conductividad)</option>
                                            <option value='μV'>microvoltio</option>
                                            <option value='μW'>microwatt</option>
                                            <option value='mA'>miliamperio</option>
                                            <option value='mg'>miligramo</option>
                                            <option value='mHz'>milihertz (frecuencia)</option>
                                            <option value='mL'>mililitros</option>
                                            <option value='mΩ'>miliohm</option>
                                            <option value='ms'>milisegundo</option>
                                            <option value='mV'>milivoltio</option>
                                            <option value='mW'>miliwatt</option>
                                            <option value='mm'>millimetro</option>
                                            <option value='nA'>nanoamperio</option>
                                            <option value='nF'>nanofaradio</option>
                                            <option value='ns'>nanosegundo</option>
                                            <option value='nV'>nanovoltio</option>
                                            <option value='nW'>nanowatt</option>
                                            <option value='N'>Newton (Fuerza)</option>
                                            <option value='N·m'>Newton metro (Par torcional)</option>
                                            <option value='Ω'>Ohm</option>
                                            <option value='oz'>Onza (masa)</option>
                                            <option value='Pa'>Pascal</option>
                                            <option value='pF'>picofaradio</option>
                                            <option value='in'>Pulgada</option>
                                            <option value='in H2O'>Pulgadas de agua</option>
                                            <option value='in Mg'>Pulgadas de mercurio</option>
                                            <option value='RPM'>Revoluciones por minuto</option>
                                            <option value='s'>segundo</option>
                                            <option value='V'>Voltio</option>
                                            <option value='W'>Watt (potencia electrica)</option>
                                        </select>
                                    </div>
                                </div>

                                <label style="display: block; margin-top: 10px;">Resolución</label>
                                <div class="row">
                                    <div class="col-md-5 col-sm-12">
                                        <input class="form-control" style="margin-right: 10px; display: inline;" id="txtResolucion" type="number">
                                    </div>

                                    <div class="col-md-7 col-sm-12">
                                        <select style="display: inline;" class="form-control" id="opResolucion">
                                            <option selected value=""></option>
                                            <option value='%RH'>% de humedad relativa</option>
                                            <option value='pH'>Acides o alcalinidad</option>
                                            <option value='A'>Amperio</option>
                                            <option value='cd'>candela</option>
                                            <option value='cP'>centipoise</option>
                                            <option value='cm'>centrimetro</option>
                                            <option value='cm3/min'>centrimetro cubico por minuto</option>
                                            <option value='dB'>decibelio</option>
                                            <option value='HR30N'>Dureza Rockwell 30N</option>
                                            <option value='HRB'>Dureza Rockwell B</option>
                                            <option value='HRC'>Dureza Rockwell C</option>
                                            <option value='G'>Gauss (Magnetismo)</option>
                                            <option value='GHz'>gigahertz (frecuencia)</option>
                                            <option value='GΩ'>gigaohms</option>
                                            <option value='°'>grado (circunferencia)</option>
                                            <option value='°C'>grados celcius</option>
                                            <option value='°F'>grados farenheit</option>
                                            <option value='g'>gramo</option>
                                            <option value='Hz'>Hertz (frecuencia)</option>
                                            <option value='h'>hora</option>
                                            <option value='Lux'>Iluminancia </option>
                                            <option value='K'>Kelvin</option>
                                            <option value='kA'>kiloamperio</option>
                                            <option value='kg'>kilogramo</option>
                                            <option value='kHz'>kilohertz (frecuencia)</option>
                                            <option value='kΩ'>kilohm</option>
                                            <option value='kN'>kilonewton</option>
                                            <option value='kPa'>kilopascal</option>
                                            <option value='kV'>kilovoltio</option>
                                            <option value='kW'>kilowatt</option>
                                            <option value='lb'>libra (masa)</option>
                                            <option value='lbf'>libra fuerza</option>
                                            <option value='lbf·ft'>libra-pie (Par torcional)</option>
                                            <option value='psi'>libras sobre pulgada cuadrada</option>
                                            <option value='L'>Litros (volumen)</option>
                                            <option value='l/min'>Litros por minuto (flujo)</option>
                                            <option value='X'>magnificacion</option>
                                            <option value='MHz'>megahertz (frecuencia)</option>
                                            <option value='MPa'>megapascal</option>
                                            <option value='MW'>megawatt</option>
                                            <option value='MΩ'>megohms</option>
                                            <option value='m'>metro</option>
                                            <option value='μA'>microamperio</option>
                                            <option value='μg'>microgramo</option>
                                            <option value='μlb'>microlibra</option>
                                            <option value='μL'>microlitros</option>
                                            <option value='μm'>micrometro</option>
                                            <option value='μΩ'>microohms</option>
                                            <option value='μin'>micropulgada</option>
                                            <option value='μs'>microsegundo</option>
                                            <option value='μS'>microsiemens (Conductividad)</option>
                                            <option value='μV'>microvoltio</option>
                                            <option value='μW'>microwatt</option>
                                            <option value='mA'>miliamperio</option>
                                            <option value='mg'>miligramo</option>
                                            <option value='mHz'>milihertz (frecuencia)</option>
                                            <option value='mL'>mililitros</option>
                                            <option value='mΩ'>miliohm</option>
                                            <option value='ms'>milisegundo</option>
                                            <option value='mV'>milivoltio</option>
                                            <option value='mW'>miliwatt</option>
                                            <option value='mm'>millimetro</option>
                                            <option value='nA'>nanoamperio</option>
                                            <option value='nF'>nanofaradio</option>
                                            <option value='ns'>nanosegundo</option>
                                            <option value='nV'>nanovoltio</option>
                                            <option value='nW'>nanowatt</option>
                                            <option value='N'>Newton (Fuerza)</option>
                                            <option value='N·m'>Newton metro (Par torcional)</option>
                                            <option value='Ω'>Ohm</option>
                                            <option value='oz'>Onza (masa)</option>
                                            <option value='Pa'>Pascal</option>
                                            <option value='pF'>picofaradio</option>
                                            <option value='in'>Pulgada</option>
                                            <option value='in H2O'>Pulgadas de agua</option>
                                            <option value='in Mg'>Pulgadas de mercurio</option>
                                            <option value='RPM'>Revoluciones por minuto</option>
                                            <option value='s'>segundo</option>
                                            <option value='V'>Voltio</option>
                                            <option value='W'>Watt (potencia electrica)</option>

                                        </select>
                                    </div>
                                </div>

                                <label style="margin-top: 10px;">Exactitud</label>
                                <input maxlength="30" class="form-control" id="txtExactitud" type="text">

                                <label style="margin-top: 10px;">Grado</label>
                                <select class="form-control" id="opGrado">
                                    <option selected value=""></option>
                                    <option value="XXX / plug gage/ring gage">XXX</option>
                                    <option value="XX / plug gage/ring gage">XX</option>
                                    <option value="X / plug gage/ring gage">X</option>
                                    <option value="Y / plug gage/ring gage">Y</option>
                                    <option value="Z / plug gage/ring gage">Z</option>
                                    <option value="Grado AAA / Bloques patron">Grado AAA</option>
                                    <option value="Grado AA / Bloques patron">Grado AA</option>
                                    <option value="Grado A / Bloques patron">Grado A</option>
                                    <option value="Grado B / Bloques patron">Grado B</option>
                                    <option value="Grado 00 / Bloques patron">Grado 00</option>
                                    <option value="Grado 0 / Bloques patron">Grado 0</option>
                                    <option value="AS-1 / Bloques patron">Grado AS-1</option>
                                    <option value="AS-2 / Bloques patron">Grado AS-2</option>
                                    <option value="K / Bloques patron">K</option>
                                </select>

                                <label style="margin-top: 10px;">Requisitos Especiales</label>
                                <textarea rows="3" style="resize: none;" class="form-control" id="txtRequisitosEspeciales"></textarea>

                                <center style="margin-top: 30px;">
                                    <div id="divButtons">
                                        <button type="button" id="btnRegistrar" onclick="registrar()" class="btn btn-success"><i class="fa fa-send"></i> Registrar</button>
                                        <button type="button" style="display: none;" id="btnEditar" onclick="editar()" class="btn btn-warning"><i class="fa fa-pencil"></i> Editar</button>
                                    </div>
                                </center>
                            </div>

                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <div class="row">
                                    <!--
                                    <div style="height: 200px;" class="col-md-12 col-sm-12 col-xs-12">
                                        <h3 style="display: inline; margin-right: 10px;"><i class="fa fa-file-pdf-o"></i> Archivos</h3>
                                        <label class="btn btn-default btn-xs" for="userfile">
                                        <input accept="application/pdf" target="_blank" onchange="uploadFile();" type="file" class="sr-only" id="userfile" name="userfile">
                                            <i class="fa fa-file"></i> Subir Archivo
                                        </label>
                                        <table id="tblArchivos" class="table table-striped">
                                            <thead>
                                                <tr class="headings">
                                                    <th class="column-title">Nombre</th>
                                                    <th class="column-title">Comentarios</th>
                                                    <th style="width: 20%;" class="column-title">Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    -->

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h3><i class="fa fa-spinner"></i> Servicios</h3>
                                        <table id="tblServicios" class="table table-striped">
                                            <thead>
                                                <tr class="headings">
                                                    <th class="column-title">Código</th>
                                                    <th class="column-title">Magnitud</th>
                                                    <th class="column-title">Descripción</th>
                                                    <th class="column-title">Sitio</th>
                                                    <th class="column-title">Tipo</th>
                                                    <th class="column-title">Calibración</th>
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
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>
<!-- /page content -->





<!-- MODALS 
<div id="mdlArchivo" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Subir Archivo</h4>
            </div>
            <div class="modal-body">
                <form>
                    <label>Nombre</label>
                    <input id="txtNombreArchivo" class="form-control" type="text">

                    <label style="margin-top: 10px;">Comentarios</label>
                    <textarea style="height: 60px; resize: none;" id="txtComentarioArchivos" class="form-control"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnCancelar" type="button" data-dismiss="modal" class="btn btn-default btn-sm pull-left"><i class="fa fa-close"></i> Cancelar</button>
                <button id="btnAgregar" type="button" onclick="agregar()" class="btn btn-primary btn-sm"><i class='fa fa-chech'></i> Aceptar</button>
            </div>
            

        </div>
    </div>
</div>
-->








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
<!-- PNotify -->
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.buttons.js"); ?>></script>
<script src=<?= base_url("template/vendors/pnotify/dist/pnotify.nonblock.js"); ?>></script>
<!-- iCheck -->
<script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
<!-- jQuery Tags Input -->
<script src=<?= base_url("template/vendors/jquery.tagsinput/src/jquery.tagsinput.js") ?>></script>
<!-- formatCurrency -->
<script src=<?= base_url("template/vendors/formatCurrency/jquery.formatCurrency-1.4.0.js"); ?>></script>
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
<!-- jquery.redirect -->
<script src=<?= base_url("template/vendors/jquery.redirect/jquery.redirect.js"); ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/requerimientos/js/crear_requerimiento.js"); ?>></script>
<script>
    var ID = '<?= $id ?>';
    var adm_ser = '<?= $this->session->privilegios['administrar_servicios'] ?>';

    $(function(){
        load();
    });


</script>
</body>
</html>
