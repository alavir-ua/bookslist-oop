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

		// Поля для формы
		$bookCode = false;
		$bookQuantity = false;
		$userAddress = false;
		$userFullName = false;
		$bookName = false;
		$bookPrice = false;

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

			// Валидация полей
			if (!User::checkFullName($userFullName)) {
				$errors[] = 'Неправильное имя';
			}

			if (!User::checkAddress($userAddress)) {
				$errors[] = 'Неправильный адресс';
			}

			//Параметры заказа в email
			$order['code'] = $bookCode;
			$order['quantity'] = $bookQuantity;
			$order['address'] = $userAddress;
			$order['user_name'] = $userFullName;
			$order['book_name'] = $bookName;
			$order['book_price'] = $bookPrice;
			$order['amount'] = $bookPrice * $bookQuantity;

			if ($errors == false) {
				$result = true;
				if($result){
					Mail::sendMail($order);
				}
			} else {
				$book['name'] = $bookName;
				$book['code'] = $bookCode;
			}
		}
		require_once(ROOT . '/views/order/index.php');
		return true;
	}


	/**
	 * Action для добавления товара в корзину при помощи асинхронного запроса (ajax)
	 * @param integer $id <p>id товара</p>
	 */
	public function actionAddAjax($id)
	{
		// Добавляем товар в корзину и печатаем результат: количество товаров в корзине
		echo Cart::addProduct($id);
		return true;
	}

	/**
	 * Action для добавления товара в корзину синхронным запросом
	 * @param integer $id <p>id товара</p>
	 */
	public function actionDelete($id)
	{
		// Удаляем заданный товар из корзины
		Cart::deleteProduct($id);

		// Возвращаем пользователя в корзину
		header("Location: /order");
	}


}
