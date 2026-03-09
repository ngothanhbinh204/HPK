<?php
/* ── Section: Liên hệ tư vấn (Reusable Template Part) ── */
$contact_title = get_field('home_contact_title', 'option') ?: '';
$contact_desc = get_field('home_contact_desc', 'option') ?: '';
$contact_image = get_field('home_contact_image', 'option');
$contact_form_shortcode = get_field('home_contact_form_shortcode', 'option'); // Link hoặc shortcode CF7
?>
<section class="home-contact">
	<div class="bg-pattern"><img src="<?php echo get_template_directory_uri(); ?>/img/partent_h_2.svg" alt="Pattern"></div>
	<div class="container-full">
		<div class="wrapper">
			<div class="col-form" data-aos="fade-right">
				<h2 class="block-title"><?php echo esc_html($contact_title); ?></h2>
				<p class="desc"><?php echo esc_html($contact_desc); ?></p>
				<div class="contact-form">
					<?php if ( $contact_form_shortcode ) : ?>
						<?php echo do_shortcode($contact_form_shortcode); ?>
					
					<?php endif; ?>
				</div>
			</div>
			<div class="col-image" data-aos="fade-left">
				<div class="img">
					<img src="<?php echo esc_url($contact_image['url'] ?? get_template_directory_uri() . '/img/contact_image.png'); ?>" alt="Contact">
				</div>
			</div>
		</div>
	</div>
</section>
