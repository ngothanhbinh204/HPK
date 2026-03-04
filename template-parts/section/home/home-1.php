<?php
/* ── Section 1: Hero Slider ── */
$slides = get_field('home_hero_slides');
?>
<section class="home-1">
	<div class="banner-slide">
		<div class="swiper">
			<div class="swiper-wrapper">
				<?php if ( $slides ) : ?>
					<?php foreach ( $slides as $slide ) : ?>
						<div class="swiper-slide">
							<div class="slide-item">
								<div class="slide-bg">
									<a class="img-ratio ratio:pt-[1200_1920] lg:ratio:pt-[880_1920]" href="<?php echo esc_url($slide['button']['url'] ?? '#'); ?>">
										<?php if ( !empty($slide['bg_image']) ) : ?>
											<img class="lozad" data-src="<?php echo esc_url($slide['bg_image']['url']); ?>" alt="<?php echo esc_attr($slide['bg_image']['alt'] ?: $slide['title']); ?>">
										<?php else : ?>
											<img class="lozad" data-src="<?php echo get_template_directory_uri(); ?>/img/bg-banner-home.png" alt="Hưng Phúc Khang">
										<?php endif; ?>
									</a>
									<div class="slide-overlay"></div>
									<img class="layer-union" src="<?php echo get_template_directory_uri(); ?>/img/Union.svg" alt="Layer">
								</div>
								<div class="slide-content">
									<div class="slide-decorations">
										<img class="deco-goctren" src="<?php echo get_template_directory_uri(); ?>/img/goctren.svg" alt="Decor">
										<img class="deco-gocduoi" src="<?php echo get_template_directory_uri(); ?>/img/gocduoi.svg" alt="Decor">
									</div>
									<div class="slide-inner">
										<div class="slide-info">
											<h2 class="slide-title"><?php echo esc_html($slide['title']); ?></h2>
											<p class="slide-desc"><?php echo esc_html($slide['description']); ?></p>
											<?php if ( !empty($slide['button']) ) : ?>
												<div class="slide-button">
													<a class="btn btn-primary" href="<?php echo esc_url($slide['button']['url']); ?>" target="<?php echo esc_attr($slide['button']['target'] ?: '_self'); ?>">
														<?php echo esc_html($slide['button']['title']); ?>
													</a>
												</div>
											<?php endif; ?>
										</div>
										<div class="slide-image">
											<?php if ( !empty($slide['product_image']) ) : ?>
												<img class="lozad" data-src="<?php echo esc_url($slide['product_image']['url']); ?>" alt="<?php echo esc_attr($slide['product_image']['alt'] ?: $slide['title']); ?>">
											<?php else : ?>
												<img class="lozad" data-src="<?php echo get_template_directory_uri(); ?>/img/product-banner.png" alt="Product">
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				<?php else : ?>
					<?php /* ── Default Fallback Slide ── */ ?>
					<div class="swiper-slide">
						<div class="slide-item">
							<div class="slide-bg">
								<a class="img-ratio ratio:pt-[1200_1920] lg:ratio:pt-[880_1920]" href="#">
									<img class="lozad" data-src="<?php echo get_template_directory_uri(); ?>/img/bg-banner-home.png" alt="Hưng Phúc Khang">
								</a>
								<div class="slide-overlay"></div>
								<img class="layer-union" src="<?php echo get_template_directory_uri(); ?>/img/Union.svg" alt="Layer">
							</div>
							<div class="slide-content">
								<div class="slide-decorations">
									<img class="deco-goctren" src="<?php echo get_template_directory_uri(); ?>/img/goctren.svg" alt="Decor">
									<img class="deco-gocduoi" src="<?php echo get_template_directory_uri(); ?>/img/gocduoi.svg" alt="Decor">
								</div>
								<div class="slide-inner">
									<div class="slide-info">
										<h2 class="slide-title">Hưng Phúc Khang</h2>
										<p class="slide-desc">Đối tác phân phối & dịch vụ máy photocopy, máy in chuyên nghiệp</p>
										<div class="slide-button"><a class="btn btn-primary" href="#">XEM SẢN PHẨM</a></div>
									</div>
									<div class="slide-image">
										<img class="lozad" data-src="<?php echo get_template_directory_uri(); ?>/img/product-banner.png" alt="Product">
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="slide-controls">
			<div class="btn-prev"><i class="fa-thin fa-chevron-left"></i></div>
			<div class="btn-next"><i class="fa-thin fa-chevron-right"></i></div>
		</div>
	</div>
</section>
