<?php

return array(
    // Товар:
    'book/([0-9]+)' => 'book/view/$1', // actionView в ProductController
    // Каталог:
    'catalog' => 'catalog/index', // actionIndex в CatalogController
    // Категория товаров:
    'genre/([0-9]+)/page-([0-9]+)' => 'catalog/genre/$1/$2', // actionCategory в CatalogController
    'genre/([0-9]+)' => 'catalog/genre/$1', // actionCategory в CatalogController
    // Корзина:
    'cart/checkout' => 'cart/checkout', // actionAdd в CartController
    'cart/delete/([0-9]+)' => 'cart/delete/$1', // actionDelete в CartController
    'cart/add/([0-9]+)' => 'cart/add/$1', // actionAdd в CartController
    'cart/addAjax/([0-9]+)' => 'cart/addAjax/$1', // actionAddAjax в CartController
    'cart' => 'cart/index', // actionIndex в CartController

    // Пользователь:
    'user/register' => 'user/register',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    'cabinet/edit' => 'cabinet/edit',
    'cabinet' => 'cabinet/index',
    // Управление товарами:
    'admin/book/create' => 'adminProduct/create',
    'admin/book/update/([0-9]+)' => 'adminProduct/update/$1',
    'admin/book/delete/([0-9]+)' => 'adminProduct/delete/$1',
    'admin/book' => 'adminProduct/index',
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
