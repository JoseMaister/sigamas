function load(){
    eventos();
}

function eventos(){
    $('input').on('keyup', function(){
        validar();
    });
}

function validar(){
    pass1 = $('#txtPassword').val();
    pass2 = $('#txtPassword2').val();
    var seArma = true;

    if(pass1.length >= 8)
    {
        $('table tr').eq(0).find('td').eq(0).html("<font color='green'><i class='fa fa-check'></i></font>");
    } 
    else 
    {
        $('table tr').eq(0).find('td').eq(0).html("<font color='red'><i class='fa fa-close'></i></font>");
        seArma = false;
    }

    
    var UP = false; var LO = false; var NUM = false;
    for (let i = 0; i < pass1.length; i++) {
        var character = pass1.charAt(i);
        if (isNaN(character))
        {
            if (character === character.toUpperCase()) {
                UP = true;
            }
            if (character === character.toLowerCase()){
                LO = true;
            }
        }
        else
        {
            if(character != " ")
            {
                NUM = true;
            }
        }
    }

    if(UP)
    {
        $('table tr').eq(1).find('td').eq(0).html("<font color='green'><i class='fa fa-check'></i></font>");
    } 
    else 
    {
        $('table tr').eq(1).find('td').eq(0).html("<font color='red'><i class='fa fa-close'></i></font>");
        seArma = false;
    }

    if(LO)
    {
        $('table tr').eq(2).find('td').eq(0).html("<font color='green'><i class='fa fa-check'></i></font>");
    } 
    else 
    {
        $('table tr').eq(2).find('td').eq(0).html("<font color='red'><i class='fa fa-close'></i></font>");
        seArma = false;
    }

    if(NUM)
    {
        $('table tr').eq(3).find('td').eq(0).html("<font color='green'><i class='fa fa-check'></i></font>");
    } 
    else 
    {
        $('table tr').eq(3).find('td').eq(0).html("<font color='red'><i class='fa fa-close'></i></font>");
        seArma = false;
    }

    if(pass1 == pass2 && pass1)
    {
        $('table tr').eq(4).find('td').eq(0).html("<font color='green'><i class='fa fa-check'></i></font>");
    } 
    else 
    {
        $('table tr').eq(4).find('td').eq(0).html("<font color='red'><i class='fa fa-close'></i></font>");
        seArma = false;
    }

    if(seArma)
    {
        $('#btnAceptar').fadeIn();        
    }
    else{
        $('#btnAceptar').fadeOut();
    }
}

function cambiarPassword(){
    pass1 = $('#txtPassword').val();

    $.ajax({
        type: "POST",
        url: base_url + "seguridad/ajax_changePass",
        data: { password : pass1 },
        success: function(result) {
            if(result)
            {
                alert("Se ha modificado contraseña con éxito");
                window.location.href = base_url + 'login';
            }
            else
            {
                alert("Password debe ser diferente al anterior");
            }
        },
    });
}