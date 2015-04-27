
$(document).ready(function() {

    console.log("campos js");
   
    $('#error').hide();
    $('#muestra').hide();
    
    
    $("#validar").click(function(){
        
        if ($('#fecha_ini').val() == '' || $('#fecha_fin').val() == '' || $('#razon_contrib').val() == '' || $('#id_cliente').val() == '' || $('#contacto_contrib').val() == ''
        || $('#contacto_contrib').val() == '' || $('#pais_contrib').val() == '' || $('#estado_contrib').val() == '' || $('#ciudad_contrib').val() == ''
        || $('#cel_contrib').val() == '' || $('#phone_contrib').val() == '' || $('#email_contrib').val() == '' || $('#serial_equipo').val() == '' || $('#producto').val() == ''
        || $('#fecha_enajenacion').val() == '' || $('#tipo_op').val() == '' || $('#precinto').val() == '' || $('#nombre_tecnico').val() == '' || $('#id_tecnico').val() == ''
        || $('#letra_tecnico').val() == '' || $('#Letra_rif_cliente').val() == '') 
        {
            $('#error').show();
            $("#error").text("Existen campos sin completar, por favor verifique su información.");
        }else{
            $('#error').hide();
        }
        
    });
    
    $('#certificado').attr("disabled", true);
    $("#terminos").click(function(){
        if (this.checked) {
            //console.log('deberia desbloquerse');
            $('#certificado').attr("disabled", false);
            $("#certificado").click(function(){
               console.log('funcion imprimir');
                $('#modalCertificado').modal('show');
                $("#certModal").click(function(){
                    var objeto=document.getElementById('muestra');  //obtenemos el objeto a imprimir
                    var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
                    ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
                    ventana.document.close();  //cerramos el documento
                    ventana.print();  //imprimimos la ventana
                    ventana.close();  //cerramos la ventana
                    var actStatus = '1';
                    $.ajax({
                        url:"save_enajenacion.php",
                        type: "POST",
                        data:"actStatus="+actStatus,
                        success: function(mensaje){
                            $("#mensaje_editado").html(mensaje);
                             console.log(mensaje);
                      }
                    })
                    
                });
            });
        }else{
            //console.log('ahora se bloquea');
            $('#certificado').attr("disabled", true);
        }
    });
    
//        console.log('ANTES DE CAMBIAR');
//        $("#nombre_tecnico").change(function(){
//            alert("The text has been changed.");
//        });
        
    
    $("#nombre_tecnico").change(function() {
        console.log('asigno valor');
        var rifTecnico = $("#nombre_tecnico").val();
        $("#id_tecnico").val(rifTecnico);
    });
    
    $('#openModal').modal('show');
    $("#mensaje_editado").hide();
    $("#delete_registro").click(function(){
        console.log($("#numero_registro").val());
        $.ajax({
            url:"acciones.php",
            type: "POST",
            data:"borrar="+$("#numero_registro").val(),
            success: function(mensaje){
                $("#mensaje_editado").show();
                $("#mensaje_editado").html(mensaje);
                
                setTimeout(function() {
                    $("#mensaje_editado").fadeOut(3000);
                },3000);
          }
        })
    });
    
    
    setTimeout(function() {
        //console.log('estoy eliminando');
        $("#mensaje_eliminado").fadeOut(3000);
    },3000);
    
    
    
    
    

});







