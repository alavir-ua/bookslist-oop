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
     * Action для страницы "Добавить категорию"
     */
    public function actionCreate()
    {
        // Обработка формы
        if (isset($_POST['submit'])) {

            // Если форма отправлена получаем данные из формы
            $name = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status = $_POST['status'];

            // Флаг ошибок в форме
            $errors = false;

	        // При необходимости можно валидировать значения нужным образом
	        if (!isset($name) || empty($name)) {
		        $errors[] = 'Заполните поле "Название"';
	        }
	        if (!isset($sortOrder) || empty($sortOrder)) {
		        $errors[] = 'Заполните поле "Порядок отображения"';
	        }

            if ($errors == false) {
                // Если ошибок нет добавляем новый жанр
                Genre::createGenre($name, $sortOrder, $status);

                // Перенаправляем пользователя на страницу управлениями категориями
                header("Location: /admin/genre");
            }
        }

        require_once(ROOT . '/views/admin/admin_genre/create.php');
        return true;
    }

    /**
     * Action для страницы "Редактировать категорию"
     */
    public function actionUpdate($id)
    {
        // Проверка доступа
        self::checkAdmin();

        // Получаем данные о конкретной категории
        $category = Genre::getCategoryById($id);

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные из формы
            $name = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status = $_POST['status'];

            // Сохраняем изменения
            Genre::updateCategoryById($id, $name, $sortOrder, $status);

            // Перенаправляем пользователя на страницу управлениями категориями
            header("Location: /admin/category");
        }

        // Подключаем вид
        require_once(ROOT . '/views/admin_genre/update.php');
        return true;
    }

    /**
     * Action для страницы "Удалить категорию"
     */
    public function actionDelete($id)
    {
        // Проверка доступа
        self::checkAdmin();

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Удаляем категорию
            Genre::deleteCategoryById($id);

            // Перенаправляем пользователя на страницу управлениями товарами
            header("Location: /admin/category");
        }

        // Подключаем вид
        require_once(ROOT . '/views/admin_genre/delete.php');
        return true;
    }

}
