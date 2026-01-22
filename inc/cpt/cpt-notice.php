<?php
/**
 * Custom Post Type: Извещения
 *
 * Извещения участникам ТОО "КТ Теренколь"
 * с группировкой по годам и месяцам
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Регистрация CPT "kt_notice"
 */
function kt_register_notice_post_type() {

    $labels = [
        'name'               => 'Извещения',
        'singular_name'      => 'Извещение',
        'menu_name'          => 'Извещения',
        'add_new'            => 'Добавить извещение',
        'add_new_item'       => 'Добавить новое извещение',
        'edit_item'          => 'Редактировать извещение',
        'new_item'           => 'Новое извещение',
        'view_item'          => 'Просмотреть извещение',
        'search_items'       => 'Найти извещение',
        'not_found'          => 'Извещения не найдены',
        'not_found_in_trash' => 'В корзине извещений нет',
        'all_items'          => 'Все извещения',
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
            'slug'       => 'notices',
            'with_front' => false,
        ],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-megaphone',
        'supports'           => [
            'title',
            'editor',
        ],
    ];

    register_post_type( 'kt_notice', $args );
}
add_action( 'init', 'kt_register_notice_post_type' );

/**
 * Месяцы для выпадающего списка
 */
function kt_get_months_list() {
    return [
        '01' => 'Январь',
        '02' => 'Февраль',
        '03' => 'Март',
        '04' => 'Апрель',
        '05' => 'Май',
        '06' => 'Июнь',
        '07' => 'Июль',
        '08' => 'Август',
        '09' => 'Сентябрь',
        '10' => 'Октябрь',
        '11' => 'Ноябрь',
        '12' => 'Декабрь',
    ];
}

/**
 * Месяц в родительном падеже (для заголовков)
 */
function kt_get_month_genitive( $month_num ) {
    $months = [
        '01' => 'январь',
        '02' => 'февраль',
        '03' => 'март',
        '04' => 'апрель',
        '05' => 'май',
        '06' => 'июнь',
        '07' => 'июль',
        '08' => 'август',
        '09' => 'сентябрь',
        '10' => 'октябрь',
        '11' => 'ноябрь',
        '12' => 'декабрь',
    ];
    return $months[ $month_num ] ?? '';
}

/**
 * Добавление метабоксов
 */
function kt_add_notice_metaboxes() {
    add_meta_box(
        'kt_notice_details',
        'Параметры извещения',
        'kt_render_notice_metabox',
        'kt_notice',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'kt_add_notice_metaboxes' );

/**
 * Рендер метабокса
 */
function kt_render_notice_metabox( $post ) {
    wp_nonce_field( 'kt_notice_meta', 'kt_notice_nonce' );

    $organization  = get_post_meta( $post->ID, 'kt_notice_organization', true ) ?: 'ТОО "КТ Теренколь"';
    $notice_date   = get_post_meta( $post->ID, 'kt_notice_date', true );
    $notice_year   = get_post_meta( $post->ID, 'kt_notice_year', true );
    $notice_month  = get_post_meta( $post->ID, 'kt_notice_month', true );
    $notice_file   = get_post_meta( $post->ID, 'kt_notice_file', true );
    $auto_title    = get_post_meta( $post->ID, 'kt_notice_auto_title', true );

    $months = kt_get_months_list();
    $current_year = (int) date( 'Y' );
    ?>

    <style>
        .kt-notice-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .kt-notice-fields .kt-field { display: flex; flex-direction: column; gap: 6px; }
        .kt-notice-fields .kt-field.full-width { grid-column: 1 / -1; }
        .kt-notice-fields label { font-weight: 600; }
        .kt-notice-fields input[type="text"],
        .kt-notice-fields input[type="date"],
        .kt-notice-fields input[type="number"],
        .kt-notice-fields select { width: 100%; padding: 8px; }
        .kt-file-field { display: flex; gap: 10px; align-items: center; }
        .kt-file-field input { flex: 1; }
        .kt-file-preview { margin-top: 8px; }
        .kt-file-preview a { color: #0073aa; }
    </style>

    <div class="kt-notice-fields">
        <div class="kt-field full-width">
            <label for="kt_notice_organization">Организация</label>
            <input type="text" id="kt_notice_organization" name="kt_notice_organization"
                   value="<?php echo esc_attr( $organization ); ?>">
        </div>

        <div class="kt-field">
            <label for="kt_notice_year">Год *</label>
            <select id="kt_notice_year" name="kt_notice_year" required>
                <option value="">— Выберите год —</option>
                <?php for ( $y = $current_year; $y >= 2015; $y-- ) : ?>
                    <option value="<?php echo $y; ?>" <?php selected( $notice_year, $y ); ?>>
                        <?php echo $y; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="kt-field">
            <label for="kt_notice_month">Месяц *</label>
            <select id="kt_notice_month" name="kt_notice_month" required>
                <option value="">— Выберите месяц —</option>
                <?php foreach ( $months as $num => $name ) : ?>
                    <option value="<?php echo $num; ?>" <?php selected( $notice_month, $num ); ?>>
                        <?php echo esc_html( $name ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="kt-field">
            <label for="kt_notice_date">Дата извещения</label>
            <input type="date" id="kt_notice_date" name="kt_notice_date"
                   value="<?php echo esc_attr( $notice_date ); ?>">
            <small style="color: #666;">Отображается рядом с ссылкой в списке</small>
        </div>

        <div class="kt-field">
            <label>
                <input type="checkbox" name="kt_notice_auto_title" value="1"
                       <?php checked( $auto_title, '1' ); ?>>
                Автозаполнение заголовка
            </label>
            <small style="color: #666;">Заголовок будет сформирован автоматически при сохранении</small>
        </div>

        <div class="kt-field full-width">
            <label for="kt_notice_file">Файл извещения (PDF, DOC)</label>
            <div class="kt-file-field">
                <input type="text" id="kt_notice_file" name="kt_notice_file"
                       value="<?php echo esc_url( $notice_file ); ?>" placeholder="URL файла">
                <button type="button" class="button" id="kt_notice_file_btn">Выбрать файл</button>
            </div>
            <?php if ( $notice_file ) : ?>
                <div class="kt-file-preview">
                    <a href="<?php echo esc_url( $notice_file ); ?>" target="_blank">
                        <?php echo esc_html( basename( $notice_file ) ); ?>
                    </a>
                </div>
            <?php endif; ?>
            <small style="color: #666; margin-top: 6px; display: block;">
                💡 Файл заполняется автоматически при вставке PDF через блок «Файл» в редакторе.
            </small>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('#kt_notice_file_btn').on('click', function(e) {
            e.preventDefault();
            var frame = wp.media({
                title: 'Выберите файл извещения',
                button: { text: 'Выбрать' },
                multiple: false
            });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#kt_notice_file').val(attachment.url);
            });
            frame.open();
        });
    });
    </script>
    <?php
}

/**
 * Сохранение метаполей
 */
function kt_save_notice_meta( $post_id ) {
    // Проверки
    if ( ! isset( $_POST['kt_notice_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['kt_notice_nonce'], 'kt_notice_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Сохранение полей
    $fields = [ 'kt_notice_organization', 'kt_notice_date', 'kt_notice_year', 'kt_notice_month' ];

    foreach ( $fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
        }
    }

    // Файл: не затираем если в POST пусто (мог быть заполнен автоматически)
    if ( ! empty( $_POST['kt_notice_file'] ) ) {
        update_post_meta( $post_id, 'kt_notice_file', esc_url_raw( $_POST['kt_notice_file'] ) );
    }

    // Автозаполнение заголовка
    $auto_title = isset( $_POST['kt_notice_auto_title'] ) ? '1' : '0';
    update_post_meta( $post_id, 'kt_notice_auto_title', $auto_title );

    if ( $auto_title === '1' ) {
        $organization = sanitize_text_field( $_POST['kt_notice_organization'] ?? 'ТОО "КТ Теренколь"' );
        $year         = sanitize_text_field( $_POST['kt_notice_year'] ?? '' );
        $month        = sanitize_text_field( $_POST['kt_notice_month'] ?? '' );

        if ( $year && $month ) {
            $month_name = kt_get_month_genitive( $month );
            $new_title  = sprintf( 'Извещение участникам %s %s %s', $organization, $month_name, $year );

            // Обновляем заголовок
            remove_action( 'save_post', 'kt_save_notice_meta' );
            wp_update_post( [
                'ID'         => $post_id,
                'post_title' => $new_title,
            ] );
            add_action( 'save_post', 'kt_save_notice_meta' );
        }
    }
}
add_action( 'save_post_kt_notice', 'kt_save_notice_meta' );

/**
 * Колонки в админке
 */
function kt_notice_admin_columns( $columns ) {
    $new_columns = [];
    foreach ( $columns as $key => $value ) {
        $new_columns[ $key ] = $value;
        if ( $key === 'title' ) {
            $new_columns['notice_year']  = 'Год';
            $new_columns['notice_month'] = 'Месяц';
            $new_columns['notice_date']  = 'Дата извещения';
            $new_columns['notice_views'] = 'Просмотры';
        }
    }
    return $new_columns;
}
add_filter( 'manage_kt_notice_posts_columns', 'kt_notice_admin_columns' );

/**
 * Содержимое колонок
 */
function kt_notice_admin_columns_content( $column, $post_id ) {
    switch ( $column ) {
        case 'notice_year':
            echo esc_html( get_post_meta( $post_id, 'kt_notice_year', true ) );
            break;
        case 'notice_month':
            $month = get_post_meta( $post_id, 'kt_notice_month', true );
            $months = kt_get_months_list();
            echo esc_html( $months[ $month ] ?? '' );
            break;
        case 'notice_date':
            $date = get_post_meta( $post_id, 'kt_notice_date', true );
            if ( $date ) {
                echo esc_html( date_i18n( 'd.m.Y', strtotime( $date ) ) );
            }
            break;
        case 'notice_views':
            echo (int) get_post_meta( $post_id, 'kt_notice_views', true );
            break;
    }
}
add_action( 'manage_kt_notice_posts_custom_column', 'kt_notice_admin_columns_content', 10, 2 );

/**
 * Сортировка по году
 */
function kt_notice_sortable_columns( $columns ) {
    $columns['notice_year']  = 'notice_year';
    $columns['notice_month'] = 'notice_month';
    return $columns;
}
add_filter( 'manage_edit-kt_notice_sortable_columns', 'kt_notice_sortable_columns' );

/**
 * Счётчик просмотров
 */
function kt_increment_notice_views() {
    if ( is_singular( 'kt_notice' ) && ! is_admin() ) {
        $post_id = get_the_ID();
        $views   = (int) get_post_meta( $post_id, 'kt_notice_views', true );
        update_post_meta( $post_id, 'kt_notice_views', $views + 1 );
    }
}
add_action( 'wp_head', 'kt_increment_notice_views' );

/**
 * Получить просмотры извещения
 */
function kt_get_notice_views( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    return (int) get_post_meta( $post_id, 'kt_notice_views', true );
}

/**
 * Автоперенос PDF из блока core/file в мета-поле
 *
 * При сохранении извещения:
 * 1. Находит первый блок core/file в контенте
 * 2. Извлекает URL файла
 * 3. Сохраняет в мета-поле kt_notice_file
 *
 * Используем wp_after_insert_post — работает и с Gutenberg (REST API)
 */
function kt_auto_extract_file_from_content( $post_id, $post, $update ) {
    // Только для kt_notice
    if ( ! $post || $post->post_type !== 'kt_notice' ) {
        return;
    }

    // Не обрабатываем ревизии
    if ( wp_is_post_revision( $post_id ) ) {
        return;
    }

    // Только для опубликованных и черновиков
    if ( ! in_array( $post->post_status, [ 'publish', 'draft', 'pending' ], true ) ) {
        return;
    }

    // Парсим блоки
    $blocks = parse_blocks( $post->post_content );
    if ( empty( $blocks ) ) {
        return;
    }

    // Ищем первый блок core/file и извлекаем URL
    $file_url = '';

    foreach ( $blocks as $block ) {
        if ( $block['blockName'] === 'core/file' ) {
            // Способ 1: из атрибутов
            if ( ! empty( $block['attrs']['href'] ) ) {
                $file_url = $block['attrs']['href'];
            }
            // Способ 2: по attachment ID
            elseif ( ! empty( $block['attrs']['id'] ) ) {
                $file_url = wp_get_attachment_url( $block['attrs']['id'] );
            }
            // Способ 3: из innerHTML (регуляркой)
            elseif ( ! empty( $block['innerHTML'] ) ) {
                if ( preg_match( '/href=["\']([^"\']+)["\']/', $block['innerHTML'], $matches ) ) {
                    $file_url = $matches[1];
                }
            }
            break; // Берём только первый блок
        }
    }

    // Сохраняем URL в мета-поле
    if ( $file_url ) {
        update_post_meta( $post_id, 'kt_notice_file', esc_url_raw( $file_url ) );
    }
}
add_action( 'wp_after_insert_post', 'kt_auto_extract_file_from_content', 20, 3 );

/**
 * Скрытие ссылок в блоке core/file на странице извещения
 *
 * Превью PDF остаётся, убираются:
 * - текстовая ссылка с названием файла
 * - кнопка "Скачать"
 * Чтобы не дублировать кастомную кнопку "Скачать извещение"
 */
function kt_hide_file_button_on_notice( $block_content, $block ) {
    if ( is_singular( 'kt_notice' ) && $block['blockName'] === 'core/file' ) {
        // Убираем все ссылки <a> внутри блока, оставляем только <object> с превью
        $block_content = preg_replace(
            '/<a[^>]*>.*?<\/a>/s',
            '',
            $block_content
        );
    }
    return $block_content;
}
add_filter( 'render_block', 'kt_hide_file_button_on_notice', 10, 2 );

/**
 * Получить извещения сгруппированные по годам и месяцам
 */
function kt_get_notices_grouped() {
    $notices = get_posts( [
        'post_type'      => 'kt_notice',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_key'       => 'kt_notice_year',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
    ] );

    $grouped = [];

    foreach ( $notices as $notice ) {
        $year  = get_post_meta( $notice->ID, 'kt_notice_year', true );
        $month = get_post_meta( $notice->ID, 'kt_notice_month', true );

        if ( ! $year || ! $month ) {
            continue;
        }

        if ( ! isset( $grouped[ $year ] ) ) {
            $grouped[ $year ] = [];
        }

        if ( ! isset( $grouped[ $year ][ $month ] ) ) {
            $grouped[ $year ][ $month ] = [];
        }

        $grouped[ $year ][ $month ][] = $notice;
    }

    // Сортировка годов по убыванию
    krsort( $grouped );

    // Сортировка месяцев внутри каждого года
    foreach ( $grouped as $year => &$months ) {
        krsort( $months );
    }

    return $grouped;
}
