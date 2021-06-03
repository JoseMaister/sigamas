function load(){
    iniciar_daterangepicker();
    buscar();
}

function buscar(){
    var URL = base_url + "recursos/ajax_getMovimientos";

    var dtpInicio = $('#dtpInicio').val() + " 00:00:00";
    var dtpFinal = $('#dtpFinal').val() + " 23:59:59";

    
    $.ajax({
        type: "POST",
        url: URL,
        data: { id : ID },
        success: function(result) {
            $('#tabla tbody tr').remove();
            if(result)
            {
                var saldo = 0;
                var t = 0; var a = 0; var totalPO = 0; var totalMov = 0;
                var tab = $('#tabla tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
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

                    $("#lblTitulo").html("<i class='fa " + ico + "'></i> " + elem.nombre);
                    t++;

                    saldo += (parseFloat(elem.monto) * parseFloat(elem.tipo_cambio)) * (elem.TipoM != "ABONO" ? -1 : 1);

                    if(elem.TipoM == "ABONO")
                    {
                        a++;
                    }
                    


                    if(moment(elem.fecha) >= moment(dtpInicio) && moment(elem.fecha) <= moment(dtpFinal))
                    {
                        var ren = tab.insertRow(tab.rows.length);
                        if(elem.TipoM != "ABONO"){
                            totalPO += parseFloat(elem.monto) * parseFloat(elem.tipo_cambio);
                            ren.style.background = '#fffbc7';
                            ren.insertCell().innerHTML = t;
                            ren.insertCell().innerHTML = elem.fecha;
                            ren.insertCell().innerHTML = "PO" + paddy(elem.id, 6);
                            var c = ren.insertCell();
                            c.classList.add("moneda");

                            if(elem.TipoM == "PROVISIONADO")
                            {
                                c.classList.add("provision");
                            }
                            c.innerHTML = parseFloat(elem.monto) * parseFloat(elem.tipo_cambio);
                            ren.insertCell().innerHTML = "";
                            ren.insertCell().innerHTML = "";
                            //SALDO
                            var s = ren.insertCell();
                            s.classList.add("moneda");
                            s.innerHTML = saldo;
                            
                        } else {
                            totalMov += parseFloat(elem.monto);
                            ren.style.background = '#d9ffe4';
                            if(elem.monto < 0)
                            {
                                ren.style.background = '#ffdada';
                            }
                            ren.insertCell().innerHTML = t;
                            ren.insertCell().innerHTML = elem.fecha;
                            ren.insertCell().innerHTML = "";
                            ren.insertCell().innerHTML = "";
                            ren.insertCell().innerHTML = a;
                            var c = ren.insertCell();
                            c.classList.add("moneda");
                            c.innerHTML = elem.monto;
                            //SALDO
                            var s = ren.insertCell();
                            s.classList.add("moneda");
                            s.innerHTML = saldo;
                            
                        }
                    }

                });
                
                var ren = tab.insertRow(tab.rows.length);
                ren.insertCell().innerHTML = "";
                ren.insertCell().innerHTML = "";
                ren.insertCell().innerHTML = "<b>TOTAL:</b>";
                var c1 = ren.insertCell();
                c1.classList.add("moneda");
                c1.innerHTML = totalPO;
                

                ren.insertCell().innerHTML = "";
                var c2 = ren.insertCell();
                c2.classList.add("moneda");
                c2.innerHTML = "<b>" + totalMov + "</b>";
                ren.insertCell().innerHTML = "";

                var ren = tab.insertRow(tab.rows.length);
                ren.insertCell().innerHTML = "";
                ren.insertCell().innerHTML = "";
                ren.insertCell().innerHTML = "";
                ren.insertCell().innerHTML = "";
                ren.insertCell().innerHTML = "";
                ren.insertCell().innerHTML = "<b>BALANCE:</b>";
                var c3 = ren.insertCell();
                c3.classList.add("moneda");
                c3.innerHTML = saldo;

                $('.moneda').formatCurrency();
                $('.moneda').append(' MXN');
                $('.provision').append(' (Provisión)');
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });

    
}

//////////DATES
function iniciar_daterangepicker() {

    if( typeof ($.fn.daterangepicker) === 'undefined'){ return; }
    console.log('init_daterangepicker_single_call');

    $('#dtpInicio').daterangepicker({
        singleDatePicker: true,
        singleClasses: "picker_4",
        startDate: moment().startOf('month'),
    }, function(start, end, label) {
    });
    
    $('#dtpFinal').daterangepicker({
        singleDatePicker: true,
        singleClasses: "picker_4",
        startDate: moment().endOf('month'),
    }, function(start, end, label) {
    });


    $('#dtpInicio').change(function () {
        buscar();
    });
    $('#dtpFinal').change(function () {
        buscar();
    });


}