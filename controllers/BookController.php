<?php

/**
 * Контроллер BookController
 * книга
 */
class BookController
{
	/**
	 * Action для страницы просмотра книги
	 */
    public function actionView($bookId)
    {
        // Список категорий для левого меню
        $genres = Genre::getGenresList();

	    // Список авторов для левого меню
	    $authors = Author::getAuthorsList();

        // Получаем инфомрацию о товаре
        $book = Book::getBookById($bookId);

        // Подключаем вид
        require_once(ROOT . '/views/book/view.php');
        return true;
    }

}
