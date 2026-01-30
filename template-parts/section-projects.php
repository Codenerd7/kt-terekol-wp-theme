<?php
/**
 * Секция "Наши проекты" для главной страницы
 *
 * Слайдер проектов:
 * - Фото: первое изображение галереи как превью, клик открывает lightbox-галерею
 * - Видео: превью с иконкой play, клик открывает видео в lightbox
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
                <?php
                $slide_index = 0;
                while ( $projects_query->have_posts() ) : $projects_query->the_post();
                    $media_type = get_post_meta( get_the_ID(), 'kt_project_media_type', true ) ?: 'photo';
                    $text       = get_post_meta( get_the_ID(), 'kt_project_text', true );
                    $title      = get_the_title();

                    // Пропускаем проекты без медиа
                    if ( $media_type === 'photo' ) {
                        $gallery = get_post_meta( get_the_ID(), 'kt_project_gallery', true );
                        if ( empty( $gallery ) || ! is_array( $gallery ) ) {
                            continue;
                        }
                    } else {
                        $video_url = get_post_meta( get_the_ID(), 'kt_project_video_url', true );
                        if ( empty( $video_url ) ) {
                            continue;
                        }
                    }

                    $gallery_id = 'project-' . get_the_ID();
                ?>
                <div class="swiper-slide">
                    <article class="project-card project-card--<?php echo esc_attr( $media_type ); ?>">
                        <?php if ( $media_type === 'photo' ) :
                            // Галерея фото
                            $first_image_id = $gallery[0];
                            $preview_url    = wp_get_attachment_image_url( $first_image_id, 'medium_large' );
                            $preview_alt    = get_post_meta( $first_image_id, '_wp_attachment_image_alt', true ) ?: $title;
                        ?>
                            <!-- Первое фото как превью (видимый слайд) -->
                            <a href="<?php echo esc_url( wp_get_attachment_image_url( $first_image_id, 'large' ) ); ?>"
                               class="project-card__link glightbox"
                               data-gallery="<?php echo esc_attr( $gallery_id ); ?>"
                               data-glightbox="title: <?php echo esc_attr( $title ); ?>">
                                <div class="project-card__image">
                                    <img src="<?php echo esc_url( $preview_url ); ?>"
                                         alt="<?php echo esc_attr( $preview_alt ); ?>"
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
                                    <?php if ( count( $gallery ) > 1 ) : ?>
                                    <span class="project-card__count"><?php echo count( $gallery ); ?> фото</span>
                                    <?php endif; ?>
                                </div>
                            </a>

                            <!-- Остальные фото галереи (скрытые, для lightbox) -->
                            <?php for ( $i = 1; $i < count( $gallery ); $i++ ) :
                                $img_id  = $gallery[ $i ];
                                $img_url = wp_get_attachment_image_url( $img_id, 'large' );
                                $img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true ) ?: $title;
                            ?>
                            <a href="<?php echo esc_url( $img_url ); ?>"
                               class="project-card__gallery-item glightbox"
                               data-gallery="<?php echo esc_attr( $gallery_id ); ?>"
                               data-glightbox="title: <?php echo esc_attr( $title ); ?>"
                               style="display: none;"></a>
                            <?php endfor; ?>

                        <?php else :
                            // Видео
                            $video_thumb = kt_get_video_thumbnail( $video_url );
                            $embed_url   = kt_get_video_embed_url( $video_url );
                        ?>
                            <a href="<?php echo esc_url( $embed_url ); ?>"
                               class="project-card__link glightbox"
                               data-gallery="<?php echo esc_attr( $gallery_id ); ?>"
                               data-glightbox="title: <?php echo esc_attr( $title ); ?>">
                                <div class="project-card__image">
                                    <?php if ( $video_thumb ) : ?>
                                    <img src="<?php echo esc_url( $video_thumb ); ?>"
                                         alt="<?php echo esc_attr( $title ); ?>"
                                         class="project-card__img"
                                         loading="lazy">
                                    <?php else : ?>
                                    <div class="project-card__video-placeholder"></div>
                                    <?php endif; ?>
                                    <div class="project-card__overlay project-card__overlay--video">
                                        <span class="project-card__play">
                                            <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        <?php endif; ?>

                        <?php if ( $text ) : ?>
                        <div class="project-card__body">
                            <h3 class="project-card__title"><?php echo esc_html( $title ); ?></h3>
                            <p class="project-card__text"><?php echo esc_html( $text ); ?></p>
                        </div>
                        <?php endif; ?>
                    </article>
                </div>
                <?php
                    $slide_index++;
                endwhile;
                ?>
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
