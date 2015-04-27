
$(document).ready(function() {


    console.log("contacto js");
    
    setTimeout(function() {
        $("#mail_contacto").fadeOut(1500);
        $("#mail_error").fadeOut(1500);
        $("#correo_guardado").fadeOut(1500);
        $("#correo_warning").fadeOut(1500);
        $("#error_captcha").fadeOut(1500);
    },6000);
    
    
    
    $('#guardar_correo').click(function(){
	
        $('#correo_guardado').hide();
        $('#correo_warning').hide();
        
        var nuevo_mail = $('#subscribe').val();
       
        console.log(nuevo_mail);
        
        $.ajax({
	    type: "POST",
	    url: "modules/email_suscribirse.php",
	    data: "email="+nuevo_mail,
	    success: function(data) {
                console.log(data);
		
                if(data == 1){
                    $('#correo_guardado').show();	
                }
                if(data == 0){
                    $('#correo_warning').show();	
                }

	    },
	    error: function() {
	    	$('#nohaycedula').show('slow');
        	$("#nohaycedula").html('El numero de cedula no le corresponde a ningun empleado <br>');  
        	//$('#datosGuardar').hide('slow');              
    	}

	});
	
    });
    
    

});








