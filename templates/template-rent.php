<?php
/**
 * Template Name: Cho Thuê Page
 */

get_header();

/* ── MAPPING ChoThue.html → template-rent.php ── */

// Section 1: Hero Banner
get_template_part('template-parts/section/rent/chothue-1');

// Section 2: Đối tác thuê máy
get_template_part('template-parts/section/rent/chothue-2');

// Section 3: Cam kết chất lượng (Reusable from Home)
get_template_part('template-parts/section/home/home-6');

// Section 4: Danh mục sản phẩm cho thuê (Sidebar + Grid)
get_template_part('template-parts/section/rent/chothue-product-list');

// Section 5: Liên hệ tư vấn (Reusable from Home)
get_template_part('template-parts/section/home/home-contact');

// Section 6: FAQs
get_template_part('template-parts/section/rent/chothue-3');

// Section 7: Bảng giá cho thuê
get_template_part('template-parts/section/rent/chothue-4');

get_footer();
