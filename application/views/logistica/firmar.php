<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="icon" href="<?= base_url("template/images/logo.ico"); ?>">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MAS Metrología</title>
        <!-- Bootstrap -->
        <link href=<?= base_url("template/vendors/bootstrap/dist/css/bootstrap.css"); ?> rel="stylesheet">
        <!-- Font Awesome -->
        <link href=<?= base_url("template/vendors/font-awesome/css/font-awesome.min.css") ?> rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href=<?= base_url("template/build/css/custom.css"); ?> rel="stylesheet">


    <style>
    @media only screen and (orientation:landscape){
        #sign{ display : block; }
        #button{ display : none; }
    }
    
    @media only screen and (orientation:portrait){
        #sign{ display:none; }
        #button{ display:block; }
    }
    </style>
</head>
<body style="background-color: #fff; overflow:hidden; margin: 10px;">
    

    <div id="button">
        

        <center>
            <h3>Voltea la pantalla para firmar</h3>
            <div id="imgDiv">
                <img style="margin-bottom: 20px; border: solid; width: 75%;" id="img">
            </div>
            <button style="display: none;" id="btnLimpiar" onclick="limpiar()" type="button" class="btn btn-primary"><i class='fa fa-trash'></i> Limpiar</button>
            <button style="display: none;" id="btnGuardar" type="button" class="btn btn-success" onclick="aceptar()"><i class='fa fa-save'></i> Aceptar</button>
            
        </center>
    </div>

    <div id="sign">
        <h3 id="lblLeyenda">Firme dentro del recuadro</h3>
        <div id="canvasSimpleDiv"></div>
    </div>


<!-- jQuery -->
<script src=<?= base_url("template/vendors/jquery/dist/jquery.min.js"); ?>></script>
<!-- jquery.redirect -->
<script src=<?= base_url("template/vendors/jquery.redirect/jquery.redirect.js"); ?>></script>
<!-- JS FILE -->
<script src=<?= base_url("application/views/logistica/js/firmar.js"); ?>></script>
<script>
    const base_url = '<?= base_url(); ?>';

    $(function(){
        load();
    });

    function aceptar(){

        var canvas = document.getElementById("canvasSimple");
        var data = <?= json_encode($data) ?>;
        data.firma = canvas.toDataURL('image/jpg');
        
                
        if(confirm('¿Desea continuar?'))
        {
            var URL = base_url + "logistica/ajax_updateRecorrido";
            $.ajax({
                type: "POST",
                url: URL,
                data: data,
                success: function(result) {
                    $.redirect( base_url + "logistica/recorridos");
                },
                error: function(data){
                    new PNotify({ title: 'ERROR', text: 'Error', type: 'error', styling: 'bootstrap3' });
                    console.log(data);
                },
            });
        }
    }

    function subirFirma(){
        var canvas = document.getElementById("canvasSimple");

        var formdata = new FormData();
        formdata.append("iptFoto", canvas.toDataURL('image/jpg'));

        var ajax = new XMLHttpRequest();
        ajax.addEventListener("load", function(e){ 

            alert(e.target.responseText);
            if(e.target.responseText)
            {
                //Foto = event.target.responseText;
                //new PNotify({ title: 'Foto', text: 'Se ha modificado imagen de empresa', type: 'success', styling: 'bootstrap3' });
            }
        }, false);
        ajax.open("POST", "<?= base_url('logistica/guardarFirma') ?>");
        ajax.send(formdata);
    }


</script>
</body>
</html>



