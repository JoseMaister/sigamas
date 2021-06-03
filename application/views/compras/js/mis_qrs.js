var CURRENT_QR;

function buscar(){

    var URL = base_url + "compras/ajax_getMisQRs";
    $('#tabla tbody tr').remove();
    
    $.ajax({
        type: "POST",
        url: URL,
        data: { usuario: USER },
        success: function(result) {
            if(result)
            {
                
                var tab = $('#tabla tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem)
                {
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell(0).innerHTML = "<button type='button' onclick='getQR(this)' value='" + elem.id +"' class='btn btn-default btn-xs'>" + elem.id + "</button>";
                    ren.insertCell(1).innerHTML = elem.fecha;
                    ren.insertCell(2).innerHTML = elem.prioridad;
                    ren.insertCell(3).innerHTML = elem.tipo;
                    ren.insertCell(4).innerHTML = elem.subtipo;
                    ren.insertCell(5).innerHTML = elem.cantidad;
                    ren.insertCell(6).innerHTML = elem.descripcion;
                    var btn = "";

                    switch (elem.estatus) {
                        case 'ABIERTO':
                        btn = 'btn btn-primary btn-xs';
                        break;

                        case 'LIBERADO':
                        case 'COMPRA APROBADA':
                        btn = 'btn btn-success btn-xs';
                        break;

                        case 'COTIZANDO':
                        btn = 'btn btn-warning btn-xs';
                        break;

                        case 'CANCELADO':
                        btn = 'btn btn-default btn-xs';
                        break;

                        case 'RECHAZADO':
                        case 'COMPRA RECHAZADA':
                        btn = 'btn btn-danger btn-xs';
                        break;
                    }
                    if(elem.estatus == "LIBERADO"){
                        ren.insertCell(7).innerHTML = "<button type='button' onclick='selectProv(this)' value='" + elem.id + "' class='btn btn-default btn-xs'><i class='fa fa-truck'></i> " + elem.Prov + "</button>";
                    } else {
                        ren.insertCell(7).innerHTML = "N/A";
                    }

                    var cell8 = ren.insertCell(8);
                    cell8.innerHTML = "<a href='" + base_url + "compras/ver_qr/" + elem.id + "' class='" + btn + "'>" + elem.estatus + "</a >";

                    if(btn == "btn btn-danger btn-xs")
                    {
                        cell8.innerHTML += "<a href='" + base_url + "compras/editar_qr/" + elem.id + "' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i> Editar</a>";
                    }
                    
                });
            }
          }
      });
}

function getQR(btn){
    var URL = base_url + 'compras/ajax_getDetalleQR';
    var idQR = $(btn).val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { idQR: idQR },
        success: function(result) {
            if(result)
            {
                $('#tblDetalle tr').remove();
                var tab = $('#tblDetalle tbody')[0];

                var rs = JSON.parse(result);
                var att = JSON.parse(rs['atributos']);
                
                $(".mdlTitulo").text("QR # " + rs.id);
                $("#lblRequisitor").text(rs.User);
                $("#lblFecha").text(rs.fecha);
                $("#lblCantidad").text(rs.cantidad);
                $("#lblDescripcion").text(rs.descripcion);
                $("#btnAsignarProveedor").val(rs.id);

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

function selectProv(btn){
    CURRENT_QR = $(btn).val();

    var URL = base_url + "compras/ajax_getProveedoresAsignados";
    $('#tblProveedores tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { idQR: CURRENT_QR },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblProveedores tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem) {
                    if(elem.nominado == 1)
                    {
                        var ren = tab.insertRow(tab.rows.length);
                        var check = elem.seleccionado == '1' ? 'checked' : '';

                        ren.insertCell(0).innerHTML = "<center><input type='radio' name='rbSelect' class='flat' value='" + elem.idQP + "' " + check + " ></center>";

                        var cell2 = ren.insertCell(1);
                        cell2.innerHTML = elem.monto;
                        $(cell2).formatCurrency();
                        cell2.innerHTML += " " + elem.moneda;

                        var diasH = elem.dias_habiles == 1 ? " Habiles" : " Naturales";
                        var cell3 = ren.insertCell(2);
                        cell3.innerHTML = elem.tiempo_entrega + " Dias" + diasH;

                        ren.insertCell(3).innerHTML = moment(elem.vencimiento).format("DD-MM-YYYY");

                        ren.insertCell(4).innerHTML = elem.nombre;
                    }
                });

                $('input.flat').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

    $('#mdlProveedores').modal();

}

function sugerirProveedor(){
    var URL = base_url + "compras/ajax_setProveedorSugerido";

    var qr_prov = $("input[name='rbSelect']:checked").val();
    if(qr_prov == undefined)
    {
        alert('Seleccione un proveedor');
        return;
    }

    $.ajax({
        type: "POST",
        url: URL,
        data: { qr : CURRENT_QR, qr_prov : qr_prov },
        success: function(result) {
            if(result)
            {
                new PNotify({ title: 'Proveedor Sugerido', text: 'Se han guardado los cambios', type: 'success', styling: 'bootstrap3' });
                $('#mdlProveedores').modal('hide');
            }
        },
    });
}