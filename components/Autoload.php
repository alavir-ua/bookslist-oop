<?php

/**
 * Функция spl_autoload_register для автоматического подключения классов
 */
spl_autoload_register(function ($class_name) {
	// Массив папок, в которых могут находиться необходимые классы
	$array_paths = array(
		'/models/',
		'/components/',
		'/controllers/',
	);

	// Проходим по массиву папок
	foreach ($array_paths as $path) {

		// Формируем имя и путь к файлу с классом
		$path = ROOT . $path . $class_name . '.php';

		// Если такой файл существует, подключаем его
		if (is_file($path)) {
			include_once $path;
		}
	}
});
