<?php

/**
 * Контроллер OrderController
 * Заказ
 */

class OrderController
{
	/**
	 * Action для страницы "Заказ"
	 */
	public function actionIndex($id)
	{
		// Список жанров для левого меню
		$genres = Genre::getGenresList();

		// Список авторов для левого меню
		$authors = Author::getAuthorsList();

		//Получаем данные заказываемой книги
		$book = Book::getBookById($id);

		// Статус успешного оформления заказа
		$result = false;

		// Обработка формы
		if (isset($_POST['submit'])) {

			// Если форма отправлена, получаем данные из формы
			$order['code'] = $_POST['book_code'];
			$order['quantity'] = $_POST['book_quant'];
			$order['address'] = $_POST['address'];
			$order['user_name'] = $_POST['full_name'];
			$order['book_name'] = $_POST['book_name'];
			$order['book_price'] = $_POST['book_price'];

			// Флаг ошибок
			$errors = false;

			if (!isset($order['quantity']) || empty($order['quantity'])) {
				$order['amount'] = false;
			} else {
				$order['amount'] = $order['book_price'] * $order['quantity'];

			}

			// При необходимости можно валидировать значения нужным образом
			if (!isset($order['address']) || empty($order['address'])) {
				$errors[] = 'Заполните поле "Ваш адресс"';
			}
			if (!isset($order['user_name']) || empty($order['user_name'])) {
				$errors[] = 'Заполните поле "Ваше ФИО"';
			}
			if (!isset($order['quantity']) || empty($order['quantity'])) {
				$errors[] = 'Заполните поле "Количество экземпляров"';
			}

			if ($errors == false) {
				$result = true;
				if($result){
					Mail::sendOrder($order);
				}
			} else {
				$book['name'] = $_POST['book_name'];
				$book['code'] = $_POST['book_code'];
				$book['price'] = $_POST['book_price'];
			}
		}
		require_once(ROOT . '/views/order/index.php');
		return true;
	}
}
