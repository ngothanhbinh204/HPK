<?php
/**
 * Theme functions and definitions
 */
define('GENERATE_VERSION', '1.1.0');
define('PerpageProduct', 12);

require get_template_directory() . '/inc/function-setup.php';
require get_template_directory() . '/inc/function-field.php';
require get_template_directory() . '/inc/function-post-types.php';
require get_template_directory() . '/inc/function-pagination.php';
require get_template_directory() . '/inc/function-walker-menu.php';
require get_template_directory() . '/inc/function-custom.php';
require get_template_directory() . '/inc/function-root.php';

/**
 * Redirect product archive to Bán Máy Page
 */
add_action('template_redirect', function() {
    if ( is_post_type_archive('product') ) {
        $page_id = get_page_id_by_template('templates/template-product-list.php');
        if ( $page_id ) {
            wp_redirect(get_permalink($page_id), 301);
            exit;
        } else {
            // Fallback hardcode nếu không tìm thấy page template
            wp_redirect(home_url('/ban-may/'), 301);
            exit;
        }
    }
});

/**
 * Filter products by range price on archive
 */
add_action( 'pre_get_posts', function ( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( $query->is_post_type_archive( 'product' ) || $query->is_tax( 'product_cat' ) || $query->is_tax( 'product_type' ) ) {
        $meta_query = array( 'relation' => 'AND' );
        if ( isset( $_GET['min_price'] ) && isset( $_GET['max_price'] ) ) {
            $meta_query[] = array(
                'key'     => 'product_price',
                'value'   => array( intval( $_GET['min_price'] ), intval( $_GET['max_price'] ) ),
                'type'    => 'NUMERIC',
                'compare' => 'BETWEEN',
            );
        }
        if ( count($meta_query) > 1 ) {
            $query->set( 'meta_query', $meta_query );
        }
        $query->set( 'posts_per_page', PerpageProduct );
    }

    if ( $query->is_search() ) {
        $query->set( 'post_type', array( 'post', 'product' ) );
        $query->set( 'posts_per_page', PerpageProduct );
    }
} );

/**
 * AJAX Load More Products & Full Filtering
 */
add_action( 'wp_ajax_load_more_products', 'canhcam_load_more_products' );
add_action( 'wp_ajax_nopriv_load_more_products', 'canhcam_load_more_products' );

function canhcam_load_more_products() {
	$paged       = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$post_type   = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : 'product';
	$product_cat = isset($_POST['product_cat']) ? sanitize_text_field($_POST['product_cat']) : '';
	$min_price   = isset($_POST['min_price']) ? intval($_POST['min_price']) : 0;
	$max_price   = isset($_POST['max_price']) ? intval($_POST['max_price']) : 500000000;
	$orderby_val = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : '';

	$args = array(
		'post_type'      => $post_type,
		'posts_per_page' => PerpageProduct,
		'paged'          => $paged,
		'post_status'    => 'publish',
	);

	// Only apply Price Meta Query if user has filtered by price (not defaults)
	// This ensures products without price keys are still shown by default.
	if ( $min_price > 0 || $max_price < 500000000 ) {
		$args['meta_query'] = array(
			array(
				'key'     => 'product_price',
				'value'   => array($min_price, $max_price),
				'type'    => 'NUMERIC',
				'compare' => 'BETWEEN'
			)
		);
	}

	// ──  ACF: Lấy cấu hình Loại hình sản phẩm hiển thị của Trang hiện tại ──
	$page_id = isset($_POST['page_id']) ? intval($_POST['page_id']) : 0;
	// Chỉ lấy config nếu page_id thực sự là ID của một Page (để tránh lấy nhầm Post/Term có cùng ID)
	$is_actual_page         = ( 'page' === get_post_type($page_id) );
	$selected_product_types = $is_actual_page ? get_field('page_product_type', $page_id) : false;
	$include_empty          = $is_actual_page ? get_field('page_product_type_empty', $page_id) : false;
	
	$tax_query = array();

	if ( $product_cat ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $product_cat
			)
		);
	}

	// Sort logic
	if ($orderby_val == 'price') {
		$args['meta_key'] = 'product_price';
		$args['orderby']  = 'meta_value_num';
		$args['order']    = 'ASC';
	} elseif ($orderby_val == 'price-desc') {
		$args['meta_key'] = 'product_price';
		$args['orderby']  = 'meta_value_num';
		$args['order']    = 'DESC';
	} elseif ($orderby_val == 'date') {
		$args['orderby'] = 'date';
		$args['order']   = 'DESC';
	}

	$query = new WP_Query($args);
	$max_pages = $query->max_num_pages;

	ob_start();
	if ( $query->have_posts() ) :
		while ( $query->have_posts() ) : $query->the_post(); ?>
			<div class="product-column">
				<?php get_template_part('template-parts/content', 'product'); ?>
			</div>
		<?php endwhile;
	else :
		if($paged == 1) : ?>
			<p class="no-products"><?php _e('Không tìm thấy sản phẩm nào.', 'canhcamtheme'); ?></p>
		<?php endif;
	endif;
	$html = ob_get_clean();

	// Generation of the updated pagination components
	$pagination = '';
	$is_load_more_mode = isset($_POST['is_load_more']) && $_POST['is_load_more'] === 'true';

	if ( $is_load_more_mode ) {
		// Return Load More Button if there are more pages
		if ( $max_pages > 1 ) {
			ob_start(); ?>
			<div class="load-more-container text-center mt-8 flex justify-center gap-4">
				<button id="load-more-products" 
						data-current-page="1" 
						data-max-pages="<?php echo $max_pages; ?>"
						data-post-type="<?php echo esc_attr($post_type); ?>"
						data-product-cat="<?php echo esc_attr($product_cat); ?>"
						data-min-price="<?php echo $min_price; ?>"
						data-max-price="<?php echo $max_price; ?>"
						class="btn btn-primary btn-load-more">
					<?php _e('Xem thêm', 'canhcamtheme'); ?>
					<i class="fa-light fa-chevron-down"></i>
				</button>
				<button id="show-less-products" class="btn btn-primary btn-show-less" style="display: none;">
					<?php _e('Thu gọn', 'canhcamtheme'); ?>
					<i class="fa-light fa-chevron-up"></i>
				</button>
			</div>
			<?php 
			$pagination = ob_get_clean();
		}
	} else {
		// Return standard pagination links
		$pagination = paginate_links( array(
			'base'      => add_query_arg( 'page', '%#%' ),
			'format'    => '',
			'total'     => $max_pages,
			'current'   => $paged,
			'prev_text' => '<i class="fa-light fa-chevron-left"></i>',
			'next_text' => '<i class="fa-light fa-chevron-right"></i>',
			'type'      => 'list',
			'add_args'  => array(
				'product_cat' => $product_cat,
				'min_price'   => $min_price,
				'max_price'   => $max_price,
				'orderby'     => $orderby_val,
			)
		) );
	}

	wp_send_json_success(array(
		'html'       => $html,
		'pagination' => $pagination,
		'max_pages'  => $max_pages,
		'total'      => $query->found_posts,
	));
	die();
}

/**
 * AJAX Filter News by Category
 */
add_action('wp_ajax_filter_news_by_category', 'filter_news_by_category_handler');
add_action('wp_ajax_nopriv_filter_news_by_category', 'filter_news_by_category_handler');

function filter_news_by_category_handler() {
	$category_id = isset($_POST['category_id']) ? sanitize_text_field($_POST['category_id']) : 'all';
	
	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => 9,
		'post_status'    => 'publish',
	);

	if ( $category_id !== 'all' ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $category_id,
			),
		);
	}

	$query = new WP_Query($args);

	ob_start();
	if ($query->have_posts()) :
		$count = 0;
		while ($query->have_posts()) : $query->the_post();
			// HTML expects 3 items per swiper-slide (1 big, 2 small)
			if ( $count % 3 === 0 ) echo '<div class="swiper-slide"><div class="news-group">';
			
			if ( $count % 3 === 0 ) : ?>
				<div class="news-item big-item">
					<a class="img" href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('large'); ?>
					</a>
					<div class="content">
						<div class="meta">
							<span class="date"><?php echo get_the_date('d.m.Y'); ?></span>
							<span class="category"><?php echo get_the_category()[0]->name; ?></span>
						</div>
						<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p class="desc"><?php echo wp_trim_words(get_the_excerpt(), 999); ?></p>
					</div>
				</div>
				<div class="small-items">
			<?php else : ?>
				<div class="news-item small-item">
					<a class="img" href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('medium'); ?>
					</a>
					<div class="content">
						<div class="meta">
							<span class="date"><?php echo get_the_date('d.m.Y'); ?></span>
							<span class="category"><?php echo get_the_category()[0]->name; ?></span>
						</div>
						<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p class="desc"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
					</div>
				</div>
			<?php endif;

			if ( $count % 3 === 2 || $count === $query->post_count - 1 ) {
				echo '</div></div></div>'; // Close small-items, news-group, swiper-slide
			}
			$count++;
		endwhile;
		wp_reset_postdata();
	else :
		echo '<p class="no-news">' . __('Không có bài viết nào.', 'canhcamtheme') . '</p>';
	endif;

	$html = ob_get_clean();
	wp_send_json_success($html);
	die();
}

/**
 * AJAX Filter Products by Category (Home Page)
 */
add_action('wp_ajax_filter_products_by_category', 'filter_products_by_category_handler');
add_action('wp_ajax_nopriv_filter_products_by_category', 'filter_products_by_category_handler');

function filter_products_by_category_handler() {
	$category_id   = isset($_POST['category_id']) ? sanitize_text_field($_POST['category_id']) : 'all';
	$category_pool = isset($_POST['category_pool']) ? sanitize_text_field($_POST['category_pool']) : '';
	
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => PerpageProduct,
		'post_status'    => 'publish',
	);

	if ( $category_id !== 'all' ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $category_id,
			),
		);
	} elseif ( !empty($category_pool) ) {
		$pool_array = array_map('intval', explode(',', $category_pool));
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $pool_array,
			),
		);
	}
	
	// Khắc phục lỗi ngôn ngữ nếu có WPML AJAX (bảo đảm lấy đúng ngôn ngữ hiện tại nếu WPML thất lạc config)
	// $args['suppress_filters'] = false; // Mặc định false

	$query = new WP_Query($args);

	ob_start();
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
	else :
		echo '<div class="no-products-wrapper w-full text-center py-10">';
		echo '<p class="no-products">' . __('Không có sản phẩm nào.', 'canhcamtheme') . '</p>';
		echo '</div>';
	endif;

	$html = ob_get_clean();
	wp_send_json_success(array(
		'html'  => $html,
		'count' => $query->found_posts
	));
	die();
}






