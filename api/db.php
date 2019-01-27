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
