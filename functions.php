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

/**
 * Handle request form submit (Front page)
 */
add_action('admin_post_nopriv_kt_request_form_submit', 'kt_handle_request_form_submit');
add_action('admin_post_kt_request_form_submit', 'kt_handle_request_form_submit');

function kt_handle_request_form_submit(): void {
  // Basic nonce check
  if ( ! isset($_POST['kt_request_nonce']) || ! wp_verify_nonce($_POST['kt_request_nonce'], 'kt_request_form') ) {
    wp_safe_redirect( home_url('/?request=error#request') );
    exit;
  }

  // Honeypot: if filled, silently succeed (or error) to avoid giving signal to bots
  if ( ! empty($_POST['website']) ) {
    wp_safe_redirect( home_url('/?request=success#request') );
    exit;
  }

  $name    = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
  $phone   = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
  $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';

  // Minimal validation
  if ( $name === '' || $phone === '' ) {
    wp_safe_redirect( home_url('/?request=error#request') );
    exit;
  }

  $to = get_option('admin_email');
  $subject = 'Новая заявка на консультацию (КТ Теренколь)';

  $body_lines = [
    'Поступила новая заявка с сайта.',
    '',
    'Имя: ' . $name,
    'Телефон: ' . $phone,
  ];

  if ( $message !== '' ) {
    $body_lines[] = 'Комментарий: ' . $message;
  }

  $body_lines[] = '';
  $body_lines[] = 'Источник: ' . home_url('/');
  $body_lines[] = 'Дата/время: ' . wp_date('Y-m-d H:i');

  $body = implode("\n", $body_lines);

  $headers = [
    'Content-Type: text/plain; charset=UTF-8',
  ];

  $sent = wp_mail($to, $subject, $body, $headers);

  wp_safe_redirect( home_url( $sent ? '/?request=success#request' : '/?request=error#request' ) );
  exit;
}
