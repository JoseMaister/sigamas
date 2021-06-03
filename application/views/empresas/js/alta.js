var estadosMexico = '' //'<datalist id="estadosMexico">'
+ '<option value="Aguascalientes">Aguascalientes</option>'
+ '<option value="Baja California">Baja California</option>'
+ '<option value="Baja California Sur">Baja California Sur</option>'
+ '<option value="Campeche">Campeche</option>'
+ '<option value="Chiapas">Chiapas</option>'
+ '<option value="Chihuahua">Chihuahua</option>'
+ '<option value="Ciudad de México">Ciudad de México</option>'
+ '<option value="Coahuila">Coahuila</option>'
+ '<option value="Colima">Colima</option>'
+ '<option value="Durango">Durango</option>'
+ '<option value="Estado de México">Estado de México</option>'
+ '<option value="Guanajuato">Guanajuato</option>'
+ '<option value="Guerrero">Guerrero</option>'
+ '<option value="Hidalgo">Hidalgo</option>'
+ '<option value="Jalisco">Jalisco</option>'
+ '<option value="Michoacán">Michoacán</option>'
+ '<option value="Morelos">Morelos</option>'
+ '<option value="Nayarit">Nayarit</option>'
+ '<option value="Nuevo León">Nuevo León</option>'
+ '<option value="Oaxaca">Oaxaca</option>'
+ '<option value="Puebla">Puebla</option>'
+ '<option value="Querétaro">Querétaro</option>'
+ '<option value="Quintana Roo">Quintana Roo</option>'
+ '<option value="San Luis Potosí">San Luis Potosí</option>'
+ '<option value="Sinaloa">Sinaloa</option>'
+ '<option value="Sonora">Sonora</option>'
+ '<option value="Tabasco">Tabasco</option>'
+ '<option value="Tamaulipas">Tamaulipas</option>'
+ '<option value="Tlaxcala">Tlaxcala</option>'
+ '<option value="Veracruz">Veracruz</option>'
+ '<option value="Yucatán">Yucatán</option>'
+ '<option value="Zacatecas">Zacatecas</option>';

var estadosUSA = ''
+ '<option value="Alabama">Alabama</option>'
+ '<option value="Alaska">Alaska</option>'
+ '<option value="Arizona">Arizona</option>'
+ '<option value="Arkansas">Arkansas</option>'
+ '<option value="California">California</option>'
+ '<option value="Carolina del Norte">Carolina del Norte</option>'
+ '<option value="Carolina del Sur">Carolina del Sur</option>'
+ '<option value="Colorado">Colorado</option>'
+ '<option value="Connecticut">Connecticut</option>'
+ '<option value="Dakota del Norte">Dakota del Norte</option>'
+ '<option value="Dakota del Sur">Dakota del Sur</option>'
+ '<option value="Delaware">Delaware</option>'
+ '<option value="Florida">Florida</option>'
+ '<option value="Georgia">Georgia</option>'
+ '<option value="Hawai">Hawai</option>'
+ '<option value="Idaho">Idaho</option>'
+ '<option value="Illinois">Illinois</option>'
+ '<option value="Indiana">Indiana</option>'
+ '<option value="Iowa">Iowa</option>'
+ '<option value="Kansas">Kansas</option>'
+ '<option value="Kentucky">Kentucky</option>'
+ '<option value="Luisiana">Luisiana</option>'
+ '<option value="Maine">Maine</option>'
+ '<option value="Maryland">Maryland</option>'
+ '<option value="Massachusetts">Massachusetts</option>'
+ '<option value="Michigan">Michigan</option>'
+ '<option value="Minnesota">Minnesota</option>'
+ '<option value="Misisipi">Misisipi</option>'
+ '<option value="Misuri">Misuri</option>'
+ '<option value="Montana">Montana</option>'
+ '<option value="Nebraska">Nebraska</option>'
+ '<option value="Nevada">Nevada</option>'
+ '<option value="Nueva Jersey">Nueva Jersey</option>'
+ '<option value="Nueva York">Nueva York</option>'
+ '<option value="Nuevo Hampshire">Nuevo Hampshire</option>'
+ '<option value="Nuevo México">Nuevo México</option>'
+ '<option value="Ohio">Ohio</option>'
+ '<option value="Oklahoma">Oklahoma</option>'
+ '<option value="Oregon">Oregon</option>'
+ '<option value="Pensilvania">Pensilvania</option>'
+ '<option value="Rhode Island">Rhode Island</option>'
+ '<option value="Tennessee">Tennessee</option>'
+ '<option value="Texas">Texas</option>'
+ '<option value="Utah">Utah</option>'
+ '<option value="Vermont">Vermont</option>'
+ '<option value="Virginia">Virginia</option>'
+ '<option value="Virginia Occidental">Virginia Occidental</option>'
+ '<option value="Washington">Washington</option>'
+ '<option value="Wisconsin">Wisconsin</option>'
+ '<option value="Wyoming">Wyoming</option>';

var estadosCanada = ''
+ '<option value="Ontario">Ontario</option>'
+ '<option value="Quebec">Quebec</option>'
+ '<option value="Nueva Escocia">Nueva Escocia</option>'
+ '<option value="Nuevo Brunswick">Nuevo Brunswick</option>'
+ '<option value="Manitoba">Manitoba</option>'
+ '<option value="Columbia Británica">Columbia Británica</option>'
+ '<option value="Isla del Príncipe Eduardo">Isla del Príncipe Eduardo</option>'
+ '<option value="Saskatchewan">Saskatchewan</option>'
+ '<option value="Alberta">Alberta</option>'
+ '<option value="Terranova y Labrador">Terranova y Labrador</option>'
+ '<option value="Territorios del Noroeste">Territorios del Noroeste</option>'
+ '<option value="Yukon">Yukon</option>'
+ '<option value="Nunavut">Nunavut</option>';


function load(){
    cargarCiudades();
}

function estados(){
    var pais = $('#pais').val();
    var estados;
    switch (pais) {
        case "MEXICO":
            estados = estadosMexico;
            break;

        case "USA":
            estados = estadosUSA;
            break;

        case "CANADA":
            estados = estadosCanada;
            break;
    
        default:
            estados="";
            break;
    }
    $('#estado').html(estados);
}

function cargarCiudades(){
    var URL = base_url + "empresas/ajax_getCiudades";
    $("#lstCiudades option").remove();
    var lista = $("#lstCiudades");

    $.ajax({
        type: "POST",
        url: URL,
        success: function(result) {
            if(result)
            {
                var rs = JSON.parse(result);
                $.each(rs, function(i, elem){
                    var opt = document.createElement('option');
                    opt.value = elem.ciudad;
                    lista.append(opt);
                });
            }
          },
      });
}






function phoneMask(inp){
    var valor = $(inp).val();
    var numeros = valor.replace("(", "");
    var numeros = numeros.replace(")", "");
    var numeros = numeros.replace("-", "");
    if(numeros.length == 3)
    {
        $(inp).val("(" + numeros + ")");
    }
    if(numeros.length == 7)
    {
        $(inp).val("(" + numeros.substring(0,3) + ")" + numeros.substring(3,6) + "-" + numeros.substring(6,7));
    }
    if(numeros.length == 9)
    {
        $(inp).val("(" + numeros.substring(0,3) + ")" + numeros.substring(3,6) + "-" + numeros.substring(6,8) + "-" + numeros.substring(8,9));
    }
    
}