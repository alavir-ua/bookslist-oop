<?php

/**
 * Контроллер ProductController
 * Товар
 */
class ProductController
{

    /**
     * Action для страницы просмотра товара
     * @param integer $productId <p>id товара</p>
     */
    public function actionView($bookId)
    {
        // Список категорий для левого меню
        $genres = Genre::getGenresList();

        // Получаем инфомрацию о товаре
        $book = Book::getBookstById($bookId);

        // Подключаем вид
        require_once(ROOT . '/views/book/view.php');
        return true;
    }

}
