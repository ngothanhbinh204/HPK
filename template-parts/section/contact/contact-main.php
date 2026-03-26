<?php
/* ── Contact Section ── */
$greeting = get_field('contact_greeting') ?: 'Xin chào chúng tôi là';
$brand_name = get_field('contact_brand') ?: get_bloginfo('name');
$details = get_field('contact_details'); // Repeater
$map_iframe = get_field('contact_map');
$form_header = get_field('contact_form_header');
$form_shortcode = get_field('contact_form_shortcode');
?>
<section class="contact">
	<div class="container">
		<div class="contact-wrapper">
			<div class="contact-info-col">
				<div class="contact-header">
					<p class="greeting"><?php echo esc_html($greeting); ?></p>
					<h1 class="brand-name"><?php echo esc_html($brand_name); ?></h1>
				</div>
				<div class="contact-details">
					<?php if ( $details ) : ?>
						<?php foreach ( $details as $item ) : ?>
							<div class="detail-item">
								<div class="icon">
									<i class="fa-light <?php echo esc_attr($item['icon']); ?>"></i>
								</div>
								<a href="<?php echo $item['link']['url']; ?>" class="text"><?php echo $item['link']['title']; ?></a>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<div class="contact-map">
					<?php if ( $map_iframe ) : ?>
						<?php echo $map_iframe; ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="contact-form-col">
				<div class="form-box">
					<div class="form-header">
						<?php if ( $form_header ) : ?>
							<div class="form-desc"><?php echo $form_header; ?></div>
						<?php endif; ?>
					</div>
					<div class="form-wrapper">
						<?php if ( $form_shortcode ) : ?>
							<?php echo do_shortcode($form_shortcode); ?>
						<?php else : ?>
							<?php 
							/* 
							Gợi ý script CF7 (Contact Form 7 structure):
							<div class="row_form">
								<div class="form-group">[text* your-name placeholder "Họ và tên"]</div>
								<div class="form-group">[email* your-email placeholder "Email"]</div>
							</div>
							<div class="row_form">
								<div class="form-group">[tel* your-tel placeholder "Điện thoại"]</div>
								<div class="form-group">[text your-subject placeholder "Tiêu đề"]</div>
							</div>
							<div class="row_form">
								<div class="form-group full-width">[textarea your-message placeholder "Nội dung" rows:5]</div>
							</div>
							<div class="form-submit">
								<button type="submit">Gửi <i class="fa-light fa-arrow-up-right"></i></button>
							</div>
							*/
							?>
							<form action="#" method="post">
								<div class="row_form">
									<div class="form-group"><span class="wpcf7-form-control-wrap"><input type="text" placeholder="Họ và tên"></span></div>
									<div class="form-group"><span class="wpcf7-form-control-wrap"><input type="email" placeholder="Email"></span></div>
								</div>
								<div class="row_form">
									<div class="form-group"><span class="wpcf7-form-control-wrap"><input type="tel" placeholder="Điện thoại"></span></div>
									<div class="form-group"><span class="wpcf7-form-control-wrap"><input type="text" placeholder="Tiêu đề"></span></div>
								</div>
								<div class="row_form">
									<div class="form-group full-width"><span class="wpcf7-form-control-wrap"><textarea placeholder="Nội dung" rows="5"></textarea></span></div>
								</div>
								<div class="form-submit">
									<button type="submit">Gửi <i class="fa-light fa-arrow-up-right"></i></button>
								</div>
							</form>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>	
	</div>
</section>
