var LISTA_PRS = [];
var CURRENT_PROV = 0;
var CURRENT_PROV_NOM = 0;
var CURRENT_MONEDA;
var CURRENT_TIPO;

function load(){
    eventos();
    buscar();
}

function eventos(){
    $( '#txtBusqueda' ).on( 'keypress', function( e ) {
        if( e.keyCode === 13 ) {
            buscar();
        }
    });
}

function buscar(){
    var URL = base_url + "ordenes_compra/ajax_getPRs";
    $('#tabla tbody tr').remove();
    
    var parametro = $("input[name=rbBusqueda]:checked").val();
    var texto = $("#txtBusqueda").val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto, parametro : parametro, id_proveedor : CURRENT_PROV, moneda : CURRENT_MONEDA, tipo : CURRENT_TIPO },
        success: function(result) {
            if(result)
            {
                var tab = $('#tabla tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    
                    var check = LISTA_PRS.includes(elem.id) ? 'checked' : '';
                    ren.insertCell().innerHTML = "<input data-id='" + elem.id + "' data-idprov='" + elem.IdProv + "' data-nomprov='" + elem.Prov + "' data-moneda='" + elem.moneda + "' data-tipo='" + elem.tipo + "' type='checkbox' class='flat selecc' name='rbBusqueda' value='proveedor' "+ check +"/>";
                    ren.insertCell().innerHTML = "<button type='button' onclick='getPR(this)' value='" + elem.id +"' class='btn btn-default btn-xs'>" + elem.id + "</button>";
                    ren.insertCell().innerHTML = elem.Prov;
                    ren.insertCell().innerHTML = elem.tipo;
                    ren.insertCell().innerHTML = elem.cantidad;
                    ren.insertCell().innerHTML = elem.Modelo;
                    ren.insertCell().innerHTML = elem.descripcion;
                    ren.insertCell().innerHTML = elem.importe + " " + elem.moneda;
                    
                    var btn = "";
                    switch (elem.estatus)
                    {
                        case 'APROBADO':
                        btn = 'btn btn-success btn-xs';
                        break;

                        case 'PENDIENTE':
                        case 'EN SELECCION':
                        btn = 'btn btn-warning btn-xs';
                        break;

                        case 'RECHAZADO':
                        btn = 'btn btn-danger btn-xs';
                        break;

                        case 'PROCESADO':
                        case 'CANCELADO':
                        btn = 'btn btn-default btn-xs';
                        break;
                    }
                    var cell7 = ren.insertCell(7);
                    cell7.innerHTML = "<a href='#' class='" + btn + "'>" + elem.estatus + "</a>";

                    $('input.flat').iCheck({
                        checkboxClass: 'icheckbox_flat-green',
                        radioClass: 'iradio_flat-green'
                    });

                    $('input.selecc').on('ifChanged', function(){
                        seleccionar(this);
                    });
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

function seleccionar(cb){
    var id = cb.dataset.id;
    var idprov = cb.dataset.idprov;
    var nombre = cb.dataset.nomprov;
    var moneda = cb.dataset.moneda;
    var tipo = cb.dataset.tipo;

    if($(cb).is(':checked'))
    {
        LISTA_PRS.push(id);
    }
    else
    {
        var index = LISTA_PRS.indexOf(id);
        LISTA_PRS.splice(index, 1);
    }

    if(LISTA_PRS.length == 0)
    {
        $('#divProveedor').hide();
        $('#lblNombreProveedor').text("");
        CURRENT_PROV = 0;
        CURRENT_PROV_NOM = '';

    }
    else
    {
        $('#divProveedor').show();
        $('#lblNombreProveedor').text(nombre);
        CURRENT_PROV = idprov;
        CURRENT_MONEDA = moneda;
        CURRENT_TIPO = tipo;
        CURRENT_PROV_NOM = nombre;
    }

    console.log(LISTA_PRS);

    buscar();
}

function continuar(){

    var URL = base_url + 'ordenes_compra/ajax_setTempPO';
    $.ajax({
        type: "POST",
        url: URL,
        data: { prs: JSON.stringify(LISTA_PRS), id_prov : CURRENT_PROV, moneda : CURRENT_MONEDA, tipo : CURRENT_TIPO  },
        success: function(result) {
            if(result)
            {
                window.location.href = base_url + 'ordenes_compra/construccion_po/' + result;
            }
        }
    });



    /*var URL = base_url + 'ordenes_compra/construccion_po';
    var f = document.createElement("form");
    f.setAttribute('method',"post");
    f.setAttribute('action', URL);

    var un = document.createElement("input");
    un.setAttribute('type',"hidden");
    un.setAttribute('name',"unid");
    un.setAttribute('value', UNID);
    f.appendChild(pn);

    var p = document.createElement("input");
    p.setAttribute('type',"hidden");
    p.setAttribute('name',"id_prov");
    p.setAttribute('value', CURRENT_PROV);
    f.appendChild(p);
    
    var pn = document.createElement("input");
    pn.setAttribute('type',"hidden");
    pn.setAttribute('name',"nombre_prov");
    pn.setAttribute('value', CURRENT_PROV_NOM);
    f.appendChild(pn);

    $.each(LISTA_PRS, function(i, elem){
        var i = document.createElement("input");
        i.setAttribute('type',"hidden");
        i.setAttribute('name',"prs[]");
        i.setAttribute('value', elem);
        f.appendChild(i);
    });

    $(document.body).append(f);
    f.submit();
    */
}
