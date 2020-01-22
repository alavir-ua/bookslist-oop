<?php

/**
 * Класс Cart
 * Компонент для работы корзиной
 */
class Cart
{

	/**
	 * Добавление товара в корзину (сессию)
	 * @param int $id <p>id товара</p>
	 * @return integer <p>Количество товаров в корзине</p>
	 */
	public static function addBook($id)
	{
		// Приводим $id к типу integer
		$id = intval($id);

		// Пустой массив для товаров в корзине
		$booksInCart = array();

		// Если в корзине уже есть товары (они хранятся в сессии)
		if (isset($_SESSION['books'])) {
			// То заполним наш массив товарами
			$booksInCart = $_SESSION['books'];
		}

		// Проверяем есть ли уже такой товар в корзине
		if (array_key_exists($id, $booksInCart)) {
			// Если такой товар есть в корзине, но был добавлен еще раз, увеличим количество на 1
			$booksInCart[$id]++;
		} else {
			// Если нет, добавляем id нового товара в корзину с количеством 1
			$booksInCart[$id] = 1;
		}

		// Записываем массив с товарами в сессию
		$_SESSION['books'] = $booksInCart;

		// Возвращаем количество товаров в корзине
		return self::countItems();
	}

	/**
	 * Подсчет количество товаров в корзине (в сессии)
	 * @return int <p>Количество товаров в корзине</p>
	 */
	public static function countItems()
	{
		// Проверка наличия товаров в корзине
		if (isset($_SESSION['books'])) {
			// Если массив с товарами есть
			// Подсчитаем и вернем их количество
			$count = 0;
			foreach ($_SESSION['books'] as $id => $quantity) {
				$count = $count + $quantity;
			}
			return $count;
		} else {
			// Если товаров нет, вернем 0
			return 0;
		}
	}

	/**
	 * Возвращает массив с идентификаторами и количеством товаров в корзине<br/>
	 * Если товаров нет, возвращает false;
	 * @return mixed: boolean or array
	 */
	public static function getBooks()
	{
		if (isset($_SESSION['books'])) {
			return $_SESSION['books'];
		}
		return false;
	}

	/**
	 * Получаем общую стоимость переданных товаров
	 * @param array $products <p>Массив с информацией о товарах</p>
	 * @return integer <p>Общая стоимость</p>
	 */
	public static function getTotalPrice($books)
	{
		// Получаем массив с идентификаторами и количеством товаров в корзине
		$booksInCart = self::getBooks();

		// Подсчитываем общую сbooks
		$total = 0;
		if ($booksInCart) {
			// Если в корзине не пусто
			// Проходим по переданному в метод массиву товаров
			foreach ($books as $item) {
				// Находим общую стоимость: цена товара * количество товара
				$total += $item['price'] * $booksInCart[$item['id']];
			}
		}

		return $total;
	}

	/**
	 * Очищает корзину
	 */
	public static function clear()
	{
		if (isset($_SESSION['books'])) {
			unset($_SESSION['books']);
		}
	}

	/**
	 * Удаляет товар с указанным id из корзины
	 * @param integer $id <p>id товара</p>
	 */
	public static function deleteProduct($id)
	{
		// Получаем массив с идентификаторами и количеством товаров в корзине
		$booksInCart = self::getBooks();

		// Удаляем из массива элемент с указанным id
		unset($booksInCart[$id]);

		// Записываем массив товаров с удаленным элементом в сессию
		$_SESSION['books'] = $booksInCart;
	}

}
