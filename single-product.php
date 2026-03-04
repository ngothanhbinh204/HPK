<?php
/**
 * The template for displaying all single products
 */

get_header();

/* ── MAPPING ProductDetail.html → single-product.php ── */

while ( have_posts() ) :
	the_post();

	// 1. Breadcrumb
	get_template_part('template-parts/section/global/breadcrumb');

	// 2. Product Summary (Gallery + Info)
	get_template_part('template-parts/section/product/detail-summary');

	// 3. Product Accordion (Specs + Intro)
	get_template_part('template-parts/section/product/detail-accordion');

	// 4. Contact Section (Reusable)
	get_template_part('template-parts/section/home/home-contact');

	// 5. Related Products
	get_template_part('template-parts/section/product/related');

endwhile;

get_footer();
