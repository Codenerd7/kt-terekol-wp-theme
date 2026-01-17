<?php
// Колонки в админке для CPT kt_lead
add_filter('manage_kt_lead_posts_columns', function ($cols) {
  $new = [];
  $new['cb'] = $cols['cb'];
  $new['title'] = 'Заявка';
  $new['kt_phone'] = 'Телефон';
  $new['kt_name'] = 'Имя';
  $new['kt_page'] = 'Страница';
  $new['date'] = 'Дата';
  return $new;
});

add_action('manage_kt_lead_posts_custom_column', function ($col, $post_id) {

  if ($col === 'kt_phone') {
    $phone = get_post_meta($post_id, 'kt_phone', true);

    if (!$phone) {
      echo '—';
      return;
    }

    $tel = preg_replace('~[^\d\+]~', '', $phone);
    echo '<a href="tel:' . esc_attr($tel) . '">' . esc_html($phone) . '</a>';
    return;
  }

  if ($col === 'kt_name') {
    $name = get_post_meta($post_id, 'kt_name', true);
    echo $name ? esc_html($name) : '—';
    return;
  }

  if ($col === 'kt_page') {
    $url = get_post_meta($post_id, 'kt_page_url', true);

    if (!$url) {
      echo '—';
      return;
    }

    $short = preg_replace('~^https?://~', '', $url);
    echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer">'
       . esc_html($short)
       . '</a>';
    return;
  }

}, 10, 2);

