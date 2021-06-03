var CURRENT_QR_ESTATUS;
var CURRENT_QR_PROV;
var CURRENT_QR_PROV_ENTREGA;
var CURRENT_CONCEPTOS = [];

var TOTAL;

function load(){
    eventos();
    init_calendario();
    proveedoresAsignados();

    $('#txtTags').tagsInput({
        width: 'auto',
        defaultText: 'correos',
    });

    $('#lblComentarios').html(detectURL($('#lblComentarios').html()));
}

function init_calendario() {
    var options = {
            singleDatePicker: true,
            singleClasses: 'picker_4',
            startDate: moment().add(30, 'days'),
            locale: {
                applyLabel: 'Aplicar',
                cancelLabel: 'Cancelar',
                fromLabel: 'De',
                toLabel: 'A',
                customRangeLabel: 'Personalizado',
                daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                firstDay: 1
            }
        };
            
    $('#txtVencimiento').daterangepicker(options);
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

function modalAsignarProveedor(){
    $('#mdlBusquedaTitulo').text('QR # ' + CURRENT_QR);
    $('#divBusqueda').show();
    $("#mdlProveedores").modal();
}

function buscarProveedor(){
    var URL = base_url + "/compras/ajax_getProveedores";
    $('#tblBuscarProveedores tr').remove();
    var texto = $("#txtBuscarProveedor").val();
    texto = texto.trim();
    
    if(texto)
    {
        $.ajax({
            type: "POST",
            url: URL,
            data: { texto: texto },
            success: function(result) {
                if(result)
                {
                    var tab = $('#tblBuscarProveedores tbody')[0];
                    var rs = JSON.parse(result);
                    $.each(rs, function(i, elem){
                        var ren = tab.insertRow(tab.rows.length);
                        var cell_id = ren.insertCell(0);
                        cell_id.style.display = "none";
                        cell_id.innerHTML = elem.id;
                        var cell = ren.insertCell(1);
                        cell.innerHTML = elem.nombre;
                        cell.style.width = "70%";
                        ren.insertCell(2).innerHTML = "<button type='button' onclick='infoProveedor(this)' class='btn btn-default btn-xs' value=" + elem.id + "><i class='fa fa-info-circle'></i> Info </button> <button type='button' onclick='asignarProveedor(this)' class='btn btn-primary btn-xs' data-empresa=" + elem.empresa + " value=" + elem.id + "><i class='fa fa-plus'></i> Asignar</button>";
                    });
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}

function buscarProveedorMarca(btn){
    $('#divBusqueda').hide();
    var URL = base_url + "/compras/proveedoresSugeridosMarca";
    $('#tblBuscarProveedores tr').remove();
    var texto = $(btn).text().trim();
    var hayResultado = false;
    $('#mdlBusquedaTitulo').text('Buscar por Marca: "' + texto +'"');

    if(texto)
    {
        $.ajax({
            type: "POST",
            url: URL,
            data: { tags: texto },
            success: function(result) {
                var tab = $('#tblBuscarProveedores tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){

                    hayResultado = true;
                    var ren = tab.insertRow(tab.rows.length);
                    var cell_id = ren.insertCell(0);
                    cell_id.style.display = "none";
                    cell_id.innerHTML = elem.id;

                    var cell = ren.insertCell(1);
                    cell.innerHTML = "<button type='button' onclick='infoProveedor(this)' class='btn btn-default btn-xs' value=" + elem.id + "><i class='fa fa-info-circle'></i></button>" + elem.nombre;
                    cell.style.width = "70%";

                    var cell = ren.insertCell(2);
                    cell.innerHTML = "<button type='button' onclick='resumenMarca(this)' data-nombreprov='"+ elem.nombre +"' data-marca=" + texto + " class='btn btn-default btn-xs' value=" + elem.id + "><i class='fa fa-shopping-cart'></i> " + elem.QtyQr + " </button>";
                    
                    ren.insertCell(3).innerHTML = "<button type='button'  onclick='asignarProveedor(this)' class='btn btn-primary btn-xs' data-empresa=" + elem.id + " value=" + elem.id + "><i class='fa fa-plus'></i> Asignar</button>";
                });

                if(!hayResultado)
                {
                    $('#mdlBusquedaTitulo').text('No existen resultados de busqueda');
                }
                $("#mdlProveedores").modal();
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}

function buscarProveedorModelo(btn){
    $('#divBusqueda').hide();
    var URL = base_url + "/compras/proveedoresSugeridosModelo";
    $('#tblBuscarProveedores tr').remove();
    var texto = $(btn).text().trim();
    var hayResultado = false;
    $('#mdlBusquedaTitulo').text('Buscar por Modelo: "' + texto +'"');
    if(texto)
    {
        $.ajax({
            type: "POST",
            url: URL,
            data: { tags: texto },
            success: function(result) {
                var tab = $('#tblBuscarProveedores tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){

                    hayResultado = true;
                    var ren = tab.insertRow(tab.rows.length);
                    var cell_id = ren.insertCell(0);
                    cell_id.style.display = "none";
                    cell_id.innerHTML = elem.id;

                    var cell = ren.insertCell(1);
                    cell.innerHTML = "<button type='button' onclick='infoProveedor(this)' class='btn btn-default btn-xs' value=" + elem.id + "><i class='fa fa-info-circle'></i></button>" + elem.nombre;
                    cell.style.width = "70%";

                    var cell = ren.insertCell(2);
                    cell.innerHTML = "<button type='button' onclick='resumenModelo(this)' data-nombreprov='"+ elem.nombre +"' data-modelo=" + texto + " class='btn btn-default btn-xs' value=" + elem.id + "><i class='fa fa-shopping-cart'></i> " + elem.QtyQr + " </button>";
                    
                    ren.insertCell(3).innerHTML = "<button type='button' onclick='asignarProveedor(this)' class='btn btn-primary btn-xs' data-empresa=" + elem.id + " value=" + elem.id + "><i class='fa fa-plus'></i> Asignar</button>";
                });

                if(!hayResultado)
                {
                    $('#mdlBusquedaTitulo').text('No existen resultados de busqueda');
                }
                $("#mdlProveedores").modal();
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}

function proveedoresAsignados(){
    var URL = base_url + "compras/ajax_getProveedoresAsignados";
    $('#tblProveedores tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { idQR: CURRENT_QR },
        success: function(result) {
            if(result)
            {
                var hayProv = false;
                var tab = $('#tblProveedores tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem) {
                    if(ED == "1" | elem.nominado == "1" | elem.seleccionado == "1")
                    {
                        hayProv = true;
                        var ren = tab.insertRow(tab.rows.length);
                        var cell0 = ren.insertCell(0);
                        cell0.innerHTML = "<button type='button' onclick='infoProveedor(this)' class='btn btn-default btn-sm' value=" + elem.id + "><i class='fa fa-info-circle'></i></button>";

                        var cell1 = ren.insertCell(1);
                        if(elem.nominado == "1")
                        {
                            $(ren).css('color','green');
                            cell1.innerHTML = "<i class='fa fa-check'></i> " + elem.nombre;
                        }
                        else
                        {
                            cell1.innerHTML = elem.nombre;
                        }

                        var cell2 = ren.insertCell(2);
                        cell2.innerHTML = elem.total;
                        $(cell2).formatCurrency();
                        cell2.innerHTML += " " + elem.moneda;

                        var diasH = elem.dias_habiles == 1 ? " Habiles" : " Naturales";
                        var cell3 = ren.insertCell(3);
                        cell3.innerHTML = elem.tiempo_entrega + " Dias" + diasH;
                        
                        ren.insertCell(4).innerHTML = "<button type='button' onclick='construirPrecio(this)' data-nombreprov='" + elem.nombre + "' class='btn btn-success btn-xs' value=" + elem.idQP + "><i class='fa fa-usd'></i> Costeo</button> <button type='button' onclick='eliminarProveedor(this)' class='btn btn-danger btn-xs' value=" + elem.id + "><i class='fa fa-trash'></i> Eliminar</button>";
                        
                        var cell5 = ren.insertCell(5);
                        cell5.innerHTML  = "<button type='button' onclick='verCosteo(this)' data-nombreprov='" + elem.nombre + "' class='btn btn-success btn-xs' value=" + elem.idQP + "><i class='fa fa-usd'></i> Costeo</button>";
                        cell5.style.display = 'none';
                    }

                });

                
            }

            if(hayProv && CURRENT_QR_ESTATUS == "ABIERTO"){
                estatus_txt("COTIZANDO");
            }else
            {
                loadEstatus(CURRENT_QR_ESTATUS);
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function asignarProveedor(btn){
    var idProv = $(btn).val();
    
    var URL = base_url + "compras/ajax_setProveedor";

    $.ajax({
        type: "POST",
        url: URL,
        data: { idQR : CURRENT_QR, idProv: idProv },
        success: function(result) {
            if(result)
            {
                $("#txtBuscarProveedor").val("");
                proveedoresAsignados();
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function eliminarProveedor(btn){
    var idProv = $(btn).val();

    var URL = base_url + 'compras/ajax_eliminarProveedor';

    if(confirm("¿Desea eliminar proveedor?"))
    {
        $.ajax({
            type: "POST",
            url: URL,
            data: { qr : CURRENT_QR, empresa : idProv },
            success: function(result) {
                if(result)
                {
                    var ren = $(btn).closest('tr');
                    ren.remove();
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
        
    }
}

////PROVEEDORES 
/*function getDetalleProveedores(btn){
    CURRENT_QR = $(btn).val();
    $(".mdlTitulo").text("QR # " + CURRENT_QR);
    var URL = base_url + 'compras/ajax_getProveedoresAsignados';
    
    $.ajax({
        type: "POST",
        url: URL,
        data: { idQR: CURRENT_QR },
        success: function(result) {
            if(result)
            {
                //var tab = $('#tblProveedoresAsignados tbody')[0];
                var rs = JSON.parse(result);
                CURRENT_QR_PROV_ENTREGA = rs.entrega;

                table = '<div class="panel">'
                $.each(rs, function(COUNT, elem) {
                    
                    table +=   '<a class="panel-heading collapsed" role="tab" id="headingOne' + COUNT + '" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne' + COUNT + '" aria-expanded="false" aria-controls="collapseOne">'
                    table +=   '<h4 class="panel-title"><i class="fa fa-bars"></i> ' + elem.nombre + '</h4>'
                    table +=   '</a>'
                    table +=   '<div id="collapseOne' + COUNT + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">'
                    table +=   '<div class="panel-body">'
                    table +=       '<table class="table table-striped">'
                    table +=       '<thead>'
                    table +=           '<tr>'
                    table +=               '<th style="width: 15%">Precio Unitario</th>'
                    table +=               '<th style="width: 15%">Tiempo de Entrega</th>'
                    table +=               '<th>Dias Habiles</th>'
                    table +=               '<th style="width: 60%">Comentarios</th>'
                    table +=           '</tr>'
                    table +=           '<tr class="capturaProveedor" data-id="' + elem.idQP + '">'
                    table +=               '<td><input style="width: 80%" type="number" value="' + elem.precio_unitario + '"/></td>'
                    table +=               '<td><input style="width: 80%" type="number" value="' + elem.tiempo_entrega + '"/></td>'
                    table +=               '<td><input type="checkbox"/></td>'
                    table +=               '<td><textarea style="width: 95%">' + elem.comentarios + '</textarea></td>'
                    table +=           '</tr>'
                    table +=       '</thead>'
                    table +=       '<tbody>'
                    table +=       '</tbody>'
                    table +=       '</table>'
                    table +=   '</div>'
                    table +=   '</div>'
                });
                table += '</div>'
                $('#acordeon').html(table);
                $('#mdlDetalleProveedores').modal();
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

    
}*/

function construirPrecio(btn){
    $('#tblPrecios tbody tr').remove();
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
                CURRENT_QR_PROV_ENTREGA = rs.entrega;
                var costos = JSON.parse(rs.costos);

                $('#opMoneda').val(rs.moneda);
                $('#txtEntrega').val(rs.tiempo_entrega);
                $("#cbDiasHabiles").iCheck(rs.dias_habiles == 1 ? 'check' : 'uncheck');
                $('#txtVencimiento').val(moment(rs.vencimiento).format('MM/DD/YYYY'));
                $('#lnkArchivo').prop('href', base_url + 'compras/getEvidencia/' + CURRENT_QR_PROV);

                if(rs.nombre_archivo)
                {
                    $("#imgArchivo").attr("src", file_image(rs.nombre_archivo));
                    $("#divArchivo").show();
                    $("#btnArchivo").hide();
                    $("#btnBorrarArchivo").show();
                }
                else
                {
                    $("#btnArchivo").show();
                    $("#btnBorrarArchivo").hide();
                    $("#divArchivo").hide();
                }
                $("#lblArchivo").html("<u>" + rs.nombre_archivo + "</u>");

                
                $("#opConcepto option").show();

                var tab = $('#tblPrecios tbody')[0];
                $.each(costos, function(i, elem){
                    $("#opConcepto option[value='" + i + "']").hide();
                    var ren = tab.insertRow(tab.rows.length);
                    var cell1 = ren.insertCell(0); cell1.style.width = "75%";
                    var cell2 = ren.insertCell(1); cell2.style.textAlign = "right";
                    var cell3 = ren.insertCell(2);

                    cell1.innerHTML = i;
                    cell2.innerHTML = elem; cell2.dataset.monto = elem; $(cell2).formatCurrency();
                    cell3.innerHTML = "<button type='button' onclick='eliminarCosto(this)' data-concepto='" + i + "' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> Eliminar</button>";
                });

                $("#opConcepto").val('');
                var op = $("#opConcepto option");
                $.each(op, function(i, elem){
                    if(elem.style.display != 'none')
                    {
                        $("#opConcepto").val(elem.value);
                        return false;
                    }
                });

                sumarTotal();      
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

    $('#lblTituloMdlPrecio').html(nombreProv);
    $('#mdlPrecio').modal();
}

function agregarCosto(){
    var concepto = $('#opConcepto').val();
    var monto = $('#txtCostoConcepto').val();
    $('#txtCostoConcepto').val("0.00");

    if(monto && concepto){
        var tab = $('#tblPrecios tbody')[0];
        var ren = tab.insertRow(tab.rows.length);
        var cell1 = ren.insertCell(0); cell1.style.width = "75%";
        var cell2 = ren.insertCell(1); cell2.style.textAlign = "right";
        var cell3 = ren.insertCell(2);

        cell1.innerHTML = concepto;
        cell2.innerHTML = monto;
        cell2.dataset.monto = monto;
        $(cell2).formatCurrency();
        cell3.innerHTML = "<button type='button' onclick='eliminarCosto(this)' data-concepto='" + concepto + "' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> Eliminar</button>";
        $("#opConcepto option[value='" + concepto + "']").hide();
        
        $("#opConcepto").val('');
        var op = $("#opConcepto option");
        $.each(op, function(i, elem){
            if(elem.style.display != 'none')
            {
                $("#opConcepto").val(elem.value);
                return false;
            }
        });

        sumarTotal();
    }

    
}

function eliminarCosto(btn){
    if(confirm("¿Desea eliminar costo?")){
        var ren = $(btn).closest('tr');
        var con = btn.dataset.concepto;
        ren.remove();

        var op = $("#opConcepto option");
        $.each(op, function(i, elem){
            if(elem.value == con)
            {
                $(elem).show();
                return false;
            }
        });

        sumarTotal();
    }
}

function guardarCostos(){
    var conceptos = {};
    var datos = [];
    var URL = base_url + 'compras/guardarProveedores';

    

    var factor = 1;
    if(DESTINO == "VENTA")
    {
        if(CURRENT_QR_PROV_ENTREGA == "MEXICO")
        {
            factor = 1.19;
        }
        else if(CURRENT_QR_PROV_ENTREGA == "USA")
        {
            factor = 1.35;
        }
    }
    

    var rows = $('#tblPrecios tr');
    $.each(rows,function(i, elem){
        var concepto = elem.children[0].innerHTML;
        var monto = elem.children[1].dataset.monto;

        conceptos[concepto] = monto;
    });
    
    var tupla = {
        costos: JSON.stringify(conceptos),
        tiempo_entrega: $('#txtEntrega').val(),
        dias_habiles: "1",
        vencimiento: moment($('#txtVencimiento').val()).format('YYYY-MM-DD'),
        factor: factor,
        moneda: $('#opMoneda').val(),
        monto: $('#lblTotal').data('total'),
        total: $('#lblTotal').data('total') * factor,
        id: CURRENT_QR_PROV,
    }
    datos.push(tupla);

    $.ajax({
        type: "POST",
        url: URL,
        data: { datos: JSON.stringify(datos) },
        success: function(result) {
            if(result)
            {
                new PNotify({ title: 'Requisición de Cotización', text: 'Se han guardado los cambios', type: 'success', styling: 'bootstrap3' });
                $('#mdlPrecio').modal('hide');
                proveedoresAsignados();
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });    
}

function sumarTotal(){
    TOTAL = 0;
    var rows = $('#tblPrecios tr');
    $.each(rows,function(i, elem){
        var monto = elem.children[1].dataset.monto;
        TOTAL += parseFloat(monto);
    });
    TOTAL = TOTAL.toFixed(2);
    $('#lblTotal').html(TOTAL);
    $('#lblTotal').formatCurrency();
    $('#lblTotal').data('total', TOTAL);
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

    var edit = false;
    switch (estatus) 
    {
        case 'ABIERTO':
        edit = true;
        $('#btnEstatus').addClass('btn btn-primary btn-lg');
        break;

        case 'LIBERADO':
        case 'COMPRA APROBADA':
        $('#btnEstatus').addClass('btn btn-success btn-lg');
        break;

        case 'COTIZANDO':
        edit = true;
        $('#btnEstatus').addClass('btn btn-warning btn-lg');
        break;

        case 'CANCELADO':
        $('#btnEstatus').addClass('btn btn-default btn-lg');
        break;

        case 'RECHAZADO':
        case 'COMPRA RECHAZADA':
        $('#btnEstatus').addClass('btn btn-danger btn-lg');
        break;
    }
    edicion(edit);
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

function seleccionarProveedor(){
    $("#btnLiberarProv").show();
    $("#btnLiberarCompraProv").hide();

    $('#mdlEstatus').modal('hide');

    var URL = base_url + "compras/ajax_getProveedoresAsignados";
    $('#tblSelectProveedores tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { idQR: CURRENT_QR },
        success: function(result) {
            var hayProveedor = false;
            
            if(result)
            {
                var tab = $('#tblSelectProveedores tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem) {
                    
                    if(elem.total > 0 && elem.nombre_archivo)
                    {
                        hayProveedor = true;
                        var ren = tab.insertRow(tab.rows.length);
                        ren.insertCell(0).innerHTML = "<center><input type='checkbox' class='flat' value='" + elem.idQP + "'></center>";
                        ren.insertCell(1).innerHTML = elem.nombre;

                        var cell2 = ren.insertCell(2);
                        cell2.innerHTML = elem.total;
                        $(cell2).formatCurrency();
                        cell2.innerHTML += " " + elem.moneda;

                        var diasH = elem.dias_habiles == 1 ? " Habiles" : " Naturales";
                        var cell3 = ren.insertCell(3);
                        cell3.innerHTML = elem.tiempo_entrega + " Dias" + diasH;
                    }
                });

                $('input.flat').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });

            }

            if(hayProveedor)
            {
                $('#mdlSelectProveedor').modal();
            }
            else 
            {
                alert('No hay proveedores listos para selección');
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

    
}

function liberarProveedor(){
    $("#btnLiberarProv").hide();
    $("#btnLiberarCompraProv").show();

    $('#mdlEstatus').modal('hide');

    var URL = base_url + "compras/ajax_getProveedoresAsignados";
    $('#tblSelectProveedores tbody tr').remove();
    var hayProveedor = false;

    $.ajax({
        type: "POST",
        url: URL,
        data: { idQR: CURRENT_QR },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblSelectProveedores tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem) {
                    if(elem.nominado == 1)
                    {
                        hayProveedor = true;
                        var ren = tab.insertRow(tab.rows.length);
                        var check = elem.seleccionado == '1' ? 'checked' : '';

                        ren.insertCell(0).innerHTML = "<center><input type='radio' name='rbSelect' class='flat' value='" + elem.idQP + "' " + check + " ></center>";
                        var cellNombre = ren.insertCell(1);
                        cellNombre.innerHTML = elem.nombre;
                        if(check)
                        {
                            cellNombre.innerHTML += " <i>[Sugerencia de Usuario]</i>";
                        }

                        var cell2 = ren.insertCell(2);
                        cell2.innerHTML = elem.monto;
                        $(cell2).formatCurrency();
                        cell2.innerHTML += " " + elem.moneda;

                        var diasH = elem.dias_habiles == 1 ? " Habiles" : " Naturales";
                        var cell3 = ren.insertCell(3);
                        cell3.innerHTML = elem.tiempo_entrega + " Dias" + diasH;
                    }
                });

                $('input.flat').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });

                if(hayProveedor)
                {
                    $('#mdlSelectProveedor').modal();
                }
                else {
                    alert("No se han seleccionado proveedores");
                }
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

    
}

function liberarCompra()
{
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
                new PNotify({ title: 'Compra Aprobada', text: 'Se ha aprobado compra', type: 'success', styling: 'bootstrap3' });
                estatus_txt('COMPRA APROBADA');
                $('#mdlSelectProveedor').modal('hide');
                //window.location.href = base_url + 'compras/ver_qr/' + CURRENT_QR;
            }
        },
    });
}

function edicion(onoff)
{
    if(onoff && (ED == "1" | LQ == "1" | RV == "1"))
    {
        $('#pnlProveedores').show();
        $('.txtSugerencias').hide();
        $('.sugerencias').show();
        $('#tblProveedores tr th:nth-child(5), #tblProveedores tr td:nth-child(5)').show();
        $('#tblProveedores tr th:nth-child(6), #tblProveedores tr td:nth-child(6)').hide();
        $('#btnBuscarProveedor').fadeIn();
    }
    else
    {
        $('#tblProveedores tr th:nth-child(5), #tblProveedores tr td:nth-child(5)').hide();
        $('.txtSugerencias').show();
        $('.sugerencias').hide();

        $('#btnBuscarProveedor').fadeOut();
        if((ED == "1" | LQ == "1" | RV == "1"))
        {
            $('#tblProveedores tr th:nth-child(6), #tblProveedores tr td:nth-child(6)').show();
            $('#pnlProveedores').show();
        }
        else
        {
            //$('#pnlProveedores').hide();
        }
    }
}

function cambiarEstatus(btn){

    if(confirm("¿Desea continuar?"))
    {
        var estatus = $(btn).val();
        var URL = base_url + 'compras/ajax_setEstatusQR';
        $.ajax({
            type: "POST",
            url: URL,
            data: { idqr : CURRENT_QR, estatus: estatus },
            success: function(result) {
                if(result)
                {
                    //new PNotify({ title: 'Requisición de Cotización', text: 'Se han guardado los cambios', type: 'success', styling: 'bootstrap3' });
                    //$('#mdlEstatus').modal('hide');
                    //$("#divBotones").fadeOut();
                    //loadEstatus(estatus);
                    window.location.href = base_url + 'compras/ver_qr/' + CURRENT_QR;
                }
            }
        });
    }
}



function guardarProveedoresSeleccionados(){
    var hayProv = false;
    var proveedores = [];
    var rows = $('#tblSelectProveedores tbody input:checked');
    
    var URL = base_url + "compras/ajax_setProveedoresNominados";

    $.each(rows, function(i,elem){
        hayProv = true;
        proveedores.push($(elem).val());
    });

    if(hayProv){
        $.ajax({
            type: "POST",
            url: URL,
            data: { qr : CURRENT_QR, qr_proveedores: JSON.stringify(proveedores) },
            success: function(result) {
                if(result)
                {
                    new PNotify({ title: 'Aprobación de QR', text: 'Se ha liberado QR', type: 'success', styling: 'bootstrap3' });
                    $('#mdlSelectProveedor').modal('hide');
                    $('#mdlEstatus').modal('hide');
                    estatus_txt("LIBERADO");
                    proveedoresAsignados();
                }
            },
        });
    }else
    {
        alert("Seleccione al menos 1 Proveedor");
    }
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

function estatus(btn){
    var estatus = $(btn).val();

    var URL = base_url + 'compras/ajax_setEstatusQR';

    $.ajax({
        type: "POST",
        url: URL,
        data: { idqr : CURRENT_QR, estatus: estatus },
        success: function(result) {
            if(result)
            {
                new PNotify({ title: 'Requisición de Cotización', text: 'Se han guardado los cambios', type: 'success', styling: 'bootstrap3' });
                $('#mdlEstatus').modal('hide');
                loadEstatus(estatus);
            }
        }
    });
}


//FILES
function _(el){
    return document.getElementById(el);
}

function uploadFile(){
    //alert(file.name+" | "+file.size+" | "+file.type);
    var file = _("userfile").files[0];
    var URL = base_url + 'compras/ajax_subirEvidencia';

    var formdata = new FormData();
    formdata.append("file", file);
    formdata.append("qr_prov", CURRENT_QR_PROV);

    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", errorHandler, false);
    ajax.open("POST", URL);
    ajax.send(formdata);
  }

  function progressHandler(event){
    var percent = (event.loaded / event.total) * 100;
    $(".progress-bar").attr('aria-valuenow', Math.round(percent)).css('width', Math.round(percent)+ '%');
  }
  function completeHandler(event){
    /*var res = JSON.parse(event.target.responseText);*/
    _("userfile").value="";

    $("#divArchivo").show();
    $("#lblArchivo").html("<u>" + event.target.responseText + "</u>");
    $("#imgArchivo").attr("src", file_image(event.target.responseText));
    $("#divArchivo").show();
    
    $("#btnArchivo").fadeOut('slow',function(){
        $("#btnBorrarArchivo").fadeIn('slow');
    });
  }
  function errorHandler(event){
    alert('ERROR');
  }

  function eliminarEvidencia(){
    
    if(confirm("¿Desea eliminar la evidencia?")){
        var URL = base_url + 'compras/ajax_eliminarEvidencia';
        $.ajax({
            type: "POST",
            url: URL,
            data: { qr_prov : CURRENT_QR_PROV },
            success: function(result) {
                if(result)
                {
                    $("#divArchivo").hide();
                    $("#btnBorrarArchivo").fadeOut('slow', function(){
                        $("#btnArchivo").fadeIn('slow');
                    });
                }
            },
        });
    }
  }

  function verEvidencia(){
      $.ajax({
            type: "POST",
            url: URL,
            data: { qr_prov : CURRENT_QR_PROV },
            success: function(result) {
                if(result)
                {
                    $("#divArchivo").hide();
                    $("#btnBorrarArchivo").fadeOut('slow', function(){
                        $("#btnArchivo").fadeIn('slow');
                    });
                }
            },
        });
  }

  function resumenMarca(btn)
  {

    var id_prov = $(btn).val();
    var marca = btn.dataset.marca;
    var nombreP = btn.dataset.nombreprov;
    var vencimiento = $("#cbVencido").is(':checked') ? "1" : "0";

    $("#lblTituloQrs").html(nombreP + " / Marca: '" + marca + "'");

    $('#tblQRs tbody tr').remove();
    var URL = base_url + 'compras/ajax_getResumenMarca';

    $.ajax({
        type: "POST",
        url: URL,
        data: { prov : id_prov, marca : marca },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblQRs tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem) {

                    var ren = tab.insertRow(tab.rows.length);
                    var cell0 = ren.insertCell(0);
                    cell0.innerHTML = "<button onclick='detalleQR(this)' value='"+ elem.qr +"' type='button' class='btn btn-default'> QR # " + elem.qr + "</button>";

                    var cell1 = ren.insertCell(1);
                    cell1.innerHTML = elem.descripcion;

                    var cell2 = ren.insertCell(2);
                    cell2.innerHTML = elem.total;
                    $(cell2).formatCurrency();
                    cell2.innerHTML += " " + elem.moneda;

                    var diasH = elem.dias_habiles == 1 ? " Habiles" : " Naturales";
                    var cell3 = ren.insertCell(3);
                    cell3.innerHTML = elem.tiempo_entrega + " Dias" + diasH;

                    ren.insertCell(4).innerHTML = moment(elem.vencimiento).format("DD-MM-YYYY");
                    
                    var arc = "<a target='_blank' href='" + base_url + 'compras/getEvidencia/' + elem.idQP + "'><img height='25px' src='" + file_image(elem.nombre_archivo) + "'></a>";


                    ren.insertCell(5).innerHTML = elem.nombre_archivo ? arc : "N/A";
                });





                $("#mdlQRs").modal();
            }
        },
    });
  }

  function resumenModelo(btn)
  {

    var id_prov = $(btn).val();
    var modelo = btn.dataset.modelo;
    var nombreP = btn.dataset.nombreprov;

    $("#lblTituloQrs").html(nombreP + " / Modelo: '" + modelo + "'");

    $('#tblQRs tbody tr').remove();
    var URL = base_url + 'compras/ajax_getResumenModelo';

    $.ajax({
        type: "POST",
        url: URL,
        data: { prov : id_prov, modelo : modelo },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblQRs tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem) {

                    var ren = tab.insertRow(tab.rows.length);
                    var cell0 = ren.insertCell(0);
                    cell0.innerHTML = "<button onclick='detalleQR(this)' value='"+ elem.qr +"' type='button' class='btn btn-default'> QR # " + elem.qr + "</button>";

                    var cell1 = ren.insertCell(1);
                    cell1.innerHTML = elem.descripcion;

                    var cell2 = ren.insertCell(2);
                    cell2.innerHTML = elem.total;
                    $(cell2).formatCurrency();
                    cell2.innerHTML += " " + elem.moneda;

                    var diasH = elem.dias_habiles == 1 ? " Habiles" : " Naturales";
                    var cell3 = ren.insertCell(3);
                    cell3.innerHTML = elem.tiempo_entrega + " Dias" + diasH;

                    ren.insertCell(4).innerHTML = moment(elem.vencimiento).format("DD-MM-YYYY");
                    
                    var arc = "<a target='_blank' href='" + base_url + 'compras/getEvidencia/' + elem.idQP + "'><img height='25px' src='" + file_image(elem.nombre_archivo) + "'></a>";

                    ren.insertCell(5).innerHTML = elem.nombre_archivo ? arc : "N/A";
                });





                $("#mdlQRs").modal();
            }
        },
    });
  }

function bloquearBotton(btn)
{
    /*$(btn).prop( "disabled", true );
    $(btn).closest('form').submit();*/
    //$('#txtComentarios').val("");
}

  function detalleQR(btn){
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
    
    var URL = base_url + 'compras/ajax_setEstatusMsjQR';

    $.ajax({
        type: "POST",
        url: URL,
        data: { idqr : CURRENT_QR, estatus: estatus, comentario: comentario, txtTags : txtTags },
        success: function(result) {
            if(result)
            {
                $('#mdlComentarios').modal('hide');
                //loadEstatus(estatus);
                window.location.href = base_url + 'compras/ver_qr/' + CURRENT_QR;
            }
        }
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