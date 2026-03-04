<?php
/**
 * Template Name: Home Page
 */

get_header();

/* ── MAPPING index.html → template-home.php ── */

// Section 1: Hero Slider
get_template_part('template-parts/section/home/home-1');

// Section 2: Về chúng tôi (Sliding Titles)
get_template_part('template-parts/section/home/home-2');

// Section 3: Counter
get_template_part('template-parts/section/home/home-3');

// Section 4: Sản phẩm đang giảm giá (Tabs)
get_template_part('template-parts/section/home/home-4');

// Section 5: Dịch vụ của chúng tôi (Accordion)
get_template_part('template-parts/section/home/home-5');

// Section 6: Cam kết chất lượng (Reusable)
get_template_part('template-parts/section/home/home-6');

// Section 7: Đối tác khách hàng
get_template_part('template-parts/section/home/home-7');

// Section 8: Tin tức nổi bật
get_template_part('template-parts/section/home/home-8');

// Section 9: Liên hệ tư vấn (Reusable)
get_template_part('template-parts/section/home/home-contact');

get_footer();
