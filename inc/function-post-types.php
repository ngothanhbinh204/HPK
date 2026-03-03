<?php

/**
 * Custom Post Types & Taxonomies - Hưng Phúc Khang Theme
 *
 * Đăng ký các Custom Post Type dựa trên phân tích cấu trúc HTML tĩnh:
 * - index.html     → Sản phẩm (product), Dịch vụ (service), Tin tức (post WP mặc định), Đối tác (partner)
 * - ProductList.html / ProductDetail.html → CPT: hpk_product + Taxonomy: hpk_product_cat
 * - ChoThue.html   → CPT: hpk_product (dùng chung, phân loại qua taxonomy)
 * - Service.html   → CPT: hpk_service
 * - About.html     → Không cần CPT (dữ liệu tĩnh qua ACF Options hoặc Page)
 * - NewsList.html / NewsDetail.html → Post WP mặc định + Taxonomy: hpk_news_cat
 * - Contact.html   → Không cần CPT (form qua Contact Form 7)
 *
 * Các hàm create_post_type() và create_taxonomy() được định nghĩa trong function-root.php
 *
 * @package canhcamtheme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * =====================================================================
 * 1. CPT: SẢN PHẨM (hpk_product)
 * =====================================================================
 * Dùng cho: ProductList.html, ProductDetail.html, ChoThue.html
 * Template cần tạo:
 *   - archive-hpk_product.php
 *   - single-hpk_product.php
 * Phân loại qua taxonomy: hpk_product_cat
 * Phân biệt loại hình (bán/cho thuê) qua taxonomy: hpk_product_type
 * =====================================================================
 */
add_action( 'init', function () {
    create_post_type( 'hpk_product', array(
        'name'          => 'Sản Phẩm',
        'singular_name' => 'Sản Phẩm',
        'slug'          => 'san-pham',
        'icon'          => 'dashicons-cart',
        'menu_position' => 6,
        'has_archive'   => true,
        'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
        'taxonomies'    => array( 'hpk_product_cat', 'hpk_product_type' ),
        'description'   => 'Sản phẩm máy photocopy, máy in dùng cho trang Bán Máy và Cho Thuê Máy',
        'rewrite'       => array(
            'slug'       => 'san-pham',
            'with_front' => false,
        ),
    ) );
} );

/**
 * =====================================================================
 * 2. TAXONOMY: DANH MỤC SẢN PHẨM (hpk_product_cat)
 * =====================================================================
 * Dùng cho: Sidebar category list trong ProductList.html
 * Ví dụ: Máy photocopy Ricoh, Máy photocopy đa chức năng,
 *        Máy in màu Konica, Máy sao chụp khổ rộng
 * =====================================================================
 */
add_action( 'init', function () {
    create_taxonomy( 'hpk_product_cat', array(
        'name'          => 'Danh Mục Sản Phẩm',
        'singular_name' => 'Danh Mục Sản Phẩm',
        'object_type'   => array( 'hpk_product' ),
        'slug'          => 'danh-muc-san-pham',
        'hierarchical'  => true,
        'description'   => 'Phân loại sản phẩm: Ricoh, Konica, máy đa chức năng...',
        'rewrite'       => array(
            'slug'       => 'danh-muc-san-pham',
            'with_front' => false,
        ),
    ) );
} );

/**
 * =====================================================================
 * 3. TAXONOMY: LOẠI HÌNH SẢN PHẨM (hpk_product_type)
 * =====================================================================
 * Phân biệt sản phẩm dùng cho Bán Máy vs Cho Thuê Máy
 * Terms: ban-may, cho-thue-may
 * =====================================================================
 */
add_action( 'init', function () {
    create_taxonomy( 'hpk_product_type', array(
        'name'          => 'Loại Hình Sản Phẩm',
        'singular_name' => 'Loại Hình Sản Phẩm',
        'object_type'   => array( 'hpk_product' ),
        'slug'          => 'loai-hinh-san-pham',
        'hierarchical'  => false,
        'description'   => 'Phân biệt sản phẩm bán máy và cho thuê máy',
        'rewrite'       => array(
            'slug'       => 'loai-hinh',
            'with_front' => false,
        ),
    ) );
} );

/**
 * =====================================================================
 * 4. CPT: DỊCH VỤ (hpk_service)
 * =====================================================================
 * Dùng cho: Service.html (accordion dịch vụ ở home-5 và trang Service)
 * Các dịch vụ:
 *   - Bán máy Photocopy
 *   - Cho thuê máy Photocopy
 *   - Sửa chữa máy Photocopy
 *   - Đào tạo kỹ thuật sửa chữa máy Photocopy
 * Template cần tạo:
 *   - archive-hpk_service.php (trang danh sách dịch vụ)
 *   - single-hpk_service.php  (trang chi tiết dịch vụ - ServiceDetail.html)
 * =====================================================================
 */
add_action( 'init', function () {
    create_post_type( 'hpk_service', array(
        'name'          => 'Dịch Vụ',
        'singular_name' => 'Dịch Vụ',
        'slug'          => 'dich-vu',
        'icon'          => 'dashicons-hammer',
        'menu_position' => 7,
        'has_archive'   => true,
        'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
        'description'   => 'Các dịch vụ: Bán máy, Cho thuê, Sửa chữa, Đào tạo kỹ thuật',
        'rewrite'       => array(
            'slug'       => 'dich-vu',
            'with_front' => false,
        ),
    ) );
} );

/**
 * =====================================================================
 * 5. TAXONOMY: DANH MỤC TIN TỨC (hpk_news_cat)
 * =====================================================================
 * Dùng cho: NewsList.html, NewsDetail.html, home-8 section
 * Thay thế/bổ sung category WordPress mặc định, dùng taxonomy riêng
 * để không dùng chung với các post khác
 * Terms: tin-tuc, kien-thuc, su-kien
 * =====================================================================
 */
add_action( 'init', function () {
    create_taxonomy( 'hpk_news_cat', array(
        'name'          => 'Danh Mục Tin Tức',
        'singular_name' => 'Danh Mục Tin Tức',
        'object_type'   => array( 'post' ),
        'slug'          => 'danh-muc-tin-tuc',
        'hierarchical'  => true,
        'description'   => 'Phân loại tin tức: Tin tức, Kiến thức, Sự kiện',
        'rewrite'       => array(
            'slug'       => 'danh-muc-tin-tuc',
            'with_front' => false,
        ),
    ) );
} );

/**
 * =====================================================================
 * 6. CPT: ĐỐI TÁC (hpk_partner)
 * =====================================================================
 * Dùng cho: section home-7 "Đối tác khách hàng" (logo slider)
 * Không cần archive hay single page
 * Chỉ dùng để admin nhập logo đối tác
 * =====================================================================
 */
add_action( 'init', function () {
    create_post_type( 'hpk_partner', array(
        'name'          => 'Đối Tác',
        'singular_name' => 'Đối Tác',
        'slug'          => 'doi-tac',
        'icon'          => 'dashicons-groups',
        'menu_position' => 8,
        'has_archive'   => false,
        'supports'      => array( 'title', 'thumbnail' ),
        'description'   => 'Logo đối tác khách hàng hiển thị ở section slider trang chủ',
        'publicly_queryable' => false, // Không cần frontend route
        'rewrite'       => false,
    ) );
} );

/**
 * =====================================================================
 * NOTE: CÁC CPT/TAXONOMY SẼ ĐƯỢC BỔ SUNG KHI CẦN
 * =====================================================================
 * - hpk_testimonial: Đánh giá khách hàng (nếu có section testimonial)
 * - hpk_repair:      Sửa chữa (nếu Repair.html có template riêng,
 *                    hiện tại dùng hpk_service với term tương ứng)
 * =====================================================================
 *
 * MAPPING HTML → WordPress Template:
 * -----------------------------------
 * index.html        → front-page.php
 * About.html        → page-about.php (hoặc Custom Page Template)
 * Service.html      → page-service.php (hoặc archive-hpk_service.php)
 * ProductList.html  → archive-hpk_product.php
 * ProductDetail.html→ single-hpk_product.php
 * ChoThue.html      → archive-hpk_product.php?loai-hinh=cho-thue-may
 *                     hoặc page-cho-thue.php với WP_Query lọc taxonomy
 * NewsList.html     → archive.php (post mặc định)
 * NewsDetail.html   → single.php
 * Contact.html      → page-contact.php
 * =====================================================================
 */
