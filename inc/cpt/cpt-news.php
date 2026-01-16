<?php
/**
 * Custom Post Type: Новости
 *
 * Регистрация типа записи для новостей компании и отрасли.
 * Используется вместо стандартных записей WordPress для разделения контента.
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Регистрация CPT "news"
 */
function kt_register_news_post_type() {

    /**
     * Метки для админ-панели WordPress
     */
    $labels = [
        'name'               => 'Новости',
        'singular_name'      => 'Новость',
        'menu_name'          => 'Новости',
        'add_new'            => 'Добавить новость',
        'add_new_item'       => 'Добавить новую новость',
        'edit_item'          => 'Редактировать новость',
        'new_item'           => 'Новая новость',
        'view_item'          => 'Просмотреть новость',
        'search_items'       => 'Найти новость',
        'not_found'          => 'Новости не найдены',
        'not_found_in_trash' => 'В корзине новостей нет',
        'all_items'          => 'Все новости',
    ];

    /**
     * Параметры типа записи
     */
    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,                // Поддержка Gutenberg
        'query_var'          => true,
        'rewrite'            => [
            'slug'       => 'news',                  // ЧПУ: /news/название-новости/
            'with_front' => false,
        ],
        'capability_type'    => 'post',
        'has_archive'        => true,                // Архив новостей /news/
        'hierarchical'       => false,
        'menu_position'      => 6,                   // После «Продуктов»
        'menu_icon'          => 'dashicons-megaphone',
        'supports'           => [
            'title',           // Заголовок новости
            'editor',          // Полный текст
            'thumbnail',       // Изображение
            'excerpt',         // Краткий анонс
            'revisions',       // История изменений
        ],
    ];

    register_post_type( 'news', $args );
}
add_action( 'init', 'kt_register_news_post_type' );

/**
 * Регистрация таксономии "Рубрики новостей"
 *
 * Позволяет группировать новости по темам:
 * «Новости компании», «Новости отрасли», «Пресс-релизы» и т.д.
 */
function kt_register_news_taxonomy() {

    $labels = [
        'name'              => 'Рубрики новостей',
        'singular_name'     => 'Рубрика',
        'search_items'      => 'Найти рубрику',
        'all_items'         => 'Все рубрики',
        'parent_item'       => 'Родительская рубрика',
        'parent_item_colon' => 'Родительская рубрика:',
        'edit_item'         => 'Редактировать рубрику',
        'update_item'       => 'Обновить рубрику',
        'add_new_item'      => 'Добавить рубрику',
        'new_item_name'     => 'Название новой рубрики',
        'menu_name'         => 'Рубрики',
    ];

    $args = [
        'labels'            => $labels,
        'hierarchical'      => true,                 // Древовидная структура
        'public'            => true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,                 // Колонка в списке новостей
        'rewrite'           => [
            'slug'       => 'news-category',         // ЧПУ: /news-category/рубрика/
            'with_front' => false,
        ],
    ];

    register_taxonomy( 'news_category', 'news', $args );
}
add_action( 'init', 'kt_register_news_taxonomy' );
