function buscar(){
    var URL = base_url + "ordenes_compra/ajax_getRecibirPRs";
    $('#tabla tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        success: function(result) {
            if(result)
            {
                var tab = $('#tabla tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = "<button type='button' onclick='getPR(this)' value='" + elem.id +"' class='btn btn-default btn-sm'>" + elem.id + "</button>";
                    ren.insertCell().innerHTML = moment(elem.fecha).format('YYYY-MM-DD');
                    ren.insertCell().innerHTML = elem.User;
                    ren.insertCell().innerHTML = elem.prioridad;
                    ren.insertCell().innerHTML = elem.tipo;
                    ren.insertCell().innerHTML = elem.subtipo;
                    ren.insertCell().innerHTML = elem.cantidad;
                    ren.insertCell().innerHTML = elem.descripcion;
                    
                    var btn = "";
                    switch (elem.estatus)
                    {
                        case 'PENDIENTE':
                        case 'POR RECIBIR':
                        case 'EN SELECCION':
                        btn = 'btn btn-warning btn-md';
                        break;

                        case 'APROBADO':
                        case 'PO AUTORIZADA':
                        btn = 'btn btn-success btn-md';
                        break;

                        case 'RECHAZADO':
                        btn = 'btn btn-danger btn-md';
                        break;

                        case 'CERRADO':
                        case 'EN PO':
                        btn = 'btn btn-primary btn-md';
                        break;

                        case 'PROCESADO':
                        case 'CANCELADO':
                        btn = 'btn btn-default btn-md';
                        break;
                    }
                    var cell8 = ren.insertCell(8);
                    if(elem.estatus == 'POR RECIBIR')
                    {
                        cell8.innerHTML = "<button onclick='mdlRecibir(this)' value='" + elem.id + "' class='" + btn + "'>" + elem.estatus + "</a>";
                    }
                    else
                    {
                        cell8.innerHTML = "<a href='" + base_url + "compras/ver_pr/" + elem.id +"' class='" + btn + "'>" + elem.estatus + "</a>";
                    }

                    /*if(btn == "btn btn-danger btn-md")
                    {
                        cell8.innerHTML += "<a href='" + base_url + "compras/editar_pr/" + elem.id + "' class='btn btn-primary btn-md'><i class='fa fa-pencil'></i> Editar</a>";
                    }*/
                });
            }
            else
            {
                new PNotify({ title: '¡Nada por aquí!', text: 'No se encontraron resultados', type: 'info', styling: 'bootstrap3' });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
      });
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
                else{
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
                buscar();
            }
        }
    });
}