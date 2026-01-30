<?php
/**
 * Custom Post Type: Наши проекты (kt_project)
 *
 * Регистрация типа записи для проектов.
 * Тип медиа: Фото (галерея) ИЛИ Видео (YouTube/Vimeo/MP4).
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
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => false,
        'query_var'           => false,
        'rewrite'             => false,
        'capability_type'     => 'post',
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => 8,
        'menu_icon'           => 'dashicons-images-alt2',
        'supports'            => [ 'title' ],
    ];

    register_post_type( 'kt_project', $args );
}
add_action( 'init', 'kt_register_project_post_type' );

/**
 * Добавление мета-боксов для kt_project
 */
add_action( 'add_meta_boxes', 'kt_add_project_metaboxes' );

function kt_add_project_metaboxes(): void {
    add_meta_box(
        'kt_project_media',
        'Медиа проекта',
        'kt_render_project_media_metabox',
        'kt_project',
        'normal',
        'high'
    );

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
 * Рендер мета-бокса "Медиа проекта"
 */
function kt_render_project_media_metabox( $post ): void {
    $media_type   = get_post_meta( $post->ID, 'kt_project_media_type', true ) ?: 'photo';
    $gallery      = get_post_meta( $post->ID, 'kt_project_gallery', true ) ?: [];
    $video_source = get_post_meta( $post->ID, 'kt_project_video_source', true ) ?: 'url';
    $video_url    = get_post_meta( $post->ID, 'kt_project_video_url', true );
    $video_file_id = get_post_meta( $post->ID, 'kt_project_video_file_id', true );
    $video_poster_id = get_post_meta( $post->ID, 'kt_project_video_poster_id', true );

    wp_nonce_field( 'kt_project_metabox', 'kt_project_nonce' );
    ?>
    <style>
        .kt-project-media-type { margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #ddd; }
        .kt-project-media-type label { margin-right: 20px; font-weight: 500; }
        .kt-project-media-type input[type="radio"] { margin-right: 5px; }
        .kt-project-field { margin-bottom: 15px; }
        .kt-project-field-label { display: block; font-weight: 600; margin-bottom: 8px; }
        .kt-project-gallery-preview { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 10px; }
        .kt-project-gallery-item { position: relative; width: 120px; height: 90px; border-radius: 4px; overflow: hidden; background: #f0f0f0; }
        .kt-project-gallery-item img { width: 100%; height: 100%; object-fit: cover; }
        .kt-project-gallery-item-remove { position: absolute; top: 4px; right: 4px; width: 20px; height: 20px; background: rgba(0,0,0,0.6); color: #fff; border: none; border-radius: 50%; cursor: pointer; font-size: 14px; line-height: 1; }
        .kt-project-gallery-item-remove:hover { background: #dc3545; }
        .kt-project-gallery-item.is-first::after { content: 'Превью'; position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,100,200,0.8); color: #fff; font-size: 10px; text-align: center; padding: 2px; }
        .kt-project-video-field { max-width: 500px; }
        .kt-project-video-preview { margin-top: 10px; }
        .kt-project-video-preview img { max-width: 300px; border-radius: 4px; }
        .kt-project-video-preview video { max-width: 300px; border-radius: 4px; }
        .kt-project-video-source { margin-bottom: 15px; padding: 10px; background: #f9f9f9; border-radius: 4px; }
        .kt-project-video-source label { margin-right: 15px; }
        .kt-project-file-preview { margin-top: 10px; padding: 10px; background: #f5f5f5; border-radius: 4px; }
        .kt-project-file-info { display: flex; align-items: center; gap: 10px; }
        .kt-project-file-icon { font-size: 24px; }
        .kt-project-poster-preview { margin-top: 10px; }
        .kt-project-poster-preview img { max-width: 200px; border-radius: 4px; }
        [data-media-section="video"] { display: none; }
        [data-video-source="url"] { display: none; }
        [data-video-source="file"] { display: none; }
        .kt-project-media-type-photo [data-media-section="photo"] { display: block; }
        .kt-project-media-type-photo [data-media-section="video"] { display: none; }
        .kt-project-media-type-video [data-media-section="photo"] { display: none; }
        .kt-project-media-type-video [data-media-section="video"] { display: block; }
        .kt-project-video-source-url [data-video-source="url"] { display: block; }
        .kt-project-video-source-url [data-video-source="file"] { display: none; }
        .kt-project-video-source-file [data-video-source="url"] { display: none; }
        .kt-project-video-source-file [data-video-source="file"] { display: block; }
    </style>

    <div class="kt-project-media-wrapper kt-project-media-type-<?php echo esc_attr( $media_type ); ?> kt-project-video-source-<?php echo esc_attr( $video_source ); ?>" id="kt-project-media-wrapper">
        <!-- Выбор типа медиа -->
        <div class="kt-project-media-type">
            <span class="kt-project-field-label">Тип медиа:</span>
            <label>
                <input type="radio" name="kt_project_media_type" value="photo" <?php checked( $media_type, 'photo' ); ?>>
                Фото
            </label>
            <label>
                <input type="radio" name="kt_project_media_type" value="video" <?php checked( $media_type, 'video' ); ?>>
                Видео
            </label>
        </div>

        <!-- Секция для фото -->
        <div class="kt-project-field" data-media-section="photo">
            <span class="kt-project-field-label">Галерея изображений:</span>
            <p class="description" style="margin-bottom: 10px;">Первое изображение будет использоваться как превью в слайдере.</p>

            <div class="kt-project-gallery-preview" id="kt-project-gallery-preview">
                <?php
                if ( ! empty( $gallery ) && is_array( $gallery ) ) :
                    foreach ( $gallery as $index => $image_id ) :
                        $img_url = wp_get_attachment_image_url( $image_id, 'thumbnail' );
                        if ( $img_url ) :
                ?>
                    <div class="kt-project-gallery-item <?php echo $index === 0 ? 'is-first' : ''; ?>" data-id="<?php echo esc_attr( $image_id ); ?>">
                        <img src="<?php echo esc_url( $img_url ); ?>" alt="">
                        <button type="button" class="kt-project-gallery-item-remove" title="Удалить">&times;</button>
                    </div>
                <?php
                        endif;
                    endforeach;
                endif;
                ?>
            </div>

            <input type="hidden" name="kt_project_gallery" id="kt-project-gallery-input" value="<?php echo esc_attr( is_array( $gallery ) ? implode( ',', $gallery ) : '' ); ?>">

            <button type="button" class="button" id="kt-project-gallery-upload">Добавить изображения</button>
            <button type="button" class="button" id="kt-project-gallery-clear" style="<?php echo empty( $gallery ) ? 'display:none;' : ''; ?>">Очистить галерею</button>
        </div>

        <!-- Секция для видео -->
        <div class="kt-project-field" data-media-section="video">
            <!-- Выбор источника видео -->
            <div class="kt-project-video-source">
                <span class="kt-project-field-label">Источник видео:</span>
                <label>
                    <input type="radio" name="kt_project_video_source" value="url" <?php checked( $video_source, 'url' ); ?>>
                    Ссылка (YouTube / Vimeo)
                </label>
                <label>
                    <input type="radio" name="kt_project_video_source" value="file" <?php checked( $video_source, 'file' ); ?>>
                    Загрузить файл (MP4)
                </label>
            </div>

            <!-- Ссылка на видео -->
            <div data-video-source="url">
                <span class="kt-project-field-label">Ссылка на видео:</span>
                <p class="description" style="margin-bottom: 10px;">Поддерживаются YouTube и Vimeo.</p>

                <input
                    type="url"
                    id="kt_project_video_url"
                    name="kt_project_video_url"
                    value="<?php echo esc_url( $video_url ); ?>"
                    class="widefat kt-project-video-field"
                    placeholder="https://www.youtube.com/watch?v=... или https://vimeo.com/..."
                >

                <div class="kt-project-video-preview" id="kt-project-video-url-preview">
                    <?php if ( $video_url && $video_source === 'url' ) :
                        $thumb_url = kt_get_video_thumbnail( $video_url );
                        if ( $thumb_url ) :
                    ?>
                        <img src="<?php echo esc_url( $thumb_url ); ?>" alt="Превью видео">
                    <?php endif; endif; ?>
                </div>
            </div>

            <!-- Загрузка видеофайла -->
            <div data-video-source="file">
                <span class="kt-project-field-label">Видеофайл (MP4):</span>
                <p class="description" style="margin-bottom: 10px;">Загрузите видео в формате MP4. Рекомендуемый размер до 50 МБ.</p>

                <input type="hidden" name="kt_project_video_file_id" id="kt-project-video-file-id" value="<?php echo esc_attr( $video_file_id ); ?>">

                <div class="kt-project-file-preview" id="kt-project-file-preview" style="<?php echo $video_file_id ? '' : 'display:none;'; ?>">
                    <?php if ( $video_file_id ) :
                        $video_file_url = wp_get_attachment_url( $video_file_id );
                        $video_meta = wp_get_attachment_metadata( $video_file_id );
                        $file_size = size_format( filesize( get_attached_file( $video_file_id ) ) );
                    ?>
                    <div class="kt-project-file-info">
                        <span class="kt-project-file-icon dashicons dashicons-video-alt3"></span>
                        <div>
                            <strong><?php echo esc_html( basename( $video_file_url ) ); ?></strong><br>
                            <span class="description"><?php echo esc_html( $file_size ); ?></span>
                        </div>
                    </div>
                    <video src="<?php echo esc_url( $video_file_url ); ?>" style="max-width: 300px; margin-top: 10px; border-radius: 4px;" controls></video>
                    <?php endif; ?>
                </div>

                <p>
                    <button type="button" class="button" id="kt-project-video-file-upload">
                        <?php echo $video_file_id ? 'Заменить видео' : 'Загрузить видео'; ?>
                    </button>
                    <button type="button" class="button" id="kt-project-video-file-remove" style="<?php echo $video_file_id ? '' : 'display:none;'; ?>">
                        Удалить видео
                    </button>
                </p>

                <!-- Постер для видео -->
                <div style="margin-top: 15px;">
                    <span class="kt-project-field-label">Постер (превью для слайдера):</span>
                    <p class="description" style="margin-bottom: 10px;">Изображение, которое будет показано в слайдере. Если не указано, будет использован первый кадр видео.</p>

                    <input type="hidden" name="kt_project_video_poster_id" id="kt-project-video-poster-id" value="<?php echo esc_attr( $video_poster_id ); ?>">

                    <div class="kt-project-poster-preview" id="kt-project-poster-preview" style="<?php echo $video_poster_id ? '' : 'display:none;'; ?>">
                        <?php if ( $video_poster_id ) :
                            $poster_url = wp_get_attachment_image_url( $video_poster_id, 'medium' );
                        ?>
                        <img src="<?php echo esc_url( $poster_url ); ?>" alt="Постер видео">
                        <?php endif; ?>
                    </div>

                    <p>
                        <button type="button" class="button" id="kt-project-poster-upload">
                            <?php echo $video_poster_id ? 'Заменить постер' : 'Выбрать постер'; ?>
                        </button>
                        <button type="button" class="button" id="kt-project-poster-remove" style="<?php echo $video_poster_id ? '' : 'display:none;'; ?>">
                            Удалить постер
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        var galleryFrame, videoFrame, posterFrame;
        var $wrapper = $('#kt-project-media-wrapper');
        var $preview = $('#kt-project-gallery-preview');
        var $input = $('#kt-project-gallery-input');
        var $clearBtn = $('#kt-project-gallery-clear');

        // Переключение типа медиа
        $('input[name="kt_project_media_type"]').on('change', function() {
            var type = $(this).val();
            $wrapper.removeClass('kt-project-media-type-photo kt-project-media-type-video')
                    .addClass('kt-project-media-type-' + type);
        });

        // Переключение источника видео
        $('input[name="kt_project_video_source"]').on('change', function() {
            var source = $(this).val();
            $wrapper.removeClass('kt-project-video-source-url kt-project-video-source-file')
                    .addClass('kt-project-video-source-' + source);
        });

        // === ГАЛЕРЕЯ ===
        function updateGalleryInput() {
            var ids = [];
            $preview.find('.kt-project-gallery-item').each(function(index) {
                ids.push($(this).data('id'));
                $(this).toggleClass('is-first', index === 0);
            });
            $input.val(ids.join(','));
            $clearBtn.toggle(ids.length > 0);
        }

        if ($.fn.sortable) {
            $preview.sortable({
                items: '.kt-project-gallery-item',
                cursor: 'move',
                update: updateGalleryInput
            });
        }

        $preview.on('click', '.kt-project-gallery-item-remove', function(e) {
            e.preventDefault();
            $(this).closest('.kt-project-gallery-item').remove();
            updateGalleryInput();
        });

        $('#kt-project-gallery-upload').on('click', function(e) {
            e.preventDefault();

            if (galleryFrame) {
                galleryFrame.open();
                return;
            }

            galleryFrame = wp.media({
                title: 'Выберите изображения для галереи',
                button: { text: 'Добавить в галерею' },
                multiple: true,
                library: { type: 'image' }
            });

            galleryFrame.on('select', function() {
                var attachments = galleryFrame.state().get('selection').toJSON();

                attachments.forEach(function(attachment) {
                    var imgUrl = attachment.sizes && attachment.sizes.thumbnail
                        ? attachment.sizes.thumbnail.url
                        : attachment.url;

                    var $item = $('<div class="kt-project-gallery-item" data-id="' + attachment.id + '">' +
                        '<img src="' + imgUrl + '" alt="">' +
                        '<button type="button" class="kt-project-gallery-item-remove" title="Удалить">&times;</button>' +
                        '</div>');

                    $preview.append($item);
                });

                updateGalleryInput();
            });

            galleryFrame.open();
        });

        $('#kt-project-gallery-clear').on('click', function(e) {
            e.preventDefault();
            if (confirm('Удалить все изображения из галереи?')) {
                $preview.empty();
                updateGalleryInput();
            }
        });

        // === ВИДЕО URL ===
        var videoTimeout;
        $('#kt_project_video_url').on('input', function() {
            var url = $(this).val();
            var $videoPreview = $('#kt-project-video-url-preview');

            clearTimeout(videoTimeout);

            if (!url) {
                $videoPreview.empty();
                return;
            }

            videoTimeout = setTimeout(function() {
                var youtubeMatch = url.match(/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
                var vimeoMatch = url.match(/vimeo\.com\/(?:video\/)?(\d+)/);

                if (youtubeMatch) {
                    var thumbUrl = 'https://img.youtube.com/vi/' + youtubeMatch[1] + '/mqdefault.jpg';
                    $videoPreview.html('<img src="' + thumbUrl + '" alt="Превью видео">');
                } else if (vimeoMatch) {
                    $videoPreview.html('<p style="color: #666;">Превью Vimeo будет отображаться на сайте</p>');
                } else {
                    $videoPreview.html('<p style="color: #dc3545;">Неподдерживаемый формат ссылки</p>');
                }
            }, 500);
        });

        // === ВИДЕО ФАЙЛ ===
        $('#kt-project-video-file-upload').on('click', function(e) {
            e.preventDefault();

            if (videoFrame) {
                videoFrame.open();
                return;
            }

            videoFrame = wp.media({
                title: 'Выберите видеофайл',
                button: { text: 'Использовать это видео' },
                multiple: false,
                library: { type: 'video' }
            });

            videoFrame.on('select', function() {
                var attachment = videoFrame.state().get('selection').first().toJSON();

                $('#kt-project-video-file-id').val(attachment.id);

                var fileSize = attachment.filesizeHumanReadable || '';
                var html = '<div class="kt-project-file-info">' +
                    '<span class="kt-project-file-icon dashicons dashicons-video-alt3"></span>' +
                    '<div><strong>' + attachment.filename + '</strong><br>' +
                    '<span class="description">' + fileSize + '</span></div></div>' +
                    '<video src="' + attachment.url + '" style="max-width: 300px; margin-top: 10px; border-radius: 4px;" controls></video>';

                $('#kt-project-file-preview').html(html).show();
                $('#kt-project-video-file-upload').text('Заменить видео');
                $('#kt-project-video-file-remove').show();
            });

            videoFrame.open();
        });

        $('#kt-project-video-file-remove').on('click', function(e) {
            e.preventDefault();
            $('#kt-project-video-file-id').val('');
            $('#kt-project-file-preview').empty().hide();
            $('#kt-project-video-file-upload').text('Загрузить видео');
            $(this).hide();
        });

        // === ПОСТЕР ===
        $('#kt-project-poster-upload').on('click', function(e) {
            e.preventDefault();

            if (posterFrame) {
                posterFrame.open();
                return;
            }

            posterFrame = wp.media({
                title: 'Выберите постер для видео',
                button: { text: 'Использовать как постер' },
                multiple: false,
                library: { type: 'image' }
            });

            posterFrame.on('select', function() {
                var attachment = posterFrame.state().get('selection').first().toJSON();

                $('#kt-project-video-poster-id').val(attachment.id);

                var imgUrl = attachment.sizes && attachment.sizes.medium
                    ? attachment.sizes.medium.url
                    : attachment.url;

                $('#kt-project-poster-preview').html('<img src="' + imgUrl + '" alt="Постер видео">').show();
                $('#kt-project-poster-upload').text('Заменить постер');
                $('#kt-project-poster-remove').show();
            });

            posterFrame.open();
        });

        $('#kt-project-poster-remove').on('click', function(e) {
            e.preventDefault();
            $('#kt-project-video-poster-id').val('');
            $('#kt-project-poster-preview').empty().hide();
            $('#kt-project-poster-upload').text('Выбрать постер');
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
    if ( ! isset( $_POST['kt_project_nonce'] ) || ! wp_verify_nonce( $_POST['kt_project_nonce'], 'kt_project_metabox' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Тип медиа
    if ( isset( $_POST['kt_project_media_type'] ) ) {
        $media_type = sanitize_text_field( $_POST['kt_project_media_type'] );
        if ( in_array( $media_type, [ 'photo', 'video' ], true ) ) {
            update_post_meta( $post_id, 'kt_project_media_type', $media_type );
        }
    }

    // Галерея
    if ( isset( $_POST['kt_project_gallery'] ) ) {
        $gallery_str = sanitize_text_field( $_POST['kt_project_gallery'] );
        if ( $gallery_str ) {
            $gallery = array_map( 'absint', explode( ',', $gallery_str ) );
            $gallery = array_filter( $gallery );
            update_post_meta( $post_id, 'kt_project_gallery', $gallery );
        } else {
            delete_post_meta( $post_id, 'kt_project_gallery' );
        }
    }

    // Источник видео
    if ( isset( $_POST['kt_project_video_source'] ) ) {
        $video_source = sanitize_text_field( $_POST['kt_project_video_source'] );
        if ( in_array( $video_source, [ 'url', 'file' ], true ) ) {
            update_post_meta( $post_id, 'kt_project_video_source', $video_source );
        }
    }

    // URL видео
    if ( isset( $_POST['kt_project_video_url'] ) ) {
        $video_url = esc_url_raw( $_POST['kt_project_video_url'] );
        if ( $video_url ) {
            update_post_meta( $post_id, 'kt_project_video_url', $video_url );
        } else {
            delete_post_meta( $post_id, 'kt_project_video_url' );
        }
    }

    // ID видеофайла
    if ( isset( $_POST['kt_project_video_file_id'] ) ) {
        $video_file_id = absint( $_POST['kt_project_video_file_id'] );
        if ( $video_file_id ) {
            update_post_meta( $post_id, 'kt_project_video_file_id', $video_file_id );
        } else {
            delete_post_meta( $post_id, 'kt_project_video_file_id' );
        }
    }

    // ID постера видео
    if ( isset( $_POST['kt_project_video_poster_id'] ) ) {
        $poster_id = absint( $_POST['kt_project_video_poster_id'] );
        if ( $poster_id ) {
            update_post_meta( $post_id, 'kt_project_video_poster_id', $poster_id );
        } else {
            delete_post_meta( $post_id, 'kt_project_video_poster_id' );
        }
    }

    // Текст
    if ( isset( $_POST['kt_project_text'] ) ) {
        update_post_meta( $post_id, 'kt_project_text', sanitize_textarea_field( $_POST['kt_project_text'] ) );
    }
}

/**
 * Подключение медиа-загрузчика и jQuery UI Sortable
 */
add_action( 'admin_enqueue_scripts', 'kt_project_admin_scripts' );

function kt_project_admin_scripts( $hook ): void {
    global $post_type;

    if ( ( $hook === 'post.php' || $hook === 'post-new.php' ) && $post_type === 'kt_project' ) {
        wp_enqueue_media();
        wp_enqueue_script( 'jquery-ui-sortable' );
    }
}

/**
 * Получить ID видео из URL (YouTube/Vimeo)
 */
function kt_get_video_id( $url ) {
    if ( preg_match( '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches ) ) {
        return $matches[1];
    }

    if ( preg_match( '/vimeo\.com\/(?:video\/)?(\d+)/', $url, $matches ) ) {
        return $matches[1];
    }

    return false;
}

/**
 * Определить тип видео (youtube/vimeo)
 */
function kt_get_video_type( $url ) {
    if ( strpos( $url, 'youtube.com' ) !== false || strpos( $url, 'youtu.be' ) !== false ) {
        return 'youtube';
    }

    if ( strpos( $url, 'vimeo.com' ) !== false ) {
        return 'vimeo';
    }

    return false;
}

/**
 * Получить URL превью видео (для YouTube/Vimeo)
 */
function kt_get_video_thumbnail( $url ) {
    $video_id = kt_get_video_id( $url );
    $video_type = kt_get_video_type( $url );

    if ( ! $video_id || ! $video_type ) {
        return '';
    }

    if ( $video_type === 'youtube' ) {
        return 'https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg';
    }

    if ( $video_type === 'vimeo' ) {
        $cached = get_transient( 'kt_vimeo_thumb_' . $video_id );
        if ( $cached ) {
            return $cached;
        }

        $response = wp_remote_get( 'https://vimeo.com/api/v2/video/' . $video_id . '.json' );
        if ( ! is_wp_error( $response ) ) {
            $body = json_decode( wp_remote_retrieve_body( $response ), true );
            if ( ! empty( $body[0]['thumbnail_large'] ) ) {
                $thumb_url = $body[0]['thumbnail_large'];
                set_transient( 'kt_vimeo_thumb_' . $video_id, $thumb_url, DAY_IN_SECONDS );
                return $thumb_url;
            }
        }

        return '';
    }

    return '';
}

/**
 * Получить embed URL для видео (YouTube/Vimeo)
 */
function kt_get_video_embed_url( $url ) {
    $video_id = kt_get_video_id( $url );
    $video_type = kt_get_video_type( $url );

    if ( ! $video_id || ! $video_type ) {
        return '';
    }

    if ( $video_type === 'youtube' ) {
        return 'https://www.youtube.com/embed/' . $video_id;
    }

    if ( $video_type === 'vimeo' ) {
        return 'https://player.vimeo.com/video/' . $video_id;
    }

    return '';
}

/**
 * Колонки в админке для kt_project
 */
add_filter( 'manage_kt_project_posts_columns', 'kt_project_admin_columns' );

function kt_project_admin_columns( $columns ) {
    $new_columns = [];

    foreach ( $columns as $key => $value ) {
        if ( $key === 'title' ) {
            $new_columns['kt_project_thumb'] = 'Превью';
            $new_columns['kt_project_type'] = 'Тип';
        }
        $new_columns[ $key ] = $value;
    }

    return $new_columns;
}

add_action( 'manage_kt_project_posts_custom_column', 'kt_project_admin_column_content', 10, 2 );

function kt_project_admin_column_content( $column, $post_id ): void {
    if ( $column === 'kt_project_thumb' ) {
        $media_type = get_post_meta( $post_id, 'kt_project_media_type', true ) ?: 'photo';

        if ( $media_type === 'photo' ) {
            $gallery = get_post_meta( $post_id, 'kt_project_gallery', true );
            if ( ! empty( $gallery ) && is_array( $gallery ) ) {
                $img = wp_get_attachment_image( $gallery[0], [ 60, 60 ], false, [ 'style' => 'border-radius: 4px;' ] );
                echo $img;
            } else {
                echo '<span style="color: #999;">—</span>';
            }
        } else {
            $video_source = get_post_meta( $post_id, 'kt_project_video_source', true ) ?: 'url';

            if ( $video_source === 'file' ) {
                $poster_id = get_post_meta( $post_id, 'kt_project_video_poster_id', true );
                if ( $poster_id ) {
                    $img = wp_get_attachment_image( $poster_id, [ 60, 60 ], false, [ 'style' => 'border-radius: 4px;' ] );
                    echo $img;
                } else {
                    echo '<span style="color: #0073aa; font-size: 20px;">▶</span>';
                }
            } else {
                $video_url = get_post_meta( $post_id, 'kt_project_video_url', true );
                if ( $video_url ) {
                    $thumb = kt_get_video_thumbnail( $video_url );
                    if ( $thumb ) {
                        echo '<img src="' . esc_url( $thumb ) . '" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">';
                    } else {
                        echo '<span style="color: #0073aa; font-size: 20px;">▶</span>';
                    }
                } else {
                    echo '<span style="color: #999;">—</span>';
                }
            }
        }
    }

    if ( $column === 'kt_project_type' ) {
        $media_type = get_post_meta( $post_id, 'kt_project_media_type', true ) ?: 'photo';
        if ( $media_type === 'video' ) {
            $video_source = get_post_meta( $post_id, 'kt_project_video_source', true ) ?: 'url';
            echo $video_source === 'file' ? 'Видео (MP4)' : 'Видео (URL)';
        } else {
            echo 'Фото';
        }
    }
}

/**
 * Стили для колонок
 */
add_action( 'admin_head', 'kt_project_admin_column_styles' );

function kt_project_admin_column_styles(): void {
    global $post_type;
    if ( $post_type === 'kt_project' ) {
        echo '<style>
            .column-kt_project_thumb { width: 70px; }
            .column-kt_project_type { width: 100px; }
        </style>';
    }
}
