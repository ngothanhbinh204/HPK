<?php

/**
 * Custom Post Types & Taxonomies - Hưng Phúc Khang Theme
 *
 * Chỉ sử dụng Post Type: product và bài viết (post) mặc định.
 * Loại bỏ các tiền tố hpk_ và các post type không sử dụng (service, partner).
 * Hỗ trợ đa ngôn ngữ WPML qua các hàm __().
 *
 * @package canhcamtheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. CPT: SẢN PHẨM (product)
 * Dùng cho: Bán máy, Cho thuê máy
 */
add_action( 'init', function () {
	create_post_type( 'product', array(
		'name'          => __( 'Sản Phẩm', 'canhcamtheme' ),
		'singular_name' => __( 'Sản Phẩm', 'canhcamtheme' ),
		'slug'          => 'san-pham',
		'icon'          => 'dashicons-cart',
		'menu_position' => 6,
		'has_archive'   => true,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'taxonomies'    => array( 'product_cat', 'product_type' ),
		'description'   => __( 'Quản lý danh sách máy photocopy và thiết bị in ấn', 'canhcamtheme' ),
		'rewrite'       => array(
			'slug'       => 'san-pham',
			'with_front' => false,
		),
	) );
} );

/**
 * 2. TAXONOMY: DANH MỤC SẢN PHẨM (product_cat)
 */
add_action( 'init', function () {
	create_taxonomy( 'product_cat', array(
		'name'          => __( 'Danh Mục Sản Phẩm', 'canhcamtheme' ),
		'singular_name' => __( 'Danh Mục Sản Phẩm', 'canhcamtheme' ),
		'object_type'   => array( 'product' ),
		'slug'          => 'danh-muc-san-pham',
		'hierarchical'  => true,
		'description'   => __( 'Phân loại theo hãng: Ricoh, Konica...', 'canhcamtheme' ),
		'rewrite'       => array(
			'slug'       => 'danh-muc-san-pham',
			'with_front' => false,
		),
	) );
} );

/**
 * 3. TAXONOMY: LOẠI HÌNH SẢN PHẨM (product_type)
 * Phân biệt Máy bán vs Máy cho thuê
 */
add_action( 'init', function () {
	create_taxonomy( 'product_type', array(
		'name'          => __( 'Loại Hình', 'canhcamtheme' ),
		'singular_name' => __( 'Loại Hình', 'canhcamtheme' ),
		'object_type'   => array( 'product' ),
		'slug'          => 'loai-hinh',
		'hierarchical'  => false,
		'description'   => __( 'Phân loại Bán máy hoặc Cho thuê máy', 'canhcamtheme' ),
		'rewrite'       => array(
			'slug'       => 'loai-hinh',
			'with_front' => false,
		),
	) );
} );



