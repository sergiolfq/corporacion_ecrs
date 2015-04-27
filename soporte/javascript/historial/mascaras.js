//jquery: onkeyup, onkeypress
function nums(donde, caracter, entr, decm) {
    cer = /\b0[0-9]*/
    valor = donde.value + caracter
    largo = valor.length
    crtr = true
    ndec = decm
    if (isNaN(caracter)) {
        if (largo > 1) {
            donde.value = valor.substring(0, largo - 1)
        }
        else {
            donde.value = ""
        }
        crtr = false                
    }
    else {
        caracter = "\\,|\\."
        carcter = new RegExp(caracter, "g")
        onlynums = valor.replace(carcter, "")
        if (cer.test(onlynums) == true || onlynums.length <= ndec) {
            temp = ndec
            ndec = onlynums.length - 1
            if(ndec < 0) ndec = 0
            if (ndec > temp) {
                spx = temp > 0 ? 2 : 1
                donde.value = valor.substring(0, temp + spx)
                crtr = false
            }
        }

        var nums = new Array()
        cont = 0
        for (m = 0; m < largo; m++) {
            if (valor.charAt(m) == "." || valor.charAt(m) == " " || valor.charAt(m) == ",") {
                continue;
            }
            else {
                nums[cont] = valor.charAt(m)
                cont++
            }
        }
        if (cont > entr) crtr = false;
    }

    var cad1 = "", cad2 = "", tres = 0
    var dec = ndec == 0 ? true : false;
    if (largo > ndec && crtr == true) {
        for (k = nums.length - 1; k >= 0; k--) {
            cad1 = nums[k]
            cad2 = cad1 + cad2
            tres++
            if (tres == ndec) {
                if (k != 0) {
                    cad2 = "," + cad2
                    dec = true;
                }
            }
            if (dec && (tres - ndec) != 0) {
                if (((tres - ndec) % 3) == 0) {
                    if (k != 0) {
                        cad2 = "." + cad2
                    }
                }
            }
        }
        donde.value = cad2
    }
}

function toEnd(el) {
    var len = el.value.length || 0;
    if (len) {
        if ('setSelectionRange' in el) el.setSelectionRange(len, len);
        else if ('createTextRange' in el) {// for IE
            var range = el.createTextRange();
            range.moveStart('character', len);
            range.select();
        }
    }
}

//onblur
function email(elem) {
    var s = elem.value;
    var filter = /^[A-Za-z][A-Za-z0-9_.]*@[A-Za-z0-9_]+\.[A-Za-z0-9_.]+[A-za-z]$/;
    if (s.length == 0) return true;
    if (filter.test(s))
        return true;
    else
        alert("Ingrese una dirección de correo válida");
    elem.focus();
    return false;
}

//onblur
function rangoPctj(elem, nombre) {
    caracter = "\\."
    carcter = new RegExp(caracter, "g")
    original = elem.value
    valor = elem.value.replace(carcter, "")
    valor = valor.replace(",", ".")
    var s = parseFloat(valor);
    if (s <= 100 && s > 0) return true;
    else
        alert("El porcentaje debe ser mayor que 1 y menor o igual 100");
    elem.focus();
    elem.value = original
    return false;
}

////onkeyup
//function identificador(donde) {
//    valor = donde.value
//    filter = "[^A-Za-z0-9_ ñÑáéíóú]"
//    carcter = new RegExp(filter, "g")
//    if (carcter.test(valor)) {
//        donde.value = valor.replace(carcter, "")
//    }
//}

//onkeyup
function identificador(valor) {
    filter = "[^A-Za-z0-9_]"
    carcter = new RegExp(filter, "g")
    if (carcter.test(valor)) return false;
    return true;
}

//jquery: keypress
function nombres(valor) {
    filter = "[^A-Za-z ]"
    carcter = new RegExp(filter, "g")
    if (carcter.test(valor)) return false;
    return true;
}

function trim(stringToTrim) {
    return stringToTrim.replace(/^\s+|\s+$/g, "");
}
function ltrim(stringToTrim) {
    return stringToTrim.replace(/^\s+/, "");
}
function rtrim(stringToTrim) {
    return stringToTrim.replace(/\s+$/, "");
}

function verify(elem_name){
    var pwfield = document.getElementById(elem_name);
    if(pwfield.value.length >= 8 && pwfield.value.length <= 12) {
        pwfield.value = rstr2hex(rstr_md5(rstr_md5(str2rstr_utf8(pwfield.value))));   
        return true;                
    }            
    return false;
}