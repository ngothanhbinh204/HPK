<?php
/* ── Section: Liên hệ tư vấn (Reusable Template Part) ── */
$contact_title = get_field('home_contact_title') ?: 'LIÊN HỆ TƯ VẤN';
$contact_desc = get_field('home_contact_desc') ?: 'Để lại thông tin, đội ngũ Hưng Phúc Khang sẽ liên hệ và tư vấn giải pháp phù hợp trong thời gian sớm nhất.';
$contact_image = get_field('home_contact_image');
$contact_form_shortcode = get_field('home_contact_form_shortcode'); // Link hoặc shortcode CF7
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
					<?php else : ?>
						<?php /* Fallback Form Structure từ index.html */ ?>
						<form action="">
							<div class="wrap-form">
								<div class="form-group"><input type="text" placeholder="Tên..."></div>
								<div class="form-group"><input type="email" placeholder="Email..."></div>
								<div class="form-group"><input type="text" placeholder="Điện thoại..."></div>
								<div class="form-group">
									<select>
										<option value="" disabled selected>Nhu cầu quan tâm</option>
										<option value="1">Bán máy Photocopy</option>
										<option value="2">Cho thuê máy Photocopy</option>
										<option value="3">Sửa chữa máy Photocopy</option>
										<option value="4">Đào tạo kỹ thuật</option>
									</select>
								</div>
								<div class="form-group full"><textarea placeholder="Nội dung..." rows="5"></textarea></div>
								<div class="form-button"><button class="btn btn-primary" type="submit"><span>GỬI</span></button></div>
							</div>
						</form>
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
