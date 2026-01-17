<?php
/**
 * Archive Template: Reports
 *
 * Шаблон архива отчётов — сетка карточек с пагинацией.
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

get_header();
?>

<main id="main" class="site-main">
    <section class="section reports-archive">
        <div class="container">
            <header class="reports-archive__header">
                <h1 class="reports-archive__title">Отчёты</h1>
                <p class="reports-archive__description">Официальная отчётность и документы компании</p>
            </header>

            <?php if ( have_posts() ) : ?>
                <div class="reports-grid">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'template-parts/report-card' ); ?>
                    <?php endwhile; ?>
                </div>

                <?php
                // Пагинация
                the_posts_pagination( [
                    'mid_size'  => 2,
                    'prev_text' => '&larr; Назад',
                    'next_text' => 'Далее &rarr;',
                    'class'     => 'reports-pagination',
                ] );
                ?>

            <?php else : ?>
                <div class="reports-archive__empty">
                    <p>Отчёты пока не опубликованы.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_footer();
