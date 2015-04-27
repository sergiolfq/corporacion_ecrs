
$(document).ready(function () {

    //console.log("registro js");

    $('#datos_ingreso').hide();

    $("#continuar").click(function () {

        $('#datos_ingreso').show('slow');
        $('#registro').hide();
        $('#bienvenido').hide();
        
        var tipo_user = $('input:radio[name=optionsRadios]:checked').val();
        console.log(tipo_user);

        if(tipo_user == 2 || tipo_user == 3 || tipo_user == 10 || tipo_user == 11){
            $("#personal_tecnico").show();
        }else{
            $("#personal_tecnico").hide();
        }
        

    });
    
    $("#back_registro").click(function () {

        $('#datos_ingreso').hide();
        $('#registro').show('slow');
        $('#bienvenido').show('slow');

    });
    
    var i = 0;
    
    $('#new_tec').hide();
    $('#other_tec').hide();
    $('#mas_tec').hide();
    $('#sin_tec').hide();
    
    $("#more_tec").click(function () {
        i = i + 1; 
        console.log(i);
        if(i == 1){
            $('#new_tec').show('slow');
        }
        if(i == 2){
            $('#other_tec').show('slow');
        }
        if(i == 3){
            $('#mas_tec').show('slow');
        }
        if(i > 3){
            $('#sin_tec').show();
            $('#more_tec').hide();
        }
        

    });
    
    $("#borrar_tec").click(function () {
        $('#new_tec').hide('slow');
        i = 0;
        $('#sin_tec').hide();
        $('#more_tec').show();
        $("#nombre_tecnico2").val('');
        $("#letra_rif_tecnico2").val('')
        $("#rif_tecnico2").val('');
    });
    
    $("#borro_tec").click(function () {
        $('#other_tec').hide('slow');
        i = 1;
        $('#sin_tec').hide();
        $('#more_tec').show();
        $("#nombre_tecnico3").val('');
        $("#letra_rif_tecnico3").val('')
        $("#rif_tecnico3").val('');
    });
    
    $("#masDelete_tec").click(function () {
        $('#mas_tec').hide('slow');
        i = 2;
        $('#sin_tec').hide();
        $('#more_tec').show();
        $("#nombre_tecnico4").val('');
        $("#letra_rif_tecnico4").val('')
        $("#rif_tecnico4").val('');
    });
    
    
    
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    
    
    $("#pais_contrib").change(function(){
        console.log($("#pais_contrib").val());
        $.ajax({
          url:"../soporte/selects_dependientes.php",
          type: "POST",
          data:"idPais="+$("#pais_contrib").val(),
          success: function(opciones){
            $("#estado_contrib").html(opciones);
            
          }
        })
    });
    
    $("#estado_contrib").change(function(){
        console.log($("#estado_contrib").val());
        $.ajax({
          url:"../soporte/selects_dependientes.php",
          type: "POST",
          data:"idEstado="+$("#estado_contrib").val(),
          success: function(alternativas){
            $("#ciudad_contrib").html(alternativas);
          }
        })
    });
    
    if($("#pais_contrib").val() != '' && $("#estado_contrib").val() != '' &&  $("#ciudad_contrib").val() != ''){
        
        var pais_contrib = $("#pais_contrib").val();
        var estado_contrib = $("#estado_contrib").val();
        var ciudad_contrib = $("#ciudad_contrib").val();
        
        $("#validar").click(function(){
            var parametros = {"pais_contrib" : pais_contrib, "estado_contrib" : estado_contrib, "ciudad_contrib" : ciudad_contrib};

            $.ajax({
                url:"save_enajenacion.php",
                type: "POST",
                data: parametros,
                success: function(alternativas){
                  $("#ciudad_contrib").html(alternativas);
                }
            })
        });
    }
    
    
    // validaciones para ingreso (login)
    $("#iniciar_sesion").click(function () {
        
        if($("#email").val() != '' && $("#password").val()){
            //console.log($("#email").val());
            //console.log($("#password").val());
            var email = $("#email").val();
            var password = $("#password").val();
            var parametros = {"email" : email, "password" : password};

            $.ajax({
                url:"login.php",
                type: "POST",
                data: parametros,
                success: function(data){
                    var obj = JSON.parse(data);
                    //console.log(obj);
                    if(obj.resultado == "Acceso denegado"){
                        $('#sesion_error').show('slow');
                    }
                    if(obj.resultado == "Acceso correcto"){
                        console.log('creo la sesion');
                        $.ajax({
                            url:"sesion_user.php",
                            type: "POST",
                            data: parametros,
                            success: function(datos){
                                var objetos = JSON.parse(datos);
                                console.log(objetos);
                                if(objetos.valores == 'sesion cargada'){
                                    var url = "/";    
                                    $(location).attr('href',url);
                                }
                            }
                        })
                        
                    }
                }
                
            })
        }  
            
    });
    
    
    $('#rif_correcto').hide();
    $('#procesando').hide();
    
    // redirecciono a la pagina de inicio al cargar los datos
    $("#datos_guardatos").click(function () {
        var home = "/";    
        $(location).attr('href',home);
    });
    
    //limpio los inputs si pulsa el boton de volver
    $("#back_registro").click(function () {
        
        $("#razon_social").val('');
        $("#Letra_rif_cliente").val('')
        $("#id_cliente").val('');
        $("#contacto").val('');
        $("#Letra_rif_contacto").val('');
        $("#rif_contacto").val('');
        $("#direccion").val('');
        $("#pais_contrib").val('');
        $("#estado_contrib").val('');
        $("#ciudad_contrib").val('');
        $("#phone").val('');
        $("#email_contrib").val('');
        $("#nombre_tecnico1").val('');
        $("#letra_rif_tecnico1").val('')
        $("#rif_tecnico1").val('');
        $("#nombre_tecnico2").val('');
        $("#letra_rif_tecnico2").val('')
        $("#rif_tecnico2").val('');
        $("#nombre_tecnico3").val('');
        $("#letra_rif_tecnico3").val('')
        $("#rif_tecnico3").val('');
        $("#nombre_tecnico4").val('');
        $("#letra_rif_tecnico4").val('')
        $("#rif_tecnico4").val('');
        
        $('#new_tec').hide();
        $('#other_tec').hide();
        $('#mas_tec').hide();
        i = 0;
        
    });
    
    $("#id_cliente").click(function () {
        var rif_cliente = $("#id_cliente");
        number(rif_cliente);
    });
    $("#rif_contacto").click(function () {
        var rif_contacto = $("#rif_contacto");
        number(rif_contacto);
    });
    $("#rif_tecnico1").click(function () {
        var rif_tecnico1 = $("#rif_tecnico1");
        number(rif_tecnico1);
    });
    $("#rif_tecnico2").click(function () {
        var rif_tecnico2 = $("#rif_tecnico2");
        number(rif_tecnico2);
    });
    $("#rif_tecnico3").click(function () {
        var rif_tecnico3 = $("#rif_tecnico3");
        number(rif_tecnico3);
    });
    $("#rif_tecnico4").click(function () {
        var rif_tecnico4 = $("#rif_tecnico4");
        number(rif_tecnico4);
    });
    
    
    //funcion para validar que se encriban solo numeros
    function number(id){
        id.keydown(function(e) {    
        // Admite [0-9], BACKSPACE y TAB  
        if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105) && e.keyCode != 8 && e.keyCode != 9)  
            e.preventDefault();  
        });
    }
    
    //valido si selecciona el tipo de usuario para habilitar el boton de continuar
    $('#continuar').attr("disabled", true);
    $("input:radio[name=optionsRadios]").click(function () {
        $('#continuar').attr("disabled", false);
    });
    
    
    
    $("#recuperar_clave").click(function () {
        
        $('#error_recuperar').hide('slow');
        var correo = $('#email_recuperar').val();
        var rif_user = $('#rif_recuperar').val();
//        console.log(correo);

        var recuperar = {"correo" : correo, "rif_user" : rif_user};
        
        $.ajax({
            url:"recuperar_clave.php",
            type: "POST",
            data: recuperar,
            success: function(recover){
                console.log(recover);
                if(recover == 0){
                    $('#error_recuperar').show('slow');
                }
                if(recover == 1){
                    $('#modal_recuperar_clave').modal('show');
                }   
            }
        })
        
    });
    
    

});


// funcion para la validaciones de la carga de un nuevo usuario al sistema 
function validaciones() {
    
    var tipo_usuario = $('input:radio[name=optionsRadios]:checked').val();
    console.log(tipo_usuario);
    
    if(tipo_usuario != '2'){
        $("#personal_tecnico").hide();
    }
    
    $('#no_conexion').hide();
    $('#rif_invalido').hide();
    $("#email_invalido").hide();
    $("#rif_duplicado").hide();
    $("#user_error").hide();
    $("#tec_existe").hide();
    $('#procesando').show('slow');
    var rif_validar = $("#Letra_rif_cliente").val()+$("#id_cliente").val();
    //console.log(rif_validar);

        $.ajax({
            url:"validar.php",
            type: "POST",
            data:"rif_validar="+rif_validar,
            success:function(data){

                var valor_rif = JSON.parse(data);
                console.log(valor_rif);
                

                if(valor_rif.datos == 'Consulta satisfactoria'){
                    $('#procesando').hide();

                    var razon_social = $("#razon_social").val();
                    var rif_razon_social = $("#Letra_rif_cliente").val()+$("#id_cliente").val();
                    var contacto = $("#contacto").val();
                    var rif_contacto = $("#Letra_rif_contacto").val()+$("#rif_contacto").val();
                    var direccion = $("#direccion").val();
                    var pais = $("#pais_contrib").val();
                    var estado = $("#estado_contrib").val();
                    var ciudad = $("#ciudad_contrib").val();
                    var phone = $("#phone").val();
                    var email = $("#email_contrib").val();
                    var nombre_tecnico1 = $("#nombre_tecnico1").val();
                    var rif_tecnico1 = $("#letra_rif_tecnico1").val()+$("#rif_tecnico1").val();
                    var nombre_tecnico2 = $("#nombre_tecnico2").val();
                    var rif_tecnico2 = $("#letra_rif_tecnico2").val()+$("#rif_tecnico2").val();
                    var nombre_tecnico3 = $("#nombre_tecnico3").val();
                    var rif_tecnico3 = $("#letra_rif_tecnico3").val()+$("#rif_tecnico3").val();
                    var nombre_tecnico4 = $("#nombre_tecnico4").val();
                    var rif_tecnico4 = $("#letra_rif_tecnico4").val()+$("#rif_tecnico4").val();
                    var tipo_usuario = $('input:radio[name=optionsRadios]:checked').val();
                    
                    console.log(tipo_usuario);

                    var datos_usuario = {"razon_social" : razon_social, "rif_razon_social" : rif_razon_social, "contacto" : contacto,
                        "rif_contacto" : rif_contacto, "direccion" : direccion, "pais" : pais, "estado" : estado, "estado" : estado, 
                        "ciudad" : ciudad, "phone" : phone, "email" : email, "nombre_tecnico1" : nombre_tecnico1, "rif_tecnico1" : rif_tecnico1,
                        "nombre_tecnico2" : nombre_tecnico2, "rif_tecnico2" : rif_tecnico2, "nombre_tecnico3" : nombre_tecnico3,
                        "rif_tecnico3" : rif_tecnico3, "nombre_tecnico4" : nombre_tecnico4, "rif_tecnico4" : rif_tecnico4, "tipo_usuario" : tipo_usuario};

                    $.ajax({
                        url:"registro_usuario.php",
                        type: "POST",
                        data: datos_usuario,
                        success: function(result){
                            console.log(result);

                            if(result == 0){
                                $("#email_invalido").show('slow');
                            } 
                            if(result == 1){
                                $("#email_invalido").hide();
                                $('#modal_save').modal('show');
                            }  
                            if(result == 00){
                                $("#rif_duplicado").show('slow');
                                $("#id_cliente").val('');
                            }
                            if(result == -1){
                                $("#user_error").show('slow');
                            }
                            if(result == -3){
                                $("#tec_existe").show('slow');
                            }
                        },
                        error: function (err) {
                            console.log('Ocurrio un error');
                        }
                    })
                    
                }
                if(valor_rif.datos == 'Sin Conexión a Internet'){
                    $('#no_conexion').show('slow');
                    $('#procesando').hide();
                }
                if(valor_rif.datos == 'Rif Inexistente o Inválido'){
                    $('#rif_invalido').show('slow');
                    $('#procesando').hide();
                }

            },
            error: function (err) {
                $('#no_conexion').show('slow');
                console.log('paso por el error de conexion');
                $('#procesando').hide();
            }

        })
    
    return false;
}

