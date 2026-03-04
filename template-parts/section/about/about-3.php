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
							<div class="img"><img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"></div>
						</div>
					<?php endforeach; ?>
				<?php else : ?>
					<?php /* Fallback samples */ ?>
					<div class="swiper-slide"><div class="img"><img src="<?php echo get_template_directory_uri(); ?>/img/bg-banner-home.png" alt="Sample"></div></div>
					<div class="swiper-slide"><div class="img"><img src="<?php echo get_template_directory_uri(); ?>/img/big_image.png" alt="Sample"></div></div>
					<div class="swiper-slide"><div class="img"><img src="<?php echo get_template_directory_uri(); ?>/img/text.jpg" alt="Sample"></div></div>
					<div class="swiper-slide"><div class="img"><img src="<?php echo get_template_directory_uri(); ?>/img/1.jpg" alt="Sample"></div></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
