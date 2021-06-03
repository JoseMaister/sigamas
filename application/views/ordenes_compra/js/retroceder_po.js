var PRS = "[]";

function load(){
    eventos();
}

function eventos(){
    $( '#txtBusqueda' ).on( 'keypress', function( e ) {
        if( e.keyCode === 13 ) {
            buscar();
        }
    });
}

function buscar(){
    var URL = base_url + "ordenes_compra/ajax_getPOs";
    $('#tabla tbody tr').remove();
    
    var parametro = "folio";
    var texto = $("#txtBusqueda").val().trim() ? $("#txtBusqueda").val().trim() : "-1";
    texto = texto == 0 ? "-1" : texto;

    $.ajax({
        type: "POST",
        url: URL,
        data: { texto : texto, parametro : parametro, estatus : "TODO", prioridad : "[]" },
        success: function(result) {
            if(result)
            {
                var tab = $('#tabla tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);

                    ren.insertCell().innerHTML = "<button type='button' onclick='getQR(this)' value='" + elem.id +"' class='btn btn-default btn-sm'>" + elem.id + "</button>";
                    ren.insertCell().innerHTML = moment(elem.fecha).format('YYYY-MM-DD');
                    ren.insertCell().innerHTML = elem.User;
                    ren.insertCell().innerHTML = elem.Prov;
                    ren.insertCell().innerHTML = elem.Contact;
                    ren.insertCell().innerHTML = elem.entrega;
                    
                    var btn = ""; var ret = false;
                    switch (elem.estatus)
                    {
                        case 'EN PROCESO':
                        case 'PENDIENTE AUTORIZACION':
                        btn = 'btn btn-warning btn-md';
                        break;

                        case 'AUTORIZADA':
                        case 'ORDENADA':
                        ret = true;
                        btn = 'btn btn-success btn-md';
                        break;

                        case 'CANCELADA':
                        btn = 'btn btn-default btn-md';
                        break;

                        case 'RECHAZADA':
                        btn = 'btn btn-danger btn-md';
                        break;

                        case 'RECIBIDA':
                        case 'CERRADA':
                        ret = true;
                        btn = 'btn btn-primary btn-md';
                        break;
                    }
                    var cellStat = ren.insertCell();
                    cellStat.innerHTML = "<button class='" + btn + "'>" + elem.estatus + "</button>";

                    ren.insertCell().innerHTML = ret ? "<button onclick='mdlRetroceder(this)' data-id='" + elem.id + "' class='btn btn-default btn-md'><i class='fa fa-reply'></i> Retroceder</button>" : "N/A";

                    PRS = elem.prs;

                    $('input.flat').iCheck({
                        checkboxClass: 'icheckbox_flat-green',
                        radioClass: 'iradio_flat-green'
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

function mdlRetroceder(btn){
    $('#mdlRetroceso').modal();
    $('#btnRetroceder').data('id', $(btn).data("id"));
    $('#txtComentarios').val("");
}

function validacion(){

    if($('#txtComentarios').val().length < 10)
    {
        alert('Ingrese un motivo de mínimo 10 caracteres');
        return false;
    }

    $('#mdlRetroceso').modal("hide");
    return confirm("¿Desea continuar");
}

function retroceder(btn){
    if(validacion()){
        var id = $(btn).data('id');
        var comentarios = $('#txtComentarios').val();
        
        var URL = base_url + "ordenes_compra/ajax_retrocederPO";

        $.ajax({
            type: "POST",
            url: URL,
            data: { id : id, comentarios : comentarios, prs : PRS },
            success: function(result)
            {
                buscar();
            },
            error: function(data)
            {
                new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            },
        });
    }
}
