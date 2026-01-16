<?php
/**
 * Custom Post Type: Кредитные продукты
 *
 * Регистрация типа записи для кредитных продуктов компании.
 * Примеры: «Кредит на посевную», «Кредит на технику», «Кредит на развитие».
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Регистрация CPT "product"
 */
function kt_register_product_post_type() {

    /**
     * Метки для админ-панели WordPress
     */
    $labels = [
        'name'               => 'Кредитные продукты',
        'singular_name'      => 'Кредитный продукт',
        'menu_name'          => 'Продукты',
        'add_new'            => 'Добавить продукт',
        'add_new_item'       => 'Добавить новый продукт',
        'edit_item'          => 'Редактировать продукт',
        'new_item'           => 'Новый продукт',
        'view_item'          => 'Просмотреть продукт',
        'search_items'       => 'Найти продукт',
        'not_found'          => 'Продукты не найдены',
        'not_found_in_trash' => 'В корзине продуктов нет',
        'all_items'          => 'Все продукты',
    ];

    /**
     * Параметры типа записи
     */
    $args = [
        'labels'             => $labels,
        'public'             => true,                // Публичный тип записи
        'publicly_queryable' => true,                // Доступен для запросов на фронте
        'show_ui'            => true,                // Показывать в админке
        'show_in_menu'       => true,                // Показывать в меню админки
        'show_in_rest'       => true,                // Поддержка Gutenberg и REST API
        'query_var'          => true,                // Параметр запроса
        'rewrite'            => [
            'slug'       => 'products',              // ЧПУ: /products/название-продукта/
            'with_front' => false,
        ],
        'capability_type'    => 'post',              // Права как у обычных записей
        'has_archive'        => true,                // Архивная страница /products/
        'hierarchical'       => false,               // Не иерархический (как записи, не страницы)
        'menu_position'      => 5,                   // Позиция в меню (после «Записи»)
        'menu_icon'          => 'dashicons-money-alt', // Иконка в меню
        'supports'           => [
            'title',           // Заголовок
            'editor',          // Контент (описание продукта)
            'thumbnail',       // Миниатюра
            'excerpt',         // Краткое описание
            'revisions',       // История изменений
        ],
    ];

    register_post_type( 'product', $args );
}
add_action( 'init', 'kt_register_product_post_type' );

/**
 * Регистрация таксономии "Категории продуктов"
 *
 * Позволяет группировать продукты по типам:
 * например, «Для КХ», «Для ИП», «Сезонные» и т.д.
 */
function kt_register_product_taxonomy() {

    $labels = [
        'name'              => 'Категории продуктов',
        'singular_name'     => 'Категория продукта',
        'search_items'      => 'Найти категорию',
        'all_items'         => 'Все категории',
        'parent_item'       => 'Родительская категория',
        'parent_item_colon' => 'Родительская категория:',
        'edit_item'         => 'Редактировать категорию',
        'update_item'       => 'Обновить категорию',
        'add_new_item'      => 'Добавить категорию',
        'new_item_name'     => 'Название новой категории',
        'menu_name'         => 'Категории',
    ];

    $args = [
        'labels'            => $labels,
        'hierarchical'      => true,                 // Как рубрики (древовидная структура)
        'public'            => true,
        'show_ui'           => true,
        'show_in_rest'      => true,                 // Поддержка Gutenberg
        'show_admin_column' => true,                 // Колонка в списке продуктов
        'rewrite'           => [
            'slug'       => 'product-category',      // ЧПУ: /product-category/название/
            'with_front' => false,
        ],
    ];

    register_taxonomy( 'product_category', 'product', $args );
}
add_action( 'init', 'kt_register_product_taxonomy' );
