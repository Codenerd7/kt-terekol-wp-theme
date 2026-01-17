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
      <p class="request__text">Форма будет добавлена в следующем Pull Request.</p>
    </div>
  </section>
</main>

<?php
get_footer();
