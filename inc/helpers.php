<?php
/**
 * Вспомогательные функции темы
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Увеличить счётчик просмотров записи
 */
function kt_increment_post_views() {
    if ( is_singular( 'post' ) && ! is_admin() && ! is_preview() ) {
        $post_id = get_the_ID();
        $views   = (int) get_post_meta( $post_id, 'kt_post_views', true );
        update_post_meta( $post_id, 'kt_post_views', $views + 1 );
    }
}
add_action( 'wp_head', 'kt_increment_post_views' );

/**
 * Получить количество просмотров записи
 *
 * @param int|null $post_id ID записи (по умолчанию текущая)
 * @return int
 */
function kt_get_post_views( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    return (int) get_post_meta( $post_id, 'kt_post_views', true );
}
