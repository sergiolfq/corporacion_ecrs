$(document).ready(function() {
    
    //console.log("numerico js");
    $('#numero_factura').keydown(function(e) {    
      // Admite [0-9], BACKSPACE y TAB  
      if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105) && e.keyCode != 8 && e.keyCode != 9)  
          e.preventDefault();  
    });
    
    $('#numero_control').keydown(function(e) {    
      // Admite [0-9], BACKSPACE y TAB  
      if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105) && e.keyCode != 8 && e.keyCode != 9)  
          e.preventDefault();  
    });
    
    
    $("#pais_contrib").change(function(){
        console.log($("#pais_contrib").val());
        $.ajax({
          url:"selects_dependientes.php",
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
          url:"selects_dependientes.php",
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
    
//    $("#articulo").hide();
//    $("#mes_enajenar").click(function(){
//        $("#articulo").show();
//    });
    
    $("#valor").hide();
    $("#mes_enajenar, #anio_enajenar").change(function(){
        if($("#mes_enajenar").val() != '' && $("#anio_enajenar").val() !=''){
            console.log($("#mes_enajenar").val());
            console.log($("#anio_enajenar").val());
            
            var mes_nuevo = $("#mes_enajenar").val();
            var anio_nuevo = $("#anio_enajenar").val();
            
            var variables = {"mes_nuevo" : mes_nuevo, "anio_nuevo" : anio_nuevo};
        
            $.ajax({
                url:"validaciones.php",
                type: "POST",
                data: variables,
                success: function(valores){
                    
                        $("#valor").show();
                        $("#valor").html(valores);
                    
                    console.log($("#valor").html());
                    
                    if($("#valor").html() === 'Mes y/o año incorrecto. No corresponde con el período a enajenar.'){
                        console.log('no');
                        $('#validar').attr("disabled", true);
                    }else{
                        console.log('si');
                        $('#validar').attr("disabled", false);
                        $("#valor").hide();
                    }
                }
            })
        }
    });
    
    
});


