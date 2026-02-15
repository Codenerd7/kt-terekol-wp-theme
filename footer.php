<?php
/**
 * Подвал сайта
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

</main><!-- .site-main -->

<footer class="footer" id="footer">
    <div class="footer__top">
        <div class="container">
            <div class="row row-gap-6">
                <!-- Column 1: About -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="footer__about">
                        <?php if ( has_custom_logo() ) : ?>
                            <div class="footer__logo">
                                <?php the_custom_logo(); ?>
                            </div>
                        <?php else : ?>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer__logo-text">
                                <?php bloginfo( 'name' ); ?>
                            </a>
                        <?php endif; ?>
                        <p class="footer__description">
                            ТОО «КТ Теренколь» — микрофинансовая организация, специализирующаяся на кредитовании субъектов агропромышленного комплекса Республики Казахстан.
                        </p>
                    </div>
                </div>

                <!-- Column 2: Navigation -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="footer__nav">
                        <h4 class="footer__title">Навигация</h4>
                        <?php
                        if ( has_nav_menu( 'footer' ) ) {
                            wp_nav_menu( array(
                                'theme_location' => 'footer',
                                'menu_class'     => 'footer__menu',
                                'container'      => false,
                                'depth'          => 1,
                                'fallback_cb'    => false,
                            ) );
                        } else {
                            // Fallback menu
                            ?>
                            <ul class="footer__menu">
                                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Главная</a></li>
                                <li><a href="<?php echo esc_url( home_url( '/products/' ) ); ?>">Программы кредитования</a></li>
                                <li><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">Новости</a></li>
                                <li><a href="<?php echo esc_url( home_url( '/reports/' ) ); ?>">Отчёты</a></li>
                                <li><a href="<?php echo esc_url( home_url( '/contacts/' ) ); ?>">Контакты</a></li>
                            </ul>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <!-- Column 3: Contacts -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="footer__contacts">
                        <h4 class="footer__title">Контакты</h4>
                        <?php
                        $phone     = kt_get_contact_phone();
                        $phone_tel = kt_get_contact_phone_link();
                        $whatsapp  = kt_get_contact_whatsapp();
                        $wa_link   = kt_get_contact_whatsapp_link();
                        $email     = kt_get_contact_email();
                        $address   = kt_get_contact_address();
                        $gis_url   = kt_get_contact_2gis_url();
                        ?>
                        <ul class="footer__contact-list">
                            <?php if ( $phone ) : ?>
                                <li>
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                    <a href="tel:<?php echo esc_attr( $phone_tel ); ?>"><?php echo esc_html( $phone ); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if ( $whatsapp && $wa_link ) : ?>
                                <li>
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    <a href="<?php echo esc_url( $wa_link ); ?>" target="_blank" rel="noopener noreferrer">WhatsApp</a>
                                </li>
                            <?php endif; ?>
                            <?php if ( $email ) : ?>
                                <li>
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                    <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if ( $address ) : ?>
                                <li>
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                    <?php if ( $gis_url ) : ?>
                                        <a href="<?php echo esc_url( $gis_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $address ); ?></a>
                                    <?php else : ?>
                                        <span><?php echo esc_html( $address ); ?></span>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                            <li>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                                <span>БИН: 030940002300</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-license">
        <div class="container">
            <div class="footer-license__inner">
                <?php $upload = wp_upload_dir(); ?>
                <p class="footer-license__text">Лицензия АРРФР №14.21.0009.К от 26.03.2021 года на право осуществления микрофинансовой деятельности</p>
                <a class="footer-license__btn" href="<?php echo esc_url( $upload['baseurl'] . '/2026/02/Лицензия.pdf' ); ?>" target="_blank" rel="noopener noreferrer">Читать</a>
            </div>
        </div>
    </div>

    <div class="footer__bottom">
        <div class="container">
            <div class="footer__bottom-inner">
                <p class="footer__copyright">
                    &copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. Все права защищены.
                </p>
                <nav class="footer__legal">
                    <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Политика конфиденциальности</a>
                </nav>
            </div>
        </div>
    </div>
</footer>

</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
