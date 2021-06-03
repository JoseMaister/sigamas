function load(){
    getInfoDashBoard();
}

function getInfoDashBoard(){
    $.ajax({
        type: "POST",
        url: base_url + 'logistica/ajax_getDashboard',
        data: { },
        success: function(result) {
            var rs = JSON.parse(result);

            rs.Total = parseInt(rs.D1) + parseInt(rs.D2) + parseInt(rs.D3);
            rs.Total += parseInt(rs.D4) + parseInt(rs.D5) + parseInt(rs.D6);
            rs.Total += parseInt(rs.D7) + parseInt(rs.D8) + parseInt(rs.D9);
            rs.Total += parseInt(rs.D10);

            $('#pb1')[0].dataset.transitiongoal = (rs.D1 / rs.Total) * 100;
            $('#pb2')[0].dataset.transitiongoal = (rs.D2 / rs.Total) * 100;
            $('#pb3')[0].dataset.transitiongoal = (rs.D3 / rs.Total) * 100;
            $('#pb4')[0].dataset.transitiongoal = (rs.D4 / rs.Total) * 100;
            $('#pb5')[0].dataset.transitiongoal = (rs.D5 / rs.Total) * 100;
            $('#pb6')[0].dataset.transitiongoal = (rs.D6 / rs.Total) * 100;
            $('#pb7')[0].dataset.transitiongoal = (rs.D7 / rs.Total) * 100;
            $('#pb8')[0].dataset.transitiongoal = (rs.D8 / rs.Total) * 100;
            $('#pb9')[0].dataset.transitiongoal = (rs.D9 / rs.Total) * 100;
            $('#pb10')[0].dataset.transitiongoal = (rs.D10 / rs.Total) * 100;

            $('#lbl1').text(rs.D1 + " / " + rs.Total + (rs.ult1 == null ? "" : " (" + moment(rs.ult1).format('DD-MMM-YYYY') + ")"));
            $('#lbl2').text(rs.D2 + " / " + rs.Total + (rs.ult2 == null ? "" : " (" + moment(rs.ult2).format('DD-MMM-YYYY') + ")"));
            $('#lbl3').text(rs.D3 + " / " + rs.Total + (rs.ult3 == null ? "" : " (" + moment(rs.ult3).format('DD-MMM-YYYY') + ")"));
            $('#lbl4').text(rs.D4 + " / " + rs.Total + (rs.ult4 == null ? "" : " (" + moment(rs.ult4).format('DD-MMM-YYYY') + ")"));
            $('#lbl5').text(rs.D5 + " / " + rs.Total + (rs.ult5 == null ? "" : " (" + moment(rs.ult5).format('DD-MMM-YYYY') + ")"));
            $('#lbl6').text(rs.D6 + " / " + rs.Total + (rs.ult6 == null ? "" : " (" + moment(rs.ult6).format('DD-MMM-YYYY') + ")"));
            $('#lbl7').text(rs.D7 + " / " + rs.Total + (rs.ult7 == null ? "" : " (" + moment(rs.ult7).format('DD-MMM-YYYY') + ")"));
            $('#lbl8').text(rs.D8 + " / " + rs.Total + (rs.ult8 == null ? "" : " (" + moment(rs.ult8).format('DD-MMM-YYYY') + ")"));
            $('#lbl9').text(rs.D9 + " / " + rs.Total + (rs.ult9 == null ? "" : " (" + moment(rs.ult9).format('DD-MMM-YYYY') + ")"));
            $('#lbl10').text(rs.D10 + " / " + rs.Total + (rs.ult10 == null ? "" : " (" + moment(rs.ult10).format('DD-MMM-YYYY') + ")"));

            $('.progress .progress-bar').progressbar();
          },
        error: function(data){
            new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
            console.log(data);
        },
      });
}