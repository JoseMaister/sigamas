function load(){
    cargarRequisitores();
    crearAprobadores();
}

function cargarRequisitores(){
    var URL = base_url + "ordenes_compra/ajax_getRequisitores";
    $('#tblRequisitores tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblRequisitores tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = '<a href="' + base_url + 'usuarios/ver/' + elem.id + '" target="_blank"><img class="avatar" src="' + base_url + 'usuarios/photo/' + elem.id + '" alt="img" /></a>';
                    ren.insertCell().innerHTML = elem.Requisitor;
                    ren.insertCell().innerHTML = elem.QRI == "1" ? "<font color='green'><i class='fa fa-check'></i></font>" : "<font color='red'><i class='fa fa-close'></i></font>";
                    ren.insertCell().innerHTML = elem.QRV == "1" ? "<font color='green'><i class='fa fa-check'></i></font>" : "<font color='red'><i class='fa fa-close'></i></font>";
                });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function crearAprobadores(){
    var URL = base_url + "ordenes_compra/ajax_getAprobadores";
    $('#tblAprobadores tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblAprobadores tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = '<a href="' + base_url + 'usuarios/ver/' + elem.id + '" target="_blank"><img class="avatar" src="' + base_url + 'usuarios/photo/' + elem.id + '" alt="img" /></a>';
                    ren.insertCell().innerHTML = elem.Aprobador;
                    ren.insertCell().innerHTML = '<button type="button" value="' + elem.id + '" onclick="verRequisitores(this)" class="btn btn-default"><i class="fa fa-users"></i> ' + elem.RequisitoresACargo + '</button>';
                });
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}

function verRequisitores(btn){
    var id = $(btn).val();
    
    var URL = base_url + "ordenes_compra/ajax_getRequisitoresACargo";
    $('#tblRequisitoresACargo tbody tr').remove();

    $.ajax({
        type: "POST",
        url: URL,
        data: { aprobador : id },
        success: function(result) {
            if(result)
            {
                var tab = $('#tblRequisitoresACargo tbody')[0];
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var ren = tab.insertRow(tab.rows.length);
                    ren.insertCell().innerHTML = '<a href="' + base_url + 'usuarios/ver/' + elem.id + '" target="_blank"><img class="avatar" src="' + base_url + 'usuarios/photo/' + elem.id + '" alt="img" /></a>';
                    ren.insertCell().innerHTML = elem.Requisitor;
                });

                $('#mdl').modal();
            }
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
    });
}