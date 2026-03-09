<?php
/**
 * The Template for displaying product archives
 */

if ( !isset($is_included_in_page) ) {
	get_header();
}

/* ── MAPPING ProductList.html → archive-product.php ── */

if ( !isset($is_included_in_page) ) {
	// 1. Banner (Lấy từ Options hoặc Taxonomy nếu cần)
	get_template_part('template-parts/section/global/banner-archive');

	// 2. Breadcrumb
	get_template_part('template-parts/section/global/breadcrumb');
}

// Logic: Check if we are on Bán Máy Page (Page Template)
$is_product_page_template = is_page_template('templates/template-product-list.php');
$current_term = get_queried_object();
$terms = get_terms(array(
	'taxonomy'   => 'product_cat',
	'hide_empty' => true,
));
$first_term = ($terms && !is_wp_error($terms)) ? $terms[0] : null;

// Filter Values from URL
$min_price = isset($_GET['min_price']) ? intval($_GET['min_price']) : 0;
$max_price = isset($_GET['max_price']) ? intval($_GET['max_price']) : 500000000; // 500tr fallback
$url_cat   = isset($_GET['product_cat']) ? sanitize_text_field($_GET['product_cat']) : '';

// Base URL for filters (category links, form action)
$base_url = isset($filter_base_url) ? $filter_base_url : '';

// Active Category Logic
$active_cat_id = 0;
if ( is_tax('product_cat') ) {
	$active_cat_id = $current_term->term_id;
} elseif ( $url_cat ) {
	$term_by_slug = get_term_by('slug', $url_cat, 'product_cat');
	if ( $term_by_slug ) $active_cat_id = $term_by_slug->term_id;
}
$is_ajax_filter = true;
$ajax_class = (isset($is_ajax_filter) && $is_ajax_filter) ? 'ajax-filter-enabled' : '';
?>
<section class="product-list <?php echo $ajax_class; ?>" id="product-list-section" data-ajax-filter="<?php echo (isset($is_ajax_filter) && $is_ajax_filter) ? 'true' : 'false'; ?>">
	<div class="container-full">
		<div class="wrapper">
			<aside class="sidebar">
				<div class="side-box sticky-sidebar">
					<div class="box-category">
						<div class="box-title"><?php _e('DANH MỤC SẢN PHẨM', 'canhcamtheme'); ?></div>
						<ul class="category-list">
							<?php
							if ($terms && !is_wp_error($terms)) :
								foreach ($terms as $term) :
									$active_class = ( $active_cat_id === $term->term_id ) ? 'active' : '';
									// Custom link if base_url is set
									$link = $base_url ? add_query_arg('product_cat', $term->slug, $base_url) : get_term_link($term);
									$link_class = (isset($is_ajax_filter) && $is_ajax_filter) ? 'ajax-cat-link' : '';
							?>
								<li class="<?php echo $active_class; ?>">
									<a href="<?php echo esc_url($link); ?>" class="<?php echo $link_class; ?>" data-slug="<?php echo $term->slug; ?>">
										<?php echo $term->name; ?>
									</a>
								</li>
							<?php
								endforeach;
							endif;
							?>
						</ul>
					</div>
					<div class="box-price">
						<div class="box-title"><?php _e('GIÁ SẢN PHẨM', 'canhcamtheme'); ?></div>
						<div class="price-range">
							<div id="price-slider" 
								 data-min="0" 
								 data-max="500000000" 
								 data-start-min="<?php echo $min_price; ?>" 
								 data-start-max="<?php echo $max_price; ?>">
							</div>
							<div class="range-info">
								<span id="price-min-label">0</span>
								<span id="price-max-label">500,000,000đ</span>
							</div>
							<form id="price-filter-form" method="GET" action="<?php echo esc_url($base_url); ?>">
								<?php /* Giữ các params hiện có như orderby và product_cat */ ?>
								<input type="hidden" name="orderby" id="input-orderby" value="<?php echo isset($_GET['orderby']) ? esc_attr($_GET['orderby']) : ''; ?>">
								<input type="hidden" name="product_cat" id="input-product-cat" value="<?php echo esc_attr($url_cat); ?>">

								<input type="hidden" name="min_price" id="input-min-price" value="<?php echo $min_price; ?>">
								<input type="hidden" name="max_price" id="input-max-price" value="<?php echo $max_price; ?>">
								<!-- <button type="submit" class="btn-filter-price"><?php _e('Lọc giá', 'canhcamtheme'); ?></button> -->
							</form>
						</div>
					</div>
				</div>
			</aside>
			<main class="main-content">
				<div class="content-header">
					<h1 class="title" id="archive-title" 
						data-default-title="<?php echo isset($product_title) ? esc_attr($product_title) : __('Sản phẩm', 'canhcamtheme'); ?>"
						data-prefix="<?php echo (isset($is_included_in_page) && $is_included_in_page) ? __('Cho Thuê', 'canhcamtheme') : ''; ?> ">
						<?php 
						$prefix = (isset($is_included_in_page) && $is_included_in_page) ? __('Cho Thuê', 'canhcamtheme') : '';
						if ( is_tax() ) {
							echo $prefix . single_term_title('', false);
						} elseif ( $active_cat_id ) {
							$act_term = get_term($active_cat_id);
							echo $prefix . $act_term->name;
						} else {
							echo isset($product_title) ? esc_html($product_title) : __('Sản phẩm', 'canhcamtheme');
						}
						?>
					</h1>
					<button class="btn btn-primary btn-remove-filter lg:ml-auto">
						<i class="fa-light fa-filter-slash"></i>
						<?php _e('Hủy Lọc', 'canhcamtheme'); ?>
					</button>
					<div class="sort-block">
						<span><?php _e('SẮP XẾP', 'canhcamtheme'); ?></span>
						<?php 
						$onchange = (isset($is_ajax_filter) && $is_ajax_filter) ? '' : 'onchange="location = this.value;"';
						$select_class = (isset($is_ajax_filter) && $is_ajax_filter) ? 'ajax-sort-select' : '';
						$current_orderby = isset($_GET['orderby']) ? $_GET['orderby'] : '';
						?>
						<select name="sort" class="<?php echo $select_class; ?>" <?php echo $onchange; ?>>
							<option value="all" <?php selected($current_orderby, ''); ?>><?php _e('Tất cả', 'canhcamtheme'); ?></option>
							<option value="date" <?php selected($current_orderby, 'date'); ?>><?php _e('Mới nhất', 'canhcamtheme'); ?></option>
							<option value="price" <?php selected($current_orderby, 'price'); ?>><?php _e('Giá thấp đến cao', 'canhcamtheme'); ?></option>
							<option value="price-desc" <?php selected($current_orderby, 'price-desc'); ?>><?php _e('Giá cao đến thấp', 'canhcamtheme'); ?></option>
						</select>
					</div>
				</div>

				<div class="product-refresh-wrapper" style="position: relative; min-height: 200px;">
					<div id="ajax-loader" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.7); z-index: 10; align-items: center; justify-content: center;">
						<i class="fa-light fa-spinner-third fa-spin" style="font-size: 40px; color: #000;"></i>
					</div>
				
					<div class="product-grid" id="product-grid-container">
					<?php 
					// Build Meta Query for Price Filter
					$meta_query = array('relation' => 'AND');
					if ( isset($_GET['min_price']) || isset($_GET['max_price']) ) {
						$meta_query[] = array(
							'key'     => 'product_price',
							'value'   => array($min_price, $max_price),
							'type'    => 'NUMERIC',
							'compare' => 'BETWEEN'
						);
					}

					// If we are on Page Template OR if it's explicitly included with flags
					if ( ($is_product_page_template || isset($is_included_in_page)) && !is_tax() ) {
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						$args = array(
							'post_type'      => 'product',
							'posts_per_page' => 12,
							'paged'          => $paged,
							'meta_query'     => $meta_query
						);

						// ──  ACF: Lấy cấu hình Loại hình sản phẩm hiển thị của Trang hiện tại ──
						$current_page_id = get_queried_object_id();
						$selected_product_types = get_field('page_product_type', $current_page_id);
						$include_empty          = get_field('page_product_type_empty', $current_page_id);
						
						$tax_query = array();

						// Filter by URL Product Category if any
						if ( $url_cat ) {
							$tax_query[] = array(
								'taxonomy' => 'product_cat',
								'field'    => 'slug',
								'terms'    => $url_cat
							);
						}

						// Filter by Product Type via ACF configuration
						if ( !empty($selected_product_types) ) {
							if ( $include_empty ) {
								// Include specific terms OR products that have NO product_type term
								$tax_query[] = array(
									'relation' => 'OR',
									array(
										'taxonomy' => 'product_type',
										'field'    => 'term_id',
										'terms'    => $selected_product_types,
										'operator' => 'IN'
									),
									array(
										'taxonomy' => 'product_type',
										'operator' => 'NOT EXISTS' // Lấy cả những SP chưa được gắn Loại hình
									)
								);
							} else {
								// Only display products with strictly matching term_ids
								$tax_query[] = array(
									'taxonomy' => 'product_type',
									'field'    => 'term_id',
									'terms'    => $selected_product_types,
									'operator' => 'IN'
								);
							}
						}

						// Apply taxonomy queries if not empty
						if ( !empty($tax_query) ) {
							$tax_query['relation'] = 'AND';
							$args['tax_query'] = $tax_query;
						}
						
						// Sort logic
						$orderby = isset($_GET['orderby']) ? $_GET['orderby'] : '';
						if ($orderby == 'price') {
							$args['meta_key'] = 'product_price';
							$args['orderby']  = 'meta_value_num';
							$args['order']    = 'ASC';
						} elseif ($orderby == 'price-desc') {
							$args['meta_key'] = 'product_price';
							$args['orderby']  = 'meta_value_num';
							$args['order']    = 'DESC';
						}

						$temp_query = new WP_Query($args);
						if ($temp_query->have_posts()) :
							while ($temp_query->have_posts()) : $temp_query->the_post(); ?>
								<div class="product-column">
									<?php get_template_part('template-parts/content', 'product'); ?>
								</div>
							<?php endwhile;
							// Store max pages for JS load more if needed
							$max_pages = $temp_query->max_num_pages;
							wp_reset_postdata();
						else : ?>
							<p><?php _e('Không tìm thấy sản phẩm nào trong tầm giá này.', 'canhcamtheme'); ?></p>
						<?php endif;
					} else {
						/* Standard Archive */
						if ( have_posts() ) :
							while ( have_posts() ) : the_post(); ?>
								<div class="product-column">
									<?php get_template_part('template-parts/content', 'product'); ?>
								</div>
							<?php endwhile;
						else : ?>
							<p><?php _e('Không tìm thấy sản phẩm nào trong tầm giá này.', 'canhcamtheme'); ?></p>
						<?php endif;
					}
					?>
				</div>
				<div class="pagination-wrapper">
					<?php
					if ( isset($is_load_more) && $is_load_more ) {
						// Load More Button instead of pagination
						if ( isset($max_pages) && $max_pages > 1 ) :
						?>
						<div class="load-more-container text-center mt-8">
							<button id="load-more-products" 
									data-current-page="1" 
									data-max-pages="<?php echo $max_pages; ?>"
									data-post-type="product"
									data-product-cat="<?php echo esc_attr($url_cat); ?>"
									data-min-price="<?php echo $min_price; ?>"
									data-max-price="<?php echo $max_price; ?>"
									class="btn-load-more">
								<?php _e('Xem thêm', 'canhcamtheme'); ?>
								<i class="fa-light fa-arrow-rotate-right"></i>
							</button>
						</div>
						<?php endif;
					} elseif ( $is_product_page_template && !is_tax() ) {
						echo paginate_links( array(
							'total' => $temp_query->max_num_pages,
							'prev_text' => '<i class="fa-light fa-chevron-left"></i>',
							'next_text' => '<i class="fa-light fa-chevron-right"></i>',
							'type'      => 'list',
						) );
					} else {
						the_posts_pagination( array(
							'prev_text' => '<i class="fa-light fa-chevron-left"></i>',
							'next_text' => '<i class="fa-light fa-chevron-right"></i>',
							'type'      => 'list',
						) );
					}
					?>
				</div>
			</main>
		</div>
	</div>
</section>

<?php
if ( !isset($is_included_in_page) ) {
	// 3. Contact Section (Reusable)
	get_template_part('template-parts/section/home/home-contact');
	get_footer();
}
