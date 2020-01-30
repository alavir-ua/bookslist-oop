<?php
/**
 * Класс Mail - модель для отправки почты
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Mail
{
	/*
	 * Отправляет админу письмо с данными о заказе
	 * @param array $data <p>Массив параметров</p>
	 * @return boolean <p>Результат отправки письма</p>
	 */
	public static function sendOrder($data){

        $order = $data; //Массив параметров в шаблон письма

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
		$mail->setFrom('alavir.7w@gmail.com'); // Email магазина
		$mail->addAddress('alehan07@ukr.net'); // Email админа

        // Письмо
		$mail->isHTML(true);
		$mail->Subject = 'Заказ с сайта www.bookslist.is-best.com #DSК-3456-93536'; // Заголовок письма
		ob_start(); //Начать буферизацию вывода
		include(ROOT . '/views/mail/order.html'); //Включить ваш файл шаблона
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

	/*
	 * Отправляет админу письмо с данными обратной связи
	 * @param array $contact <p>Массив данных пользователя</p>
	 * @return boolean <p>Результат отправки письма</p>
	 */
	public static function sendContact($contact){

		$userEmail = $contact['userEmail'];
		$userText = $contact['userText'];

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
		$mail->setFrom('alavir.7w@gmail.com'); // Email магазина
		$mail->addAddress('alehan07@ukr.net'); // Email админа

		// Письмо
		$mail->isHTML(true);
		$mail->Subject = "Сообщение от пользователя $userEmail"; // Заголовок письма
		ob_start(); //Начать буферизацию вывода
		include(ROOT . '/views/mail/contact.html'); //Включить ваш файл шаблона
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
