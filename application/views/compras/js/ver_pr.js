var CURRENT_QR_ESTATUS;
var CURRENT_QR_PROV;
var CURRENT_QR_PROV_ENTREGA;
var CURRENT_CONCEPTOS = [];

var TOTAL;

function load(){
    eventos();
    proveedorSeleccionado();
    $('#lblImporte').formatCurrency();

    $('#txtTags').tagsInput({
        width: 'auto',
        defaultText: 'correos',
    });

    verBotonCosteo();
}

var bForm = true;
function eventos(){
    $( '#mdlProveedores' ).on( 'keypress', function( e ) {
        if( e.keyCode === 13 ) {
            e.preventDefault();
            buscarProveedor();
        }
    });

    $('#frmComentarios').on('submit', function(){
        if(bForm)
        {
            bForm = false;
        }
        else
        {
            return bForm;
        }
    });
}


function proveedorSeleccionado(){

    var URL = base_url + "compras/ajax_getProveedorPR";
    $('#tblProveedores tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { id: QR_PROV },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblProveedores tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem) {
                    
                    var ren = tab.insertRow(tab.rows.length);
                    var cell0 = ren.insertCell(0);
                    cell0.innerHTML = "<button type='button' onclick='infoProveedor(this)' class='btn btn-default btn-sm' value=" + elem.id + "><i class='fa fa-info-circle'></i></button>";

                    var cell1 = ren.insertCell(1);
                    $(ren).css('color','green');
                    cell1.innerHTML = "<i class='fa fa-check'></i> " + elem.nombre;

                    var cell2 = ren.insertCell(2);
                    cell2.innerHTML = elem.total;
                    $(cell2).formatCurrency();
                    cell2.innerHTML += " " + elem.moneda;

                    var diasH = elem.dias_habiles == 1 ? " Habiles" : " Naturales";
                    var cell3 = ren.insertCell(3);
                    cell3.innerHTML = elem.tiempo_entrega + " Dias" + diasH;

                    var cell4 = ren.insertCell(4);
                    cell4.innerHTML = "<a target='_blank' href='" + base_url + 'compras/getEvidencia/' + elem.idQP + "'><img height='25px' src='" + file_image(elem.nombre_archivo) + "'></a>";

                    
                    var cell5= ren.insertCell(5);
                    cell5.innerHTML  = "<button type='button' onclick='verCosteo(this)' data-nombreprov='" + elem.nombre + "' class='btn btn-success btn-xs' value=" + elem.idQP + "><i class='fa fa-usd'></i> Costeo</button>";
                    if(AP != "1")
                    {
                        cell4.style.display = 'none';
                        cell5.style.display = 'none';
                    }

                });

                
            }

        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function infoProveedor(btn){
    var idProv = $(btn).val();
    var URL = base_url + "empresas/ajax_getProveedor"
    $.ajax({
        type: "POST",
        url: URL,
        data: { id: idProv },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);

                $("#tituloEmpresa").html(rs.nombre);

                if(rs.aprobado == "1"){
                    $("#tituloAprobado").html("Proveedor Aprobado");
                    $("#imgCertificado").show();
                }else
                {
                    //$("#tituloAprobado").html("Proveedor NO Aprobado");
                    $("#tituloAprobado").html(" ");
                    $("#imgCertificado").hide();
                }

                //TIPO
                var ul = document.getElementById("lstProveedor");
                ul.innerHTML="";
                $.each(JSON.parse(rs.tipo), function(i, elem){
                    var li = document.createElement("li");
                    li.innerHTML= elem;
                    ul.appendChild(li);
                });
                
                //FORMAS DE PAGO
                var ul = document.getElementById("lstFormasPago");
                ul.innerHTML="";
                $.each(JSON.parse(rs.formas_pago), function(i, elem){
                    var li = document.createElement("li");
                    li.innerHTML= elem;
                    ul.appendChild(li);
                });

                //FORMAS DE COMPRA
                var ul = document.getElementById("lstFormasCompra");
                ul.innerHTML="";
                $.each(JSON.parse(rs.formas_compra), function(i, elem){
                    var li = document.createElement("li");
                    li.innerHTML= elem;
                    ul.appendChild(li);
                });

                //CREDITO
                var ul = document.getElementById("lstCredito");;
                ul.innerHTML="";
                if(rs.credito == "1"){
                    var li = document.createElement("li");
                    li.innerHTML= rs.monto_credito + " " + rs.moneda_credito;
                    ul.appendChild(li);
                }else{
                    var li = document.createElement("li");
                    li.innerHTML= "N/A";
                    ul.appendChild(li);
                }

                //LUGARES DE ENTREGA
                var ul = document.getElementById("lstLugarEntrega");
                ul.innerHTML="";
                var li = document.createElement("li");
                li.innerHTML= rs.entrega;
                ul.appendChild(li);

                //TAGS
                var ul = document.getElementById("lstEtiquetas");
                ul.innerHTML="";
                var tags = rs.tags.split(",");
                $.each(tags, function(i, elem){
                    if(elem){
                    var li = document.createElement("li");
                    li.innerHTML= elem;
                    ul.appendChild(li);
                    }
                });

                //PROCESO COTIZACION
                var ul = document.getElementById("lstProcesoCotizacion");
                ul.innerHTML="";
                $.each(JSON.parse(rs.pasos_cotizacion), function(i, elem){
                    var li = document.createElement("li");
                    li.innerHTML= elem;
                    ul.appendChild(li);
                });

                //PROCESO COMPRA
                var ul = document.getElementById("lstProcesoCompra");
                ul.innerHTML="";
                $.each(JSON.parse(rs.pasos_compra), function(i, elem){
                    var li = document.createElement("li");
                    li.innerHTML= elem;
                    ul.appendChild(li);
                });                





                
                $('#mdlInfo').modal();
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function loadEstatus(estatus){
    $('#btnEstatus').val(estatus);
    $('#btnEstatus').html(estatus);

    $('#btnEstatus').removeClass();

    switch (estatus) 
    {
        case 'APROBADO':
        $('#btnEstatus').addClass('btn btn-success btn-lg');
        break;

        case 'PENDIENTE':
        edit = true;
        $('#btnEstatus').addClass('btn btn-warning btn-lg');
        break;

        case 'CANCELADO':
        $('#btnEstatus').addClass('btn btn-default btn-lg');
        break;

        case 'RECHAZADO':
        $('#btnEstatus').addClass('btn btn-danger btn-lg');
        break;
    }
    edicion(true);
}

function mdlEstatus(btn){
    var estatus = $(btn).val();
    //$('#mdlEstatus').modal();


    if(estatus == "ABIERTO"){
        $('#btnLiberar').hide();
        $('#btnRechazar').show();
        $('#btnLiberarCompra').hide();
        $('#btnRechazarCompra').hide();
        $('#mdlEstatus').modal();
    }

    if(estatus == "COTIZANDO" && LQ == "1"){
        $('#btnLiberar').show();
        $('#btnRechazar').show();
        $('#btnLiberarCompra').hide();
        $('#btnRechazarCompra').hide();
        $('#mdlEstatus').modal();
    }

    /*if(estatus == "LIBERADO" && LC == "1"){
        $('#btnLiberarCompra').show();
        $('#btnRechazarCompra').show();
        $('#btnLiberar').hide();
        $('#btnRechazar').hide();
        $('#mdlEstatus').modal();
    }*/
}

function verBotonCosteo()
{
    if(AP == "1")
    {
        $('#tblProveedores tr th:nth-child(5), #tblProveedores tr td:nth-child(5)').show();
        $('#tblProveedores tr th:nth-child(6), #tblProveedores tr td:nth-child(6)').show();
    }
    else
    {
        $('#tblProveedores tr th:nth-child(5), #tblProveedores tr td:nth-child(5)').hide();
        $('#tblProveedores tr th:nth-child(6), #tblProveedores tr td:nth-child(6)').hide();
    }
}

function edicion(onoff)
{
    verBotonCosteo();
}

function estatus_txt(estatus){
    CURRENT_QR_ESTATUS = estatus;
    var URL = base_url + 'compras/ajax_setEstatusQR';

    $.ajax({
        type: "POST",
        url: URL,
        data: { idqr : CURRENT_QR, estatus: estatus },
        success: function(result) {
            if(result)
            { 
                loadEstatus(estatus);
            }
        }
    });
}

function cambiarEstatus(btn){

    if(confirm("¿Desea continuar?"))
    {
        var estatus = $(btn).val();
        var URL = base_url + 'compras/ajax_setEstatusPR';
        $.ajax({
            type: "POST",
            url: URL,
            data: { id : CURRENT_PR, estatus: estatus },
            success: function(result) {
                if(result)
                {
                    new PNotify({ title: 'Requisición de Cotización', text: 'Se han guardado los cambios', type: 'success', styling: 'bootstrap3' });
                    $('#mdlEstatus').modal('hide');
                    //$("#divBotones").fadeOut();
                    //loadEstatus(estatus);
                    window.location.href = base_url + 'compras/ver_pr/'+CURRENT_PR;
                }
            }
        });
    }
}

function mdlComentarios()
{
    $('#btnAgregarComentario').show();
    $('#btnConfirmarRechazo').hide();
    $('#mdlComentarios').modal();
}

function mdlRechazar(btn)
{
    var estatus = $(btn).val();
    $('#btnConfirmarRechazo').val(estatus);

    $('#btnConfirmarRechazo').show();
    $('#btnAgregarComentario').hide();
    $('#mdlEstatus').modal('hide');
    $('#mdlComentarios').modal();
}

function estatus_msj(btn){

    var estatus = $(btn).val();
    var comentario = $('#txtComentarios').val();
    var txtTags = $('#txtTags').val();

    if(comentario.length < 10)
    {
        alert('Minimo 10 caracteres');
        return;
    }
    
    var URL = base_url + 'compras/ajax_setEstatusMsjPR';

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : CURRENT_PR, estatus: estatus, comentario: comentario, txtTags : txtTags },
        success: function(result) {
            if(result)
            {
                $('#mdlComentarios').modal('hide');
                //loadEstatus(estatus);
                window.location.href = base_url + 'compras/ver_pr/' + CURRENT_PR;
            }
        }
    });
}

function mdlRechazar(btn)
{
    var estatus = $(btn).val();
    $('#btnConfirmarRechazo').val(estatus);

    $('#btnConfirmarRechazo').show();
    $('#btnAgregarComentario').hide();
    $('#mdlEstatus').modal('hide');
    $('#mdlComentarios').modal();
}

function calculoImporte(btn)
{
    var qty = $(btn).val();
    var precio = document.getElementById('lblImporte').dataset.pu;
    
    if(qty == "" | qty <= 0)
    {
        $(btn).val("1");
        qty = 1;
    }

    var importe = qty * precio;

    $('#lblImporte').html(importe);
    $('#lblImporte').formatCurrency();
}

function editar(){
    if(confirm("¿Desea continuar?"))
    {
        var qty = $("#txtQty").val();
        var URL = base_url + 'compras/ajax_editarPR';

        $.ajax({
            type: "POST",
            url: URL,
            data: { id : CURRENT_PR, qty: qty },
            success: function(result) {
                if(result) {
                    window.location.href = base_url + 'compras/mis_prs/';
                }
                else {
                    alert("Error");
                }
            }
        });
    }
}

function verCosteo(btn){
    $('#tblCosteo tbody tr').remove();
    CURRENT_QR_PROV = $(btn).val();

    var nombreProv = btn.dataset.nombreprov;
    var URL = base_url + 'compras/ajax_getProveedor';

    $.ajax({
        type: "POST",
        url: URL,
        data: { id: CURRENT_QR_PROV },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                var costos = JSON.parse(rs.costos);

                var tab = $('#tblCosteo tbody')[0];
                $.each(costos, function(i, elem){

                    var ren = tab.insertRow(tab.rows.length);
                    var cell1 = ren.insertCell(0); cell1.style.width = "75%";
                    var cell2 = ren.insertCell(1); cell2.style.textAlign = "right";

                    cell1.innerHTML = i;
                    cell2.innerHTML = elem; cell2.dataset.monto = elem; $(cell2).formatCurrency();
                });

    
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

    $('#mdlCosteoTitulo').html(nombreProv);
    $('#mdlCosteo').modal();
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

