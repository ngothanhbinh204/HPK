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
				<?php foreach ( $home_counter as $item ) : ?>
					<div class="item">
						<div class="number" data-count="<?php echo esc_attr(preg_replace('/[^0-9]/', '', $item['number'])); ?>"><?php echo esc_html($item['number']); ?></div>
						<div class="desc"><?php echo esc_html($item['description']); ?></div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="item">
					<div class="number" data-count="5">5+</div>
					<div class="desc">Năm kinh nghiệm</div>
				</div>
				<div class="item">
					<div class="number" data-count="40">40+</div>
					<div class="desc">Kỹ thuật viên</div>
				</div>
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
	</div>
</section>
