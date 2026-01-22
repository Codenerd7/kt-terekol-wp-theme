<?php
/**
 * Category Template: Новости
 *
 * Архив записей из рубрики "Новости" (slug: news)
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
    <section class="archive-news">
        <div class="container">
            <header class="archive-news__header">
                <h1 class="archive-news__title">Новости</h1>
                <?php if ( category_description() ) : ?>
                    <div class="archive-news__description">
                        <?php echo category_description(); ?>
                    </div>
                <?php endif; ?>
            </header>

            <?php if ( have_posts() ) : ?>
                <div class="news-grid">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'template-parts/news-card' ); ?>
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
                <p class="archive-news__empty">Новостей пока нет.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_footer();
