<?php
/* ── Product Detail: Related Products ── */
$related_title = get_field('product_related_title') ?: 'MẪU MÁY LIÊN QUAN';

// Lấy sản phẩm liên quan dựa trên category của sản phẩm hiện tại
$current_id = get_the_ID();
$terms = get_the_terms($current_id, 'product_cat');
$term_ids = $terms ? wp_list_pluck($terms, 'term_id') : array();

$args = array(
	'post_type'      => 'product',
	'posts_per_page' => 8,
	'post__not_in'   => array($current_id),
	'tax_query'      => array(
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'term_id',
			'terms'    => $term_ids,
		),
	),
);

$query = new WP_Query($args);
?>
<section class="product-related section">
	<div class="container-seller">
		<div class="section-header text-center mb-10">
			<h2 class="section-title"><?php echo esc_html($related_title); ?></h2>
		</div>
		<div class="relative">
			<div class="swiper product-related-swiper">
				<div class="swiper-wrapper">
					<?php if ( $query->have_posts() ) : ?>
						<?php while ( $query->have_posts() ) : $query->the_post(); ?>
							<div class="swiper-slide h-auto">
								<?php get_template_part('template-parts/content', 'product'); ?>
							</div>
						<?php endwhile; wp_reset_postdata(); ?>
					<?php else : ?>
						<p class="text-center"><?php _e('Không có sản phẩm liên quan.', 'canhcamtheme'); ?></p>
					<?php endif; ?>
				</div>
			</div>
			<div class="swiper-nav-wrapper">
				<div class="swiper-button-prev"><i class="fa-light fa-chevron-left"></i></div>
				<div class="swiper-button-next"><i class="fa-light fa-chevron-right"></i></div>
			</div>
		</div>
	</div>
</section>
