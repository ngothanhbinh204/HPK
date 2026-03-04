<?php
/* ── Section: Danh sách sản phẩm (Cho Thuê Page) ── */

// Cấu hình để include archive-product.php
$is_included_in_page = true;
$is_load_more        = true; // Sử dụng nút Xem thêm
$is_ajax_filter      = true; // Bật chế độ lọc AJAX không load lại trang
$filter_base_url     = get_permalink(); // Stay on this page when filtering
$product_title       = get_field('rent_list_title') ?: 'Sản phẩm cho thuê';

include get_template_directory() . '/archive-product.php';
