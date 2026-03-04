<?php
/**
 * Template Name: Contact Page
 */

get_header();

/* ── MAPPING Contact.html → template-contact.php ── */

// Breadcrumb
get_template_part('template-parts/section/global/breadcrumb');

// Main Contact Content
get_template_part('template-parts/section/contact/contact-main');

get_footer();
