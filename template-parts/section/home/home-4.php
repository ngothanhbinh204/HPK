<?php
/* ── Section 4: Sản phẩm đang giảm giá (Tabs) ── */
$icon_title = get_field('icon_title');
$sale_title = get_field('home_sale_title') ?: 'SẢN PHẨM ĐANG GIẢM GIÁ';
$sale_cats = get_field('home_sale_cats'); // Taxonomy: product_cat
$view_shop = get_field('view_shop');
?>
<section class="home-4 section product-tabs-slider-section">
	<div class="container-seller">
		<div class="section-header">
			<div class="title flex items-end justify-center gap-2">
				<?php if($icon_title) : ?>
				<div class="icon-fire">
					<img class="lozad" data-src="<?php echo $icon_title['url']; ?>" alt="<?php echo $icon_title['alt']; ?>" />
				</div>
				<?php endif; ?>
				<h2 class="title-sale"><?php echo esc_html($sale_title); ?></h2>
			</div>
			<?php if ( $sale_cats ) : ?>
				<div class="tabs">
					<ul class="tabs-scroll-mobile" data-category-pool="<?php echo esc_attr( implode(',', wp_list_pluck( $sale_cats, 'term_id' )) ); ?>">
						<li class="tab-item active" data-category-id="all" data-tab="all"><?php _e('Tất cả', 'canhcamtheme'); ?></li>
						<?php foreach ( $sale_cats as $cat ) : ?>
							<li class="tab-item" data-category-id="<?php echo $cat->term_id; ?>" data-tab="cat-<?php echo $cat->term_id; ?>"><?php echo esc_html($cat->name); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
		<div class="relative" id="product-filter-result">
			<div class="loading-overlay">
				<div class="spinner"></div>
			</div>
			<div class="swiper home-4-swiper px-4">
				<div class="swiper-wrapper">
					<?php
					$args = array(
						'post_type'      => 'product',
						'posts_per_page' => 12,
					);

					if ( $sale_cats ) {
						$args['tax_query'] = array(
							array(
								'taxonomy' => 'product_cat',
								'field'    => 'term_id',
								'terms'    => wp_list_pluck( $sale_cats, 'term_id' ),
							),
						);
					}

					$query = new WP_Query($args);
					if ($query->have_posts()) :
						while ($query->have_posts()) : $query->the_post();
							$categories = get_the_terms(get_the_ID(), 'product_cat');
							$cat_slugs = '';
							if ($categories) {
								foreach ($categories as $cat) {
									$cat_slugs .= ' cat-' . $cat->term_id;
								}
							}
					?>
						<div class="swiper-slide h-auto" data-category="<?php echo esc_attr($cat_slugs); ?>">
							<?php get_template_part('template-parts/content', 'product'); ?>
						</div>
					<?php
						endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>
			</div>
			<div class="swiper-nav-wrapper">
				<div class="swiper-button-prev"><i class="fa-solid fa-chevron-left"></i></div>
				<div class="swiper-button-next"><i class="fa-solid fa-chevron-right"></i></div>
			</div>
		</div>
		<div class="block-btn text-center mt-10">
			<?php if($view_shop) : ?>
				<a class="btn btn-primary" href="<?php echo $view_shop['url']; ?>"><?php echo $view_shop['title']; ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>
