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

    $('.cbPriori').on( 'ifChanged', function( e ) {
        buscar();
    });
    
}

function buscar(){
    var URL = base_url + "ordenes_compra/ajax_getEmpresasHistorial";
    $('#tbl tbody tr').remove();
    
    var parametro = $("input[name=rbBusqueda]:checked").val();
    var texto = $("#txtBusqueda").val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto, parametro : parametro },
        success: function(result) {
            if(result)
            {
                var tab = $('#tbl tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id = elem.id;
                    ren.insertCell().innerHTML = "<a target='_blank' href='" + base_url + "empresas/ver/" + elem.id + "'><img src='" + base_url + "data/empresas/fotos/" + elem.foto + "' class='avatar' alt='Avatar'></a>";
                    ren.insertCell().innerHTML = elem.nombre;
                    ren.insertCell().innerHTML = elem.razon_social;
                    var tipo;
                    if(elem.cliente == "1"){
                        if(elem.proveedor == "1"){
                            tipo = "Cliente/Proveedor";
                        } else {
                            tipo = "Cliente";
                        }
                    } else {
                        if(elem.proveedor == "1"){
                            tipo = "Proveedor";
                        } else {
                            tipo = "-";
                        }
                    }
                    ren.insertCell().innerHTML = tipo;
                    ren.insertCell().innerHTML = elem.calle + ' ' + elem.numero + ' ' + elem.colonia;
                    ren.insertCell().innerHTML = '<button onclick="verHistorial(this)" type="button" class="btn btn-md btn-primary">' + elem.CountPO + ' <i class="fa fa-shopping-cart"></i></button>';
                });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
      });
}

function verHistorial(btn){
    var ren = $(btn).closest('tr');
    var id = $(ren).data('id');

    $.redirect(base_url + "ordenes_compra/historial_po", { 'id': id }, 'POST', '_blank');
}