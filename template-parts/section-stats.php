<?php
/**
 * Template Part: Stats Section
 *
 * Секция «Ключевые показатели ТОО „КТ Теренколь"»
 * Светлый дизайн, зелёные акценты, анимация цифр.
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Данные показателей (позже можно вынести в админку)
$stats = [
    [
        'value'  => 1425144733,
        'suffix' => '',
        'label'  => 'Тенге выдано',
        'icon'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="8" x2="20" y2="8"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="12" y1="8" x2="12" y2="22"/></svg>',
    ],
    [
        'value'  => 32,
        'suffix' => '',
        'label'  => 'Активных заёмщика',
        'icon'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
    ],
    [
        'value'  => 15,
        'suffix' => '',
        'label'  => 'Лет работы',
        'icon'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
    ],
    [
        'value'  => 649324000,
        'suffix' => '',
        'label'  => 'Кредитная линия',
        'icon'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>',
    ],
];
?>

<section class="kt-metrics">
    <div class="container">
        <header class="kt-metrics__header">
            <h2 class="kt-metrics__title">Ключевые показатели ТОО «КТ Теренколь»</h2>
            <p class="kt-metrics__subtitle">Кратко о масштабе работы и опыте кооператива</p>
        </header>

        <div class="kt-metrics__grid">
            <?php foreach ( $stats as $stat ) : ?>
                <article class="kt-metrics__card">
                    <div class="kt-metrics__icon">
                        <?php echo $stat['icon']; ?>
                    </div>
                    <div class="kt-metrics__value" data-count="<?php echo esc_attr( $stat['value'] ); ?>">
                        0
                    </div>
                    <div class="kt-metrics__label">
                        <?php echo esc_html( $stat['label'] ); ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
