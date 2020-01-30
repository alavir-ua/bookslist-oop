<?php

/**
 * Класс Genre - модель для работы с жанром книги
 */
class Genre
{

    /**
     * Возвращает массив жанров для списка на сайте
     * @return array <p>Массив с жанрами</p>
     */
    public static function getGenresList()
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Запрос к БД
        $result = $db->query('SELECT g_id, g_name FROM genres WHERE g_status = "1" ORDER BY g_id, g_name ASC');

        // Получение и возврат результатов
        $i = 0;
        $genresList = array();
        while ($row = $result->fetch()) {
            $genresList[$i]['id'] = $row['g_id'];
            $genresList[$i]['name'] = $row['g_name'];
            $i++;
        }
        return $genresList;
    }

    /**
     * Возвращает массив жанров для списка в админпанели <br/>
     * (при этом в результат попадают и включенные и выключенные жанры)
     * @return array $genreList <p>Массив жанров</p>
     */
    public static function getGenresListAdmin()
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Запрос к БД
        $result = $db->query('SELECT g_id, g_name, g_status FROM genres ORDER BY g_id ASC');

        // Получение и возврат результатов
        $i = 0;
	    $genreList = array();
        while ($row = $result->fetch()) {
            $genreList[$i]['id'] = $row['g_id'];
            $genreList[$i]['name'] = $row['g_name'];
            $genreList[$i]['status'] = $row['g_status'];
            $i++;
        }
        return $genreList;
    }

	/**
	 * Возвращает жанр с указанным id
	 * @param integer $id <p>id жанра</p>
	 * @return array <p>Массив с информацией о жанре</p>
	 */
	public static function getGenreById($id)
	{
		// Соединение с БД
		$db = Db::getConnection();

		// Текст запроса к БД
		$sql = 'SELECT * FROM genres WHERE g_id = :id';

		// Используется подготовленный запрос
		$result = $db->prepare($sql);
		$result->bindParam(':id', $id, PDO::PARAM_INT);

		// Указываем, что хотим получить данные в виде массива
		$result->setFetchMode(PDO::FETCH_ASSOC);

		// Выполняем запрос
		$result->execute();

		// Возвращаем данные
		return $result->fetch();
	}

    /**
     * Редактирование жанра с заданным id
     * @param integer $id <p>id жанра</p>
     * @param string $name <p>Название</p>
     * @param integer $status <p>Статус <i>(включено "1", выключено "0")</i></p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function updateGenreById($id, $name, $status)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = "UPDATE genres
            SET 
                g_name = :name, 
                g_status = :status
            WHERE g_id = :id";

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }

	/**
	 * Добавляет новый жанр
	 * @param string $name <p>Название</p>
	 * @param integer $status <p>Статус <i>(включено "1", выключено "0")</i></p>
	 * @return boolean <p>Результат добавления записи в таблицу</p>
	 */
	public static function createGenre($name, $status)
	{
		// Соединение с БД
		$db = Db::getConnection();

		// Текст запроса к БД
		$sql = 'INSERT INTO genres (g_name, g_status) '
			. 'VALUES (:name, :status)';

		// Получение и возврат результатов. Используется подготовленный запрос
		$result = $db->prepare($sql);
		$result->bindParam(':name', $name, PDO::PARAM_STR);
		$result->bindParam(':status', $status, PDO::PARAM_INT);
		return $result->execute();
	}

    /**
     * Возвращает текстое пояснение статуса для жанра :<br/>
     * <i>0 - Скрыт, 1 - Отображается</i>
     * @param integer $status <p>Статус</p>
     * @return string <p>Текстовое пояснение</p>
     */
    public static function getStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'Отображается';
                break;
            case '0':
                return 'Скрыт';
                break;
        }
    }
}
