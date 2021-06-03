function load()
{
    eventos();
    buscar();
}

function eventos()
{
    $( '#txtBuscar' ).on( 'keypress', function( e ) {
        if( e.keyCode === 13 ) {
            buscar();
        }
    });

    $( '.cbTipo' ).on( 'ifChanged', function( e ) {
        buscar();
    });

}

function buscar(){
    var URL = base_url + "empresas/ajax_getEmpresas";
    $('#tabla tbody tr').remove();
    
    var parametro = $("input[name=rbBusqueda]:checked").val();
    var texto = $("#txtBuscar").val();

    var cliente = $('#cbCliente').is(':checked') ? "1" : "0";
    var proveedor = $('#cbProveedor').is(':checked') ? "1" : "0";

    $.ajax({
        type: "POST",
        url: URL,
        data: { cliente : cliente, proveedor : proveedor, texto : texto, parametro : parametro },
        success: function(result) {
            //alert(result);
            if(result)
            {
                var tab = $('#tabla tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell(0).innerHTML = "<a href='" + base_url + "empresas/ver/" + elem.id + "'><img src='" + base_url + "data/empresas/fotos/" + elem.foto + "' class='avatar' alt='Avatar'></a>";
                    ren.insertCell(1).innerHTML = elem.nombre;
                    ren.insertCell(2).innerHTML = elem.razon_social;
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
                    ren.insertCell(3).innerHTML = tipo;
                    ren.insertCell(4).innerHTML = elem.calle + ' ' + elem.numero + ' ' + elem.colonia;
                    ren.insertCell(5).innerHTML = "<a href='" + base_url + "empresas/ver/" + elem.id + "' class='btn btn-primary'><i class='fa fa-eye'></i> Ver detalle</a>";
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
