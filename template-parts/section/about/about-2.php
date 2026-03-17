<?php
$home_counter = get_field('home_counter');
?>
<section class="about-2 counter-section">
		<div class="container">
			<div class="wrapper">
				<?php if ( $home_counter ) : ?>
					<?php foreach ( $home_counter as $item ) : ?>
						<div class="item">
							<div class="number" data-count="<?php echo esc_attr($item['number']); ?>"><?php echo $item['number'] < 10 ? sprintf('%02d', $item['number']) : esc_html($item['number']); ?></div>
							<div class="desc"><?php echo esc_html($item['description']); ?></div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</section>