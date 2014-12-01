/* 
 * #Autor: I.S.C Carlos López Ortíz.
 * #CYBERIA
 */

function validanumeros(evt)
{		
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode ==27 || charCode==8 || charCode==190 || charCode==9) return true;	
	if (charCode >= 48 && charCode <= 57) return true;	
	if (charCode >= 96 && charCode <= 105)return true;
	return false;
}

function muestra_oculta(id)
{
    if (document.getElementById)
    { //se obtiene el id
        var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
        el.style.display = (el.style.display == 'none') ? 'block' : 'none'; //damos un atributo display:none que oculta el div
        document.getElementById('otros').checked = (el.style.display == 'none') ? false : true;
    }
}

var patron = new Array(4,2,2);
var patron2 = new Array(1,3,3,3,3);

function mascara(d,sep,pat,nums){
if(d.valant != d.value){
	val = d.value
	largo = val.length;
	val = val.split(sep);
	val2 = '';
	for(r=0;r<val.length;r++){
		val2 += val[r];	
	}
	if(nums){
		for(z=0;z<val2.length;z++){
			if(isNaN(val2.charAt(z))){
				letra = new RegExp(val2.charAt(z),"g");
				val2 = val2.replace(letra,"");
			}
		}
	}
	val = ''
	val3 = new Array();
	for(s=0; s<pat.length; s++){
		val3[s] = val2.substring(0,pat[s]);
		val2 = val2.substr(pat[s]);
	}
	for(q=0;q<val3.length; q++){
		if(q ==0){
			val = val3[q];
		}
		else{
			if(val3[q] != ""){
				val += sep + val3[q];
				}
		}
	}
	d.value = val;
	d.valant = val;
	}
}

function calcular_edad(fecha) {
var fechaActual = new Date();
var diaActual = fechaActual.getDate();
var mmActual = fechaActual.getMonth() + 1;
var yyyyActual = fechaActual.getFullYear();
FechaNac = fecha.split("-");
var diaCumple = FechaNac[2];
var mmCumple = FechaNac[1];
var yyyyCumple = FechaNac[0];
//retiramos el primer cero de la izquierda
if (mmCumple.substr(0,1) == 0) {
mmCumple= mmCumple.substring(1, 2);
}
//retiramos el primer cero de la izquierda
if (diaCumple.substr(0, 1) == 0)
{
    diaCumple = diaCumple.substring(1, 2);
}
var edad = yyyyActual - yyyyCumple;

if ((mmActual < mmCumple) || (mmActual == mmCumple && diaActual < diaCumple)) {
edad--;
}
document.getElementById('pae_edad').value = edad;
};

function habilita_registrar()
{
   // alert('ok');
}

function ajaxFucntion()
{
    var ajaxRequest;
    try
    {
        ajaxRequest = new XMLHttpRequest();
        
    }catch(e)
        {
            try
            {
                ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
            }catch(e)
                {
                    try
                    {
                        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                    }catch(e)
                        {
                            alert("Wrong");
                            return false;
                        }
                }
        }
}

function actualizaTratamientos()
{
    
}