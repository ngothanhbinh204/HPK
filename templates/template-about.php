<?php
/**
 * Template Name: About Page
 */

get_header();

/* ── MAPPING About.html → template-about.php ── */

// Page Banner
get_template_part('template-parts/section/about/about-banner');

// Breadcrumb
get_template_part('template-parts/section/global/breadcrumb');

// Section 1: Sliding Titles (Về chúng tôi)
get_template_part('template-parts/section/about/about-1');

// Section 2: Counter
get_template_part('template-parts/section/about/about-2');

// Section 3: Image Slider
get_template_part('template-parts/section/about/about-3');

get_footer();
