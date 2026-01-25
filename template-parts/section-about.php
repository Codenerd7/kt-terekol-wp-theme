<?php
/**
 * Section: About (Кто мы)
 * Статичная секция на главной странице
 */
?>
<section class="section section--alt about">
  <div class="container">
    <div class="about__inner">
      <div class="section-head">
        <p class="section-eyebrow">О проекте</p>
        <h2 class="about__title section-title">Кто мы и для кого работаем</h2>
        <p class="section-subtitle">Работаем с хозяйствами Тереңкөлского района, сопровождая заявки и документы.</p>
        <div class="section-divider" aria-hidden="true"></div>
      </div>

      <div class="about__text">
        <p>Мы работаем с крестьянскими и фермерскими хозяйствами, индивидуальными предпринимателями, занятых в сфере земледелия и животноводства Тереңкөлского района. Основной фокус — доступные кредитные решения.</p>
        <p>Мы учитываем специфику сельскохозяйственной деятельности, сезонность работ и реальные условия, в которых работают хозяйства района.</p>
      </div>

      <ul class="about__list">
        <li class="about__item">Ориентация на КХ, ФХ и ИП Тереңкөлского района</li>
        <li class="about__item">Понимание местных условий и потребностей хозяйств</li>
        <li class="about__item">Прямое взаимодействие без посредников</li>
      </ul>

      <div class="about__actions">
        <?php
        $programs_page = get_page_by_path( 'programmy-kreditovaniya' );
        $programs_url  = $programs_page ? get_permalink( $programs_page ) : home_url( '/programmy-kreditovaniya/' );
        ?>
        <a href="<?php echo esc_url( $programs_url ); ?>" class="btn btn--primary">
          Кредитные программы
        </a>

        <?php
        $about_page = get_page_by_path( 'about' );
        if ( $about_page ) :
        ?>
          <a href="<?php echo esc_url( get_permalink( $about_page ) ); ?>" class="about__action">
            Подробнее о проекте
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
