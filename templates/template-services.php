<?php
/**
 * Template Name: Services Listing Page
 */

get_header();

/* ── MAPPING Service.html → template-services.php ── */

// 1. Breadcrumb
get_template_part('template-parts/section/global/breadcrumb');

// 2. Main Service Hero/Info Section
get_template_part('template-parts/section/service/service-1');

// 3. Commit Section (Reusable)
get_template_part('template-parts/section/home/home-6');

// 4. Products Section (Reusable Tabs Slider)
get_template_part('template-parts/section/home/home-4');

// 5. Contact Section (Reusable)
get_template_part('template-parts/section/home/home-contact');

get_footer();
