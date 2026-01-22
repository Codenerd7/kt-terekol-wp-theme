<?php
/**
 * Category Template: Статьи
 *
 * Архив записей из рубрики "Статьи" (slug: articles)
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main" class="site-main">
    <section class="archive-articles">
        <div class="container">
            <header class="archive-articles__header">
                <h1 class="archive-articles__title">Статьи</h1>
                <?php if ( category_description() ) : ?>
                    <div class="archive-articles__description">
                        <?php echo category_description(); ?>
                    </div>
                <?php endif; ?>
            </header>

            <?php if ( have_posts() ) : ?>
                <div class="articles-grid">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'template-parts/article-card' ); ?>
                    <?php endwhile; ?>
                </div>

                <?php
                the_posts_pagination( [
                    'mid_size'  => 2,
                    'prev_text' => '&larr; Назад',
                    'next_text' => 'Вперёд &rarr;',
                ] );
                ?>
            <?php else : ?>
                <p class="archive-articles__empty">Статей пока нет.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_footer();
