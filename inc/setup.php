<?php
/**
 * Базовая настройка темы
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Настройка поддержки функций темы
 */
function kt_theme_setup() {
    // Поддержка заголовка документа
    add_theme_support( 'title-tag' );

    // Миниатюры записей
    add_theme_support( 'post-thumbnails' );

    // HTML5 разметка
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ] );

    // Логотип
    add_theme_support( 'custom-logo', [
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ] );

    // Регистрация меню
    register_nav_menus( [
        'primary' => __( 'Главное меню', 'kt-terekol' ),
        'footer'  => __( 'Меню в подвале', 'kt-terekol' ),
    ] );
}
add_action( 'after_setup_theme', 'kt_theme_setup' );
