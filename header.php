<?php
/**
 * Шапка сайта
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="site">

<header class="header" id="header">
    <!-- Top bar -->
    <div class="header__top">
        <div class="container">
            <div class="header__top-inner">
                <?php
                $address   = kt_get_contact_address();
                $gis_url   = kt_get_contact_2gis_url();
                $phone     = kt_get_contact_phone();
                $phone_tel = kt_get_contact_phone_link();
                $whatsapp  = kt_get_contact_whatsapp();
                $wa_link   = kt_get_contact_whatsapp_link();
                ?>
                <?php if ( $address && $gis_url ) : ?>
                    <a href="<?php echo esc_url( $gis_url ); ?>" class="header__top-address" target="_blank" rel="noopener noreferrer">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <?php echo esc_html( $address ); ?> — открыть в 2GIS
                    </a>
                <?php elseif ( $address ) : ?>
                    <span class="header__top-address">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <?php echo esc_html( $address ); ?>
                    </span>
                <?php endif; ?>
                <div class="header__top-contacts">
                    <?php if ( $phone ) : ?>
                        <a href="tel:<?php echo esc_attr( $phone_tel ); ?>" class="header__phone">
                            <svg class="header__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <?php echo esc_html( $phone ); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ( $phone && $whatsapp && $wa_link ) : ?>
                        <span class="header__divider"></span>
                    <?php endif; ?>
                    <?php if ( $whatsapp && $wa_link ) : ?>
                        <a href="<?php echo esc_url( $wa_link ); ?>" class="header__whatsapp" target="_blank" rel="noopener noreferrer">
                            <svg class="header__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            WhatsApp
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Main header -->
    <div class="header__main">
        <div class="container">
            <div class="header__main-inner">
                <!-- Logo -->
                <div class="header__logo">
                    <?php if ( has_custom_logo() ) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo-text">
                            <?php bloginfo( 'name' ); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Navigation -->
                <nav class="header__nav" id="primary-nav" aria-label="<?php esc_attr_e( 'Главное меню', 'kt-terekol' ); ?>">
                    <?php
                    if ( has_nav_menu( 'primary' ) ) {
                        wp_nav_menu( array(
                            'theme_location' => 'primary',
                            'menu_class'     => 'header__menu',
                            'container'      => false,
                            'depth'          => 2,
                            'fallback_cb'    => false,
                        ) );
                    } else {
                        // Fallback menu
                        ?>
                        <ul class="header__menu">
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Главная</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/products/' ) ); ?>">Программы</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">Новости</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/reports/' ) ); ?>">Отчёты</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/contacts/' ) ); ?>">Контакты</a></li>
                        </ul>
                        <?php
                    }
                    ?>
                </nav>

                <!-- CTA Button -->
                <div class="header__cta">
                    <a href="<?php echo is_front_page() ? '#apply' : esc_url( home_url( '/#apply' ) ); ?>" class="btn btn-primary">
                        Оставить заявку
                    </a>
                </div>

                <!-- Mobile toggle -->
                <button
                    type="button"
                    class="header__toggle"
                    id="menu-toggle"
                    aria-expanded="false"
                    aria-controls="primary-nav"
                    aria-label="<?php esc_attr_e( 'Открыть меню', 'kt-terekol' ); ?>"
                >
                    <span class="header__toggle-line"></span>
                    <span class="header__toggle-line"></span>
                    <span class="header__toggle-line"></span>
                </button>
            </div>
        </div>
    </div>
</header>

<main class="site-main" id="main">
