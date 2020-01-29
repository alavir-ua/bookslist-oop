<?php

/**
 * Контроллер AdminBookController
 * Управление товарами в админпанели
 */
class AdminBookController
{
	/**
	 * Action для страницы "Управление товарами"
	 */
	public function actionIndex($page = 1)
	{
		// Получаем список книг
		$allBooks = Book::getAdminBooksLimit($page);

		// Общее количетсво книг (необходимо для постраничной навигации)
		$total = Book::getCountBooks();

		// Создаем объект Pagination - постраничная навигация
		$pagination = new Pagination($total, $page, Book::SHOW_FOR_ADMIN, 'page-');

		// Подключаем вид
		require_once(ROOT . '/views/admin/admin_book/index.php');
		return true;
	}

	/**
	 * Action для страницы "Добавить книгу"
	 */
	public function actionCreate()
	{

		//Получаем список жанров для выпадающего списка
		$genres = Genre::getGenresList();

		//Получаем список авторов для выпадающего списка
		$authors = Author::getAuthorsList();

		// Обработка формы
		if (isset($_POST['submit'])) {

			// Если форма отправлена получаем данные из формы
			$options['code'] = $_POST['code'];
			$options['name'] = $_POST['name'];
			$options['price'] = $_POST['price'];
			$options['description'] = $_POST['description'];
			$options['authors'] = $_POST['author_id'];  //массив ids выбранных авторов
			$options['genres'] = $_POST['genre_id'];  //массив ids выбранных жанров
			$options['is_new'] = $_POST['is_new'];
			$options['is_recommended'] = $_POST['is_recommended'];
			$options['status'] = $_POST['status'];

			// Флаг ошибок в форме
			$errors = false;

			// При необходимости можно валидировать значения нужным образом
			if (!isset($options['code']) || empty($options['code'])) {
				$errors[] = 'Заполните поле "Код"';
			}
			if (!isset($options['name']) || empty($options['name'])) {
				$errors[] = 'Заполните поле "Название книги"';
			}
			if (!isset($options['price']) || empty($options['price'])) {
				$errors[] = 'Заполните поле "Стоимость"';
			}
			if (!isset($options['price']) || empty($options['price'])) {
				$errors[] = 'Заполните поле "Описание"';
			}
			if (!isset($options['genres']) || empty($options['genres'])) {
				$errors[] = 'Заполните поле "Жанр"';
			}
			if (!isset($options['authors']) || empty($options['authors'])) {
				$errors[] = 'Заполните поле "Автор"';
			}

			if ($errors == false) {
				// Если ошибок нет
				// Добавляем новый товар
				$id = Book::createBook($options);

				// Если запись добавлена
				if ($id) {
					// Проверим, загружалось ли через форму изображение
					if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
						// Если загружалось, переместим его в нужную папке, дадим новое имя
						move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/books/{$id}.jpg");
					}
				};
				// Перенаправляем админа на страницу управлениями товарами
				header("Location: /admin/book");
			}
		}

		// Подключаем вид
		require_once(ROOT . '/views/admin/admin_book/create.php');
		return true;
	}

	/**
	 * Action для страницы "Редактировать книгу"
	 */
	public function actionUpdate($id)
	{
		//Получаем список жанров для выпадающего списка
		$genres = Genre::getGenresList();

		//Получаем список авторов для выпадающего списка
		$authors = Author::getAuthorsList();

		//Получаем запись о книге
		$book = Book::getBookById($id);

		// Обработка формы
		if (isset($_POST['submit'])) {
			// Если форма отправлена получаем данные из формы
			$options['code'] = $_POST['code'];
			$options['name'] = $_POST['name'];
			$options['price'] = $_POST['price'];
			$options['description'] = $_POST['description'];
			$options['authors'] = $_POST['author_id'];  //массив ids выбранных авторов
			$options['genres'] = $_POST['genre_id'];  //массив ids выбранных жанров
			$options['is_new'] = $_POST['is_new'];
			$options['is_recommended'] = $_POST['is_recommended'];
			$options['status'] = $_POST['status'];

			// Сохраняем изменения
			if (Book::updateBookById($id, $options)) {

				// Если запись изменена
				// Проверим, загружалось ли через форму изображение
				if (is_uploaded_file($_FILES["image"]["tmp_name"])) {

					//Определяем путь к прежнему изображению
					$img = ROOT . "/upload/images/books/{$id}.jpg";

					//Если существовало изображение, удаляем его
					if (file_exists($img)) {
						unlink($img);

						// Перемещаем загруженное в нужную папку, даем новое имя
						move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/books/{$id}.jpg");
					}
				}
				// Перенаправляем админа на страницу управлениями книгами
				header("Location: /admin/book");
			}
		}
		// Подключаем вид
		require_once(ROOT . '/views/admin/admin_book/update.php');
		return true;
	}

	/**
	 * Action для страницы "Удалить книгу"
	 */
	public function actionDelete($id)
	{

		// Обработка формы
		if (isset($_POST['submit'])) {
			//Если форма отправлена удаляем товар
			$result = Book::deleteBookById($id);

			//определяем путь к изображению
			$img = ROOT . "/upload/images/books/{$id}.jpg";

			//Если книга удалена и сущ.изображение, удаляем его
			if (file_exists($img) && $result) {
				unlink($img);
			}

			// Перенаправляем админа на страницу управлениями товарами
			header("Location: /admin/book");
		}

		// Подключаем вид
		require_once(ROOT . '/views/admin/admin_book/delete.php');
		return true;
	}

}
