<?php
/**
 * Template Part: Карточка продукта (горизонтальная)
 *
 * Используется на странице /programmy-kreditovaniya/ и в archive-product.php
 * Разметка: картинка слева, текст справа (на мобилке — столбиком)
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<article <?php post_class( 'product-card' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="product-card__image">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'medium_large' ); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="product-card__content">
        <h3 class="product-card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <?php if ( has_excerpt() ) : ?>
            <div class="product-card__excerpt">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>

        <a href="<?php the_permalink(); ?>" class="product-card__link">
            Подробнее <span class="product-card__arrow">→</span>
        </a>
    </div>
</article>
