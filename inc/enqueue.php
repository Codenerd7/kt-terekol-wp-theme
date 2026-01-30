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

    // Swiper CSS (для слайдера проектов)
    wp_enqueue_style(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        '11.0.0'
    );

    // GLightbox CSS (для lightbox проектов)
    wp_enqueue_style(
        'glightbox',
        'https://cdn.jsdelivr.net/npm/glightbox@3.3.0/dist/css/glightbox.min.css',
        [],
        '3.3.0'
    );

    // Swiper JS
    wp_enqueue_script(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        '11.0.0',
        true
    );

    // GLightbox JS
    wp_enqueue_script(
        'glightbox',
        'https://cdn.jsdelivr.net/npm/glightbox@3.3.0/dist/js/glightbox.min.js',
        [],
        '3.3.0',
        true
    );

    // Основной JS
    wp_enqueue_script(
        'kt-main-scripts',
        KT_THEME_URI . '/assets/js/main.js',
        [ 'swiper', 'glightbox' ],
        KT_THEME_VERSION,
        true
    );


}

add_action( 'wp_enqueue_scripts', 'kt_enqueue_assets' );

