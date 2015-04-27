$(document).ready(function() {

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