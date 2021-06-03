function load(){
    reporteQR();
    reportePR();
    reportePO();
}

function reporteQR(){
    $.ajax({
        type: "POST",
        url: base_url + 'compras/ajax_getReporteQR',
        data: { },
        success: function(result) {
            var rs = JSON.parse(result);

            rs.Total = parseInt(rs.Abiertos) + parseInt(rs.Rechazados) + parseInt(rs.Cotizando);

            $('#pbAbiertos')[0].dataset.transitiongoal = (rs.Abiertos / rs.Total) * 100;
            $('#pbRechazados')[0].dataset.transitiongoal = (rs.Rechazados / rs.Total) * 100;
            $('#pbCotizando')[0].dataset.transitiongoal = (rs.Cotizando / rs.Total) * 100;

            $('#lblAbiertos').text(rs.Abiertos + " / " + rs.Total + (rs.ultAbiertos == null ? "" : " (" + moment(rs.ultAbiertos).format('DD-MMM-YYYY') + ")"));
            $('#lblRechazados').text(rs.Rechazados + " / " + rs.Total + (rs.ultRechazados == null ? "" : " (" + moment(rs.ultRechazados).format('DD-MMM-YYYY') + ")"));
            $('#lblCotizando').text(rs.Cotizando + " / " + rs.Total + (rs.ultCotizando == null ? "" : " (" + moment(rs.ultCotizando).format('DD-MMM-YYYY') + ")"));

            $('.progress .progress-bar').progressbar();
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
      });
}

function reportePR(){
  $.ajax({
      type: "POST",
      url: base_url + 'compras/ajax_getReportePR',
      data: { },
      success: function(result) {
          var rs = JSON.parse(result);

          rs.Total = parseInt(rs.Pendientes) + parseInt(rs.Aprobados) + parseInt(rs.Rechazados) + parseInt(rs.Seleccion);
          rs.Total += parseInt(rs.PO_Autorizada) + parseInt(rs.En_PO) + parseInt(rs.Por_Recibir);

          $('#pbPRPendientes')[0].dataset.transitiongoal = (rs.Pendientes / rs.Total) * 100;
          $('#pbPRAprobados')[0].dataset.transitiongoal = (rs.Aprobados / rs.Total) * 100;
          $('#pbPRRechazados')[0].dataset.transitiongoal = (rs.Rechazados / rs.Total) * 100;
          $('#pbPREnSeleccion')[0].dataset.transitiongoal = (rs.Seleccion / rs.Total) * 100;
          $('#pbPRPOAutorizada')[0].dataset.transitiongoal = (rs.PO_Autorizada / rs.Total) * 100;
          $('#pbPREnPO')[0].dataset.transitiongoal = (rs.En_PO / rs.Total) * 100;
          $('#pbPRPorRecibir')[0].dataset.transitiongoal = (rs.Por_Recibir / rs.Total) * 100;

          $('#lblPRPendientes').text(rs.Pendientes + " / " + rs.Total + (rs.ultPendientes == null ? "" : " (" + moment(rs.ultPendientes).format('DD-MMM-YYYY') + ")"));
          $('#lblPRAprobados').text(rs.Aprobados + " / " + rs.Total + (rs.ultAprobados == null ? "" : " (" + moment(rs.ultAprobados).format('DD-MMM-YYYY') + ")"));
          $('#lblPRRechazados').text(rs.Rechazados + " / " + rs.Total + (rs.ultRechazados == null ? "" : " (" + moment(rs.ultRechazados).format('DD-MMM-YYYY') + ")"));
          $('#lblPREnSeleccion').text(rs.Seleccion + " / " + rs.Total + (rs.ultSeleccion == null ? "" : " (" + moment(rs.ultSeleccion).format('DD-MMM-YYYY') + ")"));
          $('#lblPRPOAutorizada').text(rs.PO_Autorizada + " / " + rs.Total + (rs.ultPO_Autorizada == null ? "" : " (" + moment(rs.ultPO_Autorizada).format('DD-MMM-YYYY') + ")"));
          $('#lblPREnPO').text(rs.En_PO + " / " + rs.Total + (rs.ultEn_PO == null ? "" : " (" + moment(rs.ultEn_PO).format('DD-MMM-YYYY') + ")"));
          $('#lblPRPorRecibir').text(rs.Por_Recibir + " / " + rs.Total + (rs.ultPor_Recibir == null ? "" : " (" + moment(rs.ultPor_Recibir).format('DD-MMM-YYYY') + ")"));

          $('.progress .progress-bar').progressbar();
        },
      error: function(data){
          new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
          console.log(data);
      },
    });
}

function reportePO(){
  $.ajax({
      type: "POST",
      url: base_url + 'compras/ajax_getReportePO',
      data: { },
      success: function(result) {
          var rs = JSON.parse(result);

          rs.Total = parseInt(rs.EnProceso) + parseInt(rs.PendienteAutorizacion) + parseInt(rs.Autorizada);
          rs.Total += parseInt(rs.Rechazada) + parseInt(rs.Ordenada) + parseInt(rs.Recibida);

          $('#pbPOEnProceso')[0].dataset.transitiongoal = (rs.EnProceso / rs.Total) * 100;
          $('#pbPOPendienteAutorizacion')[0].dataset.transitiongoal = (rs.PendienteAutorizacion / rs.Total) * 100;
          $('#pbPOAutorizada')[0].dataset.transitiongoal = (rs.Autorizada / rs.Total) * 100;
          $('#pbPORechazada')[0].dataset.transitiongoal = (rs.Rechazada / rs.Total) * 100;
          $('#pbPOOrdenada')[0].dataset.transitiongoal = (rs.Ordenada / rs.Total) * 100;
          $('#pbPORecibida')[0].dataset.transitiongoal = (rs.Recibida / rs.Total) * 100;

          $('#lblPOEnProceso').text(rs.EnProceso + " / " + rs.Total + (rs.ultEnProceso == null ? "" : " (" + moment(rs.ultEnProceso).format('DD-MMM-YYYY')+ ")"));
          $('#lblPOPendienteAutorizacion').text(rs.PendienteAutorizacion + " / " + rs.Total + (rs.ultPendienteAutorizacion == null ? "" : " (" + moment(rs.ultPendienteAutorizacion).format('DD-MMM-YYYY')+ ")"));
          $('#lblPOAutorizada').text(rs.Autorizada + " / " + rs.Total + (rs.ultAutorizada == null ? "" : " (" + moment(rs.ultAutorizada).format('DD-MMM-YYYY') + ")"));
          $('#lblPORechazada').text(rs.Rechazada + " / " + rs.Total + (rs.ultRechazada == null ? "" : " (" + moment(rs.ultRechazada).format('DD-MMM-YYYY') + ")"));
          $('#lblPOOrdenada').text(rs.Ordenada + " / " + rs.Total + (rs.ultOrdenada == null ? "" : " (" + moment(rs.ultOrdenada).format('DD-MMM-YYYY') + ")"));
          $('#lblPORecibida').text(rs.Recibida + " / " + rs.Total + (rs.ultRecibida == null ? "" : " (" + moment(rs.ultRecibida).format('DD-MMM-YYYY') + ")"));

          $('.progress .progress-bar').progressbar();
        },
      error: function(data){
          new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
          console.log(data);
      },
    });
}