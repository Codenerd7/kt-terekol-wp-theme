<?php
/**
 * Шаблон стандартной страницы
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<section class="page-content section">
    <div class="container container--narrow">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <h1 class="page-content__title"><?php the_title(); ?></h1>
            <div class="page-content__body">
                <?php the_content(); ?>
            </div>
            <?php
        endwhile;
        ?>
    </div>
</section>

<?php
get_footer();
