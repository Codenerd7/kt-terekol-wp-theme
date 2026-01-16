<?php
/**
 * KT Terekol Theme Functions
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Константы темы
 */
define( 'KT_THEME_VERSION', '1.0.0' );
define( 'KT_THEME_DIR', get_template_directory() );
define( 'KT_THEME_URI', get_template_directory_uri() );

/**
 * Подключение модулей темы
 */
$kt_includes = [
    '/inc/setup.php',      // Базовая настройка темы
    '/inc/enqueue.php',    // Подключение стилей и скриптов
    '/inc/helpers.php',    // Вспомогательные функции
];

foreach ( $kt_includes as $file ) {
    $filepath = KT_THEME_DIR . $file;
    if ( file_exists( $filepath ) ) {
        require_once $filepath;
    }
}

/**
 * Подключение Custom Post Types
 */
$kt_cpt_files = glob( KT_THEME_DIR . '/inc/cpt/*.php' );
if ( $kt_cpt_files ) {
    foreach ( $kt_cpt_files as $cpt_file ) {
        require_once $cpt_file;
    }
}

/**
 * Подключение ACF полей (если ACF активен)
 */
if ( class_exists( 'ACF' ) ) {
    $acf_fields = KT_THEME_DIR . '/inc/acf/fields.php';
    if ( file_exists( $acf_fields ) ) {
        require_once $acf_fields;
    }
}
