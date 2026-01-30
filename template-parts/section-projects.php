<?php
/**
 * Секция "Наши проекты" для главной страницы
 *
 * Слайдер с фото и описанием проектов.
 * При клике на слайд открывается lightbox с увеличенным фото.
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$projects_query = new WP_Query( [
    'post_type'      => 'kt_project',
    'posts_per_page' => 12,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order date',
    'order'          => 'ASC',
] );

// Не показываем секцию, если проектов нет
if ( ! $projects_query->have_posts() ) {
    return;
}
?>

<section class="section projects-section">
    <div class="container">
        <header class="projects-section__header">
            <div class="section-head">
                <p class="section-eyebrow">Достижения</p>
                <h2 class="projects-section__title section-title">Наши проекты</h2>
                <p class="section-subtitle">Успешно реализованные проекты при поддержке нашего кооператива.</p>
                <div class="section-divider" aria-hidden="true"></div>
            </div>
        </header>

        <div class="projects-slider swiper" id="projects-slider">
            <div class="swiper-wrapper">
                <?php while ( $projects_query->have_posts() ) : $projects_query->the_post();
                    $image_id = get_post_meta( get_the_ID(), 'kt_project_image_id', true );
                    $text     = get_post_meta( get_the_ID(), 'kt_project_text', true );

                    if ( ! $image_id ) {
                        continue;
                    }

                    $image_full   = wp_get_attachment_image_url( $image_id, 'large' );
                    $image_medium = wp_get_attachment_image_url( $image_id, 'medium_large' );
                    $image_alt    = get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ?: get_the_title();
                ?>
                <div class="swiper-slide">
                    <article class="project-card">
                        <a href="<?php echo esc_url( $image_full ); ?>"
                           class="project-card__link glightbox"
                           data-gallery="projects"
                           data-glightbox="title: <?php echo esc_attr( get_the_title() ); ?>">
                            <div class="project-card__image">
                                <img src="<?php echo esc_url( $image_medium ); ?>"
                                     alt="<?php echo esc_attr( $image_alt ); ?>"
                                     class="project-card__img"
                                     loading="lazy">
                                <div class="project-card__overlay">
                                    <span class="project-card__zoom">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <path d="m21 21-4.35-4.35"></path>
                                            <path d="M11 8v6"></path>
                                            <path d="M8 11h6"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                        <?php if ( $text ) : ?>
                        <div class="project-card__body">
                            <h3 class="project-card__title"><?php the_title(); ?></h3>
                            <p class="project-card__text"><?php echo esc_html( $text ); ?></p>
                        </div>
                        <?php endif; ?>
                    </article>
                </div>
                <?php endwhile; ?>
            </div>

            <!-- Navigation -->
            <div class="projects-slider__nav">
                <button class="projects-slider__btn projects-slider__btn--prev" aria-label="Предыдущий проект">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                </button>
                <button class="projects-slider__btn projects-slider__btn--next" aria-label="Следующий проект">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </button>
            </div>

            <!-- Pagination -->
            <div class="projects-slider__pagination swiper-pagination"></div>
        </div>
    </div>
</section>

<?php
wp_reset_postdata();
