<?php
/* ── Section 2: Về chúng tôi (Sliding Titles) ── */
$home_about_subtitle = get_field('home_about_subtitle');
$home_about_titles = get_field('home_about_titles');
$home_about_desc = get_field('home_about_desc');
$home_about_btn = get_field('home_about_btn');
$home_about_img_large = get_field('home_about_img_large');
$home_about_img_small = get_field('home_about_img_small');
?>
<section class="home-2 sliding-titles-section">
	<div class="bg-pattern"><img src="<?php echo get_template_directory_uri(); ?>/img/layer_partent.svg" alt="Pattern"></div>
	<div class="container-full">
		<div class="wrapper">
			<div class="col-info">
				<div class="sub-title"><?php echo esc_html($home_about_subtitle ?: 'VỀ HƯNG PHÚC KHANG'); ?></div>
				<div class="title-wrapper">
					<div class="title-list">
						<?php if ( $home_about_titles ) : ?>
							<?php foreach ( $home_about_titles as $item ) : ?>
								<div class="title-item" style="background-image: url('<?php echo esc_url($item['bg_image']['url'] ?? ''); ?>')"><?php echo esc_html($item['title']); ?></div>
							<?php endforeach; ?>
							<?php /* Đuôi cho hiệu ứng slide loop */ ?>
							<div class="title-item" style="background-image: url('<?php echo esc_url($home_about_titles[0]['bg_image']['url'] ?? ''); ?>')" aria-hidden="true"><?php echo esc_html($home_about_titles[0]['title']); ?></div>
						<?php else : ?>
							<div class="title-item" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/bg-banner-home.png')">BÁN MÁY</div>
							<div class="title-item" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/text.jpg')">SỬA CHỮA</div>
							<div class="title-item" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/1.jpg')">ĐÀO TẠO KỸ THUẬT</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="line"></div>
				<div class="desc">
					<?php echo $home_about_desc; ?>
				</div>
				<?php if ( !empty($home_about_btn) ) : ?>
					<a class="btn btn-primary" href="<?php echo esc_url($home_about_btn['url']); ?>" target="<?php echo esc_attr($home_about_btn['target'] ?: '_self'); ?>"><?php echo esc_html($home_about_btn['title']); ?></a>
				<?php endif; ?>
			</div>
			<div class="col-images">
				<div class="box-images">
					<div class="img-large">
						<div class="img">
							<img class="zoomEffect" src="<?php echo esc_url($home_about_img_large['url'] ?? get_template_directory_uri() . '/img/big_image.png'); ?>" alt="About">
						</div>
					</div>
					<div class="img-small">
						<div class="img">
							<img class="zoomEffect" src="<?php echo esc_url($home_about_img_small['url'] ?? get_template_directory_uri() . '/img/bg-banner-home.png'); ?>" alt="About">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
