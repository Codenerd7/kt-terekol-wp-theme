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

// =====================
// Контакты (Customizer)
// =====================

/**
 * Получить телефон (отформатированный для отображения)
 */
function kt_get_contact_phone() {
    return get_theme_mod( 'kt_contact_phone', '+7 (708) 808-33-74' );
}

/**
 * Получить телефон для ссылки tel:
 * Оставляет только + и цифры
 */
function kt_get_contact_phone_link() {
    $phone = kt_get_contact_phone();
    return preg_replace( '/[^\d\+]/', '', $phone );
}

/**
 * Получить WhatsApp номер (отформатированный)
 */
function kt_get_contact_whatsapp() {
    return get_theme_mod( 'kt_contact_whatsapp', '+7 (708) 808-33-74' );
}

/**
 * Получить WhatsApp ссылку (wa.me требует только цифры без +)
 */
function kt_get_contact_whatsapp_link() {
    $whatsapp = kt_get_contact_whatsapp();
    if ( empty( $whatsapp ) ) {
        return '';
    }
    $digits = preg_replace( '/[^\d]/', '', $whatsapp );
    return 'https://wa.me/' . $digits;
}

/**
 * Получить адрес
 */
function kt_get_contact_address() {
    return get_theme_mod( 'kt_contact_address', 'Павлодарская обл., с. Теренколь, ул. Торайгырова, 104А' );
}

/**
 * Получить ссылку на 2GIS
 */
function kt_get_contact_2gis_url() {
    return get_theme_mod( 'kt_contact_2gis_url', 'https://2gis.kz/search/Павлодарская%20область%2C%20район%20Тереңкөл%2C%20село%20Теренколь%2C%20улица%20Торайгырова%2C%20104А' );
}

/**
 * Получить email
 */
function kt_get_contact_email() {
    return get_theme_mod( 'kt_contact_email', 'kt.terekol@mail.ru' );
}
