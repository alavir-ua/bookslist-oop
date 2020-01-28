<?php
/**
 * Класс Mail - модель для отправки почты
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Mail
{
	public static function sendMail($arr){

        $order = $arr;//Массив параметров в шаблон письма

		// Получаем параметры подключения из файла
		$paramsPath = ROOT . '/config/smtp.php';
		$params = include($paramsPath);

		$mail = new PHPMailer;
		$mail->CharSet = 'UTF-8';
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Host = $params['host'];
		$mail->SMTPAuth = true;
		$mail->Username = $params['username'];
		$mail->Password = $params['password'];
		$mail->SMTPSecure = $params['secure'];
		$mail->Port = $params['port'];
		$mail->setFrom('alavir.7w@gmail.com'); // Ваш Email
		$mail->addAddress('alehan07@ukr.net'); // Email получателя

        // Письмо
		$mail->isHTML(true);
		$mail->Subject = 'Заказ с сайта www.bookslist.com #DSК-3456-93536'; // Заголовок письма
		ob_start(); //Начать буферизацию вывода
		include(ROOT. '/views/mail/mail.html'); //Включить ваш файл шаблона
		$template = ob_get_clean(); //Получить текущее содержимое буфера и удалить текущий выходной буфер
		$mail->msgHTML($template);

       // Результат
		if(!$mail->send()) {
			echo 'Message could not be sent';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			return true;
		}
	}
}
