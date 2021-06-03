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
    var URL = base_url + "facturas/ajax_getClientes";
    $('#tabla tbody tr').remove();
    
    var parametro = $("input[name=rbBusqueda]:checked").val();
    var texto = $("#txtBuscar").val();

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto, parametro : parametro },
        success: function(result) {
            //alert(result);
            if(result)
            {
                var tab = $('#tabla tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = "<a target='_blank' href='" + base_url + "empresas/ver/" + elem.id + "'><img src='" + base_url + "data/empresas/fotos/" + elem.foto + "' class='avatar' alt='Avatar'></a>";
                    ren.insertCell().innerHTML = elem.nombre;
                    ren.insertCell().innerHTML = elem.razon_social;
                    ren.insertCell().innerHTML = boton(elem.id, elem.opinion_positiva, 'OPINION');
                    ren.insertCell().innerHTML = boton(elem.id, elem.emision_sua, 'EMISION');
                });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
      });
}

function boton(id, tiene, file){
    var clase = "btn dropdown-toggle btn-sm";
    var texto = "VACIO";
    opcs = '<ul role="menu" class="dropdown-menu">';
    
    if(tiene)
    {
        texto = "ARCHIVO";
        clase += " btn-primary";
        opcs += '<li><a data-doc="' + file + '" data-id="' + id + '" onclick=verArchivo(this)><i class="fa fa-file-pdf-o"></i> Ver archivo</a></li>';
        opcs += '<li><a data-doc="' + file + '" data-id="' + id + '" onclick=eliminarArchivo(this)><i class="fa fa-close"></i> Eliminar</a></li>';
    }
    else
    {
        var t = '<a><label style="font-weight: normal; cursor: pointer;" for="f_' + file + '_' + id +'">';
            t += '<input accept="application/pdf" data-doc="' + file + '" data-id="' + id + '" onchange="fileChange(this);" type="file" class="sr-only" id="f_' + file + '_' + id +'">';
            t += '<i class="fa fa-upload"></i> Subir Archivo';
            t += '</label></a>';
        clase += " btn-default";
        opcs += "<li>" + t + "</li>";
    }
    opcs += '</ul></div>';
    
    
    
    var btn = "<div class='btn-group'><button style='width: 100px;' type='button' data-toggle='dropdown' value=" + id + " class='" + clase + "'>" + texto + "  <span class='caret'></span></button>";
    btn += opcs;
    return btn;
}

function verArchivo(a){
    var id = $(a).data('id');
    var doc = $(a).data('doc');

    var URL = base_url + "data/empresas/documentos_facturacion/" + doc + "_" + paddy(id, 6) + ".pdf";

    window.open(URL, '_blank');
}

function eliminarArchivo(a){
    if(confirm("¿Desea eliminar documento?")){
        var URL = base_url + "facturas/ajax_deleteDocumentoFacturacion";
        
        var id = $(a).data('id');
        var doc = $(a).data('doc');

        $.ajax({
            type: "POST",
            url: URL,
            data: { empresa : id, documento : doc },
            success: function(result) {
                buscar();
            },
            error: function(data){
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                console.log(data);
            },
        });
    }
}

function fileChange(ipt){
    var URL = base_url + "facturas/ajax_setDocumentoFacturacion";
    
    var id = $(ipt).data('id');
    var doc = $(ipt).data('doc');
    var f = $(ipt)[0];
    f = f.files[0];
    var formdata = new FormData();
    formdata.append('file', f);
    formdata.append('empresa', id);
    formdata.append('documento', doc);

    var ajax = new XMLHttpRequest();
    //ajax.addEventListener("progress", updateProgress, false);
    //ajax.addEventListener("load", complete, false);
    ajax.open("POST", URL);
    ajax.send(formdata);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == XMLHttpRequest.DONE) {
            //alert(ajax.responseText);
            buscar();
        }
    }
}

