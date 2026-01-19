<?php
/**
 * Template Name: Извещения
 * Template Post Type: page
 *
 * Страница списка извещений с группировкой по годам и месяцам (accordion)
 * URL: /izveshcheniya/
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$grouped_notices = kt_get_notices_grouped();
$months_list     = kt_get_months_list();
?>

<main class="site-main" id="main">
    <section class="notices-section">
        <div class="container">
            <header class="notices-section__header">
                <h1 class="notices-section__title"><?php the_title(); ?></h1>
                <?php if ( get_the_content() ) : ?>
                    <div class="notices-section__desc">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
            </header>

            <?php if ( ! empty( $grouped_notices ) ) : ?>
                <div class="notices-accordion">
                    <?php
                    $first_year = true;
                    foreach ( $grouped_notices as $year => $months ) :
                    ?>
                        <div class="notices-accordion__item<?php echo $first_year ? ' is-open' : ''; ?>">
                            <button class="notices-accordion__header" type="button" aria-expanded="<?php echo $first_year ? 'true' : 'false'; ?>">
                                <span class="notices-accordion__title">
                                    Извещения участникам ТОО "КТ Теренколь" <?php echo esc_html( $year ); ?> год
                                </span>
                                <span class="notices-accordion__icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </span>
                            </button>

                            <div class="notices-accordion__content">
                                <?php foreach ( $months as $month_num => $notices ) : ?>
                                    <div class="notices-month">
                                        <h3 class="notices-month__title">
                                            <?php echo esc_html( $months_list[ $month_num ] ?? '' ); ?>
                                        </h3>
                                        <ul class="notices-month__list">
                                            <?php foreach ( $notices as $notice ) :
                                                $notice_date = get_post_meta( $notice->ID, 'kt_notice_date', true );
                                                $formatted_date = $notice_date ? date_i18n( 'd.m.Y', strtotime( $notice_date ) ) : '';
                                            ?>
                                                <li class="notices-month__item">
                                                    <?php if ( $formatted_date ) : ?>
                                                        <span class="notices-month__date"><?php echo esc_html( $formatted_date ); ?></span>
                                                        <span class="notices-month__sep">—</span>
                                                    <?php endif; ?>
                                                    <a href="<?php echo esc_url( get_permalink( $notice->ID ) ); ?>" class="notices-month__link">
                                                        <?php echo esc_html( $notice->post_title ); ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php
                    $first_year = false;
                    endforeach;
                    ?>
                </div>
            <?php else : ?>
                <p class="notices-section__empty">Извещения пока не добавлены.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const accordionItems = document.querySelectorAll('.notices-accordion__item');

    accordionItems.forEach(function(item) {
        const header = item.querySelector('.notices-accordion__header');

        header.addEventListener('click', function() {
            const isOpen = item.classList.contains('is-open');

            // Закрыть все
            accordionItems.forEach(function(i) {
                i.classList.remove('is-open');
                i.querySelector('.notices-accordion__header').setAttribute('aria-expanded', 'false');
            });

            // Если не был открыт — открыть
            if (!isOpen) {
                item.classList.add('is-open');
                header.setAttribute('aria-expanded', 'true');
            }
        });
    });
});
</script>

<?php
get_footer();
