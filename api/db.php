<?php
require('PHPMailer.php');
require('SMTP.php');

class connection {

    protected $databaseLink;

    function __construct()
    {
        include "dbSettings.php";
        $this->database = $dbInfo['host'];
        $this->mysql_user = $dbInfo['user'];
        $this->mysql_pass = $dbInfo['pass'];
        $this->openConnection();
        return $this->get_link();
    }

    function openConnection()
    {
        $this->databaseLink = mysql_connect($this->database, $this->mysql_user, $this->mysql_pass);
    }

    function get_link()
    {
        return $this->databaseLink;
    }

}

function insertArr($tableName, $insData)
{
    $db = new connection();
    $columns = implode(", ", array_keys($insData));
    $escaped_values = array_map('mysql_real_escape_string', array_values($insData));
    foreach ($escaped_values as $idx => $data)
        $escaped_values[$idx] = "'" . $data . "'";
    $values = implode(", ", $escaped_values);
    $query = "INSERT INTO $tableName ($columns) VALUES ($values)";
    mysql_query($query) or die(mysql_error());
    mysql_close($db->get_link());
}


function sendEmailClienteVisa($data){
	
	$host = 'single-priva8.privatednsorg.com';
	$subject = 'Regiser Form 14th World Congress of Cosmetic Dermatology';
    $para = $data['email'];
	$password = 'C0ngr3ss.2019';

    //Componemos cuerpo correo.
    $msjCorreo .= "<strong>MESSAGE SENT FROM THE REGISTER US FORM.</strong> ";
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Title:</strong> " . $data['title'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>First name:</strong> " . $data['first_name'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Last name:</strong> " . $data['last_name'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Company:</strong> " . $data['company'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Address:</strong> " . $data['address'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Country:</strong> " . $data['country'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>City:</strong> " . $data['city'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Email:</strong> " . $data['email'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Phone:</strong> " . $data['phone'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Fee:</strong> " . $data['fee'];
	$msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Amount:</strong> USD " . $data['amount'];
	$msjCorreo .= "<br><br>";
	$pagoonline = parseInt($data['pagoonline']);
	if($pagoonline === 1){
		$msjCorreo .= "<strong>Método de pago:</strong> Pago en Línea con Visa ";
		$msjCorreo .= "<br><br>";
	}else if($pagoonline === 2){
		$msjCorreo .= "<strong>Método de pago:</strong> Pago en Línea con MasterCard ";
		$msjCorreo .= "<br><br>";
	}else if($pagoonline === 3){
		$msjCorreo .= "<strong>Método de pago:</strong> Depósito o Transferencia Nacional ";
		$msjCorreo .= "<br><br>";
	}else{
		$msjCorreo .= "<strong>Método de pago:</strong> Depósito o Transferencia Internacional ";
		$msjCorreo .= "<br><br>";
	}
	if($pagoonline === 1){
		//Visa
		$msjCorreo .= "<p>Pago rápido y seguro con tarjeta de Crédito o Débito VISA.</p>" ;
		$msjCorreo .= "<p>Como último paso para su inscripción, VISA le enviará un mail de confirmación, dicho mail debe ser reenviado al correo informes3@grupomilenium.pe</p>" ;
		$msjCorreo .= "<p>Cualquier consulta o duda, favor de contactarse al Whatsapp: +51 981 502 034 / Teléfono: +511 422 4591.</p>" ;
		$msjCorreo .= "<p><strong>Términos y Condiciones:</strong></p>" ;
		$msjCorreo .= "<p>No se aceptan cambios ni devoluciones una vez realizado el pago.</p>" ;
	}else if($pagoonline === 2){
		//Mastercard
		$msjCorreo .= "<p>Pago rápido y seguro con tarjeta de Crédito o Débito MasterCard.</p>" ;
		$msjCorreo .= "<p>Complete los campos solicitados y el monto según su categoría.</p>" ;
		$msjCorreo .= "<p>Como últimos pasos para su inscripción, le enviaremos un mail dónde estará disponible el enlace para completar su pago con tarjetas MasterCard.</p>" ;
		$msjCorreo .= "<p><strong>MasterCard</strong> le enviará un mail de confirmación, dicho mail debe ser reenviado al correo informes3@grupomilenium.pe</p>" ;
		$msjCorreo .= "<p>Cualquier consulta o duda, favor de contactarse al Whatsapp: +51 981 502 034 / Teléfono: +511 422 4591.</p>" ;
		$msjCorreo .= "<p><strong>Términos y Condiciones:</strong></p>" ;
		$msjCorreo .= "<p>No se aceptan cambios ni devoluciones una vez realizado el pago.</p>" ;
	}else if($pagoonline === 3){
		//Depósito Nacional
		$msjCorreo .= "<p>Nombre de Banco: <strong>BBVA CONTINENTAL</strong></p>" ;
		$msjCorreo .= "<p>N° Cta. Cte. Dólares: <strong>0011-0370-0100023817-48</strong></p>" ;
		$msjCorreo .= "<p>N° Cta. Interbancaria CCI: <strong>011-370-000100023817-48</strong></p>" ;
		$msjCorreo .= "<p>A nombre de: <strong>GRUPO PERUANO DE TERAPEUTICA DERMATOLOGICA, ESTETICA Y LASER</strong></p>" ;
		$msjCorreo .= "<p>RUC: <strong>20554571159</strong></p>" ;
		$msjCorreo .= "<p>Cualquier consulta o duda, favor de contactarse al Whatsapp: +51 981 502 034 / Teléfono: +511 422 4591.</p>" ;
		$msjCorreo .= "<p><strong>Términos y Condiciones:</strong></p>" ;
		$msjCorreo .= "<p>No se aceptan cambios ni devoluciones una vez realizado el pago.</p>" ;
	}else{
		//Depósito Internacional
		$msjCorreo .= "<p>Nombre de Banco: <strong>BBVA CONTINENTAL</strong></p>" ;
		$msjCorreo .= "<p>N° Cta. Cte. Dólares: <strong>0011-0370-0100023817-48</strong></p>" ;
		$msjCorreo .= "<p>Código SWIFT: <strong>BCONPEPL</strong></p>" ;
		$msjCorreo .= "<p>A nombre de: <strong>GRUPO PERUANO DE TERAPEUTICA DERMATOLOGICA, ESTETICA Y LASER</strong></p>" ;
		$msjCorreo .= "<p>RUC: <strong>20554571159</strong></p>" ;
		$msjCorreo .= "<p>Dirección: <strong>Av. Rivera Navarrete 451 Oficina 601 - San Isidro</strong></p>" ;
		$msjCorreo .= "<p>Teléfono: <strong>(511) 422 -4591</strong></p>" ;
		$msjCorreo .= "<p>Cualquier consulta o duda, favor de contactarse al Whatsapp: +51 981 502 034 / Teléfono: +511 422 4591.</p>" ;
		$msjCorreo .= "<p><strong>Términos y Condiciones:</strong></p>" ;
		$msjCorreo .= "<p>No se aceptan cambios ni devoluciones una vez realizado el pago.</p>" ;
	}

		try {
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->SMTPAuth = true;
				$mail->Host = $host;
				$mail->Username = $para;
				$mail->Password = $password;
				$mail->From = $para;
				$mail->FromName = "WCOCD LIMA 2019";
				$mail->AddAddress($para);
				$mail->addBCC("ocori.reyes@gmail.com");
				$mail->Subject = $subject;
				$mail->Body = utf8_decode($msjCorreo);
				$mail->IsHTML(true);
			

				$mail->Send();
				return true;
			} catch (phpmailerException $e) {
				return false;
			} catch (Exception $e) {
				return false;
			}
}

function sendEmailConfirm2($data){
	
	$host = 'single-priva8.privatednsorg.com';
	$subject = 'Regiser Form 14th World Congress of Cosmetic Dermatology';
    $para = 'inscripciones@wcocdlima2019.com';
//	$para = 'informes3@grupomilenium.pe';
	$password = 'C0ngr3ss.2019';

    //Componemos cuerpo correo.
    $msjCorreo .= "<strong>MESSAGE SENT FROM THE REGISTER US FORM.</strong> ";
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Title:</strong> " . $data['title'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>First name:</strong> " . $data['first_name'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Last name:</strong> " . $data['last_name'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Company:</strong> " . $data['company'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Address:</strong> " . $data['address'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Country:</strong> " . $data['country'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>City:</strong> " . $data['city'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Email:</strong> " . $data['email'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Phone:</strong> " . $data['phone'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Fee:</strong> " . $data['fee'];
	$msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Amount:</strong> USD " . $data['amount'];
	
		try {
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->SMTPAuth = true;
				$mail->Host = $host;
				$mail->Username = $para;
				$mail->Password = $password;
				$mail->From = $para;
				$mail->FromName = "WCOCD LIMA 2019";
				$mail->AddAddress($para);
				$mail->addBCC("ocori.reyes@gmail.com");
				$mail->Subject = $subject;
				$mail->Body = utf8_decode($msjCorreo);
				$mail->IsHTML(true);
			

				$mail->Send();
				return true;
			} catch (phpmailerException $e) {
				return false;
			} catch (Exception $e) {
				return false;
			}
}

function sendEmailConfirm($data)
{

    $subject = 'Regiser Form 14th World Congress of Cosmetic Dermatology';
    $para = 'informes3@grupomilenium.pe';

    //Creamos cabecera.
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'From: ' . $data['first_name'].' '.$data['last_name'] . "\r\n";
    //$headers .= 'Bcc: ocori.reyes@gmail.com' . "\r\n";

    //Componemos cuerpo correo.
    $msjCorreo .= "<strong>MESSAGE SENT FROM THE CONTACT US FORM.</strong> ";
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Title:</strong> " . $data['title'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>First name:</strong> " . $data['first_name'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Last name:</strong> " . $data['last_name'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Company:</strong> " . $data['company'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Address:</strong> " . $data['address'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Country:</strong> " . $data['country'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>City:</strong> " . $data['city'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Email:</strong> " . $data['email'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Phone:</strong> " . $data['phone'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Fee:</strong> " . $data['fee'];
    $msjCorreo .= "<br><br>";
    $msjCorreo .= "<strong>Amount:</strong> USD " . $data['amount'];

    if (mail($para, $subject, $msjCorreo, $headers))
    {
        return true;
    }
    else
    {
        return false;
    }
}
