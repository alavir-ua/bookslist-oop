<?php

/**
 * Класс Author - модель для работы с авторами
 */
class Author
{
	/**
	 * Возвращает массив авторов книг на сайте
	 * @return array <p>Массив с авторами</p>
	 */
	public static function getAuthorsList()
	{
		// Соединение с БД
		$db = Db::getConnection();

		// Запрос к БД
		$result = $db->query('SELECT a_id, a_name FROM authors  GROUP BY a_id
ORDER BY a_id ASC ');

		// Получение и возврат результатов
		$i = 0;
		$authorsList = array();
		while ($row = $result->fetch()) {
			$authorsList[$i]['id'] = $row['a_id'];
			$authorsList[$i]['name'] = $row['a_name'];
			$i++;
		}
		return $authorsList;
	}

	/**
	 * Добавляет нового автора
	 * @param string $name <p>Имя</p>
	 * @return boolean <p>Результат добавления записи в таблицу</p>
	 */
	public static function createAuthor($name)
	{
		// Соединение с БД
		$db = Db::getConnection();

		// Текст запроса к БД
		$sql = 'INSERT INTO authors (a_name) '
			. 'VALUES (:name)';

		// Получение и возврат результатов. Используется подготовленный запрос
		$result = $db->prepare($sql);
		$result->bindParam(':name', $name, PDO::PARAM_STR);
		return $result->execute();
	}
}

