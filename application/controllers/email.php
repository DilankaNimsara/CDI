<?php


class email extends CI_Controller
{
	function sendmail()
	{

		include './public/PHPMailer/PHPMailerAutoload.php';

		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = '465';
		$mail->isHTML();
		$mail->Username = 'mrdoc.dms@gmail.com';
		$mail->Password = 'mrdoc100100100';
		$mail->setFrom('no-reply@howcode.org');

		$mail->Subject = $_SESSION['subject'];
		$mail->Body = $_SESSION['body'];
		$to_mail = $_SESSION['tomail'];
		$mail->AddAddress($to_mail);

		$mail->Send();


	}
}
