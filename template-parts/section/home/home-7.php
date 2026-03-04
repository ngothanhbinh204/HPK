<?php
/* ── Section 7: Đối tác khách hàng ── */
$home_partners_title = get_field('home_partners_title') ?: 'Đối tác khách hàng';
$home_partners = get_field('home_partners'); // Repeater or Gallery
?>
<section class="home-7">
	<div class="bg-pattern"><img src="<?php echo get_template_directory_uri(); ?>/img/bg_doitac.svg" alt="Pattern"></div>
	<div class="container">
		<h2 class="block-title rem:text-[36px]" data-aos="fade-up"><?php echo esc_html($home_partners_title); ?></h2>
		<div class="swiper-wrapper-relative">
			<div class="swiper home-7-swiper" data-aos="fade-up" data-aos-delay="200">
				<div class="swiper-wrapper">
					<?php if ( $home_partners ) : ?>
						<?php foreach ( $home_partners as $item ) : ?>
							<div class="swiper-slide">
								<div class="partner-item">
									<div class="partner-logo">
										<img src="<?php echo esc_url($item['logo']['url'] ?? $item['url'] ?? ''); ?>" alt="<?php echo esc_attr($item['logo']['alt'] ?? 'Partner'); ?>">
									</div>
								</div>
								<div class="hover-line"></div>
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<?php /* Default placeholders */ ?>
						<div class="swiper-slide">
							<div class="partner-item"><div class="partner-logo"><img src="<?php echo get_template_directory_uri(); ?>/img/logo_doitac.png" alt="Partner"></div></div>
							<div class="hover-line"></div>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="swiper-nav-wrapper">
				<div class="swiper-button-prev home-7-prev"><i class="fa-light fa-chevron-left"></i></div>
				<div class="swiper-button-next home-7-next"><i class="fa-light fa-chevron-right"></i></div>
			</div>
		</div>
	</div>
</section>
