<?php
/**
 * Single Post Template
 *
 * Страница одной записи (новости/статьи)
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Определяем рубрику для классов
$is_news    = has_category( 'news' );
$is_article = has_category( 'articles' );
$post_class = $is_news ? 'is-news' : ( $is_article ? 'is-article' : '' );

// Ссылка "назад"
if ( $is_news ) {
    $back_url  = get_category_link( get_category_by_slug( 'news' ) );
    $back_text = 'Все новости';
} elseif ( $is_article ) {
    $back_url  = get_category_link( get_category_by_slug( 'articles' ) );
    $back_text = 'Все статьи';
} else {
    $back_url  = home_url( '/' );
    $back_text = 'На главную';
}
?>

<main id="main" class="site-main">
    <article class="post-single <?php echo esc_attr( $post_class ); ?>">
        <div class="container container--narrow">

            <div class="post-single__back">
                <a href="<?php echo esc_url( $back_url ); ?>">
                    &larr; <?php echo esc_html( $back_text ); ?>
                </a>
            </div>

            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                <?php if ( has_post_thumbnail() ) : ?>
                    <figure class="post-single__thumbnail">
                        <?php the_post_thumbnail( 'large', [ 'class' => 'post-single__image' ] ); ?>
                    </figure>
                <?php endif; ?>

                <header class="post-single__header">
                    <?php if ( $is_article ) : ?>
                        <span class="post-single__label">Статья</span>
                    <?php endif; ?>

                    <h1 class="post-single__title"><?php the_title(); ?></h1>

                    <div class="post-single__meta">
                        <time class="post-single__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                            <?php echo esc_html( get_the_date( 'd.m.Y' ) ); ?>
                        </time>

                        <?php if ( $is_news ) : ?>
                            <span class="post-single__views">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <?php echo esc_html( kt_get_post_views() ); ?> просмотров
                            </span>
                        <?php endif; ?>
                    </div>
                </header>

                <div class="post-single__content">
                    <?php the_content(); ?>
                </div>

            <?php endwhile; endif; ?>

        </div>
    </article>
</main>

<?php
get_footer();
