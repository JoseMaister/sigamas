var COTIZACION;
var TextoCorreo = {};
var CORREOS = [];
var CONTACTOS = [];

function load(){
    $( "#menu_toggle" ).trigger( "click" );
    eventos();

    $('button.cancelacion').show();



    jQuery.ajaxSetup({async:false});
    if(ID != 0)
    {
        cargarDatos();
        cargarComentarios();
    }
    else
    {
        $('button.creacion').show();
        $('select.tipo').attr('disabled', false);
        if(COPY != "0")
        {
            var parts = COPY.split("-");
            ID = parts[0];
            cargarDatos(parts[1]);

            ID = 0;
            ULT_REV = 0;
            $('table tbody .eliminar').show();   
        }
        
    }
}

function eventos(){
    $('#opMoneda').on('change', function(){
        evaluarMoneda($(this).val());
    });

    $('input[name="rbBusquedaConcepto"]').on('ifChanged', function(){
        evaluarBusqueda($(this).val());
    });

    $('#txtBusqueda1, #txtBusqueda2').on('keypress', function( e ) {
        if( e.keyCode === 13 ) {
            buscarEquipo();
        }
    });

    $('#txtBuscarServicio').keypress(function (e) { 
        if( e.keyCode === 13 ) {
            buscarServicios();
        }
    });

    $('#mdlClientes').keypress(function (e) { 
        if( e.keyCode === 13 ) {
            e.preventDefault();
            buscarCliente();
        }
    });

    $('#divOtro input[name="rbOtros"]').on('ifChecked', function(){
        if($(this).val() == 'cabezal'){
            $('#txtBusqueda1').show();
        } else {
            $('#txtBusqueda1').hide();
        }
    });

    window.onbeforeunload = preguntarAntesDeSalir;

    function preguntarAntesDeSalir(){
        return "¿Seguro que quieres salir?";
    }
}

function cancelar(){
    if(confirm("¿Desea cancelar la cotización?"))
    {
        if(ID == 0)
        {
            $.redirect( base_url + "inicio");
        }
        else{
            cancelarCotizacion();
        }
    }
}







//////////////// DATOS

function cargarDatos(rev = null){
    var URL = base_url + "cotizaciones/ajax_getCotizaciones";

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : ID },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                COTIZACION = rs;

                var btn = document.createElement("button");
                btn.value = rs.responsable;
                seleccionarAutor(btn);
                btn.value = rs.empresa;
                seleccionarCliente(btn, false, false);
                btn.value = rs.planta;
                seleccionarPlanta(btn);


                if(rs.confirmacion != 0)
                {
                    $('#lblConfirmacion').html("Confirmación: " + rs.confirmacion + " <br>" + moment(rs.fecha_confirmacion).format('D/MM/YYYY h:mm A') + "")
                }


                var contactos = JSON.parse(rs.contactos);
                contactos.forEach(element => {
                    btn.value = element;
                    seleccionarContacto(btn); 
                });

                if($('#opMoneda').find('option[value="' + rs.moneda + '"]').val() == undefined)
                {
                    $('#opMoneda').append(new Option(rs.moneda, rs.moneda));
                }
                
                $('#opMoneda').val(rs.moneda);
                $('#opIVA').val(rs.impuesto_factor);
                $('#opTipo').val(rs.tipo);
                $('#txtNotas').val(rs.notas);
                $('#btnTipoCambio').val(rs.tipo_cambio);
                $('#btnTipoCambio').html("$" + parseFloat(rs.tipo_cambio).toFixed(2));
                if(rs.moneda == "MXN")
                {
                    $('#divTipoCambio').hide();
                }
                else
                {
                    $('#divTipoCambio').show();
                }

                
                

                if(rev == null)
                {
                    $('#frmTitulo').html("Ver Cotización: COT" + paddy(rs.id, 6));
                    //$('.pnlBtnControl').show();
                    $('#rowEstatus').show();
                }
                else
                {
                    ULT_REV = rev;
                }

                if(!cargarConceptos(rs.UltRev, rev != null))
                {
                    botonEstatus(rs.estatus);
                }
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function bitacoraEstatus(){
    $('#tblBitacora tbody tr').remove();

    var ids = [];
    $.each(JSON.parse(COTIZACION.bitacora_estatus), function (i, elem) { 
        if(!ids.includes(parseInt(elem[2])))
        {
            ids.push(parseInt(elem[2]));
        }
    });

    var URL = base_url + "cotizaciones/ajax_getNombresUsuarios";
    var dic = {}
    $.ajax({
        type: "POST",
        url: URL,
        data: { ids : JSON.stringify(ids) },
        success: function (response) {
            if(response){
                var rs = JSON.parse(response);

                $.each(rs, function (i, elem) { 
                     dic[elem.id] = elem.User;
                });

                var tbl = $('#tblBitacora tbody')[0];
                $.each(JSON.parse(COTIZACION.bitacora_estatus), function (i, elem) { 
                    var row = tbl.insertRow();
                    row.insertCell().innerHTML = elem[0];
                    row.insertCell().innerHTML = elem[1];
                    row.insertCell().innerHTML = dic[elem[2]];
                });

                $('#mdlBitacora').modal();
            }
        }
    });





    
    
    
}

function cargarComentarios(){
    var URL = base_url + "cotizaciones/ajax_getComentarios";

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : ID },
        success: function(result) {
            if(result)
            {
                $('#ulComments').html("");
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var c = '<li>'
                    +    '<a>'
                    +        '<span class="image">'
                    +            '<img style="width: 65px; height: 65px;" class="avatar" src="' + base_url + 'usuarios/photo/' + elem.usuario + '" alt="img" />'
                    +        '</span>'
                    +        '<span>'
                    +            '<span>' + elem.User + '<small> ' + moment(elem.fecha).format('D/MM/YYYY h:mm A') + '</small></span>'
                    +        '</span>'
                    +        '<span class="message">' + elem.comentario + '</span>'
                    +    '</a>'
                    +'</li>';
                    $('#ulComments').append(c);
                });
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

    $('#rowComentarios').show();
}

function agregarComentario(){
    var URL = base_url + "cotizaciones/ajax_setComentarios";
    var comentario = $("#txtComentarios").val().trim();
    if(comentario.length > 0)
    {
        var ob = {};
        ob.cotizacion = ID;
        ob.comentario = comentario;

        $.ajax({
            type: "POST",
            url: URL,
            data: { comentario : JSON.stringify(ob) },
            success: function(result) {
                if(result)
                {
                    $('#mdlComentario').modal('hide');
                    cargarComentarios();
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
    else{
        alert("Comentario en blanco");
    }
}

function mdlComentario(){
    $('#txtComentarios').val("");
    $('#mdlComentario').modal();
}

function cargarConceptos(revision, copia = false){
    var URL = base_url + "cotizaciones/ajax_getCotizacionConceptos";

    $.ajax({
        type: "POST",
        url: URL,
        data: { cotizacion : ID, revision : revision },
        success: function(result) {
            $('#tblConceptos tbody tr').remove();
            if(result)
            {
                if(!copia)
                {
                    var select = '<select style="width: 70px; display: inline;" onchange="cambiarRevision(this)" id="optRevision" required="required" class="select2_single form-control">'
                    for (let index = 0; index <= parseInt(COTIZACION.UltRev); index++) {
                        var s = index == revision ? "selected" : "";
                        select += '<option value="' + index + '" ' + s + '>'+ index +'</option>';
                    }
                    select += '</select>';
                    $('#lblPnlConceptos').html("Conceptos (Rev: " + select + ") <button onclick='copiarCotizacion(this)' type='button' data-coti='" + ID + "' data-revision='" + revision + "' class='btn btn-xs btn-primary'><i class='fa fa-copy'></i> Copiar</button>");
                }
                else
                {

                }
                
                var pos = 0;
                var conceptos = JSON.parse(result);
                $.each(conceptos, function(i, elem){
                    elem.servicios = JSON.parse(elem.servicios);
                    
                    if(JSON.parse(elem.atributos).hasOwnProperty('otro'))
                    {
                        agregarConceptoOtro(elem);
                    }else{
                        agregarConcepto(elem);
                    }

                    
                    
                    if(elem.po){
                        pos++;
                    }
                });


                if(COTIZACION.estatus == "EN APROBACION")
                {
                    if(pos == 0)
                    {
                        $('#btnAutorizado').hide();
                        $('#btnAutorizado').val("");
                    }
                    if(pos > 0)
                    {
                        $('#btnAutorizado').html('<i class="fa fa-star-half-o"></i> Aprobación Parcial');
                        $('#btnAutorizado').val("Parcial");
                        $('#btnAutorizado').show();
                    }
                    if(pos == conceptos.length)
                    {
                        $('#btnAutorizado').html('<i class="fa fa-star"></i> Aprobación Total');
                        $('#btnAutorizado').val("Total");
                        $('#btnAutorizado').show();
                    }
                }
                

            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

    return copia;
}

function botonEstatus(estatus){
    $('#btnEstatus').text(estatus);

    switch (estatus) {
        case "CREADA":
            $('#btnEstatus').addClass("btn-primary");
            break;

        case "PENDIENTE AUTORIZACION":
        case "EN APROBACION":
        case "EN REVISION":
            $('#btnEstatus').addClass("btn-warning");
            break;
            
        case "RECHAZADA":
            $('#btnEstatus').addClass("btn-danger");
            break;

        case "ENVIADA":
        case "AUTORIZADA":
        case "APROBADO PARCIAL":
        case "APROBADO TOTAL":
        case "CONFIRMADA":
            $('#btnEstatus').addClass("btn-success");
            break;

        case "CANCELADA":
            $('#btnEstatus').addClass("btn-default");
            break;

        case "CERRADO PARCIAL":
        case "CERRADO TOTAL":
            $('#btnEstatus').addClass("btn-dark");
            break;
    
        default:
            break;
    }

    controles(estatus);
}

function copiarCotizacion(btn){
    var coti = $(btn).data('coti');
    var revision = $(btn).data('revision');

    if(confirm("¿Desea copiar la cotización " + coti + " Rev: " +revision + "?")){
        $.redirect(base_url + 'cotizaciones/crear_cotizacion', { "id" : coti, "rev" : revision }, "POST", "_blank");
    }
}

function controles(estatus){
    $('button.creacion').hide();
    $('button.pdf').show();
    $('button.solicitud').show();
    $('button.eliminar').show();
    

    switch (estatus) {
        
        

        case "PENDIENTE AUTORIZACION":
            if(PRIVILEGIOS.aprobar_cotizacion == "1")
            {
                $('button.aprobacion').show();
            }
            $('button.solicitud').hide();
            $('button.eliminar').hide();
            $('button.ctrlEdicion').hide();
            
            $('button.edicion').attr('disabled', true);
            $('#tblConceptos input, #tblConceptos textarea').attr('readonly', true);
            $('#tblConceptos select').attr('disabled', true);
            $('#pnlDatos select').attr('disabled', true);
            
            break;

        case "EN REVISION":
        case "CREADA":
            $('button.edicion').show();
            break;
        case "RECHAZADA":
            if(COTIZACION.usuario == ID_USER || COTIZACION.responsable == ID_USER)
            {
                $('button.activacion').show();
            }
            $('button.solicitud').hide();
            $('button.eliminar').hide();
            $('button.ctrlEdicion').hide();
            
            $('button.edicion').attr('disabled', true);
            $('#tblConceptos input, #tblConceptos textarea').attr('readonly', true);
            $('#tblConceptos select').attr('disabled', true);
            $('#pnlDatos select').attr('disabled', true);
            break;

        case "AUTORIZADA":
        case "ENVIADA":
            $('button.confirmacion').show();
            //$('button.envio').show();
            $('button.revision').show();
            $('button.solicitud').hide();
            $('button.eliminar').hide();
            $('button.ctrlEdicion').hide();
            
            $('button.edicion').attr('disabled', true);
            $('#tblConceptos input, #tblConceptos textarea').attr('readonly', true);
            $('#tblConceptos select').attr('disabled', true);
            $('#pnlDatos select').attr('disabled', true);
            break;

        case "EN APROBACION":
            $('button.capturaPO').show();
            $('button.revision').hide();
            $('button.solicitud').hide();
            $('button.eliminar').hide();
            $('button.ctrlEdicion').hide();
            
            $('button.edicion').attr('disabled', true);
            $('#tblConceptos input, #tblConceptos textarea').attr('readonly', true);
            $('#tblConceptos select').attr('disabled', true);
            $('#pnlDatos select').attr('disabled', true);
            mdlPONumbers();

            break;

        case "APROBADO PARCIAL":
        case "APROBADO TOTAL":
            $('button.capturaPO').html('<i class="fa fa-shopping-cart"></i> # PO\'s');
            $('button.capturaPO').show();
            $('button.cierre').show();
            $('button.revision').hide();
            $('button.solicitud').hide();
            $('button.eliminar').hide();
            $('button.ctrlEdicion').hide();
            
            $('button.edicion').attr('disabled', true);
            $('#tblConceptos input, #tblConceptos textarea').attr('readonly', true);
            $('#tblConceptos select').attr('disabled', true);
            $('#pnlDatos select').attr('disabled', true);
            break;

        case "CERRADO PARCIAL":
        case "CERRADO TOTAL":
            $('button.capturaPO').html('<i class="fa fa-shopping-cart"></i> # PO\'s');
            $('button.capturaPO').show();
            $('button.cancelacion').hide();
            $('button.revision').hide();
            $('button.solicitud').hide();
            $('button.eliminar').hide();
            $('button.ctrlEdicion').hide();
            
            $('button.edicion').attr('disabled', true);
            $('#tblConceptos input, #tblConceptos textarea').attr('readonly', true);
            $('#tblConceptos select').attr('disabled', true);
            $('#pnlDatos select').attr('disabled', true);

            break;

        case "CONFIRMADA":
            //$('button.cierre').show();
            $('button.en_aprobacion').show();
            $('button.revision').show();
            $('button.solicitud').hide();
            $('button.eliminar').hide();
            $('button.ctrlEdicion').hide();
            
            $('button.edicion').attr('disabled', true);
            $('#tblConceptos input, #tblConceptos textarea').attr('readonly', true);
            $('#tblConceptos select').attr('disabled', true);
            $('#pnlDatos select').attr('disabled', true);
            break;

        case "CANCELADA":
        case "CERRADA":
            $('button.cancelacion').hide();
            $('button.solicitud').hide();
            $('button.eliminar').hide();
            $('button.ctrlEdicion').hide();
            
            $('button.edicion').attr('disabled', true);
            $('#tblConceptos input, #tblConceptos textarea').attr('readonly', true);
            $('#tblConceptos select').attr('disabled', true);
            $('#pnlDatos select').attr('disabled', true);
            break;
    
        default:
            break;
    }
}


//////////////// CLIENTES

function mdlClientes(){
    $('#mdlClientes').modal();
}

function buscarCliente(){
    var URL = base_url + "cotizaciones/ajax_getClientes";
    $('#tblClientes tbody tr').remove();
    var nombre = $('#txtBuscarCliente').val().trim();
    
    $.ajax({
        type: "POST",
        url: URL,
        data: { nombre : nombre },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblClientes tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem)
                {
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = elem.nombre;
                    ren.insertCell().innerHTML = "<button type='button' onclick='seleccionarCliente(this)' value='" + elem.id +"' class='btn btn-default btn-xs'><i class='fa fa-check'></i> Seleccionar</button>";
                });
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function seleccionarCliente(btn, contactoDef = true, selectPlanta = true){
    CONTACTOS = [];
    CORREOS = [];

    if(!seleccionarPlanta)
    {
        
    }
    

    $('#tablaContactos tbody tr').remove();

    var URL = base_url + "cotizaciones/ajax_getClientes";
    var id = $(btn).val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                
                var xxx = selectPlanta ? !mdlPlanta(rs.id, contactoDef) : true;
                

                if(xxx) //SI NO HAY PLANTA DESPLEGA
                {
                    $('#divCliente').show();
                    $('#btnClientes').data('id', rs.id);
                    $('#btnClientes').data('NombreCorto', rs.nombre_corto);
                    $('#lblRazonSocialCliente').text(rs.razon_social);
                    $('#lblRFCCliente').text(rs.rfc);
    
                    var dir = rs.calle + ' ' + rs.numero + ' ' + ((rs.numero_interior ? ('Int. ' + rs.numero_interior + ' ') : '') + rs.colonia) + " CP " + rs.cp;
                    dir += '<br>' + rs.ciudad + ', ' + rs.estado;
                    $('#lblDireccionCliente').html(dir);
                    $('#txtNotas').val(rs.notas_cotizacion);
                    $('#lblCreditoCliente').text(rs.credito_cliente == "1" ? (rs.credito_cliente_plazo + ' Días') : 'N/A');
    
                    $('#opMoneda option').remove();
                    $.each(JSON.parse(rs.moneda_cotizacion), function(i, elem)
                    {
                        var option = new Option(elem, elem);
                        $('#opMoneda').append(option);
                    });
    
                    evaluarMoneda($('#opMoneda').val());
    
                    var arr_iva = JSON.parse(rs.iva_cotizacion);
                    $('#opIVA option').attr('selected', false);
                    //$('#opIVA').val(arr_iva[Object.keys(arr_iva)[0]]);
                    
                    $('option[data-nombre="' + Object.keys(arr_iva)[0] + '"]').attr("selected", true);

                    $('#mdlClientes').modal('hide');
    
                    //DATOS
                    $('#pnlDatos').show();
                    $('#pnlConceptos').show();
                    //CONTACTO
                    $('#pnlContacto').show();
                    $('#btnContacto').data('id', 0);
                    $('#divContacto').hide();
    
                    if(contactoDef)
                    {
                        var contactos = JSON.parse(rs.contacto_cotizacion);
                        contactos.forEach(element => {
                            var btn = document.createElement("button");
                            btn.value = element
                            seleccionarContacto(btn);    
                        });
                    }
                }



                
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function seleccionarPlanta(btn){

    var URL = base_url + "cotizaciones/ajax_getPlanta";
    var id = $(btn).val();


    if(id == 0)
    {
        $('#lblPlantaCliente').text("N/A");
        $('#lblPlantaCliente').data('id', 0);
        $('#lblPlantaCliente').data('nombre_corto', '');
    }
    else
    {
        $.ajax({
            type: "POST",
            url: URL,
            data: { id : id },
            success: function(result) {
                
                if(result)
                {
                    var rs = JSON.parse(result);
                    $('#lblPlantaCliente').text(rs.nombre);
                    $('#lblPlantaCliente').data('id', rs.id);
                    $('#lblPlantaCliente').data('nombre_corto', rs.nombre_corto);
                }
                else
                {
                    $('#lblPlantaCliente').text("NO DEFINIDO");
                    $('#lblPlantaCliente').data('id', id);
                    $('#lblPlantaCliente').data('nombre_corto', '');
                }
                
              },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }

    $('#mdlPlanta').modal('hide');

    
    var btn = document.createElement("button");
    btn.value = $('#mdlPlanta').data('id_cliente');
    seleccionarCliente(btn, $('#mdlPlanta').data('contacto_default'), false);
}

function mdlPlanta(id_cliente, contactoDef){

    $('#lblPlantaCliente').text("N/A");
    $('#lblPlantaCliente').data('id', 0);
    $('#lblPlantaCliente').data('nombre_corto','');

    var URL = base_url + "empresas/ajax_getPlantas";

    $('#mdlPlanta').data('id_cliente', id_cliente);
    $('#mdlPlanta').data('contacto_default', contactoDef);

    $('#tblPlantas tbody tr').remove();

    var resultado = false;

    jQuery.ajaxSetup({async:false});
    $.ajax({
        type: "POST",
        url: URL,
        data: { empresa : id_cliente },
        success: function (response) {
            
            var tbl = $('#tblPlantas tbody')[0];

            if(response){
                $('#mdlClientes').modal('hide');

                var rs = JSON.parse(response);                

                $.each(rs, function (i, elem) { 
                    var row = tbl.insertRow();
                    row.dataset.id = elem.id;

                    row.insertCell().innerHTML = elem.nombre;
                    row.insertCell().innerHTML = "<button type='button' onclick='seleccionarPlanta(this)' value='" + elem.id +"' class='btn btn-default btn-xs'><i class='fa fa-check'></i> Seleccionar</button>";
                });

                $('#mdlPlanta').modal();
            }

            
            resultado = tbl.rows.length > 0
        }
    });
    jQuery.ajaxSetup({async:true});

    return resultado;
}

function evaluarMoneda(moneda){
    if(moneda != "MXN")
    {
        $('#btnTipoCambio').val(USD.toFixed(2));
        $('#btnTipoCambio').html("$" + USD.toFixed(2));
        $('#divTipoCambio').show();
    }
    else{
        $('#btnTipoCambio').val(1);
        $('#btnTipoCambio').html("$1.00");
        $('#divTipoCambio').hide();
    }
}

//////////////// CONTACTOS

function buscarContactos(){
    var URL = base_url + "cotizaciones/ajax_getContactos";
    $('#tblContactos tbody tr').remove();
    var idCliente = $('#btnClientes').data('id');
    
    $.ajax({
        type: "POST",
        url: URL,
        data: { id_cliente : idCliente },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblContactos tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem)
                {
                    if(!CONTACTOS.includes(parseInt(elem.id)))
                    {
                        if(elem.planta == $('#lblPlantaCliente').data('id') || elem.planta == 0)
                        {
                            var ren = tab.insertRow(tab.rows.length);
                            ren.insertCell().innerHTML = elem.nombre;
                            ren.insertCell().innerHTML = elem.puesto;
                            ren.insertCell().innerHTML = "<button type='button' onclick='seleccionarContacto(this)' value='" + elem.id +"' class='btn btn-default btn-xs'><i class='fa fa-check'></i> Seleccionar</button>";
                        }
                    }
                });

                $('#mdlContactos').modal();
            }
            else{
                alert("Cliente no tiene definidos contactos para cotizar");
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function seleccionarContacto(btn){
    $('#btnVerPDF').hide();
    $('#btnSolAprob').hide();

    var URL = base_url + "cotizaciones/ajax_getContactos";
    var id = $(btn).val();
    if(id == 0)
    {
        return;
    }

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);

                if(rs.planta == $('#lblPlantaCliente').data('id') || rs.planta == 0)
                {
                    var tab = $('#tablaContactos tbody')[0];
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id = rs.id

                    var c1 = ren.insertCell();
                    var c2 = ren.insertCell();
                    var c3 = ren.insertCell();
                    var c4 = ren.insertCell();

                    c1.innerHTML = rs.nombre;
                    c2.innerHTML = rs.telefono + ' ' + rs.ext;
                    c3.innerHTML = rs.correo;
                    c4.innerHTML = '<button onclick="removerContacto(this)" style="margin-left: 10px;" type="button" class="btn btn-danger btn-xs eliminar"><i class="fa fa-minus"></i></button>';

                    if(CONTACTOS.length == 0){
                        TextoCorreo.contacto = rs.nombre;
                    }

                    CONTACTOS.push(parseInt(rs.id));
                    CORREOS.push(rs.correo);

                    $('#mdlContactos').modal('hide');
                    $('#divContacto').show();
                    $('#tags_1').val(CORREOS);
                }
                
               
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function removerContacto(btn){
    if(confirm("¿Desea remover contacto?"))
    {
        $('#btnVerPDF').hide();
        $('#btnSolAprob').hide();
        var ren1 = $(btn).closest('tr')[0];
        var index = CONTACTOS.indexOf(parseInt(ren1.dataset.id));
        
        if (index >= 0) 
        {
            CONTACTOS.splice(index, 1);
            CORREOS.splice(index, 1);
        }
        $(ren1).remove();
    } 
}

function buscarAutores(){
    var URL = base_url + "cotizaciones/ajax_getbuscarAutores";
    $('#tblAutores tbody tr').remove();
    
    $.ajax({
        type: "POST",
        url: URL,
        data: { },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblAutores tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem)
                {
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = elem.Nombre;
                    ren.insertCell().innerHTML = elem.Puesto;
                    ren.insertCell().innerHTML = "<button type='button' onclick='seleccionarAutor(this)' value='" + elem.id +"' class='btn btn-default btn-xs'><i class='fa fa-check'></i> Seleccionar</button>";
                });

                $('#mdlRequisitor').modal();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
      });
}

function seleccionarAutor(btn){
    $('#btnVerPDF').hide();
    $('#btnSolAprob').hide();

    var URL = base_url + "cotizaciones/ajax_getbuscarAutores";
    var id = $(btn).val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $('#btnRequisitor').data('id', rs.id);
                $('#btnRequisitor').data('nombre', rs.Nombre);
                $('#btnRequisitor').html("<i class='fa fa-user'></i> " + rs.Nombre);
                TextoCorreo.responsable = rs.Nombre;

                $('#tags_2').val(rs.correo);
    
                $('#mdlRequisitor').modal('hide');
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

//////////////// CONCEPTOS

function mdlAgregarConcepto(){
    limpiarBusquedaEquipo();
    if($('#opTipo').val().startsWith("CALIBRACION"))
    {
        $('#divrbIdEquipo').show();
        $('#divrbMarMod').show();

        $('#btnServicioManual').hide();
        $('#btnServicioCatalogo').show();
    }
    else{
        $('#divrbIdEquipo').hide();
        $('#divrbMarMod').hide();

        $('#rbManual').iCheck('check');

        $('#btnServicioManual').show();
        $('#btnServicioCatalogo').hide();
    }
    $('#mdlConcepto').modal();
}

function limpiarBusquedaEquipo(){
    $('#tblServicio tr th:nth-child(3), #tblServicio tr td:nth-child(3)').show();
    $('#tblServicio tr th:nth-child(4), #tblServicio tr td:nth-child(4)').show();

    $('#btnAgregarConcepto').hide();
    $('#opSitio').attr('disabled', false);
    $('#opSitio option').remove();
    $('#opSitio').append(new Option("OS", "OS"));
    $('#opSitio').append(new Option("LAB", "LAB"));
    $('#opSitio').append(new Option("EXT", "EXT"));

    $('#rbIdEquipo').iCheck('check');
    //$('#rbMarMod').iCheck('check');
    $('.divRb').show();

    $('#txtBusqueda1').val("");
    $('#txtBusqueda2').val("");

    $('#tblEquipos tbody tr').remove();
    $('#tblServicio tbody tr').remove();
    $('#tblConcepto tbody tr').remove();

    $('#divEquipo').hide();
    $('#divServicio').hide();
    $('#divConcepto').hide();
    
}

function buscarEquipo(){
    var data = {};
    var param = $('input[name="rbBusquedaConcepto"]:checked').val()
    var URL = base_url + "cotizaciones/";
    var valor1 = $('#txtBusqueda1').val().trim();
    var valor2 = $('#txtBusqueda2').val().trim();
    

    if(param == "id_equipo" && valor1)
    {
        //URL += "ajax_getSAData";
        URL = "http://192.168.6.13/cotizaciones/ajax_getSAData";
        data.id_equipo = valor1;

        $.ajax({
            type: "POST",
            url: URL,
            data: data,
            success: function(result) {
                $('#tblEquipos tbody tr').remove();
                $('#tblServicio tbody tr').remove();
                
                if(result)
                {
                    var rs = JSON.parse(result);
                    
                    var NombreCorto = $('#lblPlantaCliente').data('nombre_corto') ? $('#lblPlantaCliente').data('nombre_corto') : $('#btnClientes').data('NombreCorto');
                    var Vigencia = moment(rs.Table[0].Vigencia);

                    

                    
                    if( (NombreCorto.trim().toUpperCase() == rs.Table[0].NombreCorto.trim().toUpperCase()) || confirm("Equipo pertenece a: " + rs.Table[0].NombreCorto.trim() + ", ¿Desea Continuar?"))
                    {
                        
                        //alert("Cliente: " + NombreCorto.trim() + " / Equipo: " + rs.Table[0].NombreCorto.trim() + "  -NOMBRES NO COINCIDEN-");
                        $('#btnAgregarConcepto').show();
                        $('#divServicio').show();

                        $('#divEquipo').show();
                        var tab = $('#tblEquipos tbody')[0];


                        var ren = tab.insertRow(tab.rows.length);
                        var c1 = ren.insertCell(); c1.id = 'cllIdEquipo';
                        var c2 = ren.insertCell(); c2.id = 'cllDescripcion';
                        var c3 = ren.insertCell(); c3.id = 'cllMarca';
                        var c4 = ren.insertCell(); c4.id = 'cllModelo';
                        var c5 = ren.insertCell(); c5.id = 'cllSerie';

                        //rs.Table[0].CodigoServicios = "BAS0002,DIM0008,DIM0010";
                        //alert(rs.Table[0].CodigoServicios);

                        c1.innerHTML = rs.Table[0].Id_equipo;
                        c2.innerHTML = rs.Table[0].Descripcion;
                        c3.innerHTML = rs.Table[0].Marca;
                        c4.innerHTML = rs.Table[0].Modelo;
                        c5.innerHTML = rs.Table[0].Serie;

                        $('#divEquipo').data('id', rs.Table[0].Id_equipo);
                        $('#divEquipo').data('ipt', 0);

                        $('.divRb').hide();
                        //$('#rbMarMod').iCheck('check');
                        //$('#txtBusqueda1').val(rs.Table[0].Marca.trim());
                        //$('#txtBusqueda2').val(rs.Table[0].Modelo.trim());
                        //buscarEquipo();
                        $('#divrbIdEquipo').show();

                        

                        $('#opSitio option').remove();
                        var sitios = rs.Table[0].Sitio;

                        //alert(sitios);
                        $.each(sitios.split(","), function (i, sitio) { 
                            sitio = sitio.toUpperCase().trim();
                            var dic = { 'ON-SITE' : 'OS', 'LABORATORY' : 'LAB', 'EXTERNAL' : 'EXT'};
                            if(sitio == "ON-SITE" || sitio == "LABORATORY" || sitio == "EXTERNAL")
                            {
                                $('#opSitio').append(new Option(dic[sitio], dic[sitio]));
                            }
                        });

                        
                        var codigos = rs.Table[0].CodigoServicios;
                        if(codigos){
                            $.each(codigos.split(","), function (i, code) { 
                                asignarServicio_CODIGO(code.trim());
                            });
                        }

                        var tab = $('#tblServicio tbody')[0];
                        
                        var precio = rs.Table[0].Precio;
                        
                        if(tab.rows.length == 0)
                        {
                            // E3MN288
                            if(precio)
                            {
                                
                                var ro = "readonly";
                                var PRECIO = 0;
                                if(Vigencia > moment())
                                {
                                    PRECIO = precio;
                                }
                                else
                                {
                                    alert("Precio esta vencido vencido: ($" + precio.toFixed(2) + ")");
                                    ro = "";
                                }

                                if($('#opSitio').val() == "EXT"){
                                    PRECIO = 0;
                                    alert("Servicio EXTERNO, capture precio del servicio");
                                    ro = "";
                                }

                                

                                if($('#opSitio option').length > 0)
                                {
                                    var ren = tab.insertRow(tab.rows.length);
                                    ren.dataset.id = 0;
                                    ren.dataset.codigo = "N/A";
                                    ren.dataset.descripcion = "Calibración";
                                    ren.dataset.precio = PRECIO.toFixed(2);
                                    
                                    var c1 = ren.insertCell();
                                    var c2 = ren.insertCell();
                                    var c3 = ren.insertCell();
                                    var c4 = ren.insertCell();

                                    c1.innerHTML = '<input type="text" name="txtCodigo" class="form-control" value="N/A" readonly>';
                                    c2.innerHTML = '<input type="text" name="txtDescripcionServicio" class="form-control" value="Servicio de Calibración" readonly>';
                                    c3.innerHTML = '<input type="number" name="txtPrecio" class="form-control" value=' + PRECIO.toFixed(2) + ' ' + ro + '>';
                                    c4.innerHTML = '<button onclick="removerServicio(this)" style="margin-left: 10px;" type="button" class="btn btn-danger btn-xs eliminar"><i class="fa fa-minus"></i></button>';
                                }
                            }
                            //else if($('#opSitio').val() == "EXT")
                            else
                            {
                                var PRECIO = 0;
                                alert("Servicio EXTERNO, capture precio del servicio");
                                ro = "";

                                var ren = tab.insertRow(tab.rows.length);
                                ren.dataset.id = 0;
                                ren.dataset.codigo = "N/A";
                                ren.dataset.descripcion = "Calibración";
                                ren.dataset.precio = PRECIO.toFixed(2);
                                
                                var c1 = ren.insertCell();
                                var c2 = ren.insertCell();
                                var c3 = ren.insertCell();
                                var c4 = ren.insertCell();

                                c1.innerHTML = '<input type="text" name="txtCodigo" class="form-control" value="N/A" readonly>';
                                c2.innerHTML = '<input type="text" name="txtDescripcionServicio" class="form-control" value="Servicio de Calibración" readonly>';
                                c3.innerHTML = '<input type="number" name="txtPrecio" class="form-control" value=' + PRECIO.toFixed(2) + ' ' + ro + '>';
                                c4.innerHTML = '<button onclick="removerServicio(this)" style="margin-left: 10px;" type="button" class="btn btn-danger btn-xs eliminar"><i class="fa fa-minus"></i></button>';
                            }
                        }
                        else
                        {
                            if(precio)
                            {
                                var PRECIO = 0;
                                if(Vigencia > moment())
                                {
                                    PRECIO = precio;
                                }
                                else
                                {
                                    alert("Precio vencido");
                                }

                                if($('#opSitio').val() == "EXT"){
                                    PRECIO = 0;
                                    alert("Servicio EXTERNO, capture precio del servicio");
                                    ro = "";
                                }

                                PRECIO = PRECIO / tab.rows.length;
                                $.each(tab.rows, function(i, row){
                                    row.dataset.precio = PRECIO.toFixed(2);
                                    row.cells[2].innerHTML = PRECIO.toFixed(2);
                                    $('#tblServicio tr th:nth-child(3), #tblServicio tr td:nth-child(3)').hide();
                                    $('#tblServicio tr th:nth-child(4), #tblServicio tr td:nth-child(4)').hide();
                                });
                            }
                        }
                        
                    }
                    
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
    
    if(param == "marca_modelo" && valor1 && valor2)
    {
        $('#btnAgregarConcepto').show();
        URL += "ajax_getServicioMarMod";
        data.fabricante = valor1;
        data.modelo = valor2;

        $.ajax({
            type: "POST",
            url: URL,
            data: data,
            success: function(result) {
                $('#tblEquipos tbody tr').remove();
                $('#tblServicio tbody tr').remove();

                if(result)
                {
                    $('#divServicio').show();
                    $('#divEquipo').show();

                    var tab = $('#tblEquipos tbody')[0];

                    var rs = JSON.parse(result);
                    var ren = tab.insertRow(tab.rows.length);
                    var c1 = ren.insertCell();
                    var c2 = ren.insertCell();
                    var c3 = ren.insertCell();
                    var c4 = ren.insertCell();
                    var c5 = ren.insertCell();
                    
                    c1.innerHTML = '<input type="text" id="txtIdEquipo" class="form-control">';
                    c2.innerHTML = '<input type="text" id="txtDescripcion" class="form-control" value="' + rs.descripcion + '" readonly>';
                    c3.innerHTML = '<input type="text" id="txtMarca" class="form-control" value="' + valor1 + '" readonly>';
                    c4.innerHTML = '<input type="text" id="txtModelo" class="form-control" value="' + valor2 + '" readonly>';
                    c5.innerHTML = '<input type="text" id="txtSerie" class="form-control">';

                    $('#divEquipo').data('ipt', 1);

                    $('.divRb').hide();
                    $('#divrbMarMod').show();


                    
                    $.each(JSON.parse(rs.servicio) , function (i, code) { 
                        asignarServicio_ID(code);
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

function evaluarBusqueda(param){
    $('#tblServicio tr th:first, #tblServicio tr td:first').show();
    if(param == "id_equipo")
    {
        $('#btnAgregarConcepto').hide();
        
        $('#divOtro').hide();
        $('#divEquipo').hide();
        $('#divServicio').hide();
        $('#divConcepto').hide();

        $('#txtBusqueda1').attr('placeholder', 'ID Equipo');
        $('#txtBusqueda1').show();
        $('#txtBusqueda2').hide();
        $('#divrbControls').show();
        $('#btnBuscarConcepto').show();
    }
    if(param == "marca_modelo")
    {
        $('#btnAgregarConcepto').hide();
        
        $('#divOtro').hide();
        $('#divEquipo').hide();
        $('#divServicio').hide();
        $('#divConcepto').hide();

        $('#txtBusqueda1').attr('placeholder', 'Marca');
        $('#txtBusqueda2').attr('placeholder', 'Modelo');
        $('#txtBusqueda1').show();
        $('#txtBusqueda2').show();
        $('#divrbControls').show();
        $('#btnBuscarConcepto').show();
    }
    if(param == "manual")
    {
        $('#btnAgregarConcepto').show();
        $('#btnBuscarConcepto').hide();
        $('#divrbControls').hide();

        $('#divOtro').hide();
        $('#divEquipo').show();
        $('#divServicio').show();
        $('#divConcepto').hide();

        $('#tblEquipos tbody tr').remove();
        $('#tblServicio tbody tr').remove();
        var tab = $('#tblEquipos tbody')[0];
        var ren = tab.insertRow(tab.rows.length);
        var c1 = ren.insertCell();
        var c2 = ren.insertCell();
        var c3 = ren.insertCell();
        var c4 = ren.insertCell();
        var c5 = ren.insertCell();

        c1.innerHTML = '<input type="text" id="txtIdEquipo" class="form-control">';
        c2.innerHTML = '<input type="text" id="txtDescripcion" class="form-control">';
        c3.innerHTML = '<input type="text" id="txtMarca" class="form-control">';
        c4.innerHTML = '<input type="text" id="txtModelo" class="form-control">';
        c5.innerHTML = '<input type="text" id="txtSerie" class="form-control">';


        $('#divEquipo').data('ipt', 1);
        $('#divServicio').data('ipt', 1);
    }
    if(param == "concepto")
    {
        $('#btnAgregarConcepto').show();
        $('#btnBuscarConcepto').hide();
        $('#divrbControls').hide();

        $('#divOtro').hide();
        $('#divEquipo').hide();
        $('#divServicio').hide();
        $('#divConcepto').show();

        $('#tblEquipos tbody tr').remove();
        $('#tblServicio tbody tr').remove();
        $('#tblConcepto tbody tr').remove();

        var tab = $('#tblConcepto tbody')[0];
        var ren = tab.insertRow(tab.rows.length);
        var c1 = ren.insertCell();
        var c2 = ren.insertCell();


        c1.innerHTML = '<input type="text" id="txtDescripcion" class="form-control">';
        c2.innerHTML = '<input type="number" id="txtPrecio" class="form-control">';

        //$('#tblServicio tr th:first, #tblServicio tr td:first').hide();

        $('#divEquipo').data('ipt', 1);
        $('#divServicio').data('ipt', 1);
    }
    if(param == "otro")
    {
        $('#btnAgregarConcepto').show();

        $('#divOtro').show();
        $('#divEquipo').hide();
        $('#divServicio').hide();
        $('#divConcepto').hide();

        $('#divOtro input[value="cabezal"]').iCheck('check');
        $('#txtBusqueda1').attr('placeholder', 'Cabezal');
        $('#txtBusqueda1').show();
        $('#txtBusqueda2').hide();
        $('#divrbControls').show();
        $('#btnBuscarConcepto').hide();
    }
}

function eliminarConcepto(btn){
    if(confirm("¿Desea eliminar concepto?"))
    {
        $('#btnVerPDF').hide();
        $('#btnSolAprob').hide();

        var ren = $(btn).closest('tr')[0];
        if(ren.dataset.registro == 0)
        {
            $(ren).remove();
        }
        else{
            ren.dataset.registro = ren.dataset.registro * -1;
            $(ren).hide();
        }
        
        numerarTabla();
    }
}

function mdlServicios(){    
    buscarServicios();
    $('#mdlServicios').modal();
}

function buscarServicios(){
    var sitio = $('#opSitio').val();

    var URL = base_url + "servicios/ajax_getServicios";
    var parametro = "codigo_contenido";
    var texto = $('#txtBuscarServicio').val().trim();

    var rows = $('#tblServicio tbody tr');
    var servs = [];
    $.each(rows, function(i, row){
        servs.push($(row).data('id'));
    });

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto, parametro : parametro, tipo : "[]" },
        success: function(result) {
            $('#tblServicios tbody tr').remove();
            if(result)
            {
                var tab = $('#tblServicios tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    if(sitio == elem.sitio || elem.sitio == "OS/LAB")
                    {
                        var ren = tab.insertRow(tab.rows.length);
                        ren.dataset.id = elem.id;
                        ren.dataset.codigo = elem.codigo;
                        ren.dataset.descripcion = elem.descripcion;
                        ren.dataset.precio = elem.alto;
                        ren.dataset.sitio = elem.sitio;

                        ren.insertCell().innerHTML = elem.codigo;
                        ren.insertCell().innerHTML = elem.descripcion; 
                        ren.insertCell().innerHTML = elem.sitio; 
                        var b;
                        
                        if(servs.includes(parseInt(elem.id)))
                        {
                            b = "<button type='button' class='btn btn-success btn-xs'><i class='fa fa-spinner'></i> Asignado</button>";
                        }
                        else{
                            b = "<button type='button' onclick='asignarServicio(this)' class='btn btn-primary btn-xs'><i class='fa fa-plus'></i> Agregar</button>";
                        }

                        ren.insertCell().innerHTML = b;
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

function asignarServicio(btn){
    $('#opSitio').attr('disabled', true);

    var ren = $(btn).closest('tr');

    var id = $(ren).data('id');
    var codigo = $(ren).data('codigo');
    var descripcion = $(ren).data('descripcion');
    var precio = $(ren).data('precio');

    var tab = $('#tblServicio tbody')[0];
    var ren = tab.insertRow(tab.rows.length);
    ren.dataset.id = id;
    ren.dataset.codigo = codigo;
    ren.dataset.descripcion = descripcion;
    ren.dataset.precio = precio;
    
    var c1 = ren.insertCell();
    var c2 = ren.insertCell();
    var c3 = ren.insertCell();
    var c4 = ren.insertCell();

    c1.innerHTML = codigo;
    c2.innerHTML = descripcion;
    c3.innerHTML = precio;
    c4.innerHTML = '<button onclick="removerServicio(this)" style="margin-left: 10px;" type="button" class="btn btn-danger btn-xs eliminar"><i class="fa fa-minus"></i></button>';

    $('#mdlServicios').modal('hide');
}

function asignarServicio_CODIGO(codigo){
    
    $('#opSitio').attr('disabled', true);


    var URL = base_url + "servicios/ajax_getServicios";

    $.ajax({
        type: "POST",
        url: URL,
        data: { codigo : codigo },
        success: function (response) {
            
            var rs = JSON.parse(response);

            var tab = $('#tblServicio tbody')[0];
            var ren = tab.insertRow(tab.rows.length);

            ren.dataset.id = rs.id;
            ren.dataset.codigo = rs.codigo;
            ren.dataset.descripcion = rs.descripcion;
            ren.dataset.precio = rs.alto;
            
            var c1 = ren.insertCell();
            var c2 = ren.insertCell();
            var c3 = ren.insertCell();
            var c4 = ren.insertCell();

            c1.innerHTML = rs.codigo;
            c2.innerHTML = rs.descripcion;
            c3.innerHTML = rs.alto;
            c4.innerHTML = '<button onclick="removerServicio(this)" style="margin-left: 10px;" type="button" class="btn btn-danger btn-xs eliminar"><i class="fa fa-minus"></i></button>';     
        }
    });

}

function asignarServicio_ID(id){
    
    $('#opSitio').attr('disabled', true);


    var URL = base_url + "servicios/ajax_getServicios";

    $.ajax({
        type: "POST",
        url: URL,
        data: { id : id },
        success: function (response) {
            
            var rs = JSON.parse(response);

            var tab = $('#tblServicio tbody')[0];
            var ren = tab.insertRow(tab.rows.length);

            ren.dataset.id = rs.id;
            ren.dataset.codigo = rs.codigo;
            ren.dataset.descripcion = rs.descripcion;
            ren.dataset.precio = rs.alto;
            
            var c1 = ren.insertCell();
            var c2 = ren.insertCell();
            var c3 = ren.insertCell();
            var c4 = ren.insertCell();

            c1.innerHTML = rs.codigo;
            c2.innerHTML = rs.descripcion;
            c3.innerHTML = rs.alto;
            c4.innerHTML = '<button onclick="removerServicio(this)" style="margin-left: 10px;" type="button" class="btn btn-danger btn-xs eliminar"><i class="fa fa-minus"></i></button>';     
        }
    });

}

function agregarServicioManual(){
    var tab = $('#tblServicio tbody')[0];
    var ren = tab.insertRow(tab.rows.length);
    ren.dataset.id = 0;

    var c1 = ren.insertCell();
    var c2 = ren.insertCell();
    var c3 = ren.insertCell();
    var c4 = ren.insertCell();

    c1.innerHTML = '<input type="text" name="txtCodigo" class="form-control" value="N/A" readonly>';
    c2.innerHTML = '<input type="text" name="txtDescripcionServicio" class="form-control">';
    c3.innerHTML = '<input type="number" name="txtPrecio" class="form-control">';
    c4.innerHTML = '<button onclick="removerServicio(this)" style="margin-left: 10px;" type="button" class="btn btn-danger btn-xs eliminar"><i class="fa fa-minus"></i></button>';

    //$('#tblServicio tr th:first, #tblServicio tr td:first').hide();
}

function removerServicio(btn){
    if(confirm("¿Desea eliminar servicio?"))
    {
        var ren = $(btn).closest('tr')[0];
        $(ren).remove();

        if($('#tblServicio tbody tr').length == 0)
        {
            $('#opSitio').attr('disabled', false);
        }
    }
}

function verServicio(btn){
    var r = $(btn).closest('tr')[0];
    var serv = JSON.parse(r.dataset.servicios);

    $('#tblMdlServicios tbody tr').remove();
    var tab = $('#tblMdlServicios tbody')[0];

    serv.forEach(function(elem){
        var ren = tab.insertRow(tab.rows.length);
        ren.insertCell().innerHTML = elem[1];
        ren.insertCell().innerHTML = elem[2];
    });
    
    $('#mdlVerServicio').modal();
}


/* AQUI HAY QUE MODIFICAR PARA ADJUNTAR VARIOS SERVICIOS */
function validacionAgregarConcepto(){
    
    Concepto = {};
    Concepto.atributos = {};

    if($('#rbOtro').is(':checked'))
    {
        if($('#divOtro input[name="rbOtros"]:checked').val() == 'cabezal' && !$('#txtBusqueda1').val()){
            alert('Ingrese nombre de cabezal');
            return;
        }

        ///// C O N C E P T O /////
        Concepto.id = 0;
        Concepto.cantidad = 1;
        Concepto.descripcion = $('#divOtro input[name="rbOtros"]:checked').val() == 'cabezal' ? $('#txtBusqueda1').val() : "N/A";
        Concepto.atributos.otro = $('#divOtro input[name="rbOtros"]:checked').val() == 'cabezal' ? "CABEZAL" : "SEPARADOR";
        Concepto.atributos = JSON.stringify(Concepto.atributos);

        agregarConceptoOtro(Concepto);
    }
    else
    {
        //Concepto.revision = REV;
        Concepto.cantidad = 1;

        var iptEqui = $('#divEquipo').data('ipt');
        var iptServ = $('#divServicio').data('ipt');

        Concepto.cantidadRO = iptEqui ? "0" : "1";

        Concepto.descripcion = iptEqui ? $('#txtDescripcion').val().trim() : $('#cllDescripcion').text().trim();

        
        if($('#divEquipo').is(':visible'))
        {
            Concepto.atributos.ID = iptEqui ? $('#txtIdEquipo').val().trim() : $('#cllIdEquipo').text().trim();
            Concepto.atributos.Marca = iptEqui ? $('#txtMarca').val().trim() : $('#cllMarca').text().trim();
            Concepto.atributos.Modelo = iptEqui ? $('#txtModelo').val().trim() : $('#cllModelo').text().trim();
            Concepto.atributos.Serie = iptEqui ? $('#txtSerie').val().trim() : $('#cllSerie').text().trim();
        }

        Concepto.servicios = [];
        Concepto.precio_unitario = 0;
        if($('#divServicio').is(':visible'))
        {
            var rows = $('#tblServicio tbody tr');
            if(rows.length == 0 && $('#opSitio').val() != "EXT")
            {
                alert("Ingrese servicio(s) a realizar");
                return;
            }

            $.each(rows, function(i, row){
                var prize = $(row).data('id') == 0 ? parseFloat($(row).find('[name="txtPrecio"]').val()) : parseFloat($(row).data('precio'));
                Concepto.servicios.push(Array(
                    $(row).data('id'),
                    $(row).data('id') == 0 ? $(row).find('[name="txtCodigo"]').val() : $(row).data('codigo'),
                    $(row).data('id') == 0 ? $(row).find('[name="txtDescripcionServicio"]').val() : $(row).data('descripcion'),
                    prize
                ));
                Concepto.precio_unitario += prize;
            });

            Concepto.sitio = $('#opSitio').val();
        } 
        else if($('#divConcepto').is(':visible'))
        {
            Concepto.precio_unitario = parseFloat($('#txtPrecio').val());

            Concepto.sitio = $('#opSitioConcepto').val();
        }

        Concepto.comentarios = "";
        //Concepto.tiempo_entrega = 1;
        //Concepto.precio_unitario = iptServ ? $('#txtPrecio').val().trim() : $('#cllPrecio').text().trim();
        
        if(!$('#divEquipo').is(':visible') && !$('#divConcepto').is(':visible'))
        {
            alert("Es necesario ingresar un equipo");
            return;
        }
        if(!$('#divServicio').is(':visible') && !$('#divConcepto').is(':visible'))
        {
            alert("Es necesario ingresar un servicio");
            return;
        }

        if(!Concepto.descripcion)
        {
            alert("Por favor ingrese descripción del equipo o concepto");
            return;
        }
        
        if($('#divEquipo').is(':visible'))
        {
            if(!Concepto.atributos.ID)
            {
                alert("Por favor ingrese ID de equipo");
                return;
            }
            if(!Concepto.atributos.Marca)
            {
                alert("Por favor ingrese marca del equipo");
                return;
            }
            if(!Concepto.atributos.Modelo)
            {
                alert("Por favor ingrese modelo del equipo");
                return;
            }
            if(!Concepto.atributos.Serie)
            {
                alert("Por favor ingrese serie del equipo");
                return;
            }
        }

        if(Concepto.servicios.length > 0)
        {
            var msj = false;
            $.each(Concepto.servicios, function(i, elem){
                if(!elem[2] && !msj)
                {
                    alert("Por favor ingrese descripción del servicio");
                    msj = true;
                    return;
                }
            });
        }



        if(!Concepto.sitio)
        {
            alert("Por favor seleccione sitio del servicio a realizarse");
            return;
        }
        if(!Concepto.precio_unitario)
        {
            alert("Por favor ingrese precio unitario");
            return;
        }

        var existe = false;
        //VALIDACION REPETICION ID
        if(Concepto.atributos.ID)
        {
            
            var renglones = $('#tblConceptos tbody tr').toArray();
            renglones.forEach(function(elem, i){
                if(JSON.parse(elem.dataset.atributos).ID == Concepto.atributos.ID)
                {
                    
                    existe = true;
                }
            });
        }


        if(existe)
        {
            alert("ID de equipo ya se encuentra en la cotización");
        }
        else
        {
            Concepto.atributos = JSON.stringify(Concepto.atributos);
            Concepto.id = 0;
            agregarConcepto(Concepto);
        }
    }

    
    
}

function agregarConcepto(Concepto){
    //////////////////////////////////////////////////////////////////

    $('#btnVerPDF').hide();
    $('#btnSolAprob').hide();

    var tab = $('#tblConceptos tbody')[0];
    var ren = tab.insertRow(tab.rows.length);
    
    
    ren.dataset.registro = Concepto.id;
    ren.dataset.cantidad = Concepto.cantidad;
    ren.dataset.servicios = JSON.stringify(Concepto.servicios);
    ren.dataset.descripcion = Concepto.descripcion;
    ren.dataset.atributos = Concepto.atributos;

    var cellText = '';
    var atr = JSON.parse(Concepto.atributos);
    $.each(atr, function(i, elem){
        cellText += ' <b>' + i + ':</b> ' + elem + ",";
    });

    var c1 = ren.insertCell();
    var c2 = ren.insertCell();
    var c3 = ren.insertCell();
    var c4 = ren.insertCell();
    var c5 = ren.insertCell();
    var c6 = ren.insertCell();
    var c7 = ren.insertCell();
    var c8 = ren.insertCell();
    var c9 = ren.insertCell();

    var RO = Concepto.cantidadRO == "1" ? 'readonly' : '';

    c1.innerHTML = 0;
    c2.innerHTML = '<input name="txtCant" style="text-align:center;" type="number" min="1" class="form-control iptChange" value="' + Concepto.cantidad + '" ' + RO + '>';
    
    
    c3.innerHTML = Concepto.descripcion + "<br>";
    c3.innerHTML += cellText.substring(0, cellText.length - 1);
    if(Concepto.servicios.length > 0)
    {
        c4.innerHTML = '<button style="width: 90%;" name="btnServicio" onclick="verServicio(this)" class="btn btn-success btn-sm" type="button"><i class="fa fa-spinner"></i> ' + Concepto.servicios.length + ' Servicio' + (Concepto.servicios.length > 1 ? 's' : '') + '</button>';
    }
    else
    {
        c4.innerHTML = 'N/A';
    }

    var btnDel = '';
    var select = '<select style="width: 90%;" name="opSitio" class="form-control iptChange">';
    select +=       '<option value="' + Concepto.sitio + '">' + Concepto.sitio + '</option>';
    select += '</select>';

    c5.innerHTML = '<textarea placeholder="Comentarios" name="txtComentarios" style="display: inline; resize: none; height: 40px;" class="form-control iptChange">' + Concepto.comentarios + '</textarea>';
    c6.innerHTML = select;
    c7.innerHTML = '<input name="txtEntrega" style="text-align:center;" type="number" class="form-control iptChange" min="0" value=' + Concepto.tiempo_entrega + '>';
    c8.innerHTML = '<input name="txtPU" style="text-align:right;" type="number" class="form-control iptChange" value=' + parseFloat(Concepto.precio_unitario).toFixed(2) + '>';
    c9.innerHTML = '<button onclick="eliminarConcepto(this)" style="margin-left: 10px;' + btnDel + '" type="button" class="btn btn-danger btn-xs eliminar"><i class="fa fa-minus"></i></button>';
    

    $(ren).find('select[name="opSitio"]').val(Concepto.sitio);
    
    $(ren).find('.iptChange').on('change', function(){
        $('#btnVerPDF').hide();
        $('#btnSolAprob').hide();
    });

    $(ren).find('.iptChange').on('keypress', function(){
        $('#btnVerPDF').hide();
        $('#btnSolAprob').hide();
    });

    $('#mdlConcepto').modal('hide');

    numerarTabla();
}

function agregarConceptoOtro(Concepto){
    //////////////////////////////////////////////////////////////////

    var tipo = JSON.parse(Concepto.atributos).otro;

    $('#btnVerPDF').hide();
    $('#btnSolAprob').hide();

    var tab = $('#tblConceptos tbody')[0];
    var ren = tab.insertRow(tab.rows.length);

    ren.dataset.cantidad = Concepto.cantidad;
    ren.dataset.registro = Concepto.id;
    ren.dataset.descripcion = Concepto.descripcion;
    ren.dataset.servicios = "[]";
    ren.dataset.atributos = Concepto.atributos;

    var c1 = ren.insertCell();
    var c2 = ren.insertCell();
    var c3 = ren.insertCell();
    var c4 = ren.insertCell();
    var c5 = ren.insertCell();
    var c6 = ren.insertCell();
    var c7 = ren.insertCell();
    var c8 = ren.insertCell();
    var c9 = ren.insertCell();


    c1.innerHTML = 0;
    c2.innerHTML = '';
    c3.innerHTML = tipo == 'CABEZAL' ? '<b>Cabezal: ' + Concepto.descripcion + '</b>' : '============ S E P A R A D O R ============';
    c4.innerHTML = '';
    c5.innerHTML = '';
    c6.innerHTML = '';
    c7.innerHTML = '';
    c8.innerHTML = '';
    c9.innerHTML = '<button onclick="eliminarConcepto(this)" style="margin-left: 10px;" type="button" class="btn btn-danger btn-xs eliminar"><i class="fa fa-minus"></i></button>';

    $('#mdlConcepto').modal('hide');

    numerarTabla();
}

////////////// NUEVA REVISION

function nuevaRevision(){
    if(confirm("¿Desea crear una nueva revisión?"))
    {
        var rev = parseInt(COTIZACION.UltRev) + 1;
        $('#lblPnlConceptos').text("Conceptos (Rev: " + rev + ")");
        $("#divCtrl").hide();
        $('.revision').hide();
        $('#btnAgregarPartidas').show();
        $('#btnGuardarRevision').show();
        $('#btnCancelarRevision').show();

        $('#tblConceptos tbody .eliminar').show();
        $('#tblConceptos tbody textarea').attr('readonly', false);
        $('#tblConceptos tbody input').attr('readonly', false);
        $('#tblConceptos tbody select').attr('disabled', false);
    }
}

function cancelarRevision(){
    if(confirm("¿Desea cancelar la revisión actual?"))
    {
        $.redirect( base_url + "cotizaciones/ver_cotizacion", { 'id': ID });
    }
}

function cambiarRevision(opt){
    cargarConceptos($(opt).val());

    if($(opt).val() == COTIZACION.UltRev)
    {
        $('#divCtrl').show();
        controles(COTIZACION.estatus);
    }
    else
    {
        $('#divCtrl').hide();
        controles(COTIZACION.estatus);

        $('button.solicitud').hide();
        $('button.eliminar').hide();
        $('button.ctrlEdicion').hide();
        
        $('#tblConceptos input, #tblConceptos textarea').attr('readonly', true);
        $('#tblConceptos select').attr('disabled', true);
    }
    
}

function numerarTabla(){
    var tab = $('#tblConceptos')[0];
    var i = 1;
    $(tab.rows).each(function(){
        if(this.rowIndex > 0 && $(this).is(':visible'))
        {
            this.cells[0].innerHTML = i;
            i++;
        }
    });
}

function ver_pdf(){
    var rev_act = $("#optRevision").val();
    $.redirect(base_url + "cotizaciones/cotizacion_pdf/" + ID + "-" + rev_act, null, null, '_blank');
}

////////////// ACEPTAR

function validacion(){
    if(!$('#btnClientes').data('id'))
    {
        alert("Seleccione Cliente");
        return false;
    }
    if(CONTACTOS.length == 0)
    {
        alert("Seleccione Contactos");
        return false;
    }

    var rows = $('#tblConceptos tbody tr:visible');
    if(rows.length <= 0)
    {
        alert("La tabla Conceptos se encuentra vacia");
        return false;
    }

    for (let index = 0; index < rows.length; index++)
    {
        var attr = $(rows[index]).data('atributos');
        
        if(attr.otro == undefined)
        {
            var cant = $(rows[index]).find("input[name='txtCant']").val();
            var tiempoE = $(rows[index]).find("input[name='txtEntrega']").val();
            var precioU = $(rows[index]).find("input[name='txtPU']").val();
    
            if(cant <= 0)
            {
                alert("Capture campo 'Cantidad' con un valor valido");
                return false;
            }
            if(!tiempoE || (tiempoE < 0))
            {
                alert("Capture campo 'Tiempo de Entrega' con un valor valido");
                return false;
            }
            if(precioU <= 0)
            {
                alert("Capture campo 'Precio Unitario' con un valor valido");
                return false;
            }
        }

    }

    return confirm("¿Desea continuar?");
}

function crearCotizacion(){
    if(validacion()){
        var cotizacion = {};
        cotizacion.id = 0;
        cotizacion.responsable = $('#btnRequisitor').data('id');
        cotizacion.empresa = $('#btnClientes').data('id');
        cotizacion.planta = $('#lblPlantaCliente').data('id');
        cotizacion.contactos = JSON.stringify(CONTACTOS);
        
        cotizacion.tipo = $('#opTipo').val();
        cotizacion.moneda = $('#opMoneda').val();
        cotizacion.tipo_cambio = $('#btnTipoCambio').val();
        cotizacion.impuesto_nombre = $('#opIVA option:selected').data('nombre');
        cotizacion.impuesto_factor = $('#opIVA').val();
        cotizacion.notas = $('#txtNotas').val();
        cotizacion.estatus = "CREADA";
        cotizacion.enviar_autorizar = 0;
        cotizacion.aprobador = 0;
        cotizacion.confirmacion = 0;
        var bitacora = [cotizacion.estatus, moment().format('D/MM/YYYY h:mm A'), ID_USER];
        cotizacion.bitacora_estatus = JSON.stringify([bitacora]);
        
        var conceptos = [];
        var rows = $('#tblConceptos tbody tr');
        for (let index = 0; index < rows.length; index++)
        {
            var concepto = {};
            concepto.id = rows[index].dataset.registro;
            concepto.revision = 0;
            concepto.cantidad = $(rows[index]).find("input[name='txtCant']").val();
            concepto.descripcion = rows[index].dataset.descripcion;
            concepto.atributos = rows[index].dataset.atributos
            concepto.servicios = rows[index].dataset.servicios;

            concepto.comentarios = $(rows[index]).find("textarea[name='txtComentarios']").val();
            concepto.sitio = $(rows[index]).find("select[name='opSitio']").val();
            concepto.tiempo_entrega = $(rows[index]).find("input[name='txtEntrega']").val();
            concepto.precio_unitario = $(rows[index]).find("input[name='txtPU']").val();
            concepto.po = "";
            
            conceptos.push(concepto);
        }

        /////////////////////////////////////////////////////
        var URL = base_url + "cotizaciones/ajax_setCotizacion";
        $.ajax({
            type: "POST",
            url: URL,
            data: { cotizacion : JSON.stringify(cotizacion), conceptos : JSON.stringify(conceptos) },
            success: function(result) {
                if(result)
                {
                    $.redirect( base_url + "cotizaciones/ver_cotizacion", { 'id': result });
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });

    }

}

function guardarCotizacion(){
    if(validacion()){
        var cotizacion = {};
        cotizacion.id = COTIZACION.id;
        cotizacion.responsable = $('#btnRequisitor').data('id');
        cotizacion.empresa = $('#btnClientes').data('id');
        cotizacion.planta = $('#lblPlantaCliente').data('id');
        cotizacion.contactos = JSON.stringify(CONTACTOS);
        
        cotizacion.tipo = $('#opTipo').val();
        cotizacion.moneda = $('#opMoneda').val();
        cotizacion.tipo_cambio = $('#btnTipoCambio').val();
        cotizacion.impuesto_nombre = $('#opIVA option:selected').data('nombre');
        cotizacion.impuesto_factor = $('#opIVA').val();
        cotizacion.notas = $('#txtNotas').val();
        cotizacion.estatus = COTIZACION.estatus;
        
        var conceptos = [];
        var rows = $('#tblConceptos tbody tr');
        for (let index = 0; index < rows.length; index++)
        {
            var concepto = {};
            concepto.id = rows[index].dataset.registro;
            concepto.revision = COTIZACION.UltRev;
            concepto.cantidad = $(rows[index]).find("input[name='txtCant']").val() ? $(rows[index]).find("input[name='txtCant']").val() : 1;
            concepto.descripcion = rows[index].dataset.descripcion;
            concepto.atributos = rows[index].dataset.atributos
            concepto.servicios = rows[index].dataset.servicios;

            concepto.comentarios = $(rows[index]).find("textarea[name='txtComentarios']").val() ? $(rows[index]).find("textarea[name='txtComentarios']").val() : "";
            concepto.sitio = $(rows[index]).find("select[name='opSitio']").val() ? $(rows[index]).find("select[name='opSitio']").val() : "N/A";
            concepto.tiempo_entrega = $(rows[index]).find("input[name='txtEntrega']").val() ? $(rows[index]).find("input[name='txtEntrega']").val() : 0;
            concepto.precio_unitario = $(rows[index]).find("input[name='txtPU']").val() ? $(rows[index]).find("input[name='txtPU']").val() : 0;
            concepto.po = "";
            
            conceptos.push(concepto);
        }

        /////////////////////////////////////////////////////
        var URL = base_url + "cotizaciones/ajax_setCotizacion";
        $.ajax({
            type: "POST",
            url: URL,
            data: { cotizacion : JSON.stringify(cotizacion), conceptos : JSON.stringify(conceptos) },
            success: function(result) {
                if(result)
                {
                    alert("Se ha guardado Cotización con exito");
                    $.redirect( base_url + "cotizaciones/ver_cotizacion", { 'id': result });
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });

    }

}

function crearRevision(){
    if(validacion()){
        var cotizacion = {};
        cotizacion.id = COTIZACION.id;
        cotizacion.responsable = $('#btnRequisitor').data('id');
        cotizacion.empresa = $('#btnClientes').data('id');
        cotizacion.planta = $('#lblPlantaCliente').data('id');
        cotizacion.contactos = JSON.stringify(CONTACTOS);
        
        cotizacion.tipo = $('#opTipo').val();
        cotizacion.moneda = $('#opMoneda').val();
        cotizacion.tipo_cambio = $('#btnTipoCambio').val();
        cotizacion.impuesto_nombre = $('#opIVA option:selected').data('nombre');
        cotizacion.impuesto_factor = $('#opIVA').val();
        cotizacion.notas = $('#txtNotas').val();
        cotizacion.estatus = "EN REVISION";
        cotizacion.aprobador = 0;
        
        var conceptos = [];
        var rows = $('#tblConceptos tbody tr:visible');
        for (let index = 0; index < rows.length; index++)
        {
            var concepto = {};
            concepto.id = 0;
            concepto.revision = parseInt(COTIZACION.UltRev) + 1;
            concepto.cantidad = $(rows[index]).find("input[name='txtCant']").val();
            concepto.descripcion = rows[index].dataset.descripcion;
            concepto.atributos = rows[index].dataset.atributos
            concepto.servicios = rows[index].dataset.servicios;

            concepto.comentarios = $(rows[index]).find("textarea[name='txtComentarios']").val();
            concepto.sitio = $(rows[index]).find("select[name='opSitio']").val();
            concepto.tiempo_entrega = $(rows[index]).find("input[name='txtEntrega']").val();
            concepto.precio_unitario = $(rows[index]).find("input[name='txtPU']").val();
            concepto.po = "";
            
            conceptos.push(concepto);
        }

        /////////////////////////////////////////////////////
        var URL = base_url + "cotizaciones/ajax_setRevision";
        $.ajax({
            type: "POST",
            url: URL,
            data: { cotizacion : JSON.stringify(cotizacion), conceptos : JSON.stringify(conceptos) },
            success: function(result) {
                if(result)
                {
                    $.redirect( base_url + "cotizaciones/ver_cotizacion", { 'id': ID });
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });

    }

}

function solicitarAprobacion(btn){
    if(validacion()){
        $(btn).attr('disabled', true);

        var cotizacion = {};
        cotizacion.id = COTIZACION.id;
        cotizacion.responsable = $('#btnRequisitor').data('id');
        cotizacion.empresa = $('#btnClientes').data('id');
        cotizacion.planta = $('#lblPlantaCliente').data('id');
        cotizacion.contactos = JSON.stringify(CONTACTOS);
        
        cotizacion.tipo = $('#opTipo').val();
        cotizacion.moneda = $('#opMoneda').val();
        cotizacion.tipo_cambio = $('#btnTipoCambio').val();
        cotizacion.impuesto_nombre = $('#opIVA option:selected').data('nombre');
        cotizacion.impuesto_factor = $('#opIVA').val();
        cotizacion.notas = $('#txtNotas').val();
        cotizacion.estatus = "PENDIENTE AUTORIZACION";
        cotizacion.bitacora_estatus = JSON.parse(COTIZACION.bitacora_estatus);
        cotizacion.bitacora_estatus.push([cotizacion.estatus, moment().format('D/MM/YYYY h:mm A'), ID_USER]);
        cotizacion.bitacora_estatus = JSON.stringify(cotizacion.bitacora_estatus);

        cotizacion.enviar_autorizar = $('#cbEnviarAutorizar').is(':checked') ? 1 : 0;
        
        var conceptos = [];
        var rows = $('#tblConceptos tbody tr');
        for (let index = 0; index < rows.length; index++)
        {
            var concepto = {};
            concepto.id = rows[index].dataset.registro;
            concepto.revision = COTIZACION.UltRev;
            concepto.cantidad = $(rows[index]).find("input[name='txtCant']").val();
            concepto.descripcion = rows[index].dataset.descripcion;
            concepto.atributos = rows[index].dataset.atributos
            concepto.servicios = rows[index].dataset.servicios;

            concepto.comentarios = $(rows[index]).find("textarea[name='txtComentarios']").val();
            concepto.sitio = $(rows[index]).find("select[name='opSitio']").val();
            concepto.tiempo_entrega = $(rows[index]).find("input[name='txtEntrega']").val();
            concepto.precio_unitario = $(rows[index]).find("input[name='txtPU']").val();
            concepto.po = "";
            
            conceptos.push(concepto);
        }

        /////////////////////////////////////////////////////
        var comentario = $("#txtComentariosAprobacion").val().trim();
        if(comentario.length > 0)
        {
            comentario = "<b><font color=blue>SOLICITUD AUTORIZACIÓN:</font></b> " + comentario;
        }

        var URL = base_url + "cotizaciones/ajax_setCotizacion";
        $.ajax({
            type: "POST",
            url: URL,
            data: { cotizacion : JSON.stringify(cotizacion), conceptos : JSON.stringify(conceptos), comentarios : comentario },
            success: function(result) {
                if(result)
                {
                    $.redirect( base_url + "cotizaciones/ver_cotizacion", { 'id': result });
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });

    }

}

function rechazarCotizacion(btn){
    var comentario = $("#txtComentariosRechazar").val().trim();
    if(comentario.length < 10)
    {
        alert("Ingrese motivo de rechazo (min. 10 Caracteres)");
        return;
    }

    $(btn).attr('disabled', true);

    comentario = "<b><font color=red>RECHAZADO:</font></b> " + comentario;

    var cotizacion = {};
    cotizacion.id = COTIZACION.id;
    cotizacion.estatus = "RECHAZADA";
    cotizacion.bitacora_estatus = JSON.parse(COTIZACION.bitacora_estatus);
    cotizacion.bitacora_estatus.push([cotizacion.estatus, moment().format('D/MM/YYYY h:mm A'), ID_USER]);
    cotizacion.bitacora_estatus = JSON.stringify(cotizacion.bitacora_estatus);

    /////////////////////////////////////////////////////
    var URL = base_url + "cotizaciones/ajax_setCotizacion";
    $.ajax({
        type: "POST",
        url: URL,
        data: { cotizacion : JSON.stringify(cotizacion), conceptos : "[]", comentarios : comentario },
        success: function(result) {
            if(result)
            {
                $.redirect( base_url + "cotizaciones/ver_cotizacion", { 'id': result });
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function cancelarCotizacion(){
    var cotizacion = {};
    cotizacion.id = COTIZACION.id;
    cotizacion.estatus = "CANCELADA";
    cotizacion.aprobador = 0;
    /////////////////////////////////////////////////////
    var URL = base_url + "cotizaciones/ajax_setCotizacion";
    $.ajax({
        type: "POST",
        url: URL,
        data: { cotizacion : JSON.stringify(cotizacion), conceptos : "[]" },
        success: function(result) {
            if(result)
            {
                $.redirect( base_url + "cotizaciones/ver_cotizacion", { 'id': result });
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function mdlAprobar(){
    if(COTIZACION.enviar_autorizar == "1")
    {
        $('#txtEnviarAprobar').show();
        $('#btnAprobar').html("<i class='fa fa-check'></i> Aprobar y Enviar");
    }
    $('#mdlAprobar').modal();
}

function aprobarCotizacion(btn){
    $(btn).attr('disabled', true);
    var comentario = $("#txtComentariosAprobar").val().trim();
    if(comentario.length > 0)
    {
        comentario = "<b><font color=green>AUTORIZADO:</font></b> " + comentario;
    }

    var cotizacion = {};
    cotizacion.id = COTIZACION.id;
    cotizacion.estatus = "AUTORIZADA";
    cotizacion.bitacora_estatus = JSON.parse(COTIZACION.bitacora_estatus);
    cotizacion.bitacora_estatus.push([cotizacion.estatus, moment().format('D/MM/YYYY h:mm A'), ID_USER]);
    cotizacion.bitacora_estatus = JSON.stringify(cotizacion.bitacora_estatus);
    cotizacion.enviar_autorizar = COTIZACION.enviar_autorizar;

    /////////////////////////////////////////////////////
    var URL = base_url + "cotizaciones/ajax_setCotizacion";
    $.ajax({
        type: "POST",
        url: URL,
        data: { cotizacion : JSON.stringify(cotizacion), conceptos : "[]", comentarios : comentario },
        success: function(result) {
            if(result)
            {
                if(cotizacion.enviar_autorizar == "1")
                {
                    setCorreoTexto($('#opTipo').val());
                    enviarCorreo();
                }
                else
                {
                    $.redirect( base_url + "cotizaciones/ver_cotizacion", { 'id': result });
                }

                $(btn).attr('disabled', true);
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function reactivarCotizacion(){
    if(confirm("¿Desea reactivar cotización?")){
        var cotizacion = {};
        cotizacion.id = COTIZACION.id;
        cotizacion.estatus = "CREADA";
        if(COTIZACION.UltRev > 0)
        {
            cotizacion.estatus = "EN REVISION";
        }
        
        
        cotizacion.bitacora_estatus = JSON.parse(COTIZACION.bitacora_estatus);
        cotizacion.bitacora_estatus.push([cotizacion.estatus, moment().format('D/MM/YYYY h:mm A'), ID_USER]);
        cotizacion.bitacora_estatus = JSON.stringify(cotizacion.bitacora_estatus);
        
        

        /////////////////////////////////////////////////////
        var URL = base_url + "cotizaciones/ajax_setCotizacion";
        $.ajax({
            type: "POST",
            url: URL,
            data: { cotizacion : JSON.stringify(cotizacion), conceptos : "[]" },
            success: function(result) {
                if(result)
                {
                    $.redirect( base_url + "cotizaciones/ver_cotizacion", { 'id': result });
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}

function confirmarCotizacion(){
    if($('input[name="rbConfirmacion"]:checked').val() == undefined)
    {
        alert("Seleccione método de confirmación");
        return;
    }

    if(confirm("¿Desea confirmar cotización?")){
        var cotizacion = {};
        cotizacion.id = COTIZACION.id;
        cotizacion.estatus = "CONFIRMADA";
        cotizacion.bitacora_estatus = JSON.parse(COTIZACION.bitacora_estatus);
        cotizacion.bitacora_estatus.push([cotizacion.estatus, moment().format('D/MM/YYYY h:mm A'), ID_USER]);
        cotizacion.bitacora_estatus = JSON.stringify(cotizacion.bitacora_estatus);
        cotizacion.confirmacion = $('input[name="rbConfirmacion"]:checked').val();

        /////////////////////////////////////////////////////
        var URL = base_url + "cotizaciones/ajax_setCotizacion";
        $.ajax({
            type: "POST",
            url: URL,
            data: { cotizacion : JSON.stringify(cotizacion), conceptos : "[]" },
            success: function(result) {
                if(result)
                {
                    $.redirect( base_url + "cotizaciones/ver_cotizacion", { 'id': result });
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}

////////////// CORREO

function mdlCorreo(){
    setCorreoTexto($('#opTipo').val());
    $('#mdlCorreo').modal();
}

function setCorreoTexto(tipo){
    $('#tags_1').val(CORREOS);

    var texto = '<p style="font-family:Calibri">Buen día: ' + TextoCorreo.contacto + '</p>';
    switch (tipo) {
        case "CALIBRACION":
        case "ESTUDIO DIMENSIONAL":
        case "RENTA":
        case "REPARACION":
        case "VENTA":
        case "SOPORTE":
        case "CALIBRACION EXTERNA":
        case "MAPEO":
        case "LISTA PRECIOS":
            texto += '<p style="font-family:Calibri">'
            + 'Por este medio le estamos enviando la cotización solicitada, esperando sea de su agrado. Nuestro compromiso es servirle, asi que no dude en '
            + 'contactarnos si tiene cualquier pregunta relacionada con la información aquí presentada. Favor de confirmar la recepción de la presente propuesta.'
            + '</p>'

            + '<p style="font-family:Calibri">'
            + 'Agradeciendo la oportunidad de atenderle quedamos en espera de sus comentarios.'
            + '</p>'

            + '<p style="font-family:Calibri">'
            + 'Metrología Aplicada y Servicios</p>';
            break;
    }

    texto += '<p style="font-family:Calibri">'
    + TextoCorreo.responsable + '<br>'
    + '1-800-CALIBRA (225-4272)<br>'
    + '(656) 980-0800 </p>';

    $('#editor-one').html(texto);
}

function enviarCorreo(){
    if(validacionCorreo())
    {
        $('#mdlCorreo').modal('hide');
        var URL = base_url + 'cotizaciones/ajax_enviarCorreo';
        var asunto = $('#txtAsunto').val().trim();
        var text = $('#editor-one').html().trim();
        var para = $('#tags_1').val().trim();
        var cc = $('#tags_2').val().trim();


        COTIZACION.bitacora_estatus = JSON.parse(COTIZACION.bitacora_estatus);
        COTIZACION.bitacora_estatus.push(["ENVIADA", moment().format('D/MM/YYYY h:mm A'), ID_USER]);
        COTIZACION.bitacora_estatus = JSON.stringify(COTIZACION.bitacora_estatus);

        $.ajax({
            type: "POST",
            url: URL,
            data: { asunto : asunto, body : text, para : para, cc : cc, cotizacion : JSON.stringify(COTIZACION) },
            success: function (result) 
            {
                if (result) {
                    $.redirect( base_url + "cotizaciones/ver_cotizacion", { 'id': COTIZACION.id });
                }
            },
        });
    }
}

function validacionCorreo(){
    if(!$('#tags_1').val().trim())
    {
        alert('Campo de remitentes esta vacío');
        return false;
    }
    return confirm("¿Desea enviar correo?");
}

/////////// C I E R R E 
function mdlPONumbers(){
    var URL = base_url + "cotizaciones/ajax_getCotizacionConceptos";

    $.ajax({
        type: "POST",
        url: URL,
        data: { cotizacion : ID, revision : COTIZACION.UltRev },
        success: function(result) {
            $('#tblPONumbers tbody tr').remove();
            if(result)
            {   
                var tab = $('#tblPONumbers tbody')[0];             
                var conceptos = JSON.parse(result);
                
                $.each(conceptos, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id = elem.id;
                    ren.insertCell().innerHTML = elem.cantidad;
                    ren.insertCell().innerHTML = elem.descripcion;
                    ren.insertCell().innerHTML = elem.sitio;
                    ren.insertCell().innerHTML = "<input name='txtPO' value='" + elem.po + "' style='text-transform: uppercase;' type='text' maxlength='25' class='form-control' " + (COTIZACION.estatus != "EN APROBACION" ? "readonly" : "") + " >";
                    if(COTIZACION.estatus != "EN APROBACION")
                    {
                        $('#btnGuardarPONumbers').hide();
                    }
                });

                $('#mdlPONumbers').modal();
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function guardarPONumbers(){
    if(confirm("¿Desea continuar?"))
    {
        var cotizacion = {};
        cotizacion.id = COTIZACION.id;
        //cotizacion.estatus = "CERRADA";

        var conceptos = [];
        var rows = $('#tblPONumbers tbody tr');
        for (let index = 0; index < rows.length; index++)
        {
            var concepto = {};
            concepto.id = rows[index].dataset.id;
            concepto.po = $(rows[index]).find("input[name='txtPO']").val().trim().toUpperCase();
            
            conceptos.push(concepto);
        }

        /////////////////////////////////////////////////////
        var URL = base_url + "cotizaciones/ajax_setCotizacion";
        $.ajax({
            type: "POST",
            url: URL,
            data: { cotizacion : JSON.stringify(cotizacion), conceptos : JSON.stringify(conceptos) },
            success: function(result) {
                if(result)
                {
                    //$.redirect( base_url + "cotizaciones/ver_cotizacion", { 'id': result });
                    $('#mdlPONumbers').modal('hide');
                    evaluarCierre();
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}

function en_aprobacion(){
    if("¿Desea cambiar estatus a 'EN APROBACION'?")
    {
        var cotizacion = {};
        cotizacion.id = COTIZACION.id;
        cotizacion.estatus = "EN APROBACION";
        cotizacion.bitacora_estatus = JSON.parse(COTIZACION.bitacora_estatus);
        cotizacion.bitacora_estatus.push([cotizacion.estatus, moment().format('D/MM/YYYY h:mm A'), ID_USER]);
        cotizacion.bitacora_estatus = JSON.stringify(cotizacion.bitacora_estatus);

        /////////////////////////////////////////////////////
        var URL = base_url + "cotizaciones/ajax_setCotizacion";
        $.ajax({
            type: "POST",
            url: URL,
            data: { cotizacion : JSON.stringify(cotizacion), conceptos : "[]" },
            success: function(result) {
                if(result)
                {
                    $.redirect( base_url + "cotizaciones/ver_cotizacion", { 'id': result });
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}

function evaluarCierre(){
    var URL = base_url + "cotizaciones/ajax_getCotizacionConceptos"    

    $.ajax({
        type: "POST",
        url: URL,
        data: { cotizacion : ID, revision : COTIZACION.UltRev },
        success: function(result) {
            if(result)
            {
                var pos = 0;
                var conceptos = JSON.parse(result);
                $.each(conceptos, function(i, elem){
                    if(elem.po){
                        pos++;
                    }
                });



                if(pos == 0)
                {
                    $('#btnAutorizado').hide();
                    $('#btnAutorizado').val("");
                }
                if(pos > 0)
                {
                    $('#btnAutorizado').html('<i class="fa fa-star-half-o"></i> Aprobación Parcial');
                    $('#btnAutorizado').val("Parcial");
                    $('#btnAutorizado').show();
                }
                if(pos == conceptos.length)
                {
                    $('#btnAutorizado').html('<i class="fa fa-star"></i> Aprobación Total');
                    $('#btnAutorizado').val("Total");
                    $('#btnAutorizado').show();
                }
                

            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function mdlAutorizar(btn){
    var tipo = $(btn).val();

    $('#mdlAtorizacion .modal-title').text("Aprobación " + tipo);
    $('#mdlAtorizacion').modal();
}

function autorizar(){
    var tipo = $('#btnAutorizado').val();
    var comentarios = $("#txtComentariosAutorizacion").val().trim();
    
    if(tipo == "Parcial" && !comentarios)
    {
        alert("Ingrese comentarios");
        return;
    }

    var cotizacion = {};
    cotizacion.id = COTIZACION.id;
    cotizacion.estatus = "APROBADO " + tipo.toUpperCase();
    cotizacion.bitacora_estatus = JSON.parse(COTIZACION.bitacora_estatus);
    cotizacion.bitacora_estatus.push([cotizacion.estatus, moment().format('D/MM/YYYY h:mm A'), ID_USER]);
    cotizacion.bitacora_estatus = JSON.stringify(cotizacion.bitacora_estatus);


    if(comentarios.length > 0)
    {
        comentario = "<b><font color=green>" + cotizacion.estatus + ":</font></b> " + comentarios;
    }

    var URL = base_url + "cotizaciones/ajax_setCotizacion";
    $.ajax({
        type: "POST",
        url: URL,
        data: { cotizacion : JSON.stringify(cotizacion), conceptos : '[]', comentarios : comentarios },
        success: function(result) {
            if(result)
            {
                $.redirect( base_url + "cotizaciones/ver_cotizacion", { 'id': result });
            }
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });


}

function cerrar(){
    if(confirm("¿Desea cerrar la cotización?")){
        var cotizacion = {};
        cotizacion.id = COTIZACION.id;
        cotizacion.estatus = COTIZACION.estatus.replace("APROBADO", "CERRADO");
        cotizacion.bitacora_estatus = JSON.parse(COTIZACION.bitacora_estatus);
        cotizacion.bitacora_estatus.push([cotizacion.estatus, moment().format('D/MM/YYYY h:mm A'), ID_USER]);
        cotizacion.bitacora_estatus = JSON.stringify(cotizacion.bitacora_estatus);

        /////////////////////////////////////////////////////
        var URL = base_url + "cotizaciones/ajax_setCotizacion";
        $.ajax({
            type: "POST",
            url: URL,
            data: { cotizacion : JSON.stringify(cotizacion), conceptos : "[]" },
            success: function(result) {
                if(result)
                {
                    $.redirect( base_url + "cotizaciones/ver_cotizacion", { 'id': result });
                }
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}




