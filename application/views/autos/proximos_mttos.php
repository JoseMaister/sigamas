<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?= $titulo ?></h2>
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
                                            <th class="column-title">No.</th>
                                            <th class="column-title">Foto</th>
                                            <th class="column-title">Automóvil</th>
                                            <th class="column-title">Serie</th>
                                            <th class="column-title">Placas</th>
                                            <th class="column-title">Kilometraje Actual</th>
                                            <th class="column-title">Prox. Mtto.(KM)</th>
                                            <th class="column-title">Ticket</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    if ($autos) {
                                        foreach ($autos->result() as $elem) {
                                            ?>
                                            <tbody>
                                                <tr class="even pointer">
                                                    <td><h4><?= $elem->id ?></h4></td>
                                                    <td><img width="100" src=<?= 'data:image/bmp;base64,' . base64_encode($elem->foto); ?>></td>
                                                    <td><?= $elem->fabricante . ' ' . $elem->marca . ' ' . $elem->modelo ?></td>
                                                    <td><?= $elem->serie ?></td>
                                                    <td><?= $elem->placas ?></td>
                                                    <td><?= number_format($elem->kilometraje) . ' KM'?></td>
                                                    <td><?= number_format($elem->proximo_mtto) . ' KM'?></td>
                                                    <td>
                                                      <?php
                                                      if($elem->ticket_mtto == 0)
                                                      {
                                                        echo '<a href="'.base_url('tickets_AT/mantenimiento/'.$elem->id).'" class="btn btn-primary">Abrir Ticket</a>';
                                                      }
                                                      else
                                                      {
                                                        echo '<a href="'.base_url('tickets_AT/ver/'.$elem->ticket_mtto).'" class="btn btn-success">AT'.str_pad($elem->ticket_mtto, 6, "0", STR_PAD_LEFT).'</a>';
                                                      }
                                                      ?>
                                                    </td>
                                                </tr>
                                            </tbody>

                                        <?php }
                                    }
                                    ?>
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
