<?php
/**
 * Template Part: News Card
 *
 * Карточка новости — компактный вид, акцент на дату.
 * Используется в category-news.php и на главной.
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$has_thumb = has_post_thumbnail();
$views     = kt_get_post_views();
?>

<article class="news-card">
    <a href="<?php the_permalink(); ?>" class="news-card__link">
        <?php if ( $has_thumb ) : ?>
            <div class="news-card__image">
                <?php the_post_thumbnail( 'medium', [ 'class' => 'news-card__thumb' ] ); ?>
            </div>
        <?php endif; ?>

        <div class="news-card__body">
            <div class="news-card__meta">
                <time class="news-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                    <?php echo esc_html( get_the_date( 'd.m.Y' ) ); ?>
                </time>
                <span class="news-card__views">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <?php echo esc_html( $views ); ?>
                </span>
            </div>

            <h3 class="news-card__title"><?php the_title(); ?></h3>

            <?php if ( has_excerpt() || get_the_content() ) : ?>
                <p class="news-card__excerpt">
                    <?php echo esc_html( wp_trim_words( get_the_excerpt() ?: get_the_content(), 15, '...' ) ); ?>
                </p>
            <?php endif; ?>
        </div>
    </a>
</article>
