<?php
/**
 * Template Name: Bán Máy (Product List)
 */

get_header();

/* ── MAPPING ProductList.html → template-product-list.php ── */

// 1. Banner
get_template_part('modules/common/banner');

// 2. Breadcrumb
get_template_part('template-parts/section/global/breadcrumb');

$is_included_in_page = true;
include get_template_directory() . '/archive-product.php';
?>



<?php
// Contact Section
get_template_part('template-parts/section/home/home-contact');

get_footer();
