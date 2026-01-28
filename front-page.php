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
      <div class="hero__layout">
        <!-- Левая колонка -->
        <div class="hero__content">
          <h1 id="hero-title" class="hero__title">
            Кредитование агропромышленного комплекса Республики Казахстан
          </h1>

          <p class="hero__text">
            Прозрачные условия, понятные требования и сопровождение заявки на каждом этапе.
          </p>

          <?php
          $programs_page = get_page_by_path( 'programmy-kreditovaniya' );
          $programs_url  = $programs_page ? get_permalink( $programs_page ) : get_post_type_archive_link( 'product' );
          ?>
          <a class="hero__link" href="<?php echo esc_url( $programs_url ); ?>">
            <span class="hero__link-text">Программы кредитования</span> <span class="hero__link-arrow">→</span>
          </a>
        </div>

        <!-- Правая колонка -->
        <aside class="hero__aside" role="complementary">
          <div class="hero-card">
            <h2 class="hero-card__title">Консультация за 1 минуту</h2>
            <p class="hero-card__text">
              Оставьте имя и телефон — специалист перезвонит и подскажет, какие документы нужны и какая программа подходит.
            </p>
            <ul class="hero-card__benefits">
              <li>Понятный список документов</li>
              <li>Подбор программы</li>
              <li>Сопровождение</li>
            </ul>
            <a class="btn btn--primary hero-card__btn" href="#apply">
              <svg class="hero-card__icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
              Заказать звонок
            </a>
            <p class="hero-card__note">Без спама. Только по вашей заявке.</p>
          </div>
        </aside>
      </div>

      <!-- Нижняя дымка на всю ширину контейнера -->
      <div class="hero__lower">
        <ol class="hero__steps" aria-label="Как это работает">
          <li>Оставляете заявку</li>
          <li>Уточняем цель и документы</li>
          <li>Подбираем программу и сопровождаем оформление</li>
        </ol>
      </div>
    </div>
  </section>

  <?php get_template_part( 'template-parts/section', 'about' ); ?>

  <?php get_template_part( 'template-parts/section', 'stats' ); ?>

  <?php
  // Секция "Свежие отчёты" — приоритет №1
  $reports_query = new WP_Query( [
      'post_type'      => 'kt_report',
      'posts_per_page' => 3,
      'post_status'    => 'publish',
      'orderby'        => 'date',
      'order'          => 'DESC',
  ] );

  if ( $reports_query->have_posts() ) :
  ?>
  <section class="section section--alt latest-reports">
    <div class="container">
      <header class="latest-reports__header">
        <div class="section-head">
          <p class="section-eyebrow">Документы</p>
          <h2 class="latest-reports__title section-title">Отчёты</h2>
          <p class="section-subtitle">Официальные отчёты и документы о деятельности кооператива.</p>
          <div class="section-divider" aria-hidden="true"></div>
        </div>
        <a href="<?php echo esc_url( get_post_type_archive_link( 'kt_report' ) ); ?>" class="latest-reports__link">
          Все отчёты &rarr;
        </a>
      </header>

      <div class="reports-grid">
        <?php while ( $reports_query->have_posts() ) : $reports_query->the_post(); ?>
          <?php get_template_part( 'template-parts/report-card' ); ?>
        <?php endwhile; ?>
      </div>
    </div>
  </section>
  <?php
  wp_reset_postdata();
  endif;
  ?>

  <?php
  // Секция "Новости"
  $news_cat = get_category_by_slug( 'news' );
  if ( $news_cat ) :
      $news_query = new WP_Query( [
          'post_type'      => 'post',
          'posts_per_page' => 3,
          'post_status'    => 'publish',
          'cat'            => $news_cat->term_id,
          'orderby'        => 'date',
          'order'          => 'DESC',
      ] );

      if ( $news_query->have_posts() ) :
      ?>
      <section class="section latest-news">
        <div class="container">
          <header class="latest-news__header">
            <div class="section-head">
              <p class="section-eyebrow">Актуальное</p>
              <h2 class="latest-news__title section-title">Новости</h2>
              <p class="section-subtitle">Актуальные события, изменения и объявления.</p>
              <div class="section-divider" aria-hidden="true"></div>
            </div>
            <a href="<?php echo esc_url( get_category_link( $news_cat ) ); ?>" class="latest-news__link">
              Все новости &rarr;
            </a>
          </header>

          <div class="news-grid">
            <?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
              <?php get_template_part( 'template-parts/news-card' ); ?>
            <?php endwhile; ?>
          </div>
        </div>
      </section>
      <?php
      wp_reset_postdata();
      endif;
  endif;
  ?>

  <?php
  // Секция "Статьи"
  $articles_cat = get_category_by_slug( 'articles' );
  if ( $articles_cat ) :
      $articles_query = new WP_Query( [
          'post_type'      => 'post',
          'posts_per_page' => 2,
          'post_status'    => 'publish',
          'cat'            => $articles_cat->term_id,
          'orderby'        => 'date',
          'order'          => 'DESC',
      ] );

      if ( $articles_query->have_posts() ) :
      ?>
      <section class="section section--alt latest-articles">
        <div class="container">
          <header class="latest-articles__header">
            <div class="section-head">
              <p class="section-eyebrow">Полезное</p>
              <h2 class="latest-articles__title section-title">Статьи</h2>
              <p class="section-subtitle">Полезные материалы для сельхозпроизводителей.</p>
              <div class="section-divider" aria-hidden="true"></div>
            </div>
            <a href="<?php echo esc_url( get_category_link( $articles_cat ) ); ?>" class="latest-articles__link">
              Все статьи &rarr;
            </a>
          </header>

          <div class="articles-grid">
            <?php while ( $articles_query->have_posts() ) : $articles_query->the_post(); ?>
              <?php get_template_part( 'template-parts/article-card' ); ?>
            <?php endwhile; ?>
          </div>
        </div>
      </section>
      <?php
      wp_reset_postdata();
      endif;
  endif;
  ?>

  <section id="apply" class="section request">
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
</main>

<?php
get_footer();
