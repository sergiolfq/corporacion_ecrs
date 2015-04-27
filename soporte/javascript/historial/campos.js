
$(document).ready(function() {


    //console.log("campos js");
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
                var objeto=document.getElementById('muestra');  //obtenemos el objeto a imprimir
                var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
                ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
                ventana.document.close();  //cerramos el documento
                ventana.print();  //imprimimos la ventana
                ventana.close();  //cerramos la ventana
            });
        }else{
            //console.log('ahora se bloquea');
            $('#certificado').attr("disabled", true);
        }
    });
    
    
    $("#nombre_tecnico").change(function() {
        console.log('asigno valor');
        var rifTecnico = $("#nombre_tecnico").val();
        $("#id_tecnico").val(rifTecnico);
    });
    

});







