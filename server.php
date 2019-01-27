<?php

include("api/db.php");


header('Content-Type: application/json');
require 'vendor/autoload.php';


/* Verificamos que se invoque a la página mediante POST */
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    /* Obtengo los valores del formulario */
    $title = mb_strtoupper($_POST["title"]);
    $first_name = mb_strtoupper($_POST['fname']);
    $last_name = mb_strtoupper($_POST['lname']);
    $company = mb_strtoupper($_POST['company']);
    $address = mb_strtoupper($_POST['address']);
    $country = mb_strtoupper($_POST['country']);
    $city = mb_strtoupper($_POST['city']);
    $email = mb_strtoupper($_POST['email']);
    $phone = mb_strtoupper($_POST['phone']);
    $fee = mb_strtoupper($_POST['fee']);
	$pagoonline = mb_strtoupper($_POST['pago-online']);
   
	 $generate_token_form_post = $_POST["token_frm"];
    /* Validar que formulario no sea modificado en el camino */
    $generate_token_form = $title . '#' . $first_name . '#' . $last_name . '#' . $company . '#' . $address . '#' . $country . '#' . $city . '#' . $email . '#' . $phone . '#' . $fee . '#' . $last_name;
    $generate_token_form = sha1($generate_token_form);

    if ($generate_token_form !== $generate_token_form_post)
    {
        $rpta = [
            'id' => -1,
            'msg' => 'Por favor, no alterar el contenido del formulario.'
        ];
        echo json_encode($rpta);
        exit;
    }
    /* Validar categorías de pago */
    $category_fee = array("IACD","CERTIFIED", "NOMEMBER", "STUDENT");
    if (!in_array($fee, $category_fee))
    {
        $rpta = [
            'id' => -1,
            'msg' => 'Categoría no definida. Por favor actualice la página y vuelva a llenar el formulario.'
        ];
        echo json_encode($rpta);
        exit;
    }
	
	
	if($fee === 'IACD'){
		$amount = '360';
	}else if($fee === 'CERTIFIED'){
		$amount = '360';
	}else if($fee === 'NOMEMBER'){
		$amount = '640';
	}else if($fee === 'STUDENT'){
		$amount = '240';
	}
	
	
	
    try {

        // Response
            $data = [
                'title' => $title,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'company' => $company,
                'address' => $address,
                'country' => $country,
                'city' => $city,
                'email' => $email,
                'phone' => $phone,
                'fee' => $fee,
				'pagoonline' = $pagoonline
            ];
            /* Insetando registro en bd */
            insertArr("wcocdlim_registro.congreso_registro", $data);
			
			$data['amount'] = $amount;
			
			
			
            /* Enviando correo */
            sendEmailConfirm($data);
            sendEmailConfirm2($data);	
	
            $rpta = [
                'id' => 1,
                'msg' => "Dear participant, we will contact you as soon as possible, to help you with the registration process at WCOCD LIMA 2019.<br>
							Estimado participante, nos contactaremos con usted a la brevedad posible, para ayudarlo con el proceso de registro al WCOCD LIMA 2019."
            ];
            echo json_encode($rpta);
      
    } catch (Exception $e) {
        $respuesta_json = json_decode($e->getMessage());
        $rpta = [
                'id' => -1,
                'msg' => $respuesta_json->user_message
            ];
        
        echo json_encode($rpta);
    }
}
else
{
    $rpta = [
        'id' => -1,
        'msg' => 'Method is not defined'
    ];
    echo json_encode($rpta);
}
exit;
