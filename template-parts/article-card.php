<?php
/**
 * Template Part: Article Card
 *
 * Карточка статьи — более развёрнутый вид, акцент на контент.
 * Используется в category-articles.php и на главной.
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$has_thumb = has_post_thumbnail();
?>

<article class="article-card">
    <a href="<?php the_permalink(); ?>" class="article-card__link">
        <?php if ( $has_thumb ) : ?>
            <div class="article-card__image">
                <?php the_post_thumbnail( 'medium_large', [ 'class' => 'article-card__thumb' ] ); ?>
            </div>
        <?php endif; ?>

        <div class="article-card__body">
            <span class="article-card__label">Статья</span>

            <h3 class="article-card__title"><?php the_title(); ?></h3>

            <?php if ( has_excerpt() || get_the_content() ) : ?>
                <p class="article-card__excerpt">
                    <?php echo esc_html( wp_trim_words( get_the_excerpt() ?: get_the_content(), 25, '...' ) ); ?>
                </p>
            <?php endif; ?>

            <span class="article-card__more">
                Читать далее
                <svg class="article-card__arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </span>
        </div>
    </a>
</article>
