<?php
/**
 * Single Template: Извещение
 *
 * Страница отдельного извещения с датой, просмотрами, файлом
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Метаданные извещения
$notice_date   = get_post_meta( get_the_ID(), 'kt_notice_date', true );
$notice_file   = get_post_meta( get_the_ID(), 'kt_notice_file', true );
$notice_views  = kt_get_notice_views();

// Ссылка "назад"
$notices_page = get_page_by_path( 'izveshcheniya' );
$back_url     = $notices_page ? get_permalink( $notices_page ) : get_post_type_archive_link( 'kt_notice' );
?>

<main id="main" class="site-main">
    <article class="notice-single">
        <div class="container">
            <div class="notice-back">
                <a href="<?php echo esc_url( $back_url ); ?>">
                    &larr; Назад к извещениям
                </a>
            </div>

            <header class="notice-single__header">
                <h1 class="notice-single__title"><?php the_title(); ?></h1>

                <div class="notice-single__meta">
                    <?php if ( $notice_date ) : ?>
                        <span class="notice-single__meta-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            Опубликовано на сайте: <?php echo esc_html( date_i18n( 'd.m.Y', strtotime( $notice_date ) ) ); ?>
                        </span>
                    <?php endif; ?>

                    <span class="notice-single__meta-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        Просмотров: <?php echo esc_html( $notice_views ); ?>
                    </span>
                </div>
            </header>

            <?php if ( get_the_content() ) : ?>
                <div class="notice-single__content">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>

            <?php if ( $notice_file ) : ?>
                <div class="notice-single__download">
                    <a href="<?php echo esc_url( $notice_file ); ?>" class="btn btn--primary" target="_blank" rel="noopener noreferrer">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        Скачать извещение
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </article>
</main>

<?php
get_footer();
