<?php

/**
 * Управление авторами книг в админпанели
 */
class AdminAuthorController
{

	/**
	 * Action для страницы "Управление авторами"
	 */
	public function actionIndex()
	{
		// Получаем массив авторов
		$authorsList = Author::getAuthorsList();

		// Подключаем вид
		require_once(ROOT . '/views/admin/admin_author/index.php');
		return true;
	}

	/**
	 * Action для страницы "Добавить автора"
	 */
	public function actionCreate()
	{
		// Обработка формы
		if (isset($_POST['submit'])) {

			// Если форма отправлена получаем данные из формы
			$name = $_POST['name'];

			// Флаг ошибок в форме
			$errors = false;

			// При необходимости можно валидировать значения нужным образом
			if (!isset($name) || empty($name)) {
				$errors[] = 'Заполните поле "Имя"';
			}

			if ($errors == false) {
				// Если ошибок нет добавляем новый жанр
				Author::createAuthor($name);

				// Перенаправляем пользователя на страницу управления жанрами
				header("Location: /admin/author");
			}
		}
		require_once(ROOT . '/views/admin/admin_author/create.php');
		return true;
	}
}
