<?php
/* ── Section 3: Counter ── */
$home_counter = get_field('home_counter');
$home_counter_bg = get_field('home_counter_bg');
?>
<section class="home-counter counter-section">
	<div class="bg-pattern">
		<img src="<?php echo esc_url($home_counter_bg['url'] ?? get_template_directory_uri() . '/img/bg_count.png'); ?>" alt="Pattern">
	</div>
	<div class="container">
		<div class="wrapper">
			<?php if ( $home_counter ) : ?>
				<?php foreach ( $home_counter as $index => $item ) : ?>
					<div class="item" 
						data-aos="flip-down" 
						data-aos-delay="<?php echo esc_attr($index * 200); ?>">
						
						<div class="number" 
							data-count="<?php echo esc_attr(preg_replace('/[^0-9]/', '', $item['number'])); ?>">
							<?php echo esc_html($item['number']); ?>
						</div>

						<div class="desc">
							<?php echo esc_html($item['description']); ?>
						</div>

					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>