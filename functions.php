<?php
/**
 * Theme functions and definitions
 */
define('GENERATE_VERSION', '1.1.0');

require get_template_directory() . '/inc/function-setup.php';
require get_template_directory() . '/inc/function-field.php';
require get_template_directory() . '/inc/function-post-types.php';
require get_template_directory() . '/inc/function-pagination.php';
require get_template_directory() . '/inc/function-walker-menu.php';
require get_template_directory() . '/inc/function-custom.php';
require get_template_directory() . '/inc/function-root.php';

/**
 * Filter products by range price on archive
 */
add_action( 'pre_get_posts', function ( $query ) {
    if ( ! is_admin() && $query->is_main_query() && ( is_post_type_archive( 'product' ) || is_tax( 'product_cat' ) ) ) {
        $meta_query = array( 'relation' => 'AND' );
        if ( isset( $_GET['min_price'] ) && isset( $_GET['max_price'] ) ) {
            $meta_query[] = array(
                'key'     => 'product_price',
                'value'   => array( intval( $_GET['min_price'] ), intval( $_GET['max_price'] ) ),
                'type'    => 'NUMERIC',
                'compare' => 'BETWEEN',
            );
        }
        $query->set( 'meta_query', $meta_query );
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
		'posts_per_page' => 12,
		'paged'          => $paged,
		'post_status'    => 'publish',
		'meta_query'     => array(
			array(
				'key'     => 'product_price',
				'value'   => array($min_price, $max_price),
				'type'    => 'NUMERIC',
				'compare' => 'BETWEEN'
			)
		)
	);

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

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) { 
			$query->the_post();
			echo '<div class="product-column">';
			get_template_part('template-parts/content', 'product');
			echo '</div>';
		}
		
		if($paged == 1) {
			echo '<input type="hidden" id="data-ajax-max-pages" value="' . $max_pages . '">';
		}
	} else {
		if($paged == 1) {
			echo '<p class="no-products">' . __('Không tìm thấy sản phẩm nào.', 'canhcamtheme') . '</p>';
			echo '<input type="hidden" id="data-ajax-max-pages" value="0">';
		}
	}

	wp_reset_postdata();
	die();
}
