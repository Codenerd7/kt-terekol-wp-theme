<?php
/**
 * Single Template: Report
 *
 * Страница отдельного отчёта: заголовок, изображение, аннотация, период, кнопка PDF.
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

get_header();

$period    = get_post_meta( get_the_ID(), 'kt_report_period', true );
$pdf_url   = get_post_meta( get_the_ID(), 'kt_report_pdf', true );
$has_thumb = has_post_thumbnail();
?>

<main id="main" class="site-main">
    <article class="section report-single">
        <div class="container container-narrow">

            <a href="<?php echo esc_url( get_post_type_archive_link( 'kt_report' ) ); ?>" class="report-single__back">
                &larr; Назад к отчётам
            </a>

            <header class="report-single__header">
                <h1 class="report-single__title"><?php the_title(); ?></h1>

                <?php if ( $period ) : ?>
                    <p class="report-single__period">
                        <strong>Период:</strong> <?php echo esc_html( $period ); ?>
                    </p>
                <?php endif; ?>
            </header>

            <?php if ( $has_thumb ) : ?>
                <figure class="report-single__image">
                    <?php the_post_thumbnail( 'large', [ 'class' => 'report-single__thumb' ] ); ?>
                </figure>
            <?php endif; ?>

            <?php if ( get_the_content() ) : ?>
                <div class="report-single__content">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>

            <?php if ( $pdf_url ) : ?>
                <div class="report-single__download">
                    <a href="<?php echo esc_url( $pdf_url ); ?>" class="btn btn--primary" target="_blank" rel="noopener noreferrer">
                        <svg class="btn__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20" aria-hidden="true">
                            <path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Скачать PDF
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </article>
</main>

<?php
get_footer();
