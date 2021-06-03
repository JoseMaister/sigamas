<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Seleccione Automóvil</h2>
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
                                            <th class="column-title">Foto</th>
                                            <th class="column-title">Marca</th>
                                            <th class="column-title">Modelo</th>
                                            <th class="column-title">Fabricante</th>
                                            <th class="column-title">Combustible</th>
                                            <th class="column-title">Serie</th>
                                            <th class="column-title">Placas</th>
                                            <th class="column-title">Vencimiento de Poliza</th>
                                            <th class="column-title">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if ($autos) {
                                        foreach ($autos->result() as $elem) {
                                            ?>
                                                <tr class="even pointer">
                                                    <td><img width="100" src=<?= 'data:image/bmp;base64,' . base64_encode($elem->foto); ?>></td>
                                                    <td><?= $elem->marca ?></td>
                                                    <td><?= $elem->modelo ?></td>
                                                    <td><?= $elem->fabricante ?></td>
                                                    <td><?= $elem->combustible ?></td>
                                                    <td><?= $elem->serie ?></td>
                                                    <td><?= $elem->placas ?></td>
                                                    <td>
                                                        <?php $date = date_create($elem->vencimiento_poliza); ?>
                                                        <?= date_format($date, 'd/m/Y'); ?>
                                                    </td>
                                                    <td>
                                                      <form action=<?= base_url("tickets_AT/generar"); ?> method="POST">
                                                        <button class="btn btn-primary" type="submit" name="auto" value="<?= $elem->id; ?>"><i class="fa fa-car"></i> Seleccionar</button>
                                                      </form>
                                                    </td>
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
<script src=<?= base_url("template/build/js/custom.min.js"); ?>></script>


</body>
</html>
