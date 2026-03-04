<?php
/* ── Section 1: Hero Banner (Cho Thuê Page) ── */
// Lấy dữ liệu từ trang sử dụng template-rent.php để dùng chung ở nhiều trang
$rent_page_id = get_page_id_by_template('templates/template-rent.php') ?: get_the_ID();

$rent_hero_title = get_field('rent_hero_title', $rent_page_id) ?: 'Hưng Phúc Khang';
$rent_hero_desc = get_field('rent_hero_desc', $rent_page_id) ?: 'Đối tác phân phối & dịch vụ máy photocopy, máy in chuyên nghiệp';
$rent_hero_bg = get_field('rent_hero_bg', $rent_page_id);
$rent_hero_img = get_field('rent_hero_img', $rent_page_id);
?>
<section class="chothue-1">
	<div class="slide-item">
		<div class="slide-bg">
			<a class="img-ratio ratio:pt-[800_1920] xl:ratio:pt-[600_1920]" href="javascript:void(0)">
				<?php if ( $rent_hero_bg ) : ?>
					<img class="lozad" data-src="<?php echo esc_url($rent_hero_bg['url']); ?>" alt="<?php echo esc_attr($rent_hero_bg['alt'] ?: 'Background'); ?>" />
				<?php else : ?>
					<img class="lozad" data-src="<?php echo get_template_directory_uri(); ?>/img/bg_banner_2.png" alt="Background" />
				<?php endif; ?>
			</a>
			<div class="slide-overlay"></div>
			<img class="layer-union" src="<?php echo get_template_directory_uri(); ?>/img/Union.svg" alt="Decoration">
		</div>
		<div class="slide-content">
			<div class="slide-decorations">
				<img class="deco-goctren" src="<?php echo get_template_directory_uri(); ?>/img/goctren.svg" alt="Decor">
				<img class="deco-gocduoi" src="<?php echo get_template_directory_uri(); ?>/img/gocduoi.svg" alt="Decor">
			</div>
			<div class="slide-inner">
				<div class="slide-info" data-aos="fade-right">
					<h2 class="slide-title"><?php echo esc_html($rent_hero_title); ?></h2>
					<p class="slide-desc"><?php echo esc_html($rent_hero_desc); ?></p>
				</div>
				<div class="slide-image" data-aos="fade-left">
					<?php if ( $rent_hero_img ) : ?>
						<img class="lozad" data-src="<?php echo esc_url($rent_hero_img['url']); ?>" alt="<?php echo esc_attr($rent_hero_img['alt'] ?: 'Product'); ?>" />
					<?php else : ?>
						<img class="lozad" data-src="<?php echo get_template_directory_uri(); ?>/img/product-banner.png" alt="Product" />
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
