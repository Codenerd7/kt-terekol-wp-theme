<?php
/**
 * Подключение стилей и скриптов
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Подключение стилей и скриптов на фронтенде
 */
function kt_enqueue_assets() {

   // Основные стили темы (assets) — один источник
    wp_enqueue_style(
        'kt-main-styles',
        KT_THEME_URI . '/assets/css/styles.css',
        [],
        filemtime( KT_THEME_DIR . '/assets/css/styles.css' )
    );

    // Основной JS
    wp_enqueue_script(
        'kt-main-scripts',
        KT_THEME_URI . '/assets/js/main.js',
        [],
        KT_THEME_VERSION,
        true
    );

    
}

add_action( 'wp_enqueue_scripts', 'kt_enqueue_assets' );

