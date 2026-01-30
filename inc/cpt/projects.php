<?php
/**
 * Custom Post Type: Наши проекты (kt_project)
 *
 * Регистрация типа записи для проектов.
 * Только 2 поля: фото и текст (через мета-боксы).
 * Без архива, без single page.
 *
 * @package KT_Terekol
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Регистрация CPT "kt_project"
 */
function kt_register_project_post_type() {

    $labels = [
        'name'               => 'Наши проекты',
        'singular_name'      => 'Проект',
        'menu_name'          => 'Наши проекты',
        'add_new'            => 'Добавить проект',
        'add_new_item'       => 'Добавить новый проект',
        'edit_item'          => 'Редактировать проект',
        'new_item'           => 'Новый проект',
        'view_item'          => 'Просмотреть проект',
        'search_items'       => 'Найти проект',
        'not_found'          => 'Проекты не найдены',
        'not_found_in_trash' => 'В корзине проектов нет',
        'all_items'          => 'Все проекты',
    ];

    $args = [
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => false, // Отключаем single page
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => false, // Без Gutenberg
        'query_var'           => false,
        'rewrite'             => false, // Без URL
        'capability_type'     => 'post',
        'has_archive'         => false, // Без архива
        'hierarchical'        => false,
        'menu_position'       => 8,
        'menu_icon'           => 'dashicons-images-alt2',
        'supports'            => [ 'title' ], // Только заголовок
    ];

    register_post_type( 'kt_project', $args );
}
add_action( 'init', 'kt_register_project_post_type' );

/**
 * Добавление мета-боксов для kt_project
 */
add_action( 'add_meta_boxes', 'kt_add_project_metaboxes' );

function kt_add_project_metaboxes(): void {
    // Мета-бокс для фото
    add_meta_box(
        'kt_project_image',
        'Фото проекта',
        'kt_render_project_image_metabox',
        'kt_project',
        'normal',
        'high'
    );

    // Мета-бокс для текста
    add_meta_box(
        'kt_project_text',
        'Описание проекта',
        'kt_render_project_text_metabox',
        'kt_project',
        'normal',
        'high'
    );
}

/**
 * Рендер мета-бокса "Фото проекта"
 */
function kt_render_project_image_metabox( $post ): void {
    $image_id = get_post_meta( $post->ID, 'kt_project_image_id', true );
    $image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : '';

    wp_nonce_field( 'kt_project_metabox', 'kt_project_nonce' );
    ?>
    <div class="kt-project-image-wrapper">
        <div class="kt-project-image-preview" id="kt-project-image-preview" style="margin-bottom: 10px; <?php echo $image_url ? '' : 'display:none;'; ?>">
            <img src="<?php echo esc_url( $image_url ); ?>" style="max-width: 300px; height: auto; border-radius: 4px;">
        </div>
        <input type="hidden" id="kt_project_image_id" name="kt_project_image_id" value="<?php echo esc_attr( $image_id ); ?>">
        <button type="button" class="button" id="kt-project-image-upload">
            <?php echo $image_id ? 'Изменить фото' : 'Выбрать фото'; ?>
        </button>
        <button type="button" class="button" id="kt-project-image-remove" style="<?php echo $image_id ? '' : 'display:none;'; ?>">
            Удалить фото
        </button>
    </div>

    <script>
    jQuery(document).ready(function($) {
        var frame;

        $('#kt-project-image-upload').on('click', function(e) {
            e.preventDefault();

            if (frame) {
                frame.open();
                return;
            }

            frame = wp.media({
                title: 'Выберите фото проекта',
                button: { text: 'Использовать это фото' },
                multiple: false
            });

            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#kt_project_image_id').val(attachment.id);

                var imgUrl = attachment.sizes && attachment.sizes.medium
                    ? attachment.sizes.medium.url
                    : attachment.url;

                $('#kt-project-image-preview').show().find('img').attr('src', imgUrl);
                $('#kt-project-image-upload').text('Изменить фото');
                $('#kt-project-image-remove').show();
            });

            frame.open();
        });

        $('#kt-project-image-remove').on('click', function(e) {
            e.preventDefault();
            $('#kt_project_image_id').val('');
            $('#kt-project-image-preview').hide().find('img').attr('src', '');
            $('#kt-project-image-upload').text('Выбрать фото');
            $(this).hide();
        });
    });
    </script>
    <?php
}

/**
 * Рендер мета-бокса "Описание проекта"
 */
function kt_render_project_text_metabox( $post ): void {
    $text = get_post_meta( $post->ID, 'kt_project_text', true );
    ?>
    <textarea
        id="kt_project_text"
        name="kt_project_text"
        rows="6"
        class="widefat"
        placeholder="Введите описание проекта..."
    ><?php echo esc_textarea( $text ); ?></textarea>
    <p class="description">Краткое описание проекта, которое будет отображаться в слайдере на главной странице.</p>
    <?php
}

/**
 * Сохранение метаполей проекта
 */
add_action( 'save_post_kt_project', 'kt_save_project_meta' );

function kt_save_project_meta( $post_id ): void {
    // Проверка nonce
    if ( ! isset( $_POST['kt_project_nonce'] ) || ! wp_verify_nonce( $_POST['kt_project_nonce'], 'kt_project_metabox' ) ) {
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

    // Сохранение ID изображения
    if ( isset( $_POST['kt_project_image_id'] ) ) {
        $image_id = absint( $_POST['kt_project_image_id'] );
        if ( $image_id ) {
            update_post_meta( $post_id, 'kt_project_image_id', $image_id );
        } else {
            delete_post_meta( $post_id, 'kt_project_image_id' );
        }
    }

    // Сохранение текста
    if ( isset( $_POST['kt_project_text'] ) ) {
        update_post_meta( $post_id, 'kt_project_text', sanitize_textarea_field( $_POST['kt_project_text'] ) );
    }
}

/**
 * Подключение медиа-загрузчика в админке для kt_project
 */
add_action( 'admin_enqueue_scripts', 'kt_project_admin_scripts' );

function kt_project_admin_scripts( $hook ): void {
    global $post_type;

    if ( ( $hook === 'post.php' || $hook === 'post-new.php' ) && $post_type === 'kt_project' ) {
        wp_enqueue_media();
    }
}

/**
 * Колонки в админке для kt_project
 */
add_filter( 'manage_kt_project_posts_columns', 'kt_project_admin_columns' );

function kt_project_admin_columns( $columns ) {
    $new_columns = [];

    foreach ( $columns as $key => $value ) {
        if ( $key === 'title' ) {
            $new_columns['kt_project_thumb'] = 'Фото';
        }
        $new_columns[ $key ] = $value;
    }

    return $new_columns;
}

add_action( 'manage_kt_project_posts_custom_column', 'kt_project_admin_column_content', 10, 2 );

function kt_project_admin_column_content( $column, $post_id ): void {
    if ( $column === 'kt_project_thumb' ) {
        $image_id = get_post_meta( $post_id, 'kt_project_image_id', true );
        if ( $image_id ) {
            $img = wp_get_attachment_image( $image_id, [ 60, 60 ], false, [ 'style' => 'border-radius: 4px;' ] );
            echo $img;
        } else {
            echo '<span style="color: #999;">—</span>';
        }
    }
}

/**
 * Стили для колонки с миниатюрой
 */
add_action( 'admin_head', 'kt_project_admin_column_styles' );

function kt_project_admin_column_styles(): void {
    global $post_type;
    if ( $post_type === 'kt_project' ) {
        echo '<style>.column-kt_project_thumb { width: 70px; }</style>';
    }
}
