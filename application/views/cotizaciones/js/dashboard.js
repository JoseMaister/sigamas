function load(){
  cotizaciones();
}

function cotizaciones(){
    $.ajax({
        type: "POST",
        url: base_url + 'cotizaciones/ajax_getDashboard',
        data: { },
        success: function(result) {
            var rs = JSON.parse(result);

            rs.Total = parseInt(rs.Aprobadas) + parseInt(rs.Enviadas) + parseInt(rs.Confirmadas) + parseInt(rs.EnRevision) + parseInt(rs.EnAutorizacion) + parseInt(rs.AutorizadoParcial) + parseInt(rs.AutorizadoTotal);

            $('#pbAprobadas')[0].dataset.transitiongoal = (rs.Aprobadas / rs.Total) * 100;
            $('#pbEnviadas')[0].dataset.transitiongoal = (rs.Enviadas / rs.Total) * 100;
            $('#pbConfirmadas')[0].dataset.transitiongoal = (rs.Confirmadas / rs.Total) * 100;
            $('#pbEnRevision')[0].dataset.transitiongoal = (rs.EnRevision / rs.Total) * 100;
            $('#pbEnAutorizacion')[0].dataset.transitiongoal = (rs.EnAutorizacion / rs.Total) * 100;
            $('#pbAutorizadoParcial')[0].dataset.transitiongoal = (rs.AutorizadoParcial / rs.Total) * 100;
            $('#pbAutorizadoTotal')[0].dataset.transitiongoal = (rs.AutorizadoTotal / rs.Total) * 100;

            $('#lblAprobadas').text(rs.Aprobadas + " / " + rs.Total + (rs.ultAprobadas == null ? "" : " (" + moment(rs.ultAprobadas).format('DD-MMM-YYYY') + ")"));
            $('#lblEnviadas').text(rs.Enviadas + " / " + rs.Total + (rs.ultEnviadas == null ? "" : " (" + moment(rs.ultEnviadas).format('DD-MMM-YYYY') + ")"));
            $('#lblConfirmadas').text(rs.Confirmadas + " / " + rs.Total + (rs.ultConfirmadas == null ? "" : " (" + moment(rs.ultConfirmadas).format('DD-MMM-YYYY') + ")"));
            $('#lblEnRevision').text(rs.EnRevision + " / " + rs.Total + (rs.ultEnRevision == null ? "" : " (" + moment(rs.ultEnRevision).format('DD-MMM-YYYY') + ")"));
            $('#lblEnAutorizacion').text(rs.EnAutorizacion + " / " + rs.Total + (rs.ultEnAutorizacion == null ? "" : " (" + moment(rs.ultEnAutorizacion).format('DD-MMM-YYYY') + ")"));
            $('#lblAutorizadoParcial').text(rs.AutorizadoParcial + " / " + rs.Total + (rs.ultAutorizadoParcial == null ? "" : " (" + moment(rs.ultAutorizadoParcial).format('DD-MMM-YYYY') + ")"));
            $('#lblAutorizadoTotal').text(rs.AutorizadoTotal + " / " + rs.Total + (rs.ultAutorizadoTotal == null ? "" : " (" + moment(rs.ultAutorizadoTotal).format('DD-MMM-YYYY') + ")"));

            $('.progress .progress-bar').progressbar();
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
      });
}