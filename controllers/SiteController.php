<?php

/**
 * Контроллер OrderController
 */
class SiteController
{

	/**
	 * Action для главной страницы
	 */
	public function actionIndex()
	{
		// Список жанров для левого меню
		$genres = Genre::getGenresList();

		// Список авторов для левого меню
		$authors = Author::getAuthorsList();

		// Список последних книг
		$latestBooks = Book::getLatestBooks(6);

		// Список книг для слайдера
		$sliderBooks = Book::getRecommendedBooks();

		// Подключаем вид
		require_once(ROOT . '/views/site/index.php');
		return true;
	}

	/**
	 * Action для страницы "Контакты"
	 */
	public function actionContact()
	{
		// Статус успешной отправки контактной информации
		$result = false;

		//Результат обработка формы
		if (isset($_POST['submit'])) {

			//Если форма отправлена получаем данные из формы
			$contact['userEmail'] = $_POST['userEmail'];
			$contact['userText'] = $_POST['userText'];

			// Флаг ошибок
			$errors = false;

			// При необходимости можно валидировать значения нужным образом
			if (!isset($contact['userEmail']) || empty($contact['userEmail'])) {
				$errors[] = 'Заполните поле "Ваша почта"';
			}
			if (!isset($contact['userText']) || empty($contact['userText'])) {
				$errors[] = 'Заполните поле "Сообщение"';
			}

			if ($errors == false) {
				// Если ошибок нет отправляем письмо администратору
				Mail::sendContact($contact);
				$result = true;
			}
		}
		// Подключаем вид
		require_once(ROOT . '/views/site/contact.php');
		return true;
	}

	/**
	 * Action для страницы "О магазине"
	 */
	public function actionAbout()
	{
		// Подключаем вид
		require_once(ROOT . '/views/site/about.php');
		return true;
	}

}
