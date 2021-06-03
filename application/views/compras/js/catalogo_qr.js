var CURRENT_ASIGNADOS;
var CURRENT_QR;
var CURRENT_ROW;
var CURRENT_SUBTIPO;

function buscar(){
    var URL = base_url + "compras/ajax_getQRs";
    $('#tabla tbody tr').remove();
    
    var parametro = $("input[name=rbBusqueda]:checked").val();
    var texto = $("#txtBusqueda").val();

    var prioridad = [];
    if($('#cbNormal').is(':checked'))
    {
        prioridad.push('NORMAL');
    }
    if($('#cbUrgente').is(':checked'))
    {
        prioridad.push('URGENTE');
    }
    if($('#cbInfoUrgente').is(':checked'))
    {
        prioridad.push('INFO URGENTE');
    }

    var tipo = [];
    if($('#cbProducto').is(':checked'))
    {
        tipo.push('PRODUCTO');
    }
    if($('#cbServicio').is(':checked'))
    {
        tipo.push('SERVICIO');
    }


    var estatus = $('#opEstatus').val();
    
    var user = $('#cbMisQrs').is(':checked') ? "1" : "0";

    $.ajax({
        type: "POST",
        url: URL,
        data: { prioridad: JSON.stringify(prioridad), tipo: JSON.stringify(tipo), estatus: estatus, texto : texto, parametro : parametro, usuario : user },
        success: function(result) {
            if(result)
            {
                var tab = $('#tabla tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell(0).innerHTML = "<button type='button' onclick='getQR(this)' value='" + elem.id +"' class='btn btn-default btn-xs'>" + elem.id + "</button>";
                    ren.insertCell(1).innerHTML = moment(elem.fecha).format('YYYY-MM-DD');
                    ren.insertCell(2).innerHTML = elem.User;
                    ren.insertCell(3).innerHTML = elem.prioridad;
                    ren.insertCell(4).innerHTML = elem.tipo;
                    ren.insertCell(5).innerHTML = elem.subtipo;
                    ren.insertCell(6).innerHTML = elem.cantidad;
                    ren.insertCell(7).innerHTML = elem.descripcion;

                    if(elem.estatus == "LIBERADO" && ((elem.destino == "VENTA" && V == "1") | (elem.destino == "CONSUMO INTERNO" && I == "1") | RV == "1") ){
                        ren.insertCell(8).innerHTML = "<button type='button' onclick='selectPropuesta(this)' value='" + elem.id + "' class='btn btn-default btn-xs'><i class='fa fa-file-text-o'></i></button>";
                    } else {
                        ren.insertCell(8).innerHTML = "N/A";
                    }
                    
                    var btn = "";
                    switch (elem.estatus)
                    {
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
                    var cell9 = ren.insertCell(9);
                    //cell9.innerHTML = "<a href='" + base_url + "compras/ver_qr/"+ elem.id +"' class='" + btn + "'>" + elem.estatus + "</a>";
                    cell9.innerHTML = boton(elem.estatus, elem.id, btn, elem.usuario == usuario);
                    
                    if(btn == "btn btn-danger btn-xs" && elem.usuario == usuario)
                    {
                        //cell9.innerHTML += "<a href='" + base_url + "compras/editar_qr/" + elem.id + "' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i> Editar</a>";
                    }
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

function boton(estatus, id, clss, editar){

    opcs = "<ul role='menu' class='dropdown-menu'>";
    opcs += "<li><a href='" + base_url + "compras/ver_qr/"+ id +"'><i class='fa fa-eye'></i> Ver</a></li>";
    opcs += "<li><a href='" + base_url + "compras/clonar_qr/" + id + "'><i class='fa fa-copy'></i> Clonar</a></li>";
    if(clss == "btn btn-danger btn-xs" && editar)
    {
        opcs += "<li><a href='" + base_url + "compras/editar_qr/" + id + "'><i class='fa fa-pencil'></i> Editar</a></li>";
    }
    
    clss += " dropdown";
    
    var btn = "<div class='btn-group'><button type='button' data-toggle='dropdown' class='" + clss + "'>" + estatus + "  <span class='caret'></span></button>";
    btn += opcs;
    return btn;


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
                $("#lblDestino").html('Destino: <small>' + rs.destino + '</small>');
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

                if(rs.nombre_archivo)
                {
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell(0).innerHTML = "Archivo";
                    ren.insertCell(1).innerHTML = "<a target='_blank' href='" + base_url + 'compras/getQrFile/' + rs.id + "'><img height='25px' src='" + file_image(rs.nombre_archivo) + "'> <u>" + rs.nombre_archivo + "</u></a>";
                }

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

function getDetalle(idQR, URL){
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

                $.each(att, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell(0).innerHTML = i[0].toUpperCase() + i.slice(1);
                    ren.insertCell(1).innerHTML = elem;
                });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
      });
      $("#mdlDetalle").modal();
}

function selectPropuesta(btn){
    CURRENT_QR = $(btn).val();
    $('#txtQtySolicitud').val("0");

    $('#tblProveedores tr th:nth-child(6), #tblProveedores tr td:nth-child(6)').hide();

    var URL = base_url + "compras/ajax_getPropuestas";
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
                        if(moment(elem.vencimiento) > moment(new Date()))
                        {
                            ren.insertCell(0).innerHTML = "<center><input type='radio' name='rbSelect' class='flat' value='" + elem.idQP + "' " + check + " ></center>";
                        }
                        else
                        {
                            ren.style = "color: red;";
                            ren.insertCell(0).innerHTML = "VENC.";
                        }

                        var cell2 = ren.insertCell(1);
                        cell2.innerHTML = elem.total;
                        $(cell2).formatCurrency();
                        cell2.innerHTML += " " + elem.moneda;

                        var diasH = elem.dias_habiles == 1 ? " Habiles" : " Naturales";
                        var cell3 = ren.insertCell(2);
                        cell3.innerHTML = elem.tiempo_entrega + " Dias" + diasH;

                        ren.insertCell(3).innerHTML = moment(elem.vencimiento).format("DD-MM-YYYY");

                        ren.insertCell(4).innerHTML = elem.nombre;

                        var rma = "N/A"
                        if(elem.tipo == "SERVICIO")
                        {
                            rma = elem.rma_requerido == "1" ? "SI" : "NO";

                            if(elem.rma_requerido == "1")
                            {
                                $('#tblProveedores tr th:nth-child(6), #tblProveedores tr td:nth-child(6)').show();
                            }
                        }
                        ren.insertCell(5).innerHTML = rma;
                        ren.insertCell(6).innerHTML = elem.entrega;

                        //var arc = "<a target='_blank' href='" + base_url + 'compras/getEvidencia/' + elem.idQP + "'><img height='25px' src='" + file_image(elem.nombre_archivo) + "'></a>";
                        ren.insertCell(7).innerHTML = "<a target='_blank' href='" + base_url + 'compras/getEvidencia/' + elem.idQP + "'><img height='25px' src='" + file_image(elem.nombre_archivo) + "'></a>";

                        if(C == "1" | L == "1" | RV =="1") //COMPRADOR QR o LIBERADOR QR o REVISAR QR
                        {
                            $('#tblProveedores tr th:nth-child(8), #tblProveedores tr td:nth-child(8)').show();
                        }
                        else
                        {
                            $('#tblProveedores tr th:nth-child(8), #tblProveedores tr td:nth-child(8)').hide();
                        }

                    }
                    
                    $('#txtQtySolicitud').val(elem.cantidad);
                    $('#txtDescripcion').val(elem.descripcion);
                    $('#txtItem').val("");
                    $('#txtID').val("");
                    $('#txtSerie').val(elem.Serie);
                    CURRENT_SUBTIPO = elem.subtipo;
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

    cargarComentariosModalQR(CURRENT_QR);

    $('#mdlCotizaciones').modal();

}

function cargarComentariosModalQR(id_QR){
    var URL = base_url + "compras/ajax_getQRComentarios";
    
    $('#ulComments').html("");
    
    $.ajax({
        type: "POST",
        url: URL,
        data: { qr : id_QR },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var c = '<li>'
                    +    '<a>'
                    +        '<span>'
                    +            '<b>' + elem.User + '</b> ' + moment(elem.fecha).format('D/MM/YYYY h:mm A') + '</span>'
                    +        '</span>'
                    +        '<span class="message">' + elem.comentario + '</span>'
                    +    '</a>'
                    +'</li>';
                    $('#ulComments').append(c);
                });

                $('#mdlComentarios').modal();
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function mdlConfirmarPR(){
    var qty = $('#txtQtySolicitud').val();
    var qr_prov = $("input[name='rbSelect']:checked").val();
    if(qr_prov == undefined)
    {
        alert('Seleccione un proveedor');
        return;
    }
    if(qty <= 0)
    {
        alert('La cantidad debe ser mayor a 0');
        return;
    }

    $('#tblPRs tbody tr').remove();
    var URL = base_url + "compras/ajax_getPRS_QR";
    $.ajax({
        type: "POST",
        url: URL,
        data: { id_qr : CURRENT_QR },
        success: function(result) {
            if(result)
            {
                $('#mdlCotizaciones').modal('hide');

                var tab = $('#tblPRs tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem) {
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell(0).innerHTML = "<button type='button' value='" + elem.id +"' class='btn btn-default btn-sm'>" + elem.id + "</button>";
                    ren.insertCell(1).innerHTML = elem.fecha;
                    ren.insertCell(2).innerHTML = elem.User;
                    ren.insertCell(3).innerHTML = "<button type='button' class='btn btn-warning btn-sm'>" + elem.estatus + "</a>";
                });

                $('#lblPRRecientes').text("QR " + CURRENT_QR + ": PR's Recientes");

                $('#mdlConfirmarPR').modal();
            }
            else
            {
                generarPR();
            }
        },
    });


}

function generarPR(){
    ////modal DESCRIPCION
    $('#mdlCotizaciones').modal('hide');
    $('#mdlConfirmarPR').modal('hide');
    if(CURRENT_SUBTIPO == "CALIBRACION")
    {
        $('#mdlDescripcionQR').modal();
    }
    else
    {
        if(confirm("¿Desea continuar?"))
        {
            registrarPR();
        }
    }
}

function registrarPR(){
    var URL = base_url + "compras/ajax_generarPR";
    
    var qty = $('#txtQtySolicitud').val();
    var qr_prov = $("input[name='rbSelect']:checked").val();

    var descripcion = $('#txtDescripcion').val().trim();
    var serie = $('#txtSerie').val().trim();

    var id = $('#txtID').val().trim();
    var item = $('#txtItem').val().trim();

    if(qr_prov == undefined)
    {
        alert('Seleccione un proveedor');
        return;
    }
    if(qty <= 0)
    {
        alert('La cantidad debe ser mayor a 0');
        return;
    }

    $.ajax({
        type: "POST",
        url: URL,
        data: { qr : CURRENT_QR, qr_prov : qr_prov, qty : qty, descripcion : descripcion, serie : serie, id : id, item : item },
        success: function(result) {
            if(result)
            {
                new PNotify({ title: 'Nueva PR', text: 'Se ha generado PR #' + result, type: 'success', styling: 'bootstrap3' });
                $('#mdlDescripcionQR').modal('hide');
            }
        },
    });
}

function file_image(archivo) {
    if(archivo)
    {
        var ext = archivo.split('.');
        ext = ext[ext.length - 1];
        ext = ext.toLowerCase();

        switch (ext)
        {
            case "avi":
                return base_url + "template/images/files/avi.png";
            case "css":
                return base_url + "template/images/files/css.png";
            case "csv":
                return base_url + "template/images/files/csv.png";
            case "dbf":
                return base_url + "template/images/files/dbf.png";
            case "doc":
                return base_url + "template/images/files/doc.png";
            case "docx":
                return base_url + "template/images/files/doc.png";
            case "dwg":
                return base_url + "template/images/files/dwg.png";
            case "exe":
                return base_url + "template/images/files/exe.png";
            case "html":
                return base_url + "template/images/files/html.png";
            case "iso":
                return base_url + "template/images/files/iso.png";
            case "js":
                return base_url + "template/images/files/js.png";
            case "jpeg":
                return base_url + "template/images/files/jpg.png";
            case "jpg":
                return base_url + "template/images/files/jpg.png";
            case "json":
                return base_url + "template/images/files/json.png";
            case "mp3":
                return base_url + "template/images/files/mp3.png";
            case "mp4":
                return base_url + "template/images/files/mp4.png";
            case "pdf":
                return base_url + "template/images/files/pdf.png";
            case "png":
                return base_url + "template/images/files/png.png";
            case "ppt":
                return base_url + "template/images/files/ppt.png";
            case "pptx":
                return base_url + "template/images/files/ppt.png";
            case "ppsx":
                return base_url + "template/images/files/ppt.png";
            case "psd":
                return base_url + "template/images/files/psd.png";
            case "rtf":
                return base_url + "template/images/files/rtf.png";
            case "search":
                return base_url + "template/images/files/search.png";
            case "rar":
                return base_url + "template/images/files/rar.png";
            case "svg":
                return base_url + "template/images/files/svg.png";
            case "txt":
                return base_url + "template/images/files/txt.png";
            case "xls":
                return base_url + "template/images/files/xls.png";
            case "xlsx":
                return base_url + "template/images/files/xls.png";
            case "xml":
                return base_url + "template/images/files/xml.png";
            case "zip":
                return base_url + "template/images/files/zip.png";
            default:
                return base_url + "template/images/files/file.png";
        }
    }
}