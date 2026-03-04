<?php
/* ── About Section 1: Sliding Titles ── */
$about_subtitle = get_field('about_subtitle');
$about_titles = get_field('about_titles'); // Repeater (same as home)
$about_desc = get_field('about_desc'); // WYSIWYG
?>
<section class="about-1 sliding-titles-section">
	<div class="container-full">
		<div class="wrapper">
			<div class="col-info">
				<div class="sub-title"><?php echo esc_html($about_subtitle ?: 'VỀ HƯNG PHÚC KHANG'); ?></div>
				<div class="title-wrapper">
					<div class="title-list">
						<?php if ( $about_titles ) : ?>
							<?php foreach ( $about_titles as $item ) : ?>
								<div class="title-item" style="background-image: url('<?php echo esc_url($item['bg_image']['url'] ?? ''); ?>')"><?php echo esc_html($item['title']); ?></div>
							<?php endforeach; ?>
							<div class="title-item" style="background-image: url('<?php echo esc_url($about_titles[0]['bg_image']['url'] ?? ''); ?>')" aria-hidden="true"><?php echo esc_html($about_titles[0]['title']); ?></div>
						<?php else : ?>
							<div class="title-item" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/bg-banner-home.png')">BÁN MÁY</div>
							<div class="title-item" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/text.jpg')">SỬA CHỮA</div>
							<div class="title-item" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/1.jpg')">ĐÀO TẠO KỸ THUẬT</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="line"></div>
				<div class="desc">
					<?php echo $about_desc; ?>
				</div>
			</div>
		</div>
	</div>
</section>
