
$(document).ready(function() {

    //console.log("eeeeepaa");
    $('#celular').keydown(function(e) {    
      // Admite [0-9], BACKSPACE y TAB  
      if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105) && e.keyCode != 8 && e.keyCode != 9)  
          e.preventDefault();  
    });
    
    $('#telefono').keydown(function(e) {    
      // Admite [0-9], BACKSPACE y TAB  
      if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105) && e.keyCode != 8 && e.keyCode != 9)  
          e.preventDefault();  
    });
    

});





