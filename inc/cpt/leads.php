<?php
/**
 * Custom Post Type: Заявки (kt_lead)
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', 'kt_register_lead_cpt' );

function kt_register_lead_cpt(): void {
    $labels = [
        'name'               => 'Заявки',
        'singular_name'      => 'Заявка',
        'menu_name'          => 'Заявки',
        'add_new'            => 'Добавить заявку',
        'add_new_item'       => 'Новая заявка',
        'edit_item'          => 'Редактировать заявку',
        'new_item'           => 'Новая заявка',
        'view_item'          => 'Просмотреть заявку',
        'search_items'       => 'Поиск заявок',
        'not_found'          => 'Заявок не найдено',
        'not_found_in_trash' => 'В корзине заявок нет',
    ];

    $args = [
        'labels'              => $labels,
        'public'              => false,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 25,
        'menu_icon'           => 'dashicons-email-alt',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => [ 'title' ],
        'has_archive'         => false,
        'rewrite'             => false,
        'query_var'           => false,
        'show_in_rest'        => false,
    ];

    register_post_type( 'kt_lead', $args );
}
