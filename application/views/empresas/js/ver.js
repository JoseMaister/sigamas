var estadosMexico = '' //'<datalist id="estadosMexico">'
+ '<option value="Aguascalientes">Aguascalientes</option>'
+ '<option value="Baja California">Baja California</option>'
+ '<option value="Baja California Sur">Baja California Sur</option>'
+ '<option value="Campeche">Campeche</option>'
+ '<option value="Chiapas">Chiapas</option>'
+ '<option value="Chihuahua">Chihuahua</option>'
+ '<option value="Ciudad de México">Ciudad de México</option>'
+ '<option value="Coahuila">Coahuila</option>'
+ '<option value="Colima">Colima</option>'
+ '<option value="Durango">Durango</option>'
+ '<option value="Estado de México">Estado de México</option>'
+ '<option value="Guanajuato">Guanajuato</option>'
+ '<option value="Guerrero">Guerrero</option>'
+ '<option value="Hidalgo">Hidalgo</option>'
+ '<option value="Jalisco">Jalisco</option>'
+ '<option value="Michoacán">Michoacán</option>'
+ '<option value="Morelos">Morelos</option>'
+ '<option value="Nayarit">Nayarit</option>'
+ '<option value="Nuevo León">Nuevo León</option>'
+ '<option value="Oaxaca">Oaxaca</option>'
+ '<option value="Puebla">Puebla</option>'
+ '<option value="Querétaro">Querétaro</option>'
+ '<option value="Quintana Roo">Quintana Roo</option>'
+ '<option value="San Luis Potosí">San Luis Potosí</option>'
+ '<option value="Sinaloa">Sinaloa</option>'
+ '<option value="Sonora">Sonora</option>'
+ '<option value="Tabasco">Tabasco</option>'
+ '<option value="Tamaulipas">Tamaulipas</option>'
+ '<option value="Tlaxcala">Tlaxcala</option>'
+ '<option value="Veracruz">Veracruz</option>'
+ '<option value="Yucatán">Yucatán</option>'
+ '<option value="Zacatecas">Zacatecas</option>';

var estadosUSA = ''
+ '<option value="Alabama">Alabama</option>'
+ '<option value="Alaska">Alaska</option>'
+ '<option value="Arizona">Arizona</option>'
+ '<option value="Arkansas">Arkansas</option>'
+ '<option value="California">California</option>'
+ '<option value="Carolina del Norte">Carolina del Norte</option>'
+ '<option value="Carolina del Sur">Carolina del Sur</option>'
+ '<option value="Colorado">Colorado</option>'
+ '<option value="Connecticut">Connecticut</option>'
+ '<option value="Dakota del Norte">Dakota del Norte</option>'
+ '<option value="Dakota del Sur">Dakota del Sur</option>'
+ '<option value="Delaware">Delaware</option>'
+ '<option value="Florida">Florida</option>'
+ '<option value="Georgia">Georgia</option>'
+ '<option value="Hawai">Hawai</option>'
+ '<option value="Idaho">Idaho</option>'
+ '<option value="Illinois">Illinois</option>'
+ '<option value="Indiana">Indiana</option>'
+ '<option value="Iowa">Iowa</option>'
+ '<option value="Kansas">Kansas</option>'
+ '<option value="Kentucky">Kentucky</option>'
+ '<option value="Luisiana">Luisiana</option>'
+ '<option value="Maine">Maine</option>'
+ '<option value="Maryland">Maryland</option>'
+ '<option value="Massachusetts">Massachusetts</option>'
+ '<option value="Michigan">Michigan</option>'
+ '<option value="Minnesota">Minnesota</option>'
+ '<option value="Misisipi">Misisipi</option>'
+ '<option value="Misuri">Misuri</option>'
+ '<option value="Montana">Montana</option>'
+ '<option value="Nebraska">Nebraska</option>'
+ '<option value="Nevada">Nevada</option>'
+ '<option value="Nueva Jersey">Nueva Jersey</option>'
+ '<option value="Nueva York">Nueva York</option>'
+ '<option value="Nuevo Hampshire">Nuevo Hampshire</option>'
+ '<option value="Nuevo México">Nuevo México</option>'
+ '<option value="Ohio">Ohio</option>'
+ '<option value="Oklahoma">Oklahoma</option>'
+ '<option value="Oregon">Oregon</option>'
+ '<option value="Pensilvania">Pensilvania</option>'
+ '<option value="Rhode Island">Rhode Island</option>'
+ '<option value="Tennessee">Tennessee</option>'
+ '<option value="Texas">Texas</option>'
+ '<option value="Utah">Utah</option>'
+ '<option value="Vermont">Vermont</option>'
+ '<option value="Virginia">Virginia</option>'
+ '<option value="Virginia Occidental">Virginia Occidental</option>'
+ '<option value="Washington">Washington</option>'
+ '<option value="Wisconsin">Wisconsin</option>'
+ '<option value="Wyoming">Wyoming</option>';

var estadosCanada = ''
+ '<option value="Ontario">Ontario</option>'
+ '<option value="Quebec">Quebec</option>'
+ '<option value="Nueva Escocia">Nueva Escocia</option>'
+ '<option value="Nuevo Brunswick">Nuevo Brunswick</option>'
+ '<option value="Manitoba">Manitoba</option>'
+ '<option value="Columbia Británica">Columbia Británica</option>'
+ '<option value="Isla del Príncipe Eduardo">Isla del Príncipe Eduardo</option>'
+ '<option value="Saskatchewan">Saskatchewan</option>'
+ '<option value="Alberta">Alberta</option>'
+ '<option value="Terranova y Labrador">Terranova y Labrador</option>'
+ '<option value="Territorios del Noroeste">Territorios del Noroeste</option>'
+ '<option value="Yukon">Yukon</option>'
+ '<option value="Nunavut">Nunavut</option>';


function load(){
    cargarCiudades();
    cargarListadoDocumentos();
    cargarArchivos();
    cargarFactura_ejemplo();
    cargarPlantas();
}

function cargarFactura_ejemplo(){
    
    $('#tblArchivoEjemplo tbody tr').remove();
    var URL = base_url + 'empresas/ajax_getFacturaEjemplo';

    $.ajax({
        type: "POST",
        url: URL,
        data: { empresa : ID_EMPRESA },
        success: function (response) {
            var tbl = $('#tblArchivoEjemplo tbody')[0];
            if(response){
                var row = tbl.insertRow();
                row.insertCell().innerHTML = response;
                
                var r = '<a target="_blank" href="' + base_url + 'data/empresas/ejemplo_facturas/' + response + '" class="btn btn-primary btn-xs"><i class="fa fa-download"></i> Abrir Archivo</a>';
                if(PRIVILEGIOS.administrar_empresas_facturacion == "1")
                {
                    r += '<button type="button" onclick="borrarFacturaEjemplo()" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Eliminar</button>';
                }

                row.insertCell().innerHTML = r;
                
            }
            else
            {
                var ipt = '<label class="btn btn-success btn-xs" for="iptFacturaEjemplo"><input onchange="subirFacturaEjemplo()" type="file" class="sr-only" id="iptFacturaEjemplo"><i class="fa fa-upload"></i> Subir Archivo</label>';
                var row = tbl.insertRow();
                row.insertCell().innerHTML = PRIVILEGIOS.administrar_empresas_facturacion == "1" ? ipt : '';
                row.insertCell().innerHTML = '';
            }
        }
    });
}

function _(el) {
    return document.getElementById(el);
}

function subirFacturaEjemplo(){
    var file = _("iptFacturaEjemplo").files[0];
    var URL = base_url + 'empresas/ajax_setFacturaEjemplo';

    var formdata = new FormData();
    formdata.append("file", file);
    formdata.append("empresa", ID_EMPRESA);

    var ajax = new XMLHttpRequest();
    //ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", cargarFactura_ejemplo, false);
    //ajax.addEventListener("error", errorHandler, false);
    //ajax.addEventListener("abort", errorHandler, false);
    ajax.open("POST", URL);
    ajax.send(formdata);
}

function borrarFacturaEjemplo(){
    if(confirm("¿Desea eliminar archivo?")){
        var URL = base_url + 'empresas/ajax_deleteFacturaEjemplo';

        $.ajax({
            type: "POST",
            url: URL,
            data: { empresa : ID_EMPRESA },
            success: function (response) {
                cargarFactura_ejemplo();
            }
        });
    }
}








function estados(){
    var pais = $('#pais').val();
    var estados;
    switch (pais) {
        case "MEXICO":
            estados = estadosMexico;
            break;

        case "USA":
            estados = estadosUSA;
            break;

        case "CANADA":
            estados = estadosCanada;
            break;
    
        default:
            estados="";
            break;
    }
    $('#estado').html(estados);
}

function privilegios(){
    if(PRIVILEGIOS.administrar_parametros_cotizacion == 0)
    {
        $('.coti').attr('disabled', true);
        $('button.coti').hide();
    }

    if(PRIVILEGIOS.administrar_empresas_proveedor == 0){
        $('.prov').attr('disabled', true);
    }
}

function cargarCiudades(){
    var URL = base_url + "empresas/ajax_getCiudades";
    $("#lstCiudades option").remove();
    var lista = $("#lstCiudades");

    $.ajax({
        type: "POST",
        url: URL,
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var opt = document.createElement('option');
                    opt.value = elem.ciudad;
                    lista.append(opt);
                });
            }
          },
      });
}

function cargarListadoDocumentos(){
    var rows = $('#tblDocumentos tbody tr');
    var documentos = [];

    $.each(rows, function(i, ren){
        $.each(LST_DOC, function(i,e){
            if($(ren).find('.doc').text() == e.documento && e.requerido == "1")
            {
                $(ren).find("input[type='checkbox']").iCheck('check');
            }
        });
    });

    if(PRIVILEGIOS.administrar_empresas_facturacion == "0")
    {
        $('#tblDocumentos .cbDocu').attr('disabled', true);
        $('#txtCodigoImpresion').attr('readonly', true);
    }


}

function guardarInfoCotizaciones(){
    var URL = base_url + "empresas/ajax_setInfoCotizaciones";

    var datos = {};
    datos.id = ID_EMPRESA;
    datos.nombre_corto = $('#txtNombreCorto').val().trim();
    datos.clasificacion = $('#txtClasificacion').val().trim();
    datos.moneda_cotizacion = [];
    if($("#cbCotizacionMXN").is(":checked"))
    {
        datos.moneda_cotizacion.push($("#cbCotizacionMXN").val());
    }
    if($("#cbCotizacionUSD").is(":checked"))
    {
        datos.moneda_cotizacion.push($("#cbCotizacionUSD").val());
    }
    
    datos.iva_cotizacion = {};
    datos.iva_cotizacion[$("#opCotizacionIva option:selected").text()] = $("#opCotizacionIva").val();
    datos.credito_cliente = $('#credito_cliente').is(':checked') ? "1" : "0";
    datos.credito_cliente_plazo = $('#optCreditoClientePlazo').val();
    datos.notas_cotizacion = $('#txtNotasCotizacion').val().trim();
    
    var conRows = $('#tblContactoCotizacion tbody tr');
    var contactosActuales = [];
    $.each(conRows, function (i, elem) {
        contactosActuales.push($(elem).data('id'));
    });
    datos.contacto_cotizacion = JSON.stringify(contactosActuales);

    $.ajax({
        type: "POST",
        url: URL,
        data: { datos : JSON.stringify(datos) },
        success: function(result) {
            if(result)
            {
                $('#btnGuardarCotizaciones').fadeOut('slow');
                new PNotify({ title: 'Empresa', text: 'Se han guardado cambios', type: 'success', styling: 'bootstrap3' });
            }
        },
    });
}

function guardarListadoDocumentos(){
    var URL = base_url + "empresas/ajax_setListadoDocumentos";
    var rows = $('#tblDocumentos tbody tr');
    var documentos = [];

    $.each(rows, function(i,e){
        var docu = {};
        docu.requerido = $(e).find("input[type='checkbox']").is(':checked') ? "1" : "0";
        docu.documento = $(e).find('.doc').text();
        docu.nivel = $(e).find('.nivel').text();
        docu.origen = $(e).find('.origen').text();
        docu.codigo = $(e).find('.codigo').text();
        docu.campo = $(e).find('.campo').text();

        documentos.push(docu);
    });

    var codigo = $('#txtCodigoImpresion').val().trim();


    $.ajax({
        type: "POST",
        url: URL,
        data: {id : ID_EMPRESA, documentos : JSON.stringify(documentos), codigo : codigo },
        success: function(result) {
            if(result)
            {
                $('#btnCodigoImpresion').fadeOut('slow');
                new PNotify({ title: 'Empresa', text: 'Se han guardado cambios', type: 'success', styling: 'bootstrap3' });
            }
        },
    });

}



function phoneMask(inp){
    var valor = $(inp).val();
    var numeros = valor.replace("(", "");
    var numeros = numeros.replace(")", "");
    var numeros = numeros.replace("-", "");
    if(numeros.length == 3)
    {
        $(inp).val("(" + numeros + ")");
    }
    if(numeros.length == 7)
    {
        $(inp).val("(" + numeros.substring(0,3) + ")" + numeros.substring(3,6) + "-" + numeros.substring(6,7));
    }
    if(numeros.length == 9)
    {
        $(inp).val("(" + numeros.substring(0,3) + ")" + numeros.substring(3,6) + "-" + numeros.substring(6,8) + "-" + numeros.substring(8,9));
    }
    
}

function modalPasos(x){
    
    $('#btnPaso').val(x);
    
    var titulo = "Proceso de Cotización";

    if(x == 2){
        titulo = "Proceso de Compra";
    }

    $('#lblPasoTitulo').html(titulo);
    $('#mdlPasos').modal();
}

function setPaso(btn){
    var x = $(btn).val();
    var paso = $("#txtPaso").val();
    paso = paso.trim();

    var tabla = "#tblPasosCotizar";

    if(x == 2){
        tabla = "#tblPasosComprar";
    }

    if(paso)
    {
        var tab = $(tabla)[0];
        var ren = tab.insertRow(tab.rows.length);
        var cell1 = ren.insertCell(0);
        var cell2 = ren.insertCell(1);
        
        cell1.innerHTML = paso;
        cell1.style.width = "80%";
        
        cell2.innerHTML = "<button onclick='eliminarPaso(this)' class='btn btn-danger btn-xs'><i class='fa fa-minus'></i></button>";
        $("#btnGuardarProveedor").fadeIn('slow');
    }
    $("#txtPaso").val("");
    $('#mdlPasos').modal("hide");
}

function eliminarPaso(btn){
    if(confirm("¿Desea continuar?")){
        var ren = $(btn).closest('tr');
        ren.remove();
        $("#btnGuardarProveedor").fadeIn('slow');
    }
}

function codigoImpresion(){
    //ORIGINAL
    //var arr = [ 'F', 'X', 'R', 'O', 'P', 'A', 'V', 'S' ]; 
    
    $('#btnCodigoImpresion').fadeIn('slow');
    var arr = [ 'F', 'R', 'O', 'P', 'A', 'S' ]; 

    if(!arr.includes(event.key.toUpperCase()))
    {
        event.preventDefault();
    }
}

function cargarPlantas(){

    $('#tblPlantas tbody tr').remove();
    $('#optContactoPlanta option').remove();
    $('#optContactoPlanta').append(new Option("(GLOBAL)", 0));

    var URL = base_url + "empresas/ajax_getPlantas";

    $.ajax({
        type: "POST",
        url: URL,
        data: { empresa : ID_EMPRESA },
        success: function (response) {
            if(response){
                var tbl = $('#tblPlantas tbody')[0];
                var rs = JSON.parse(response);

                $.each(rs, function (i, elem) { 
                     var row = tbl.insertRow();
                     $('#optContactoPlanta').append(new Option(elem.nombre, elem.id));

                     row.dataset.id = elem.id;
                     row.dataset.nombre = elem.nombre;
                     row.dataset.nombre_corto = elem.nombre_corto;
                     row.dataset.calle = elem.calle;
                     row.dataset.colonia = elem.colonia;
                     row.dataset.ciudad = elem.ciudad;
                     row.dataset.estado = elem.estado;
                     row.dataset.comentarios = elem.comentarios;

                     row.insertCell().innerHTML = tbl.rows.length;
                     row.insertCell().innerHTML = elem.nombre;
                     row.insertCell().innerHTML = elem.nombre_corto;
                     row.insertCell().innerHTML = elem.calle + " " + elem.colonia;
                     row.insertCell().innerHTML = elem.ciudad + " " + elem.estado;
                     row.insertCell().innerHTML = elem.comentarios;
                     row.insertCell().innerHTML = PRIVILEGIOS.administrar_empresas == "1" ? '<button type="button" onclick="mdlEditarPlanta(this)" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Editar</button><button onclick="eliminarPlanta(this)" type="button" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Eliminar</button>' : "N/A";

                     
                });

            }
        }
    });
}

function mdlPlanta(){
    $('#btnAgregarPlanta').show();
    $('#btnEditarPlanta').hide();
    $('#mdlPlanta').data('id', 0);
    $('#txtNombrePlanta').val("");
    $('#txtNombreCortoPlanta').val("");
    $('#txtCallePlanta').val("");
    $('#txtColoniaPlanta').val("");
    $('#txtCiudadPlanta').val("");
    $('#txtEstadoPlanta').val("");
    $('#txtComentariosPlanta').val("");
    $('#mdlPlanta').modal();
}

function agregarPlanta(){
    if(validarPlanta()){
        var URL = base_url + "empresas/ajax_setPlanta";
        var planta = {};
        planta.empresa = ID_EMPRESA;
        planta.nombre = $('#txtNombrePlanta').val().trim();
        planta.nombre_corto = $('#txtNombreCortoPlanta').val().trim();
        planta.calle = $('#txtCallePlanta').val().trim();
        planta.colonia = $('#txtColoniaPlanta').val().trim();
        planta.ciudad = $('#txtCiudadPlanta').val().trim();
        planta.estado = $('#txtEstadoPlanta').val().trim();
        planta.comentarios = $('#txtComentariosPlanta').val().trim();

        $.ajax({
            type: "POST",
            url: URL,
            data: { planta : JSON.stringify(planta) },
            success: function (response) {
                $('#mdlPlanta').modal('hide');
                cargarPlantas();
            }
        });
    }
}

function editarPlanta(){
    if(validarPlanta()){
        var URL = base_url + "empresas/ajax_setPlanta";
        var planta = {};
        planta.id = $('#mdlPlanta').data('id');
        planta.nombre = $('#txtNombrePlanta').val().trim();
        planta.nombre_corto = $('#txtNombreCortoPlanta').val().trim();
        planta.calle = $('#txtCallePlanta').val().trim();
        planta.colonia = $('#txtColoniaPlanta').val().trim();
        planta.ciudad = $('#txtCiudadPlanta').val().trim();
        planta.estado = $('#txtEstadoPlanta').val().trim();
        planta.comentarios = $('#txtComentariosPlanta').val().trim();

        $.ajax({
            type: "POST",
            url: URL,
            data: { planta : JSON.stringify(planta) },
            success: function (response) {
                $('#mdlPlanta').modal('hide');
                cargarPlantas();
            }
        });
        
        
    }
}

function eliminarPlanta(btn){
    var row = $(btn).closest('tr');
    var id = $(row).data('id');

    if(confirm("¿Desea eliminar Planta?")){
        var URL = base_url + "empresas/ajax_deletePlanta";

        $.ajax({
            type: "POST",
            url: URL,
            data: { id : id },
            success: function (response) {
                cargarPlantas();
            }
        });
        
        
    }
}

function mdlEditarPlanta(btn){
    var row = $(btn).closest('tr');
    var id = $(row).data('id');
    var nombre = $(row).data('nombre');
    var nombre_corto = $(row).data('nombre_corto');
    var calle = $(row).data('calle');
    var colonia = $(row).data('colonia');
    var ciudad = $(row).data('ciudad');
    var estado = $(row).data('estado');
    var comentarios = $(row).data('comentarios');

    $('#btnAgregarPlanta').hide();
    $('#btnEditarPlanta').show();
    $('#mdlPlanta').data('id', id);
    $('#txtNombrePlanta').val(nombre);
    $('#txtNombreCortoPlanta').val(nombre_corto);
    $('#txtCallePlanta').val(calle);
    $('#txtColoniaPlanta').val(colonia);
    $('#txtCiudadPlanta').val(ciudad);
    $('#txtEstadoPlanta').val(estado);
    $('#txtComentariosPlanta').val(comentarios);
    $('#mdlPlanta').modal();
}

function validarPlanta(){
    if(!$('#txtNombrePlanta').val()){
        alert('Ingrese Nombre');
        return false;
    }

    return true;
}