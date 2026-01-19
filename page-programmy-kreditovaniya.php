<?php
/**
 * Template Name: Программы кредитования
 * Template Post Type: page
 *
 * Витрина кредитных продуктов (CPT product)
 * URL: /programmy-kreditovaniya/
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
                <h1 class="products-section__title"><?php the_title(); ?></h1>
                <?php if ( get_the_content() ) : ?>
                    <div class="products-section__desc">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
            </header>

            <?php
            $products = new WP_Query( [
                'post_type'      => 'product',
                'posts_per_page' => -1,
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
            ] );

            if ( $products->have_posts() ) :
            ?>
                <div class="products-list">
                    <?php
                    while ( $products->have_posts() ) :
                        $products->the_post();
                        get_template_part( 'template-parts/product-card-row' );
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            <?php else : ?>
                <p class="products-section__empty">Продукты пока не добавлены.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_footer();
