<?php
/* ── Global Archive Banner ── */
// Có thể lấy ảnh banner chung từ Options Page hoặc banner đặc thù cho từng Post Type
$archive_banner = get_field('archive_product_banner', 'options');
?>
<section class="page-banner-main">
	<div class="img img-ratio">
		<?php if ( $archive_banner ) : ?>
			<img class="lozad" data-src="<?php echo esc_url($archive_banner['url']); ?>" alt="<?php post_type_archive_title(); ?>" />
		<?php else : ?>
			<img class="lozad" data-src="<?php echo get_template_directory_uri(); ?>/img/1.jpg" alt="Archive Banner" />
		<?php endif; ?>
	</div>
</section>
