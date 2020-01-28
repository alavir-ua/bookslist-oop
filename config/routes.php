<?php

return array(
    // Книга:
    'book/([0-9]+)' => 'book/view/$1', // actionView в BookController

    // Каталог:
	'catalog/page-([0-9]+)' => 'catalog/index/$1', // actionIndex в CatalogController
	'catalog' => 'catalog/index', // actionIndex в CatalogController

    //Жанр книг:
	'genre/([0-9]+)/page-([0-9]+)' => 'catalog/genre/$1/$2', // actionGenre в CatalogController
	'genre/([0-9]+)' => 'catalog/genre/$1', // actionGenre в CatalogController

	//Автор книг:
	'author/([0-9]+)/page-([0-9]+)' => 'catalog/author/$1/$2', // actionAuthor в CatalogController
	'author/([0-9]+)' => 'catalog/author/$1', // actionAuthor в CatalogController

	//Заказ:
	'order/([0-9]+)' => 'order/index/$1', // actionIndex в OrderController
	'order/checkout' => 'order/checkout', // actionCheckout в OrderController

    // Управление книгами:
    'admin/book/create' => 'adminBook/create', // actionCreate в AdminBookController

    'admin/book/update/([0-9]+)' => 'adminProduct/update/$1',
    'admin/book/delete/([0-9]+)' => 'adminProduct/delete/$1',

	'admin/book/page-([0-9]+)' => 'adminBook/index/$1', // actionIndex в AdminBookController
    'admin/book' => 'adminBook/index', // actionIndex в AdminBookController


    // Управление категориями:
    'admin/genre/create' => 'adminGenre/create',
    'admin/genre/update/([0-9]+)' => 'adminGenre/update/$1',
    'admin/genre/delete/([0-9]+)' => 'adminGenre/delete/$1',
    'admin/genre' => 'adminGenre/index',

    // Управление заказами:
    'admin/order/update/([0-9]+)' => 'adminOrder/update/$1',
    'admin/order/delete/([0-9]+)' => 'adminOrder/delete/$1',
    'admin/order/view/([0-9]+)' => 'adminOrder/view/$1',
    'admin/order' => 'adminOrder/index',

    // Админпанель:
    'admin' => 'admin/index',
    // О магазине

    'contacts' => 'site/contact',
    'about' => 'site/about',
    // Главная страница

    'index.php' => 'site/index', // actionIndex в SiteController
    '' => 'site/index', // actionIndex в SiteController
);
