/*Métodos que cargan cuando la página está lista*/
$(function () {

    /*Agregando validación de entrada para campos del formulario*/
    var txt_tittle = jQuery('#title');
    var txt_fname = jQuery('#fname');
    var txt_lname = jQuery('#lname');
    var txt_company = jQuery('#company');
    var txt_address = jQuery('#address');
    var txt_city = jQuery('#city');
    var txt_email = jQuery('#email');
    var txt_phone = jQuery('#phone');
    var txt_fee = jQuery('#fee');


    txt_tittle.filter_input({regex: '[a-zA-Z \'ñÑáÁéÉíÍóÓúÚäÄëËïÏöÖüÜ]'});
    txt_fname.filter_input({regex: '[a-zA-Z \'ñÑáÁéÉíÍóÓúÚäÄëËïÏöÖüÜ]'});
    txt_lname.filter_input({regex: '[a-zA-Z \'ñÑáÁéÉíÍóÓúÚäÄëËïÏöÖüÜ]'});
    txt_company.filter_input({regex: '[a-zA-Z \'ñÑáÁéÉíÍóÓúÚäÄëËïÏöÖüÜ]'});
    txt_address.filter_input({regex: '[a-zA-Z0-9 \'ñÑáÁéÉíÍóÓúÚäÄëËïÏöÖüÜ]'});
    txt_city.filter_input({regex: '[a-zA-Z \'ñÑáÁéÉíÍóÓúÚäÄëËïÏöÖüÜ]'});
    txt_email.filter_input({regex: '[a-zA-Z0-9._@-]'});
    txt_phone.filter_input({regex: '[0-9]'});
    txt_fee.filter_input({regex: '[a-zA-Z \'ñÑáÁéÉíÍóÓúÚäÄëËïÏöÖüÜ]'});

    /*Evitar caracteres con ALT + */
    jQuery('#phone').on('keypress', evtKeypressStop);

    /*Evitar 0 al inicio*/
    txt_tittle.on("change paste keyup", function () {
        if ($(this).val().charAt(0) === ' ') {
            $(this).val('');
        }
    });
    txt_fname.on("change paste keyup", function () {
        if ($(this).val().charAt(0) === ' ') {
            $(this).val('');
        }
    });
    txt_lname.on("change paste keyup", function () {
        if ($(this).val().charAt(0) === ' ') {
            $(this).val('');
        }
    });
    txt_company.on("change paste keyup", function () {
        if ($(this).val().charAt(0) === ' ') {
            $(this).val('');
        }
    });
    txt_address.on("change paste keyup", function () {
        if ($(this).val().charAt(0) === ' ') {
            $(this).val('');
        }
    });
    txt_city.on("change paste keyup", function () {
        if ($(this).val().charAt(0) === ' ') {
            $(this).val('');
        }
    });
    txt_email.on("change paste keyup", function () {
        if ($(this).val().charAt(0) === ' ') {
            $(this).val('');
        }
    });
    txt_phone.on("change paste keyup", function () {
        if ($(this).val().charAt(0) === ' ') {
            $(this).val('');
        }
    });
    txt_fee.on("change paste keyup", function () {
        if ($(this).val().charAt(0) === ' ') {
            $(this).val('');
        }
    });

    /*Evento onChange para el método de pago*/
    /*jQuery('input[type=radio][name=fee]').change(function () {
        if (this.value == 'iacd') {
            strings_.settingsCulqi.description = strings_.settingsCulqiAltern.title_dermatologist;
            strings_.settingsCulqi.amount = strings_.settingsCulqiAltern.amount_dermatologist;
            Culqi.settings(strings_.settingsCulqi);
        } else if (this.value == 'nomember') {
            strings_.settingsCulqi.description = strings_.settingsCulqiAltern.title_no_dermatologist;
            strings_.settingsCulqi.amount = strings_.settingsCulqiAltern.amount_no_dermatologist;
            Culqi.settings(strings_.settingsCulqi);
        } else if (this.value == 'student') {
            strings_.settingsCulqi.description = strings_.settingsCulqiAltern.title_student;
            strings_.settingsCulqi.amount = strings_.settingsCulqiAltern.amount_student;
            Culqi.settings(strings_.settingsCulqi);
        }
    });
	*/
	
    /*Evento onClick: primero valida campos llenos y luego muestra formulario de pago*/
    jQuery("#btn_submit").click(function (e) {
      
       if($('input[name=fee]:checked').val() === undefined){
            bootbox.alert('Por favor, seleccione una categoría para el pago.', function () {});
            return false;
        }
        var error = 0;
        $.each($('#frm_registration').serializeArray(), function () {
            if (this.value === '' || this.value === undefined) {
                bootbox.alert(strings_.messages_error[this.name], function () {});
                error++;
                return false;
            }
        });
        if (error > 0) {
            return false;
        }
        
          if(txt_address.val().length <=3){
        bootbox.alert('Por favor, ingrese una dirección válida', function () {});
        return false;
    }
       
		sendForm();    
        e.preventDefault();
    });
});


function sendForm(){
	 var formData = jQuery('#frm_registration').serializeObject();
	 formData.token_frm = frm_tokenizer(formData);
	 
	 if(formData.pago-online === undefined){
	     bootbox.alert("Por favor, seleccione un método de pago.");
                return false;
	 }
	 
	$.ajax({
            type: 'POST',
            url: 'server.php',
            data: formData,
            datatype: 'json',
            success: function (data) {
                bootbox.alert(data.msg, function () {});
                resultdiv();
                if (parseInt(data.id) > 0) {
                    jQuery('#frm_registration')[0].reset();
                    if(parseInt(formData.pago-online) === 1){
                        //visa
                        if(formData.fee === "iacd"){
                            window.location.href = 'https://www.visanetlink.pe/pagoseguro/PERUDERM/63243';    
                        }else if(formData.fee === "nomember"){
                            window.location.href = 'https://www.visanetlink.pe/pagoseguro/PERUDERM/63247';
                        }else if(formData.fee === "resident"){
                            window.location.href = 'https://www.visanetlink.pe/pagoseguro/PERUDERM/63249';   
                        }
                    }
                }

                return false;
            },
            error: function (error) {
                bootbox.alert(error, function () {});
                return false;
            }
        });
}
/*Función que recoge el token generado y envía al server.php para su respectiva validación*/
function culqi() {

    if (Culqi.token) {
        $(document).ajaxStart(function () {
            run_waitMe();
        });

        var formData = jQuery('#frm_registration').serializeObject();
        formData.token = Culqi.token.id;
        formData.installments = Culqi.token.metadata.installments;
        formData.email = Culqi.token.email;
        formData.token_frm = frm_tokenizer(formData);

        $.ajax({
            type: 'POST',
            url: 'server.php',
            data: formData,
            datatype: 'json',
            success: function (data) {
                bootbox.alert(data.msg, function () {});
                resultdiv();
                if (parseInt(data.id) > 0) {
                    jQuery('#frm_registration')[0].reset();
                }

                return false;
            },
            error: function (error) {
                bootbox.alert(error, function () {});
                return false;
            }
        });
    } else {
        bootbox.alert(Culqi.error.merchant_message, function () {});
        $('body').waitMe('hide');
        return false;
    }

}
/*Función Ajax POST para guardar registro y enviar correo*/
function ajax_register_post_save(obj) {
    var jqxhr = $.post("api/register.php", obj);
    return jqxhr;

}

/*Función para mostrar espera de pago*/
function run_waitMe() {
    $('body').waitMe({
        effect: 'orbit',
        text: 'Procesando pago...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#28d2c8'
    });
}
/*Functión para ocultar mensaje de espera*/
function resultdiv() {
    $('body').waitMe('hide');
}

/*Función para evitar ALT + */
function evtKeypressStop(evt) {
    if (evt.altKey === true) {
        evt.stopImmediatePropagation();
        return false;
    }
}
/*Agregando functión serialize object para obtener los valores de un formulario en formato json*/
$.fn.serializeObject = function ()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

function frm_tokenizer(obj) {
    var token = '';
    if (obj === null || obj === undefined) {
        return token;
    }

    token = obj.title.toUpperCase() + '#' + obj.fname.toUpperCase() + '#' + obj.lname.toUpperCase() + '#' + obj.company.toUpperCase() + '#' + obj.address.toUpperCase() + '#' + obj.country.toUpperCase() + '#' + obj.city.toUpperCase() + '#' + obj.email.toUpperCase() + '#' + obj.phone.toUpperCase() + '#' + obj.fee.toUpperCase() + '#' + obj.lname.toUpperCase();
    token = Kakashi.hash(token);

    return token;

}