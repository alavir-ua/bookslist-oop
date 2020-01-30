<?php

return array(
    // Книга:
    'book/([0-9]+)' => 'book/view/$1', // actionView в BookController

    // Каталог:
	'catalog/page-([0-9]+)' => 'catalog/index/$1', // actionIndex в CatalogController
	'catalog' => 'catalog/index', // actionIndex в CatalogController

    //Каталог по жанру:
	'genre/([0-9]+)/page-([0-9]+)' => 'catalog/genre/$1/$2', // actionGenre в CatalogController
	'genre/([0-9]+)' => 'catalog/genre/$1', // actionGenre в CatalogController

	//Каталог по автору:
	'author/([0-9]+)/page-([0-9]+)' => 'catalog/author/$1/$2', // actionAuthor в CatalogController
	'author/([0-9]+)' => 'catalog/author/$1', // actionAuthor в CatalogController

	//Заказ:
	'order/([0-9]+)' => 'order/index/$1', // actionIndex в OrderController

    // Управление книгами:
    'admin/book/create' => 'adminBook/create', // actionCreate в AdminBookController
    'admin/book/update/([0-9]+)' => 'adminBook/update/$1', //actionUpdate в AdminBookController
    'admin/book/delete/([0-9]+)' => 'adminBook/delete/$1', //actionDelete в AdminBookController
	'admin/book/page-([0-9]+)' => 'adminBook/index/$1', // actionIndex в AdminBookController
    'admin/book' => 'adminBook/index', // actionIndex в AdminBookController

    // Управление жанрами:
	'admin/genre/update/([0-9]+)' => 'adminGenre/update/$1', //actionUpdate в AdminGenreController
    'admin/genre/create' => 'adminGenre/create', //actionCreate в AdminGenreController
    'admin/genre' => 'adminGenre/index', //actionIndex в AdminGenreController

	// Управление авторами:
	'admin/author/create' => 'adminAuthor/create', //actionCreate в AdminAuthorController
	'admin/author' => 'adminAuthor/index', //actionIndex в AdminAuthorController

    // Админпанель:
    'admin' => 'admin/index', // actionIndex в SiteController

    // О магазине
    'contacts' => 'site/contact', // actionContact в SiteController
    'about' => 'site/about', // actionAbout в SiteController

    // Главная страница
    'index.php' => 'site/index', // actionIndex в SiteController
    '' => 'site/index', // actionIndex в SiteController
);
