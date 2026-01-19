<?php
/**
 * Archive: Кредитные продукты
 *
 * Шаблон архива CPT product
 * URL: /products/
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main class="site-main" id="main">
    <section class="products-section">
        <div class="container">
            <header class="products-section__header">
                <h1 class="products-section__title">
                    <?php post_type_archive_title(); ?>
                </h1>
            </header>

            <?php if ( have_posts() ) : ?>
                <div class="products-list">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/product-card-row' );
                    endwhile;
                    ?>
                </div>

                <?php the_posts_pagination( [
                    'mid_size'  => 2,
                    'prev_text' => '←',
                    'next_text' => '→',
                ] ); ?>
            <?php else : ?>
                <p class="products-section__empty">Продукты пока не добавлены.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_footer();
