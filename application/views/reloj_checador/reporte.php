<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">

                        <div class="x_content">
                            <div class="col-md-2 col-sm-2 col-xs-12">
                            <label class="control-label">Año:</label>
                            <select required="required" class="cb select2_single form-control" id="year" name="year">
                                <?php
                                $year = date('Y');
                                for($i=$year; $i >= 2018; $i--) { 
                                    echo "<option value='$i'>$i</option>";
                                } ?>
                            </select>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                            <label class="control-label">Semana</label>
                            <select required="required" class="cb select2_single form-control" id="semana" name="semana">
                                <?php
                                for($i=1; $i <= 52; $i++) { 
                                    if($semanaActual != $i)
                                    {
                                        echo "<option value='$i'>$i</option>";
                                    }else{
                                        echo "<option value='$i' selected>$i</option>";
                                    }
                                } ?>
                            </select>
                            </div>



                            <div class="col-md-2 col-sm-2 col-xs-12">

                            </div>

                            <div class="col-md-2 col-sm-2 col-xs-12">

                            </div>

                            <div class="col-md-2 col-sm-2 col-xs-12">

                            </div>

                            <div class="col-md-2 col-sm-2 col-xs-12">

                            </div>

                            <div class="col-md-1 col-sm-1 col-xs-12">
                            <!--<label class="control-label">Opciones: </label>
                            <button name="btnSubmit" onclick="verOpciones(this)" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Opciones</button>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        
            

        <div class="row">
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">   

                        <div class="x_content">
                            <!-- start accordion -->
                            <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                                <div id="paneles">

                                </div>
                            </div>
                            <!-- end of accordion -->
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
<!-- Custom Theme Scripts -->
<script src=<?= base_url("template/build/js/custom.js"); ?>></script>
<!-- iCheck -->
<script src=<?= base_url("template/vendors/iCheck/icheck.min.js"); ?>></script>
<!-- Moment -->
<script src=<?= base_url("template/vendors/moment/moment.js"); ?>></script>
<!-- FancyBOX -->
<script src=<?= base_url("template/vendors/fancybox/dist/jquery.fancybox.min.js"); ?>></script>
<script>

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
        buscar(); //INICIO BUSQUEDA
    });
    


    $('.cb').change(function(){    
        buscar();
    });


    function buscar(){
        var year = $('#year option:selected').val();
        var semana = $('#semana option:selected').val();
        $('#paneles').empty();
        $.ajax({
            url: '<?= base_url('reloj_checador/reporte_ajax'); ?>',
            method: 'POST',
            data: { year : year, semana : semana },
            success: function(resultado){

                var COUNT = 1;
                var idUsuario = 0;
                if(resultado) {
                    var table = "";
                    var res = JSON.parse(resultado);
                    //var table = $('tbody')[0];
                    $.each(res, function(i, elem) {
                        if(idUsuario != elem.usuario)
                        {
                            if(idUsuario != 0)
                            {
                                table +=           '</tbody>'
                                table +=       '</table>'
                                table +=   '</div>'
                                table +=   '</div>'
                                table += '</div>';
                            }
                            
                            idUsuario = elem.usuario;
                            table += '<div class="panel">'
                            table +=   '<a class="panel-heading collapsed" role="tab" id="headingOne' + COUNT + '" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne' + COUNT + '" aria-expanded="false" aria-controls="collapseOne">'
                            table +=   '<h4 class="panel-title">' + elem.User + ' - ' + elem.no_empleado + '</h4>'
                            table +=   '</a>'
                            table +=   '<div id="collapseOne' + COUNT + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">'
                            table +=   '<div class="panel-body">'
                            table +=       '<table class="table table-striped">'
                            table +=       '<thead>'
                            table +=           '<tr>'
                            table +=               '<th>FECHA</th>'
                            table +=               '<th>ENTRADA</th>'
                            table +=               '<th>DESAYUNO</th>'
                            table +=               '<th>REGRESO</th>'
                            table +=               '<th>COMIDA</th>'
                            table +=               '<th>REGRESO</th>'
                            table +=               '<th>SALIDA</th>'
                            table +=               '<th>TOTAL</th>'
                            table +=           '</tr>'
                            table +=       '</thead>'
                            table +=       '<tbody>'
                        }
                        var def = '<?= base_url('template/images/avatar.png') ?>';
                        var res = 0;
                        if(elem.Salida != "S/R")
                        {
                            var entrada = moment(elem.Fecha + " " + elem.Entrada, 'YYYY-MM-DD hh:mm');
                            var salida = moment(elem.Fecha + " " + elem.Salida, 'YYYY-MM-DD hh:mm');
                            res = salida.diff(entrada, 'hours', true);

                            console.log(entrada);
                            console.log(salida);
                            console.log(res);
                        }

                        table +=           '<tr>'
                        table +=                '<td>' + elem.Fecha + '</td>'
                                                var foto = elem.Entrada_foto != "" ? elem.Entrada_foto : def;
                        table +=                '<td><img height=75 width=75  src="' + foto + '" class="usuario" ><br>' + elem.Entrada + '</td>'
                                                foto = elem.Desayuno_foto != "" ? elem.Desayuno_foto : def;
                        table +=                '<td><img height=75 width=75  src="' + foto + '" class="usuario" ><br>' + elem.Desayuno + '</td>'
                                                foto = elem.R_desayuno_foto != "" ? elem.R_desayuno_foto : def;
                        table +=                '<td><img height=75 width=75  src="' + foto + '" class="usuario" ><br>' + elem.R_desayuno + '</td>'
                                                foto = elem.Comida_foto != "" ? elem.Comida_foto : def;
                        table +=                '<td><img height=75 width=75  src="' + foto + '" class="usuario" ><br>' + elem.Comida + '</td>'
                                                foto = elem.R_comida_foto != "" ? elem.R_comida_foto : def;
                        table +=                '<td><img height=75 width=75  src="' + foto + '" class="usuario" ><br>' + elem.R_comida + '</td>'
                                                foto = elem.Salida_foto != "" ? elem.Salida_foto : def;
                        table +=                '<td><img height=75 width=75 src="' + foto + '" class="usuario" ><br>' + elem.Salida + '</td>'
                        table +=                '<td>' + res.toFixed(2); + '</td>'
                        table +=           '</tr>'
                        
                        COUNT++;
                    });

                        table +=           '</tbody>'
                        table +=       '</table>'
                        table +=   '</div>'
                        table +=   '</div>'
                        table += '</div>';
                        $('#paneles').html(table);
                }
            },

            error: function(err){
                console.log(err);
            }
        });
    }
</script>

</body>
</html>
