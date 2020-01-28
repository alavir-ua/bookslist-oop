<?php

/**
 * Класс Product - модель для работы с товарами
 */
class Book
{
	// Количество отображаемых товаров по умолчанию
	const SHOW_BY_DEFAULT = 6;
#----------------------------Главная страница----------------------------------

	//Возвращает массив последних книг
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

	//Возвращает массив рекомендуемых книг
	public static function getRecommendedBooks()
	{
		// Соединение с БД
		$db = Db::getConnection();

		// Получение и возврат результатов
		$sql = 'SELECT b_id, b_is_new 
FROM books   
WHERE b_is_recommended=1
GROUP BY b_id';

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

#----------------------------Страница книги------------------------------------
	//Возвращает запись книги по id
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

#----------------------------Страница каталога---------------------------------
	//Возвращает массив книг страницы в каталоге
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
ORDER BY b_id ASC
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

	//Возвращает  общее число записей в каталоге
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

#----------------------------Страница жанра------------------------------------
	//Возвращает массив книг страницы в жанре
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
ORDER BY b_id
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

	//Возвращает  общее число записей в жанре
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

#----------------------------Страница автора-----------------------------------

	//Возвращает массив книг страницы по автору
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
	ORDER BY b_id 
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

	//Возвращает  общее число записей по автору
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

	//Возвращает массив ids книг по id автора
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

#-----------------------------------------------------------------------------



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
	 * Редактирует товар с заданным id
	 * @param integer $id <p>id товара</p>
	 * @param array $options <p>Массив с информацей о товаре</p>
	 * @return boolean <p>Результат выполнения метода</p>
	 */
	public static function updateBookById($id, $options)
	{
		// Соединение с БД
		$db = Db::getConnection();

		// Текст запроса к БД
		$sql = "UPDATE books
            SET
                b_name = :title,
                b_price = :price,
                genre_id = :genre_id,
                b_description = :description,
                b_is_new = :is_new,
                b_is_recommended = :is_recommended,
                b_status = :status
            WHERE b_id = :id";

		// Получение и возврат результатов. Используется подготовленный запрос
		$result = $db->prepare($sql);
		$result->bindParam(':id', $id, PDO::PARAM_INT);
		$result->bindParam(':title', $options['title'], PDO::PARAM_STR);
		$result->bindParam(':price', $options['price'], PDO::PARAM_STR);
		$result->bindParam(':genre_id', $options['genre_id'], PDO::PARAM_INT);
		$result->bindParam(':description', $options['description'], PDO::PARAM_STR);
		$result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
		$result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
		$result->bindParam(':status', $options['status'], PDO::PARAM_INT);
		return $result->execute();
	}

	/**
	 * Добавляет новый товар
	 * @param array $options <p>Массив с информацией о товаре</p>
	 * @return integer <p>id добавленной в таблицу записи</p>
	 */
	public static function createBook($options)
	{
		// Соединение с БД
		$db = Db::getConnection();

		// Текст запроса к БД
		$sql = 'INSERT INTO books '
			. '(title, price, genre_id,'
			. 'description, is_new, is_recommended, status)'
			. 'VALUES
                                                                                                                 '
			. '(:title, :price, :genre_id,'
			. ':description, :is_new, :is_recommended, :status)';

		// Получение и возврат результатов. Используется подготовленный запрос
		$result = $db->prepare($sql);
		$result->bindParam(':title', $options['title'], PDO::PARAM_STR);
		$result->bindParam(':price', $options['price'], PDO::PARAM_STR);
		$result->bindParam(':genre_id', $options['genre_id'], PDO::PARAM_INT);
		$result->bindParam(':description', $options['description'], PDO::PARAM_STR);
		$result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
		$result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
		$result->bindParam(':status', $options['status'], PDO::PARAM_INT);
		if ($result->execute()) {
			// Если запрос выполенен успешно, возвращаем id добавленной записи
			return $db->lastInsertId();
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
