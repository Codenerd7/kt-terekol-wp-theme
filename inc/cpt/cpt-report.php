<?php
/**
 * Custom Post Type: Отчёты
 *
 * Регистрация типа записи для публикации отчётов и документов.
 * Примеры: годовые отчёты, финансовая отчётность, аудиторские заключения.
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Регистрация CPT "report"
 */
function kt_register_report_post_type() {

    /**
     * Метки для админ-панели WordPress
     */
    $labels = [
        'name'               => 'Отчёты',
        'singular_name'      => 'Отчёт',
        'menu_name'          => 'Отчёты',
        'add_new'            => 'Добавить отчёт',
        'add_new_item'       => 'Добавить новый отчёт',
        'edit_item'          => 'Редактировать отчёт',
        'new_item'           => 'Новый отчёт',
        'view_item'          => 'Просмотреть отчёт',
        'search_items'       => 'Найти отчёт',
        'not_found'          => 'Отчёты не найдены',
        'not_found_in_trash' => 'В корзине отчётов нет',
        'all_items'          => 'Все отчёты',
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
            'slug'       => 'reports',               // ЧПУ: /reports/название-отчёта/
            'with_front' => false,
        ],
        'capability_type'    => 'post',
        'has_archive'        => true,                // Архив отчётов /reports/
        'hierarchical'       => false,
        'menu_position'      => 7,                   // После «Новостей»
        'menu_icon'          => 'dashicons-media-document',
        'supports'           => [
            'title',           // Название отчёта (например, «Годовой отчёт 2024»)
            'editor',          // Описание / аннотация
            'thumbnail',       // Обложка документа
            'revisions',       // История изменений
        ],
    ];

    register_post_type( 'report', $args );
}
add_action( 'init', 'kt_register_report_post_type' );

/**
 * Регистрация таксономии "Типы отчётов"
 *
 * Позволяет группировать документы по типам:
 * «Годовые отчёты», «Финансовая отчётность», «Аудит» и т.д.
 */
function kt_register_report_taxonomy() {

    $labels = [
        'name'              => 'Типы отчётов',
        'singular_name'     => 'Тип отчёта',
        'search_items'      => 'Найти тип',
        'all_items'         => 'Все типы',
        'parent_item'       => 'Родительский тип',
        'parent_item_colon' => 'Родительский тип:',
        'edit_item'         => 'Редактировать тип',
        'update_item'       => 'Обновить тип',
        'add_new_item'      => 'Добавить тип',
        'new_item_name'     => 'Название нового типа',
        'menu_name'         => 'Типы отчётов',
    ];

    $args = [
        'labels'            => $labels,
        'hierarchical'      => true,                 // Древовидная структура
        'public'            => true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,                 // Колонка в списке отчётов
        'rewrite'           => [
            'slug'       => 'report-type',           // ЧПУ: /report-type/тип/
            'with_front' => false,
        ],
    ];

    register_taxonomy( 'report_type', 'report', $args );
}
add_action( 'init', 'kt_register_report_taxonomy' );

/**
 * Регистрация таксономии "Год отчёта"
 *
 * Удобная фильтрация по годам: 2024, 2023, 2022 и т.д.
 * Не иерархическая (как метки).
 */
function kt_register_report_year_taxonomy() {

    $labels = [
        'name'                       => 'Год',
        'singular_name'              => 'Год',
        'search_items'               => 'Найти год',
        'popular_items'              => 'Популярные годы',
        'all_items'                  => 'Все годы',
        'edit_item'                  => 'Редактировать год',
        'update_item'                => 'Обновить год',
        'add_new_item'               => 'Добавить год',
        'new_item_name'              => 'Новый год',
        'separate_items_with_commas' => 'Разделите запятыми',
        'add_or_remove_items'        => 'Добавить или удалить год',
        'choose_from_most_used'      => 'Выбрать из часто используемых',
        'menu_name'                  => 'Год',
    ];

    $args = [
        'labels'            => $labels,
        'hierarchical'      => false,                // Как метки (не древовидная)
        'public'            => true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'rewrite'           => [
            'slug'       => 'report-year',           // ЧПУ: /report-year/2024/
            'with_front' => false,
        ],
    ];

    register_taxonomy( 'report_year', 'report', $args );
}
add_action( 'init', 'kt_register_report_year_taxonomy' );
