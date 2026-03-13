<?php
/* ── About Section 3: Image Slider ── */
$about_gallery = get_field('about_gallery');
?>
<section class="about-3">
	<div class="container-full">
		<div class="about-3-swiper swiper">
			<div class="swiper-wrapper">
				<?php if ( $about_gallery ) : ?>
					<?php foreach ( $about_gallery as $image ) : ?>
						<div class="swiper-slide">
							<a href="<?php echo esc_url($image['url']); ?>" 
							   data-fancybox="about-gallery"
							   data-caption="<?php echo esc_attr($image['alt']); ?>">
								
								<div class="img">
									<img src="<?php echo esc_url($image['url']); ?>" 
										 alt="<?php echo esc_attr($image['alt']); ?>">
								</div>

							</a>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>