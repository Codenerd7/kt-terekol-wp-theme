<?php
/**
 * Template Part: Report Card
 *
 * Компонент карточки отчёта для архива и главной страницы.
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$period    = get_post_meta( get_the_ID(), 'kt_report_period', true );
$pdf_url   = get_post_meta( get_the_ID(), 'kt_report_pdf', true );
$has_thumb = has_post_thumbnail();
?>

<article class="report-card">
    <a href="<?php the_permalink(); ?>" class="report-card__link">
        <div class="report-card__image">
            <?php if ( $has_thumb ) : ?>
                <?php the_post_thumbnail( 'medium', [ 'class' => 'report-card__thumb' ] ); ?>
            <?php else : ?>
                <div class="report-card__placeholder">
                    <svg class="report-card__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            <?php endif; ?>
        </div>

        <div class="report-card__body">
            <h3 class="report-card__title"><?php the_title(); ?></h3>

            <?php if ( $period ) : ?>
                <p class="report-card__period"><?php echo esc_html( $period ); ?></p>
            <?php endif; ?>
        </div>
    </a>
</article>
