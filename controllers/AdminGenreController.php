<?php

/**
 * Контроллер AdminGenreController
 * Управление категориями товаров в админпанели
 */
class AdminGenreController
{

	/**
	 * Action для страницы "Управление жанрами"
	 */
	public function actionIndex()
	{
		// Получаем список жанров
		$genresList = Genre::getGenresListAdmin();

		// Подключаем вид
		require_once(ROOT . '/views/admin/admin_genre/index.php');
		return true;
	}

	/**
	 * Action для страницы "Добавить жанр"
	 */
	public function actionCreate()
	{
		// Обработка формы
		if (isset($_POST['submit'])) {

			// Если форма отправлена получаем данные из формы
			$name = $_POST['name'];
			$status = $_POST['status'];

			// Флаг ошибок в форме
			$errors = false;

			// При необходимости можно валидировать значения нужным образом
			if (!isset($name) || empty($name)) {
				$errors[] = 'Заполните поле "Название"';
			}

			if ($errors == false) {
				// Если ошибок нет добавляем новый жанр
				Genre::createGenre($name, $status);

				// Перенаправляем пользователя на страницу управления жанрами
				header("Location: /admin/genre");
			}
		}
		require_once(ROOT . '/views/admin/admin_genre/create.php');
		return true;
	}

	/**
	 * Action для страницы "Редактировать жанр"
	 */
	public function actionUpdate($id)
	{
		// Получаем данные о жанре
		$genre = Genre::getGenreById($id);

		// Обработка формы
		if (isset($_POST['submit'])) {
			// Если форма отправлена получаем данные из формы
			$name = $_POST['name'];
			$status = $_POST['status'];

			// Сохраняем изменения
			Genre::updateGenreById($id, $name, $status);

			// Перенаправляем админа на страницу управлениями жанрами
			header("Location: /admin/genre");
		}
		// Подключаем вид
		require_once(ROOT . '/views/admin/admin_genre/update.php');
		return true;
	}
}
