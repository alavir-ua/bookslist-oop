<?php

/**
 * Контроллер OrderController
 * Корзина
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

		// Добавляем товар в корзину
		$book = Book::getBookById($id);

       //Статус успешнной отправки письма админу
		$result = false;

		// Подключаем вид
		require_once(ROOT . '/views/order/index.php');
		return true;
	}

	/**
	 * Action для страницы "Оформление покупки"
	 */
	public function actionCheckout()
	{
        // Список жанров для левого меню
		$genres = Genre::getGenresList();

		// Список авторов для левого меню
		$authors = Author::getAuthorsList();

		// Статус успешного оформления заказа
		$result = false;

		function test_input($data)
		{
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		// Обработка формы
		if (isset($_POST['submit'])) {

			// Если форма отправлена, получаем данные из формы
			$bookCode = $_POST['book_code'];
			$bookQuantity = test_input($_POST['book_quant']);
			$userAddress = test_input($_POST['address']);
			$userFullName = test_input($_POST['full_name']);
			$bookName = $_POST['book_name'];
			$bookPrice = $_POST['book_price'];

			// Флаг ошибок
			$errors = false;

			//Параметры заказа в email
			$order['code'] = $bookCode;
			$order['quantity'] = $bookQuantity;
			$order['address'] = $userAddress;
			$order['user_name'] = $userFullName;
			$order['book_name'] = $bookName;
			$order['book_price'] = $bookPrice;
			if (!isset($order['quantity']) || empty($order['quantity'])) {
				$order['amount'] = 0;
			} else {
				$order['amount'] = $bookPrice * $bookQuantity;

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
					Mail::sendMail($order);
				}
			} else {
				$book['name'] = $bookName;
				$book['code'] = $bookCode;
				$book['price'] = $bookPrice;
			}
		}
		require_once(ROOT . '/views/order/index.php');
		return true;
	}

}
