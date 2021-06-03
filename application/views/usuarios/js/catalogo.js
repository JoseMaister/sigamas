function load(){
    eventos();
    buscar();
}

function eventos(){
    $('#cbActivo').on('ifChanged', function(){
        buscar();
    });

    $( '#txtBusqueda' ).on( 'keypress', function( e ) {
        if( e.keyCode === 13 ) {
            buscar();
        }
    });
}

function buscar(){
    var URL = base_url + "usuarios/ajax_getUsuarios";
    $('#tblUsuarios tbody tr').remove();
    
    var parametro = $("input[name=rbBusqueda]:checked").val();
    var texto = $("#txtBusqueda").val();
    var activo = $("#cbActivo").is(":checked") ? 1 : 0;

    $.ajax({
        type: "POST",
        url: URL,
        data: { parametro : parametro, texto : texto, activo : activo },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblUsuarios tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.dataset.id = elem.id;
                    
                    var style = "cursor: pointer;";
                    if(elem.activo != "1"){
                        style += " color: red;";
                    }
                    ren.style = style;

                    $(ren).on('click', function(){
                        verProducto($(this).data('id'));
                    });
                    
                    ren.insertCell().innerHTML = '<a><img src="'+ base_url +'/usuarios/photo/'+elem.id +'" class="avatar" alt="Avatar"></a>';
                    ren.insertCell().innerHTML = elem.User + "<br/><small>Ultima Sesión: " + moment(elem.ultima_sesion).format('D/MM/YYYY h:mm a') +"</small>";
                    ren.insertCell().innerHTML = elem.no_empleado;
                    ren.insertCell().innerHTML = elem.departamento;
                    ren.insertCell().innerHTML = elem.puesto;
                    ren.insertCell().innerHTML = elem.correo;

                    
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

function verProducto(id){
    $.redirect( base_url + "usuarios/ver", { 'id': id }, 'POST', '_blank');
}