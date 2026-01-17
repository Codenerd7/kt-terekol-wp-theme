<?php
/**
 * Front Page template
 * Theme: KT Terenkol
 */
get_header();
?>

<main id="main" class="site-main">
  <section class="hero" aria-labelledby="hero-title">
    <div class="container">
      <p class="hero__eyebrow">ТОО «КТ Теренколь»</p>

      <h1 id="hero-title" class="hero__title">
        Кредитование агропромышленного комплекса Республики Казахстан
      </h1>

      <p class="hero__text">
        Прозрачные условия, понятные требования и сопровождение заявки на каждом этапе.
      </p>

      <div class="hero__actions">
        <a class="btn btn--primary" href="#request">Получить консультацию</a>
        <a class="btn btn--ghost" href="/programmy-kreditovaniya/">Программы кредитования</a>
      </div>

      <ul class="hero__facts" aria-label="Ключевые преимущества">
        <li>Фермерам и ИП в АПК</li>
        <li>Понятный перечень документов</li>
        <li>Поддержка специалистов</li>
      </ul>
    </div>
  </section>

  <section id="request" class="request">
  <div class="container">
    <h2 class="request__title">Оставить заявку на консультацию</h2>

    <?php if ( isset($_GET['request']) && $_GET['request'] === 'success' ) : ?>
      <div class="notice notice--success" role="status">
        Спасибо! Заявка отправлена. Мы свяжемся с вами в ближайшее время.
      </div>
    <?php elseif ( isset($_GET['request']) && $_GET['request'] === 'error' ) : ?>
      <div class="notice notice--error" role="alert">
        Не удалось отправить заявку. Попробуйте ещё раз или позвоните нам.
      </div>
    <?php endif; ?>

    <form class="request-form" method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
      <?php wp_nonce_field( 'kt_request_form', 'kt_request_nonce' ); ?>
      <input type="hidden" name="action" value="kt_request_form_submit">

      <div class="request-form__grid">
        <label class="field">
          <span class="field__label">Имя</span>
          <input class="field__input" type="text" name="name" autocomplete="name" required>
        </label>

        <label class="field">
          <span class="field__label">Телефон</span>
          <input class="field__input" type="tel" name="phone" autocomplete="tel" required placeholder="+7 (___) ___-__-__">
        </label>
      </div>

      <label class="field">
        <span class="field__label">Комментарий (необязательно)</span>
        <textarea class="field__input field__textarea" name="message" rows="4" placeholder="Например: сумма, цель, сроки"></textarea>
      </label>

      <!-- Honeypot: скрытое поле. Если заполнено — бот -->
      <label class="hp" aria-hidden="true">
        <span>Не заполнять</span>
        <input type="text" name="website" tabindex="-1" autocomplete="off">
      </label>

      <button class="btn btn--primary" type="submit">Отправить заявку</button>

      <p class="request-form__hint">
        Нажимая кнопку, вы соглашаетесь на обработку персональных данных для связи по заявке.
      </p>
    </form>
  </div>
</section>


<?php
get_footer();
