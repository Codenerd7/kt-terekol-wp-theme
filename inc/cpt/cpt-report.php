<?php
/**
 * Custom Post Type: Отчёты (kt_report)
 *
 * Регистрация типа записи для публикации отчётов и документов.
 * Примеры: годовые отчёты, финансовая отчётность, аудиторские заключения.
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Регистрация CPT "kt_report"
 */
function kt_register_report_post_type() {

    $labels = [
        'name'               => 'Отчёты',
        'singular_name'      => 'Отчёт',
        'menu_name'          => 'Отчёты',
        'add_new'            => 'Добавить отчёт',
        'add_new_item'       => 'Добавить новый отчёт',
        'edit_item'          => 'Редактировать отчёт',
        'new_item'           => 'Новый отчёт',
        'view_item'          => 'Просмотреть отчёт',
        'search_items'       => 'Найти отчёт',
        'not_found'          => 'Отчёты не найдены',
        'not_found_in_trash' => 'В корзине отчётов нет',
        'all_items'          => 'Все отчёты',
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => [
            'slug'       => 'reports',
            'with_front' => false,
        ],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 7,
        'menu_icon'          => 'dashicons-media-document',
        'supports'           => [
            'title',
            'editor',
            'thumbnail',
            'excerpt',
        ],
    ];

    register_post_type( 'kt_report', $args );
}
add_action( 'init', 'kt_register_report_post_type' );

/**
 * Регистрация таксономии "Типы отчётов"
 */
function kt_register_report_taxonomy() {

    $labels = [
        'name'              => 'Типы отчётов',
        'singular_name'     => 'Тип отчёта',
        'search_items'      => 'Найти тип',
        'all_items'         => 'Все типы',
        'parent_item'       => 'Родительский тип',
        'parent_item_colon' => 'Родительский тип:',
        'edit_item'         => 'Редактировать тип',
        'update_item'       => 'Обновить тип',
        'add_new_item'      => 'Добавить тип',
        'new_item_name'     => 'Название нового типа',
        'menu_name'         => 'Типы отчётов',
    ];

    $args = [
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'rewrite'           => [
            'slug'       => 'report-type',
            'with_front' => false,
        ],
    ];

    register_taxonomy( 'report_type', 'kt_report', $args );
}
add_action( 'init', 'kt_register_report_taxonomy' );

/**
 * Metabox: Параметры отчёта (период, PDF)
 */
add_action( 'add_meta_boxes', 'kt_add_report_metaboxes' );

function kt_add_report_metaboxes(): void {
    add_meta_box(
        'kt_report_details',
        'Параметры отчёта',
        'kt_render_report_details_metabox',
        'kt_report',
        'side',
        'default'
    );
}

function kt_render_report_details_metabox( $post ): void {
    $period = get_post_meta( $post->ID, 'kt_report_period', true );
    $pdf    = get_post_meta( $post->ID, 'kt_report_pdf', true );

    wp_nonce_field( 'kt_report_metabox', 'kt_report_nonce' );
    ?>
    <p>
        <label for="kt_report_period"><strong>Период отчётности</strong></label><br>
        <input
            type="text"
            id="kt_report_period"
            name="kt_report_period"
            value="<?php echo esc_attr( $period ); ?>"
            class="widefat"
            placeholder="Например: 2024, I квартал 2025"
        >
    </p>
    <p>
        <label for="kt_report_pdf"><strong>Ссылка на PDF</strong></label><br>
        <input
            type="url"
            id="kt_report_pdf"
            name="kt_report_pdf"
            value="<?php echo esc_url( $pdf ); ?>"
            class="widefat"
            placeholder="https://..."
        >
        <span class="description">URL файла PDF или ссылка из медиабиблиотеки</span>
    </p>
    <?php
}

/**
 * Сохранение метаполей отчёта
 */
add_action( 'save_post_kt_report', 'kt_save_report_meta' );

function kt_save_report_meta( $post_id ): void {
    // Проверка nonce
    if ( ! isset( $_POST['kt_report_nonce'] ) || ! wp_verify_nonce( $_POST['kt_report_nonce'], 'kt_report_metabox' ) ) {
        return;
    }

    // Проверка автосохранения
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Проверка прав
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Сохранение периода
    if ( isset( $_POST['kt_report_period'] ) ) {
        update_post_meta( $post_id, 'kt_report_period', sanitize_text_field( $_POST['kt_report_period'] ) );
    }

    // Сохранение PDF URL
    if ( isset( $_POST['kt_report_pdf'] ) ) {
        update_post_meta( $post_id, 'kt_report_pdf', esc_url_raw( $_POST['kt_report_pdf'] ) );
    }
}

/**
 * Колонки в админке для kt_report
 */
add_filter( 'manage_kt_report_posts_columns', 'kt_report_admin_columns' );

function kt_report_admin_columns( $columns ) {
    $new_columns = [];

    foreach ( $columns as $key => $value ) {
        $new_columns[ $key ] = $value;

        if ( $key === 'title' ) {
            $new_columns['kt_report_period'] = 'Период';
            $new_columns['kt_report_pdf']    = 'PDF';
        }
    }

    return $new_columns;
}

add_action( 'manage_kt_report_posts_custom_column', 'kt_report_admin_column_content', 10, 2 );

function kt_report_admin_column_content( $column, $post_id ): void {
    if ( $column === 'kt_report_period' ) {
        $period = get_post_meta( $post_id, 'kt_report_period', true );
        echo $period ? esc_html( $period ) : '—';
    }

    if ( $column === 'kt_report_pdf' ) {
        $pdf = get_post_meta( $post_id, 'kt_report_pdf', true );
        if ( $pdf ) {
            echo '<a href="' . esc_url( $pdf ) . '" target="_blank">Скачать</a>';
        } else {
            echo '—';
        }
    }
}
