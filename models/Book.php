<?php

/**
 * Класс Product - модель для работы с товарами
 */
class Book
{
	// Количество отображаемых товаров по умолчанию
	const SHOW_BY_DEFAULT = 6;

	// Количество отображаемых товаров в админпанели
	const SHOW_FOR_ADMIN = 10;

	/**
	 * Возвращает массив с информацей о последних книгах
	 * @param integer $count <p>Страниц по умолчанию</p>
	 * @return array $booksList <p>Массив с информацей о последних книгах</p>
	 */
	public static function getLatestBooks($count = self::SHOW_BY_DEFAULT)
	{
		// Соединение с БД
		$db = Db::getConnection();

		$sql = 'SELECT 
        b_id  AS id,
        b_name  AS name,
        b_price  AS price,
        b_is_new  AS is_new,
		GROUP_CONCAT(DISTINCT a_name ORDER BY a_name)
		AS authors
		FROM books
JOIN m2m_books_authors USING (b_id)
JOIN authors USING (a_id)
WHERE b_status=1
GROUP BY b_id
ORDER BY b_id DESC 
LIMIT :count';


		// Используется подготовленный запрос
		$result = $db->prepare($sql);
		$result->bindParam(':count', $count, PDO::PARAM_INT);

		// Указываем, что хотим получить данные в виде массива
		$result->setFetchMode(PDO::FETCH_ASSOC);

		// Выполнение команды
		$result->execute();

		// Получение и возврат результатов
		$i = 0;
		$booksList = array();
		while ($row = $result->fetch()) {
			$booksList[$i]['id'] = $row['id'];
			$booksList[$i]['name'] = $row['name'];
			$booksList[$i]['price'] = $row['price'];
			$booksList[$i]['authors'] = $row['authors'];
			$booksList[$i]['is_new'] = $row['is_new'];
			$i++;
		}
		return $booksList;
	}

	/**
	 * Возвращает массив с информацей о рекомендуемых книгах
	 * @return array $sliderBooks <p>Массив с информацей о рекомендуемых книгах</p>
	 */
	public static function getRecommendedBooks()
	{
		// Соединение с БД
		$db = Db::getConnection();

		// Получение и возврат результатов
		$sql = 'SELECT b_id, b_is_new 
FROM books   
WHERE b_is_recommended=1
GROUP BY b_id
ORDER BY b_id DESC';

		// Используется подготовленный запрос
		$result = $db->prepare($sql);

		// Указываем, что хотим получить данные в виде массива
		$result->setFetchMode(PDO::FETCH_ASSOC);

		// Выполнение команды
		$result->execute();

		// Получение и возврат результатов
		$i = 0;
		$sliderBooks = array();
		while ($row = $result->fetch()) {
			$sliderBooks[$i]['id'] = $row['b_id'];
			$sliderBooks[$i]['is_new'] = $row['b_is_new'];
			$i++;
		}
		return $sliderBooks;
	}

	/**
	 * Возвращает массив с информацей о книге
	 * @param integer $id <p>id книги</p>
	 * @return array <p>Массив с информацей о книге</p>
	 */
	public static function getBookById($id)
	{
		// Соединение с БД
		$db = Db::getConnection();

		// Текст запроса к БД
		$sql = 'SELECT 
        b_id  AS id,
        b_code  AS code,
        b_name  AS name,
        b_price  AS price,
        b_description  AS description,
        b_is_new  AS is_new,
		GROUP_CONCAT(DISTINCT a_name ORDER BY a_name)
		AS authors,
        GROUP_CONCAT(DISTINCT g_name ORDER BY g_name)
		AS genres
		FROM books
JOIN m2m_books_authors USING (b_id)
JOIN authors USING (a_id)
JOIN m2m_books_genres USING (b_id)
JOIN genres USING (g_id)
WHERE b_id = :id';


		// Используется подготовленный запрос
		$result = $db->prepare($sql);
		$result->bindParam(':id', $id, PDO::PARAM_INT);

		// Указываем, что хотим получить данные в виде массива
		$result->setFetchMode(PDO::FETCH_ASSOC);

		// Выполнение коменды
		$result->execute();

		// Получение и возврат результатов
		return $result->fetch();
	}

	/**
	 * Возвращает массив с информацей о книгах на страницу(каталог)
	 * @param integer $page <p>Страница пагинации</p>
	 * @return array $booksLimit <p>Массив с информацей о книгах на страницу(каталог)</p>
	 */
	public static function getBooksLimit($page = 1)
	{
		$limit = Book::SHOW_BY_DEFAULT;
		// Смещение (для запроса)
		$offset = ($page - 1) * self::SHOW_BY_DEFAULT;

		// Соединение с БД
		$db = Db::getConnection();

		$sql = 'SELECT 
        b_id  AS id,
        b_name  AS name,
        b_price  AS price,
        b_is_new  AS is_new,
		GROUP_CONCAT(DISTINCT a_name ORDER BY a_name)
		AS authors
		FROM books
JOIN m2m_books_authors USING (b_id)
JOIN authors USING (a_id)
WHERE b_status=1
GROUP BY b_id
ORDER BY b_id DESC
LIMIT :limit 
OFFSET :offset';

		// Используется подготовленный запрос
		$result = $db->prepare($sql);
		$result->bindParam(':limit', $limit, PDO::PARAM_INT);
		$result->bindParam(':offset', $offset, PDO::PARAM_INT);

		// Выполнение команды
		$result->execute();

		// Получение и возврат результатов
		$i = 0;
		$booksLimit = array();
		while ($row = $result->fetch()) {
			$booksLimit[$i]['id'] = $row['id'];
			$booksLimit[$i]['name'] = $row['name'];
			$booksLimit[$i]['price'] = $row['price'];
			$booksLimit[$i]['authors'] = $row['authors'];
			$booksLimit[$i]['is_new'] = $row['is_new'];
			$i++;
		}
		return $booksLimit;
	}

	/**
	 * Возвращает число строк записей в каталоге
	 * @return integer  <p>Число строк записей в каталоге</p>
	 */
	public static function getCountBooks()
	{
		// Соединение с БД
		$db = Db::getConnection();

		// Текст запроса к БД
		$sql = 'SELECT count(b_id) AS count FROM books WHERE b_status=1';

		// Используется подготовленный запрос
		$result = $db->prepare($sql);

		// Выполнение команды
		$result->execute();

		// Возвращаем значение count - количество
		$row = $result->fetch();

		return $row['count'];
	}

	/**
	 * Возвращает массив с информацей о книгах жанра на страницу
	 * @param integer $genreId <p>id жанра</p>
	 * @param integer $page <p>Страница пагинации</p>
	 * @return array $booksGenre <p>Массив с информацей о книгах жанра на страницу</p>
	 */
	public static function getBooksLimitByGenre($genreId, $page = 1)
	{
		$limit = Book::SHOW_BY_DEFAULT;
		// Смещение (для запроса)
		$offset = ($page - 1) * self::SHOW_BY_DEFAULT;

		// Соединение с БД
		$db = Db::getConnection();

		// Текст запроса к БД
		$sql = 'SELECT 
        b_id  AS id,
        b_name  AS name,
        b_price  AS price,
        b_is_new  AS is_new,
		GROUP_CONCAT(DISTINCT a_name ORDER BY a_name)
		AS authors
		FROM books
JOIN m2m_books_authors USING (b_id)
JOIN authors USING (a_id)
JOIN m2m_books_genres USING (b_id)
JOIN genres USING (g_id)
WHERE b_status=1 and g_id=:genre_id
GROUP BY b_id
ORDER BY b_id DESC
LIMIT :limit
OFFSET :offset';

		// Используется подготовленный запрос
		$result = $db->prepare($sql);
		$result->bindParam(':genre_id', $genreId, PDO::PARAM_INT);
		$result->bindParam(':limit', $limit, PDO::PARAM_INT);
		$result->bindParam(':offset', $offset, PDO::PARAM_INT);

		//Выполнение команды
		$result->execute();

		// Получение и возврат результатов
		$i = 0;
		$booksGenre = array();
		while ($row = $result->fetch()) {
			$booksGenre[$i]['id'] = $row['id'];
			$booksGenre[$i]['name'] = $row['name'];
			$booksGenre[$i]['price'] = $row['price'];
			$booksGenre[$i]['authors'] = $row['authors'];
			$booksGenre[$i]['is_new'] = $row['is_new'];
			$i++;
		}
		return $booksGenre;
	}

	/**
	 * Возврвщает число строк записей в каталоге по жанру
	 * @param integer $genreId <p>id жанра</p>
	 * @return integer <p>Число строк записей в каталоге по жанру</p>
	 */
	public static function getCountBooksInGenre($genreId)
	{
		// Соединение с БД
		$db = Db::getConnection();

		// Текст запроса к БД
		$sql = 'SELECT count(g_id) AS count FROM m2m_books_genres WHERE g_id=:genre_id';

		// Используется подготовленный запрос
		$result = $db->prepare($sql);
		$result->bindParam(':genre_id', $genreId, PDO::PARAM_INT);

		// Выполнение команды
		$result->execute();

		// Возвращаем значение count - количество
		$row = $result->fetch();

		return $row['count'];
	}

	/**
	 * Возвращает массив с информацей о книгах автора на страницу
	 * @param integer $authorId <p>id автора</p>
	 * @param integer $page <p>Страница пагинации</p>
	 * @return array $booksAuthor <p>Массив с информацей о книгах автора на страницу</p>
	 */
	public static function getBooksLimitByAuthor($authorId, $page = 1)
	{
		$limit = Book::SHOW_BY_DEFAULT;
		// Смещение (для запроса)
		$offset = ($page - 1) * self::SHOW_BY_DEFAULT;

		// Соединение с БД
		$db = Db::getConnection();

		// Превращаем массив в строку для формирования условия в запросе
		$idsString = implode(',', self::getBooksIdsByAuthor($authorId));

		// Текст запроса к БД
		$sql = "SELECT
			b_id  AS id,
			b_name  AS name,
			b_price  AS price,
			b_is_new  AS is_new,
			GROUP_CONCAT(DISTINCT a_name ORDER BY a_name)
			AS authors
			FROM books
	JOIN m2m_books_authors USING (b_id)
	JOIN authors USING (a_id)
	WHERE b_status=1 AND b_id IN (${idsString})
	GROUP BY b_id 
	ORDER BY b_id DESC
	LIMIT :limit
	OFFSET :offset";

		// Используется подготовленный запрос
		$result = $db->prepare($sql);
		$result->bindParam(':limit', $limit, PDO::PARAM_INT);
		$result->bindParam(':offset', $offset, PDO::PARAM_INT);

		//Выполнение команды
		$result->execute();

		// Получение и возврат результатов
		$i = 0;
		$booksAuthor = array();
		while ($row = $result->fetch()) {
			$booksAuthor[$i]['id'] = $row['id'];
			$booksAuthor[$i]['name'] = $row['name'];
			$booksAuthor[$i]['price'] = $row['price'];
			$booksAuthor[$i]['authors'] = $row['authors'];
			$booksAuthor[$i]['is_new'] = $row['is_new'];
			$i++;
		}
		return $booksAuthor;
	}

	/**
	 * Возвращает число строк записей в каталоге по автору
	 * @param integer $authorId <p>id жанра</p>
	 * @return integer <p>Число строк записей в каталоге по автору</p>
	 */
	public static function getCountBooksByAuthor($authorId)
	{
		// Соединение с БД
		$db = Db::getConnection();

		// Текст запроса к БД
		$sql = 'SELECT count(a_id) AS count FROM m2m_books_authors WHERE a_id=:author_id';

		// Используется подготовленный запрос
		$result = $db->prepare($sql);
		$result->bindParam(':author_id', $authorId, PDO::PARAM_INT);

		// Выполнение команды
		$result->execute();

		// Возвращаем значение count - количество
		$row = $result->fetch();

		return $row['count'];
	}

	/**
	 * Возвращает массив ids книг по id автора
	 * @param integer $authorId <p>id автора</p>
	 * @return array $idsArray <p>Массив ids книг по id автора</p>
	 */
	public static function getBooksIdsByAuthor($authorId)
	{
		// Соединение с БД
		$db = Db::getConnection();

		// Текст запроса к БД
		$sql = 'SELECT b_id AS id
FROM books 
JOIN m2m_books_authors USING (b_id)
JOIN authors USING (a_id)
WHERE b_status = 1 AND a_id = :author_id';

		// Используется подготовленный запрос
		$result = $db->prepare($sql);
		$result->bindParam(':author_id', $authorId, PDO::PARAM_INT);

		//Выполнение команды
		$result->execute();

		// Получение и возврат результатов
		$i = 0;
		$idsArray = array();
		while ($row = $result->fetch()) {
			$idsArray[$i] = $row['id'];
			$i++;
		}
		return $idsArray;
	}

	/**
	 * Возвращает массив с информацей о книгах на страницу(админпанель)
	 * @param integer $page <p>Страница пагинации</p>
	 * @return array $allBooks <p>Массив с информацей о книгах на страницу(админпанель)</p>
	 */
	public static function getAdminBooksLimit($page = 1)
	{
		$limit = Book::SHOW_FOR_ADMIN;
		// Смещение (для запроса)
		$offset = ($page - 1) * self::SHOW_FOR_ADMIN;

		// Соединение с БД
		$db = Db::getConnection();

		$sql = 'SELECT 
        b_id  AS id,
        b_code  AS code,
        b_name  AS name,
        b_price  AS price,
        b_is_new  AS is_new,
        b_is_recommended  AS is_recommended,
        b_status  AS status,
		GROUP_CONCAT(DISTINCT a_name ORDER BY a_name)
		AS authors,
        GROUP_CONCAT(DISTINCT g_name ORDER BY g_name)
		AS genres
		FROM books
JOIN m2m_books_authors USING (b_id)
JOIN authors USING (a_id)
JOIN m2m_books_genres USING (b_id)
JOIN genres USING (g_id)
GROUP BY b_id
ORDER BY b_id DESC
LIMIT :limit 
OFFSET :offset';

		// Используется подготовленный запрос
		$result = $db->prepare($sql);
		$result->bindParam(':limit', $limit, PDO::PARAM_INT);
		$result->bindParam(':offset', $offset, PDO::PARAM_INT);

		// Выполнение команды
		$result->execute();

		// Получение и возврат результатов
		$i = 0;
		$allBooks = array();
		while ($row = $result->fetch()) {
			$allBooks[$i]['id'] = $row['id'];
			$allBooks[$i]['code'] = $row['code'];
			$allBooks[$i]['name'] = $row['name'];
			$allBooks[$i]['price'] = $row['price'];
			$allBooks[$i]['authors'] = $row['authors'];
			$allBooks[$i]['genres'] = $row['genres'];
			$allBooks[$i]['is_new'] = $row['is_new'];
			$allBooks[$i]['is_recommended'] = $row['is_recommended'];
			$allBooks[$i]['status'] = $row['status'];
			$i++;
		}
		return $allBooks;
	}

	/**
	 * Добавляет новую книгу
	 * @param array $options <p>Массив с информацией о ниге</p>
	 * @return integer <p>id добавленной в таблицу записи</p>
	 */
	public static function createBook($options)
	{
		// Соединение с БД
		$db = Db::getConnection();

		// Текст запроса к БД
		$sql_1 = 'INSERT INTO books '
			. '(b_code, b_name, b_price,'
			. 'b_description, b_is_new, b_is_recommended, b_status)'
			. 'VALUE                      '
			. '(:code, :name, :price,'
			. ':description, :is_new, :is_recommended, :status)';

		// Получение и возврат результатов. Используется подготовленный запрос
		$result_1 = $db->prepare($sql_1);
		$result_1->bindParam(':code', $options['code'], PDO::PARAM_STR);
		$result_1->bindParam(':name', $options['name'], PDO::PARAM_STR);
		$result_1->bindParam(':price', $options['price'], PDO::PARAM_INT);
		$result_1->bindParam(':description', $options['description'], PDO::PARAM_STR);
		$result_1->bindParam(':is_new', $options['is_new'], PDO::PARAM_STR);
		$result_1->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_STR);
		$result_1->bindParam(':status', $options['status'], PDO::PARAM_INT);

		if ($result_1->execute()) {
			$book_id = $db->lastInsertId();

			//Запись в таблицу authors
			foreach ($options['authors'] as $author_id) {
				$sql_2 = 'INSERT INTO m2m_books_authors '
					. '(a_id, b_id )'
					. 'VALUE                 '
					. '(:author_id, :book_id)';
				// Получение и возврат результатов. Используется подготовленный запрос
				$result_2 = $db->prepare($sql_2);
				$result_2->bindParam(':author_id', $author_id, PDO::PARAM_STR);
				$result_2->bindParam(':book_id', $book_id, PDO::PARAM_STR);
				$result_2->execute();
			}

			//Запись в таблицу genres
			foreach ($options['genres'] as $genre_id) {
				$sql_3 = 'INSERT INTO m2m_books_genres '
					. '(g_id, b_id )'
					. 'VALUE                 '
					. '(:genre_id, :book_id)';
				// Получение и возврат результатов. Используется подготовленный запрос
				$result_3 = $db->prepare($sql_3);
				$result_3->bindParam(':genre_id', $genre_id, PDO::PARAM_STR);
				$result_3->bindParam(':book_id', $book_id, PDO::PARAM_STR);
				$result_3->execute();
			}
			// Если запрос выполенен успешно, возвращаем id добавленной книги
			return $book_id;

		}
		// Иначе возвращаем 0
		return 0;
	}

	/**
	 * Удаляет книгу
	 * @param integer $id <p>id книги</p>
	 * @return boolean <p>Результат удаления</p>
	 */

	public static function deleteBookById($id)
	{
		// Соединение с БД
		$db = Db::getConnection();

		// Текст запроса к БД
		$sql = 'DELETE FROM books WHERE b_id = :id';

		// Получение и возврат результатов. Используется подготовленный запрос
		$result = $db->prepare($sql);
		$result->bindParam(':id', $id, PDO::PARAM_INT);
		return $result->execute();
	}

	/**
	 * Редактирует книгу с заданным id
	 * @param integer $id <p>id книги</p>
	 * @param array $options <p>Массив с информацей о книге с формы</p>
	 * @return boolean <p>Результат выполнения метода</p>
	 */
	public static function updateBookById($id, $options)
	{
		// Соединение с БД
		$db = Db::getConnection();

		// Текст запроса к БД
		$sql_1 = 'UPDATE books
            SET
                b_code = :code,
                b_name = :name,
                b_price = :price,
                b_description = :description,
                b_is_new = :is_new,
                b_is_recommended = :is_recommended,
                b_status = :status
            WHERE b_id = :id';

		// Получение и возврат результатов. Используется подготовленный запрос
		$result_1 = $db->prepare($sql_1);
		$result_1->bindParam(':id', $id, PDO::PARAM_INT);
		$result_1->bindParam(':code', $options['code'], PDO::PARAM_STR);
		$result_1->bindParam(':name', $options['name'], PDO::PARAM_STR);
		$result_1->bindParam(':price', $options['price'], PDO::PARAM_STR);
		$result_1->bindParam(':description', $options['description'], PDO::PARAM_STR);
		$result_1->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
		$result_1->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
		$result_1->bindParam(':status', $options['status'], PDO::PARAM_INT);

		if ($result_1->execute()) {
			// Удаление c связей книги с таблицы authors
			$sql_2 = 'DELETE FROM m2m_books_authors WHERE b_id = :id';
			$result_2 = $db->prepare($sql_2);
			$result_2->bindParam(':id', $id, PDO::PARAM_INT);
			$result_2->execute();

			// Удаление c связей книги с таблицы genres
			$sql_3 = 'DELETE FROM m2m_books_genres WHERE b_id = :id';
			$result_3 = $db->prepare($sql_3);
			$result_3->bindParam(':id', $id, PDO::PARAM_INT);
			$result_3->execute();

			//Запись в таблицу authors
			foreach ($options['authors'] as $author_id) {
				$sql_2 = 'INSERT INTO m2m_books_authors '
					. '(a_id, b_id )'
					. 'VALUE                 '
					. '(:author_id, :book_id)';
				// Получение и возврат результатов. Используется подготовленный запрос
				$result_2 = $db->prepare($sql_2);
				$result_2->bindParam(':author_id', $author_id, PDO::PARAM_STR);
				$result_2->bindParam(':book_id', $id, PDO::PARAM_STR);
				$result_2->execute();
			}

			//Запись в таблицу genres
			foreach ($options['genres'] as $genre_id) {
				$sql_3 = 'INSERT INTO m2m_books_genres '
					. '(g_id, b_id )'
					. 'VALUE                 '
					. '(:genre_id, :book_id)';
				// Получение и возврат результатов. Используется подготовленный запрос
				$result_3 = $db->prepare($sql_3);
				$result_3->bindParam(':genre_id', $genre_id, PDO::PARAM_STR);
				$result_3->bindParam(':book_id', $id, PDO::PARAM_STR);
				$result_3->execute();
			}
			// Если запрос выполенен успешно, true
			return true;
		}
		// Иначе возвращаем 0
		return 0;
	}



	/**
	 * Возвращает путь к изображению
	 * @param integer $id
	 * @return string <p>Путь к изображению</p>
	 */
	#done
	public static function getImage($id)
	{
		// Название изображения-пустышки
		$noImage = 'no-image.jpg';

		// Путь к папке с товарами
		$path = '/upload/images/books/';

		// Путь к изображению товара
		$pathToProductImage = $path . $id . '.jpg';

		if (file_exists($_SERVER['DOCUMENT_ROOT'] . $pathToProductImage)) {
			// Если изображение для товара существует
			// Возвращаем путь изображения товара
			return $pathToProductImage;
		}

		// Возвращаем путь изображения-пустышки
		return $path . $noImage;
	}

}
