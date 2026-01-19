<?php
/**
 * Single Template: Product
 *
 * Страница отдельного кредитного продукта
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
?>

<main id="main" class="site-main">
    <article class="section product-single">
        <div class="container container-narrow">

            <div class="product-back">
                <a href="<?php echo esc_url( $back_url ); ?>">
                    &larr; Ко всем программам
                </a>
            </div>

            <header class="product-single__header">
                <h1 class="product-single__title"><?php the_title(); ?></h1>
            </header>

            <?php if ( has_post_thumbnail() ) : ?>
                <figure class="product-single__image">
                    <?php the_post_thumbnail( 'large', [ 'class' => 'product-single__thumb' ] ); ?>
                </figure>
            <?php endif; ?>

            <?php if ( get_the_content() ) : ?>
                <div class="product-single__content">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>

        </div>
    </article>
</main>

<?php
get_footer();
