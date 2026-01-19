<?php
/**
 * Single Template: Product
 *
 * Страница отдельного кредитного продукта
 * Hero-обложка с featured image + заголовок overlay
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

get_header();

// Ссылка "назад ко всем программам"
$programs_page = get_page_by_path( 'programmy-kreditovaniya' );
$back_url = $programs_page
    ? get_permalink( $programs_page )
    : get_post_type_archive_link( 'product' );

$has_thumb = has_post_thumbnail();
$thumb_url = $has_thumb ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '';
?>

<main id="main" class="site-main">
    <article class="product-single">

        <?php if ( $has_thumb ) : ?>
            <!-- Hero с обложкой -->
            <section class="product-hero" style="background-image: url('<?php echo esc_url( $thumb_url ); ?>');">
                <div class="product-hero__overlay"></div>
                <div class="container">
                    <div class="product-back product-back--light">
                        <a href="<?php echo esc_url( $back_url ); ?>">
                            &larr; Ко всем программам
                        </a>
                    </div>
                    <h1 class="product-hero__title"><?php the_title(); ?></h1>
                </div>
            </section>
        <?php else : ?>
            <!-- Fallback: без обложки -->
            <section class="product-header">
                <div class="container">
                    <div class="product-back">
                        <a href="<?php echo esc_url( $back_url ); ?>">
                            &larr; Ко всем программам
                        </a>
                    </div>
                    <h1 class="product-header__title"><?php the_title(); ?></h1>
                </div>
            </section>
        <?php endif; ?>

        <!-- Контент -->
        <?php if ( get_the_content() ) : ?>
            <section class="product-content">
                <div class="container">
                    <?php the_content(); ?>
                </div>
            </section>
        <?php endif; ?>

    </article>
</main>

<?php
get_footer();
