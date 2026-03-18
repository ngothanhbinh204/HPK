<?php
/* ── About Banner ── */
$page_banner = get_field('page_banner');
?>
<section class="page-banner-main">
	<div class="img img-ratio ">
		<?php if ( $page_banner ) : ?>
			<img class="lozad" data-src="<?php echo esc_url($page_banner['url']); ?>" alt="<?php the_title(); ?>" />
		<?php else : ?>
			<img class="lozad" data-src="<?php echo get_template_directory_uri(); ?>/img/1.jpg" alt="About Banner" />
		<?php endif; ?>
	</div>
</section>
