<?php
/* ── Section 1: Service Hero/Info (Service Listing Page) ── */
$service_title = get_field('service_hero_title') ?: 'BÁN MÁY PHOTOCOPY CHÍNH HÃNG';
$service_desc = get_field('service_hero_desc') ?: 'Hưng Phúc Khang hoạt động trong lĩnh vực máy photocopy với định hướng cung cấp các giải pháp phù hợp cho nhu cầu sử dụng thực tế...';
$service_counters = get_field('service_hero_counters'); // Repeater
$service_image = get_field('service_hero_image');
$service_btn_left = get_field('service_hero_btn_left'); // Link
$service_btn_right = get_field('service_hero_btn_right'); // Link
?>
<section class="service-1 counter-section">
	<div class="container-full">
		<div class="wrapper">
			<div class="col-content" data-aos="fade-right">
				<h2 class="block-title uppercase"><?php echo esc_html($service_title); ?></h2>
				<div class="desc">
					<?php echo wp_kses_post($service_desc); ?>
				</div>
				<div class="counter-wrapper">
					<?php if ( $service_counters ) : ?>
						<?php foreach ( $service_counters as $item ) : ?>
							<div class="item">
								<div class="number" data-count="<?php echo esc_attr(preg_replace('/[^0-9]/', '', $item['number'])); ?>">
									<?php echo esc_html($item['number']); ?>
								</div>
								<div class="desc"><?php echo esc_html($item['description']); ?></div>
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<div class="item">
							<div class="number" data-count="150">150+</div>
							<div class="desc">Dòng máy khác nhau</div>
						</div>
						<div class="item">
							<div class="number" data-count="3000">3000+</div>
							<div class="desc">Khách hàng</div>
						</div>
					<?php endif; ?>
				</div>
				<div class="btn-list">
					<?php if ( $service_btn_left ) : ?>
						<a class="btn btn-primary" href="<?php echo esc_url($service_btn_left['url']); ?>" target="<?php echo esc_attr($service_btn_left['target'] ?: '_self'); ?>">
							<span><?php echo esc_html($service_btn_left['title']); ?></span>
						</a>
					<?php else : ?>
						<a class="btn btn-primary" href="#"><span>LIÊN HỆ VỚI CHÚNG TÔI</span></a>
					<?php endif; ?>

					<?php if ( $service_btn_right ) : ?>
						<a class="btn btn-primary-solid" href="<?php echo esc_url($service_btn_right['url']); ?>" target="<?php echo esc_attr($service_btn_right['target'] ?: '_self'); ?>">
							<span><?php echo esc_html($service_btn_right['title']); ?></span>
						</a>
					<?php else : ?>
						<a class="btn btn-primary-solid" href="#"><span>XEM DÒNG MÁY</span></a>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-image" data-aos="fade-left">
				<div class="img">
					<img src="<?php echo esc_url($service_image['url'] ?? get_template_directory_uri() . '/img/product-banner.png'); ?>" alt="<?php echo esc_attr($service_image['alt'] ?: 'Service'); ?>">
				</div>
			</div>
		</div>
	</div>
</section>
