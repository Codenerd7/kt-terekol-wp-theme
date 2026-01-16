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
                <a href="https://2gis.kz/search/Павлодарская%20область%2C%20район%20Тереңкөл%2C%20село%20Теренколь%2C%20улица%20Торайгырова%2C%20104А" class="header__top-address" target="_blank" rel="noopener noreferrer">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    Павлодарская обл., с. Теренколь — открыть в 2GIS
                </a>
                <div class="header__top-contacts">
                    <a href="tel:+77088083374" class="header__phone">
                        <span class="header__icon">&#128222;</span>
                        +7 (708) 808-33-74
                    </a>
                    <a href="https://wa.me/77088083374" class="header__whatsapp" target="_blank" rel="noopener noreferrer">
                        <span class="header__icon">&#128172;</span>
                        WhatsApp
                    </a>
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
                    <a href="#request" class="btn btn-primary">
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
