var METODOS = {};
var DATE_SORT = 0;

function load(){
    jQuery.ajaxSetup({async:false});

    eventos();
    cargarMetodos(false);
    cargarFiltro();
    buscar();
}

function eventos(){
    $( '#mdlTipoCambio' ).on( 'keypress', function( e ) {
        if( e.keyCode === 13 ) {
            e.preventDefault();
        }
    });
}

function cargarFiltro(){
    $('#opFiltroMetodo option').remove();
    $('#opFiltroMetodo').append('<option value="0">TODOS</option>');

    $.each(METODOS, function(i, el)
    {
        $('#opFiltroMetodo').append('<option value="' + el.id + '">' + el.nombre + '</option>');
    });
}

function cargarMetodos(search){
    var URL = base_url + "recursos/ajax_getMetodosPago";

    $.ajax({
        type: "POST",
        url: URL,
        success: function(result) {
            $('#divPagos').empty();
            if(result)
            {
                METODOS = JSON.parse(result);

                $.each(METODOS, function(i, elem){
                    var ico;
                    switch(elem.tipo){
                        case 'AMERICAN EXPRESS':
                            ico = 'fa-cc-amex';
                            break;

                        case 'MASTER CARD':
                            ico = 'fa-cc-mastercard';
                            break;

                        case 'VISA':
                            ico = 'fa-cc-visa';
                            break;

                        case 'TRANSFERENCIA':
                            ico = 'fa-bank';
                            break;

                        case 'CHEQUE':
                            ico = 'fa-money';
                            break;
                    }
                    var box = '<div style="cursor: pointer;" onclick=verPago(this) data-id="'+ elem.id +'" class="animated flipInY col-lg-12 col-md-12 col-sm-12 col-xs-12">';
                    box +=      '<a>';
                    box +=          '<div class="tile-stats">';
                    box +=              '<div class="icon"><i class="fa ' + ico + '"></i></div>';
                    box +=              '<div class="count">' + elem.Saldo + '</div>';
                    box +=              '<h3>' + elem.nombre + '</h3>';
                    box +=          '</div>';
                    box +=      '</a>';
                    box += '</div>';

                    $('#divPagos').append(box);
                    $('.count').formatCurrency();
                });

                

                if(search){
                    buscar();
                }else{
                    totalizarTabla();
                }
            }
          },
      });
}

function buscar(){
    var URL = base_url + "recursos/ajax_getPO_recursos";
    var metodo = $('#opFiltroMetodo').val();
    $('#tabla tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { metodo : metodo, date_sort : DATE_SORT },
        success: function(result) {
            if(result)
            {
                var tab = $('#tabla tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.monto = elem.total * elem.tipo_cambio;

                    ren.insertCell().innerHTML = "<a target='_blank' href='" + base_url + "ordenes_compra/ver_po/" + elem.id + "' class='btn btn-default btn-sm'>" + elem.id + "</a>";
                    ren.insertCell().innerHTML = moment(elem.fecha_cobro).format('YYYY-MM-DD');
                    var cellTotal = ren.insertCell();
                    cellTotal.innerHTML = elem.total;
                    $(cellTotal).formatCurrency();
                    cellTotal.innerHTML += " " + elem.moneda;


                    //COLUMNA MONTO (MXN)
                    var montoMXN = elem.total * elem.tipo_cambio;
                    var celda2 = ren.insertCell();
                    celda2.innerHTML = montoMXN;
                    celda2.dataset.monto = montoMXN;
                    celda2.classList.add('montoMXN');
                    $(celda2).formatCurrency();
                    celda2.innerHTML += " MXN";
                    
                    ren.insertCell().innerHTML = elem.moneda == "MXN" ? "N/A" : "<button value=' " + elem.id + "' data-valor='" + elem.tipo_cambio + "' onclick=mdlTipoCambio(this) type='button' class='btn btn-success btn-xs'>" + elem.tipo_cambio + "</button>";

                    var M = '<select data-id="' + elem.id + '" onchange=cambiarMetodo(this) required="required" class="select2_single form-control" name="opMetodo">';
                    $.each(METODOS, function(i, el)
                    {
                        var s = el.id == elem.metodo_pago ? "selected" : "";
                        M += '<option data-saldo = "' + el.Saldo + '" ' + s + ' value="' + el.id + '">' + el.nombre + '</option>';
                    });
                    M += '</select>';
                    
                    ren.insertCell().innerHTML = M;

                    var R = '<select data-id="' + elem.id + '" onchange=cambiarRecurso(this) required="required" class="select2_single form-control" name="opRecurso">';
                    $.each(["PENDIENTE", "PROVISIONADO", "PAGADO"], function(i, el)
                    {
                        var s = el == elem.recurso ? "selected" : "";
                        R += '<option ' + s + ' value="' + el + '">' + el + '</option>';
                    });
                    R += '</select>';
                    ren.insertCell().innerHTML = R;
                    
                });

                totalizarTabla();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function totalizarTabla(){
    var rows = $('#tabla tbody tr');
    var Pend = 0; var Prov = 0; var Paga = 0;
    $.each(rows, function(i, elem)
    {
        var monto = $(elem).find('.montoMXN').data('monto');
        var recurso = $(elem).find("select[name='opRecurso']").val();

        switch (recurso) {
            case "PENDIENTE":
                Pend += monto;
                break;
        
            case "PROVISIONADO":
                Prov += monto;
                break;

            case "PAGADO":
                Paga += monto;
                break;
        }

        $('#lblPendiente').html(Pend);
        $('#lblProvisionado').html(Prov);
        $('#lblPagado').html(Paga);
        $('h2.total').formatCurrency();
    });
}

function dateSort(){
    DATE_SORT = DATE_SORT == 0 ? 1 : 0;
    buscar();
}

function cambiarMetodo(op){
    var URL = base_url + "recursos/ajax_setPO";
    var metodo_pago = $(op).val();
    var id = $(op).data("id");

    var PO = { id : id, metodo_pago : metodo_pago };

    if(validacionSaldo(op))
    {
        $.ajax({
            type: "POST",
            url: URL,
            data: { PO : JSON.stringify(PO) },
            success: function(result){
                cargarMetodos(false);
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    } else {
        cargarMetodos(true);
    }
}

function cambiarRecurso(op){
    var row = $(op).closest('tr');
    var URL = base_url + "recursos/ajax_setPO";
    var recurso = $(op).val();
    var id = $(op).data("id");

    var metodo_pago = $(row).find("select[name='opMetodo']").val();
    

    var PO = { id : id, recurso : recurso, metodo_pago : metodo_pago };

    if(validacionSaldo(op))
    {
        $.ajax({
            type: "POST",
            url: URL,
            data: { PO : JSON.stringify(PO) },
            success: function(result){
                cargarMetodos(false);
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    } else {
        cargarMetodos(true);
    }
}

function validacionSaldo(op){
    var ren = $(op).closest('tr');
    var monto = $(ren).data('monto');
    var saldo = $(ren).find("select[name='opMetodo'] option:selected").data('saldo');
    var estatus = $(ren).find("select[name='opRecurso']").val();

    if(monto > saldo && estatus != 'PENDIENTE'){
        alert("Saldo insuficiente en método de pago");
        return false;
    }


    return true;
}

function verPago(a){
    var id = $(a).data('id');
    $.redirect( base_url + "recursos/ver_forma_pago", { 'id': id });
}

function mdlTipoCambio(btn){
    var id = $(btn).val();
    var row = $(btn).closest('tr');
    var metodo_pago = $(row).find("select[name='opMetodo']").val();
    var valor = $(btn).data('valor');

    

    $('#btnGuardarTipoCambio').val(id);
    $('#btnGuardarTipoCambio').data('metodo', metodo_pago);
    $('#txtTipoCambio').val(valor);

    $('#mdlTipoCambio').modal();
}

function modificarTipoCambio(btn){
    var URL = base_url + "recursos/ajax_setPO";
    
    var id = $(btn).val();
    var metodo_pago = $(btn).data('metodo');
    
    var tipo_cambio = $('#txtTipoCambio').val();

    var PO = { id : id, tipo_cambio : tipo_cambio, metodo_pago : metodo_pago };

    $.ajax({
        type: "POST",
        url: URL,
        data: { PO : JSON.stringify(PO) },
        success: function(result){
            $('#mdlTipoCambio').modal("hide");
            cargarMetodos(true);
        },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}


