function load(){
    eventos();
}

function eventos(){
    $('input').keypress(function(e){
        if (e.keyCode == 13) {
            aceptar();
        }
    });
}

function validacion(){
    var noempleado = $('#txtNoEmpleado').val();
    var correo = $('#txtCorreo').val();

    if(!noempleado){
        alert("Ingrese número de empleado");
        return false;
    }
    if(!correo){
        alert("Ingrese Correo");
        return false;
    }

    return true;
}

function aceptar(){
    
    if(validacion()){
        var noempleado = $('#txtNoEmpleado').val();
        var correo = $('#txtCorreo').val();
        $.ajax({
            type: "POST",
            url: base_url + "seguridad/ajax_recoverPass",
            data: { noempleado : noempleado, correo : correo },
            success: function(result) {
                if(result)
                {
                    alert("Se ha enviado correo con información para la recuperación de contraseña");
                    window.location.href = base_url + 'login';
                }
                else
                {
                    alert("Datos incorrectos");
                }
            },
        });
    }
}