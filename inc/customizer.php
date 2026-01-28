<?php
/**
 * Настройки Customizer для темы
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Регистрация настроек Customizer
 */
function kt_customize_register( $wp_customize ) {

    // =====================
    // Секция: Контакты
    // =====================
    $wp_customize->add_section( 'kt_contacts', [
        'title'       => __( 'Контакты', 'kt-terekol' ),
        'description' => __( 'Контактные данные компании для шапки, подвала и страницы контактов.', 'kt-terekol' ),
        'priority'    => 30,
    ] );

    // --- Телефон ---
    $wp_customize->add_setting( 'kt_contact_phone', [
        'default'           => '+7 (708) 808-33-74',
        'sanitize_callback' => 'kt_sanitize_phone',
        'transport'         => 'refresh',
    ] );

    $wp_customize->add_control( 'kt_contact_phone', [
        'label'       => __( 'Телефон', 'kt-terekol' ),
        'description' => __( 'Формат: +7 (XXX) XXX-XX-XX', 'kt-terekol' ),
        'section'     => 'kt_contacts',
        'type'        => 'text',
    ] );

    // --- WhatsApp ---
    $wp_customize->add_setting( 'kt_contact_whatsapp', [
        'default'           => '+7 (708) 808-33-74',
        'sanitize_callback' => 'kt_sanitize_phone',
        'transport'         => 'refresh',
    ] );

    $wp_customize->add_control( 'kt_contact_whatsapp', [
        'label'       => __( 'WhatsApp', 'kt-terekol' ),
        'description' => __( 'Номер для WhatsApp (может отличаться от основного телефона). Оставьте пустым, чтобы скрыть кнопку WhatsApp.', 'kt-terekol' ),
        'section'     => 'kt_contacts',
        'type'        => 'text',
    ] );

    // --- Адрес ---
    $wp_customize->add_setting( 'kt_contact_address', [
        'default'           => 'Павлодарская обл., с. Теренколь, ул. Торайгырова, 104А',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );

    $wp_customize->add_control( 'kt_contact_address', [
        'label'       => __( 'Адрес', 'kt-terekol' ),
        'description' => __( 'Полный адрес компании.', 'kt-terekol' ),
        'section'     => 'kt_contacts',
        'type'        => 'text',
    ] );

    // --- Ссылка на 2GIS ---
    $wp_customize->add_setting( 'kt_contact_2gis_url', [
        'default'           => 'https://2gis.kz/search/Павлодарская%20область%2C%20район%20Тереңкөл%2C%20село%20Теренколь%2C%20улица%20Торайгырова%2C%20104А',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ] );

    $wp_customize->add_control( 'kt_contact_2gis_url', [
        'label'       => __( 'Ссылка на 2GIS', 'kt-terekol' ),
        'description' => __( 'URL на карту 2GIS. Оставьте пустым, чтобы убрать ссылку.', 'kt-terekol' ),
        'section'     => 'kt_contacts',
        'type'        => 'url',
    ] );

    // --- Email ---
    $wp_customize->add_setting( 'kt_contact_email', [
        'default'           => 'kt.terekol@mail.ru',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ] );

    $wp_customize->add_control( 'kt_contact_email', [
        'label'       => __( 'Email', 'kt-terekol' ),
        'description' => __( 'Контактный email.', 'kt-terekol' ),
        'section'     => 'kt_contacts',
        'type'        => 'email',
    ] );
}
add_action( 'customize_register', 'kt_customize_register' );

/**
 * Санитизация телефона
 * Разрешает: +, цифры, пробелы, -, (), точки
 */
function kt_sanitize_phone( $phone ) {
    // Удаляем всё кроме разрешённых символов
    return preg_replace( '/[^\d\s\+\-\(\)\.]/u', '', $phone );
}
