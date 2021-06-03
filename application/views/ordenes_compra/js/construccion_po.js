var CURRENT_PR = 0;
var CURRENT_PR_ENTREGA = 0;
var COSTOS = [];
var CONTACTO = 0;

function load(){
    buscar();
}

function buscar(){
    var URL = base_url + "ordenes_compra/ajax_getTempPO";
    $('#paneles').empty();
    

    $.ajax({
        type: "POST",
        url: URL,
        data: { prs : JSON.stringify(PRS) },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var costos = JSON.parse(elem.costos);
                    
                    CURRENT_PR_ENTREGA = elem.entrega;
                    var cadena = elem.tipo + ' ' + elem.subtipo + ' ' + elem.descripcion + ' ' + elem.Marca + ' ' + elem.Modelo + ' ' + elem.Serie;

                    var panel = '<div class="panel">'
                        + '<a class="panel-heading collapsed" role="tab" id="heading'+ i +'" data-toggle="collapse" data-parent="#accordion1" href="#collapse'+ i +'" aria-expanded="false" aria-controls="collapse'+ i +'">'
                        +    '<table id="tblPR' + elem.id + '" data-pr="' + elem.id + '" data-f="' + elem.factor + '" data-qty="' + elem.cantidad + '" data-cadena="' + cadena + '" style="margin-bottom: 0px;" class="table table-striped tablapr">'
                        +        '<thead>'
                        +            '<tr class="headings">'
                        +                '<th style="width: 7%" class="column-title">PR</th>'
                        +                '<th style="width: 10%" class="column-title">Cantidad</th>'
                        +                '<th style="width: 20%" class="column-title">Modelo</th>'
                        +                '<th style="width: 50%" class="column-title">Descripción</th>'
                        +                '<th cstyle="width: 7%" class="column-title">Monto</th>'
                        +            '</tr>'
                        +        '</thead>'
                        +        '<tbody>'
                        +            '<tr>'
                        +                '<td><button onclick="getPR(this)" value="' + elem.id + '" class="btn btn-default btn-md" type="button">' + elem.id + '</button></td>'
                        +                '<td>' + elem.cantidad + '</td>'
                        +                '<td>' + elem.Modelo + '</td>'
                        +                '<td>' + elem.descripcion + '</td>'
                        +                '<td><button class="btn btn-success btn-md" type="button"><div style="display: inline;" data-importe="' + elem.importe + '" data-pu="' + elem.precio_unitario + '" class="formatC" id="lblImporte' + elem.id + '">' + elem.importe + '</div> ' + elem.moneda + '</button></td>'
                        +            '</tr>'
                        +        '</tbody>'
                        +    '</table>'
                        + '</a>'

                        + '<div id="collapse'+ i +'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'+ i +'" aria-expanded="false">'
                        +    '<div class="panel-body">'

                        +        '<div class="row">'
                        +            '<div class="col-md-6 col-sm-12 col-xs-12">'
                        +                '<table id="tblCostos' + elem.id + '" class="table tablacostos">'
                        +                    '<thead>'
                        +                        '<tr>'
                        +                            '<th style="width: 7%"><i class="fa fa-check"></i></th>'
                        +                            '<th>Concepto</th>'
                        +                            '<th style="width: 20%">Costo</th>'
                        +                        '</tr>'
                        +                    '</thead>'
                        +                    '<tbody>';


                        $.each(costos, function(concept, mont){
                            panel +=                        '<tr>'
                            panel +=                            '<td><input value="' + elem.id + '" type="checkbox" class="flat selecc" checked /></td>'
                            panel +=                            '<td>' + concept + '</td>'
                            panel +=                            '<td class="formatC" data-mon="' + mont + '">' + mont + '</td>'
                            panel +=                        '</tr>'
                        });
                        panel += ''
                        +                    '</tbody>'
                        +                '</table>'
                        +            '</div>'
                        +        '</div>'
                                
                        +    '</div>'
                        + '</div>'

                        +'</div>'; 
                        $('#paneles').append(panel);
                });

                $(".formatC").formatCurrency();

                $('input.flat').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });

                $('input.selecc').on('ifChanged', function(){
                    calculoImporte(this);
                });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
      });
}

function calculoImporte(inp){
    var idPR = $(inp).val();
    var rows = $('#tblCostos' + idPR + ' tbody tr');
    var factor = $('#tblPR' + idPR).data('f');
    var qty = $('#tblPR' + idPR).data('qty');

    var monto = 0;
    $.each(rows, function(i, elem){
        var cb = $(elem).find('input');
        if($(cb).is(':checked'))
        {
            monto += parseFloat($(elem).find('td').last().data("mon"));
        }
    });

    var pu = monto * factor; 
    monto = pu * qty;

    $('#lblImporte' + idPR).html(monto.toFixed(2));
    $('#lblImporte' + idPR).data('pu', pu.toFixed(2));
    $('#lblImporte' + idPR).data('importe', monto.toFixed(2));
    $('#lblImporte' + idPR).formatCurrency();
}

function getPR(btn){
    var URL = base_url + 'compras/ajax_getPR';
    var idPR = $(btn).val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { id: idPR },
        success: function(result) {
            if(result)
            {
                $('#tblDetalle tr').remove();
                var tab = $('#tblDetalle tbody')[0];

                var rs = JSON.parse(result);
                var att = JSON.parse(rs['atributos']);
                
                
                $(".mdlTitulo").text("PR # " + rs.id);
                $("#lblQR").html('QR: # ' + rs.qr);
                $("#lblDestino").html('Destino: <small>' + rs.destino + '</small>');
                $("#lblRequisitor").text(rs.User);
                $("#lblFecha").text(rs.fecha);
                $("#lblCantidad").text(rs.cantidad);
                $("#lblDescripcion").text(rs.descripcion);

                var ren = tab.insertRow(tab.rows.length);
                var cell0 = ren.insertCell(0);
                cell0.innerHTML = "Tipo";
                cell0.style.width = "40%";
                ren.insertCell(1).innerHTML = rs.tipo;

                var ren = tab.insertRow(tab.rows.length);
                ren.insertCell(0).innerHTML = "Subtipo";
                ren.insertCell(1).innerHTML = rs.subtipo;

                var ren = tab.insertRow(tab.rows.length);
                ren.insertCell(0).innerHTML = "Cantidad";
                ren.insertCell(1).innerHTML = rs.cantidad;

                var ren = tab.insertRow(tab.rows.length);
                ren.insertCell(0).innerHTML = "Unidad de Medida";
                ren.insertCell(1).innerHTML = rs.unidad;

                $.each(att, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell(0).innerHTML = i[0].toUpperCase() + i.slice(1);
                    ren.insertCell(1).innerHTML = elem;
                });

                if(rs.comentarios)
                {
                    $("#divCommentQR").show();
                    $("#lblCommentQR").text(rs.comentarios);
                }
                else
                {
                    $("#divCommentQR").hide();
                    $("#lblCommentQR").text("");
                }
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
      });
      $("#mdlDetalle").modal();
}

function validacion(){
    if(!confirm('¿Desea continuar?'))
    {
        return false;
    }

    return true;
}

function mdlGenerarPO(){
    $('#mdlGenerarPO').modal();
    $('#btnPOExistente').hide();

    $('#tblPOExistentes tbody tr').remove();
    var URL = base_url + "ordenes_compra/ajax_getPOs";
    
    var proveedor = $('#btnNuevaPO').data('p');
    var moneda = $('#btnNuevaPO').data('m');
    var tipo = $('#btnNuevaPO').data('t');


    $.ajax({
        type: "POST",
        url: URL,
        data: { proveedor : proveedor, moneda : moneda, tipo : tipo, estatus : 'EN PROCESO' },
        success: function(result) {
            if(result)
            {
                $('#btnPOExistente').show();
                var rs = JSON.parse(result);
                var tab = $('#tblPOExistentes tbody')[0];

                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = elem.id;
                    ren.insertCell().innerHTML = moment(elem.fecha).format('YYYY-MM-DD');
                    ren.insertCell().innerHTML = elem.User;
                    ren.insertCell().innerHTML = elem.Prov;
                    ren.insertCell().innerHTML = "<button type='button' onclick='agregarAPO(this)' value='" + elem.id + "' class='btn btn-primary btn-xs'><i class='fa fa-shopping-cart'></i> Agregar a PO</button>";
                });
            }
        },
    });
}

function mdlPOExistentes(){
    $('#mdlGenerarPO').modal('hide');
    $('#mdlPOExistentes').modal();
}

function agregarAPO(btn){
    var id_po = $(btn).val();

    var URL = base_url + 'ordenes_compra/ajax_agregarAPO';
    var datos = [];

    var pr_rows = $('table.tablapr');
    var costos_rows = $('table.tablacostos');

    $.each(pr_rows, function(i, elem){
        var pr = $(elem).data('pr');
        var qty = $(elem).data('qty');
        var pu = $('#lblImporte' + pr).data('pu');
        var importe = $('#lblImporte' + pr).data('importe');

        var cad = [$(elem).data('cadena')];
        var pr_arr = [pr, qty, pu, importe];
        var tCostos = $(costos_rows[i]).find('tbody tr');

        var costos = {};
        $.each(tCostos, function(i_c, row_c)
        {
            if($(row_c).find('td').eq(0).find('input').is(':checked'))
            {
                costos[cad + ' - ' + $(row_c).find('td').eq(1).text()] = parseFloat($(row_c).find('td').eq(2).data('mon')).toFixed(2);
            }
        });

        pr_arr.push(costos);
        datos.push(pr_arr);
    });

    $.ajax({
        type: "POST",
        url: URL,
        data: { datos : JSON.stringify(datos), id_po : id_po, idtemp : idtemp },
        success: function(result) {
            if(result)
            {
                window.location.href = base_url + 'ordenes_compra';
            }
            else
            {
                alert('PO NO DISPONIBLE');
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

    

}

function generarPO(btn){
    var URL = base_url + 'ordenes_compra/ajax_generarPO';
    var datos = [];

    var pr_rows = $('table.tablapr');
    var costos_rows = $('table.tablacostos');

    $.each(pr_rows, function(i, elem){
        var pr = $(elem).data('pr');
        var qty = $(elem).data('qty');
        var pu = $('#lblImporte' + pr).data('pu');
        var importe = $('#lblImporte' + pr).data('importe');

        var cad = [$(elem).data('cadena')];
        var pr_arr = [pr, qty, pu, importe];
        var tCostos = $(costos_rows[i]).find('tbody tr');

        var costos = {};
        $.each(tCostos, function(i_c, row_c)
        {
            if($(row_c).find('td').eq(0).find('input').is(':checked'))
            {
                costos[cad + ' - ' + $(row_c).find('td').eq(1).text()] = parseFloat($(row_c).find('td').eq(2).data('mon')).toFixed(2);
            }
        });

        pr_arr.push(costos);
        datos.push(pr_arr);
    });

    var id_prov = $(btn).data('p');
    var moneda = $(btn).data('m');
    var tipo = $(btn).data('t');
    var entrega = CURRENT_PR_ENTREGA;

    $.ajax({
        type: "POST",
        url: URL,
        data: { datos : JSON.stringify(datos), id_prov : id_prov, moneda : moneda, tipo : tipo, entrega : entrega, prs : JSON.stringify(PRS), idtemp : idtemp },
        success: function(result) {
            if(result)
            {
                window.location.href = base_url + 'ordenes_compra/editar_po/' + result;
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

}

function cancelar(){
    if(confirm('¿Desea cancelar PO?'))
    {
        var URL = base_url + 'ordenes_compra/ajax_cancelarTempPO';
        $.ajax({
            type: "POST",
            url: URL,
            data: { idtemp : idtemp },
            success: function(result) {
                if(result)
                {
                    window.location.href = base_url + 'inicio';
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}



