<?php

/**
 * Контроллер CatalogController
 * Каталог книг
 */
class CatalogController
{
    /**
     * Action для страницы "Каталог"
     */
    public function actionIndex($page=1)
    {
	    // Список категорий для левого меню
	    $genres = Genre::getGenresList();

	    // Список авторов для левого меню
	    $authors = Author::getAuthorsList();

	    // Массив книг страницы в каталоге
	    $booksList = Book::getBooksLimit($page);

	    // Общее количетсво книг (необходимо для постраничной навигации)
	    $total = Book::getCountBooks();

	    // Создаем объект Pagination - постраничная навигация
	    $pagination = new Pagination($total, $page, Book::SHOW_BY_DEFAULT, 'page-');

        // Подключаем вид
        require_once(ROOT . '/views/catalog/index.php');
        return true;
    }

    /**
     * Action для страницы "Каталог по автору"
     */
    public function actionGenre($genreId, $page=1)
    {
	    // Список категорий для левого меню
	    $genres = Genre::getGenresList();

	    //Список авторов для левого меню
	    $authors = Author::getAuthorsList();

        //Массив книг книг жанра для страницы (пагинация)
        $genreBooks = Book::getBooksLimitByGenre($genreId, $page);

        // Общее количетсво книг жанра (пагинация)
        $total = Book::getCountBooksInGenre($genreId);

        // Создаем объект Pagination - постраничная навигация
        $pagination = new Pagination($total, $page, Book::SHOW_BY_DEFAULT, 'page-');

        // Подключаем вид
        require_once(ROOT . '/views/catalog/genre.php');
        return true;
    }

	/**
	 * Action для страницы "Каталог по автору"
	 */
	public function actionAuthor($authorId, $page=1)
	{
		// Список категорий для левого меню
		$genres = Genre::getGenresList();

		//Список авторов для левого меню
		$authors = Author::getAuthorsList();

		//Массив книг книг жанра для страницы (пагинация)
		$authorBooks = Book::getBooksLimitByAuthor($authorId, $page);

		// Общее количетсво книг жанра (пагинация)
		$total = Book::getCountBooksByAuthor($authorId);

		// Создаем объект Pagination - постраничная навигация
		$pagination = new Pagination($total, $page, Book::SHOW_BY_DEFAULT, 'page-');

		// Подключаем вид
		require_once(ROOT . '/views/catalog/author.php');
		return true;
	}
}
