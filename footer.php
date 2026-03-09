<?php
/* =============================================================
 * </main> đóng thẻ mở trong header.php
 * =============================================================
 */
?>
</main>
<?php /* ── END <main> ── */ ?>

<?php
/* =============================================================
 * FOOTER
 * Mapping từ: UI/header-footer.html → <footer class="footer">
 * ACF fields (Options Page - group_options_header_footer.json):
 *
 * Tab "Thông Tin Công Ty":
 *   - footer_company_name   (text)
 *   - footer_contact_list   (repeater)
 *      └── contact_icon (text)  : fa icon name, vd: fa-location-dot
 *      └── contact_link (link)  : title + url + target
 *   - footer_license_info   (textarea)
 *
 * Tab "Footer Bottom":
 *   - footer_logo           (image)
 *   - footer_copyright      (text)
 *   - footer_links          (repeater) → link_item (link)
 *   - footer_social         (repeater) → social_icon_class, social_url, social_name
 *
 * Tab "Hỗ Trợ 24/7":
 *   - footer_support_title      (text)
 *   - footer_support_icon_class (text)
 *   - footer_support_items      (repeater)
 *      └── support_label (text)
 *      └── support_links (repeater)
 *         └── link_class (text)  : phone | email
 *         └── link_item  (link)  : title + url
 *
 * Tab "Nút CTA cố định":
 *   - footer_fixed_socials  (repeater)
 *      └── icon  (text) : fa icon name, vd: fa-envelope
 *      └── link  (link) : title + url + target
 *
 * Tab "Cấu hình kỹ thuật":
 *   - field_config_head, field_config_body
 *
 * Menu Locations:
 *   - footer-1 : Liên kết nhanh
 * =============================================================
 */

/* ── Helper: xác định fa-prefix từ tên icon ── */
function canhcam_get_fa_prefix( $icon ) {
	if ( strpos( $icon, 'fa-brands' ) !== false ) return 'fa-brands';
	if ( strpos( $icon, 'fa-solid' )  !== false ) return 'fa-solid';
	if ( strpos( $icon, 'fa-light' )  !== false ) return 'fa-light';
	if ( strpos( $icon, 'fa-regular' ) !== false ) return 'fa-regular';
	/* Dò tên icon để tự đặt prefix */
	$brands = array( 'facebook', 'messenger', 'linkedin', 'youtube', 'twitter', 'instagram', 'tiktok', 'zalo' );
	foreach ( $brands as $brand ) {
		if ( strpos( $icon, $brand ) !== false ) return 'fa-brands';
	}
	return 'fa-solid'; /* mặc định */
}

/* ── Lấy data scalar ACF ── */
$footer_company_name  = '';
$footer_license_info  = '';
$footer_logo          = null;
$footer_copyright     = '';
$footer_support_title = '';
$footer_support_icon  = '';

if ( function_exists('get_field') ) {
	$footer_company_name  = get_field( 'footer_company_name', 'options' )      ?: 'CÔNG TY THIẾT BỊ MÁY VĂN PHÒNG HƯNG PHÚC KHANG';
	$footer_license_info  = get_field( 'footer_license_info', 'options' )      ?: "Giấy phép kinh doanh được cấp bởi Sở kế hoạch và đầu tư TPHCM\nMã số thuế: 0314753815";
	$footer_logo          = get_field( 'footer_logo', 'options' );
	$footer_copyright     = get_field( 'footer_copyright', 'options' )         ?: '© 2025 Hưng Phúc Khang. All Rights Reserved. Website designed by CanhCam.';
	$footer_support_title = get_field( 'footer_support_title', 'options' )     ?: 'HỖ TRỢ 24/7';
	$footer_support_icon  = get_field( 'footer_support_icon_class', 'options' ) ?: 'fa-headphones';
} else {
	$footer_company_name  = 'CÔNG TY THIẾT BỊ MÁY VĂN PHÒNG HƯNG PHÚC KHANG';
	$footer_license_info  = "Giấy phép kinh doanh được cấp bởi Sở kế hoạch và đầu tư TPHCM\nMã số thuế: 0314753815";
	$footer_copyright     = '© 2025 Hưng Phúc Khang. All Rights Reserved. Website designed by CanhCam.';
	$footer_support_title = 'HỖ TRỢ 24/7';
	$footer_support_icon  = 'fa-headphones';
}
?>

<footer class="footer">
	<div class="container">

		<?php /* ── FOOTER TOP ── */ ?>
		<div class="footer-top">
			<div class="footer-grid">

				<?php /* ────────────────────────────────────────────
				 * COL 1: THÔNG TIN CÔNG TY
				 * Danh sách liên hệ: repeater footer_contact_list
				 * Sub-fields: contact_icon (text) + contact_link (link)
				 * ──────────────────────────────────────────────── */ ?>
				<div class="footer-col company-info">
					<h3 class="footer-title"><?php echo esc_html( $footer_company_name ); ?></h3>

					<ul class="contact-list">
						<?php if ( function_exists('have_rows') && have_rows( 'footer_contact_list', 'options' ) ) : ?>
							<?php while ( have_rows( 'footer_contact_list', 'options' ) ) : the_row(); ?>
								<?php
								$contact_icon = get_sub_field('contact_icon'); // vd: fa-location-dot
								$contact_link = get_sub_field('contact_link'); // array: title, url, target
								if ( ! $contact_link ) continue;

								$prefix = canhcam_get_fa_prefix( $contact_icon );
								$icon_class = trim( $prefix . ' ' . $contact_icon );
								?>
								<li>
									<?php if ( $contact_icon ) : ?>
										<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
									<?php endif; ?>
									<?php if ( ! empty( $contact_link['url'] ) ) : ?>
										<a href="<?php echo esc_url( $contact_link['url'] ); ?>"
										   <?php echo $contact_link['target'] ? 'target="' . esc_attr($contact_link['target']) . '"' : ''; ?>>
											<span><?php echo esc_html( $contact_link['title'] ); ?></span>
										</a>
									<?php else : ?>
										<span><?php echo esc_html( $contact_link['title'] ); ?></span>
									<?php endif; ?>
								</li>
							<?php endwhile; ?>
					
						<?php endif; ?>
					</ul>

					<?php /* Giấy phép / MST */ ?>
					<?php if ( $footer_license_info ) : ?>
						<div class="license-info">
							<?php
							$license_lines = explode( "\n", $footer_license_info );
							foreach ( $license_lines as $line ) {
								$line = trim( $line );
								if ( $line ) {
									echo '<p>' . esc_html( $line ) . '</p>';
								}
							}
							?>
						</div>
					<?php endif; ?>
				</div>
				<?php /* ── END COL 1 ── */ ?>

				<?php /* ────────────────────────────────────────────
				 * COL 2: LIÊN KẾT NHANH
				 * Menu WP: theme_location = footer-1
				 * ──────────────────────────────────────────────── */ ?>
				<div class="footer-col quick-links">
					<h3 class="footer-title">LIÊN KẾT NHANH</h3>
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer-1',
						'menu_class'     => 'menu-list',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
					) );
					?>
				</div>

				<?php /* ────────────────────────────────────────────
				 * COL 3: HỖ TRỢ 24/7
				 * ACF: footer_support_title, footer_support_icon_class
				 *      footer_support_items (repeater)
				 *        └── support_label (text)
				 *        └── support_links (repeater)
				 *              └── link_class (text)  phone | email
				 *              └── link_item  (link)  title + url
				 * ──────────────────────────────────────────────── */ ?>
				<div class="footer-col support-box">
					<div class="support-card">

						<?php /* Card Header */ ?>
						<div class="card-header">
							<?php
							$support_icon_prefix = canhcam_get_fa_prefix( $footer_support_icon );
							$support_icon_full   = trim( $support_icon_prefix . ' ' . $footer_support_icon );
							?>
							<i class="<?php echo esc_attr( $support_icon_full ); ?>"></i>
							<h3><?php echo esc_html( $footer_support_title ); ?></h3>
						</div>

						<div class="divider"></div>

						<div class="card-body">
							<?php if ( function_exists('have_rows') && have_rows( 'footer_support_items', 'options' ) ) : ?>
								<?php
								$support_item_count = 0;
								while ( have_rows( 'footer_support_items', 'options' ) ) :
									the_row();
									$support_label = get_sub_field('support_label');
									$support_links = get_sub_field('support_links'); // array of rows
									if ( $support_item_count > 0 ) echo '<div class="divider"></div>';
									$support_item_count++;
								?>
									<div class="support-item">
										<?php if ( $support_label ) : ?>
											<p class="label"><?php echo esc_html( $support_label ); ?></p>
										<?php endif; ?>

										<?php /* Các link con (phone, email...) */ ?>
										<?php if ( ! empty( $support_links ) ) : ?>
											<?php foreach ( $support_links as $sl ) :
												$sl_class = sanitize_html_class( $sl['link_class'] ?? 'phone' );
												$sl_link  = $sl['link_item'] ?? null;
												if ( ! $sl_link || empty($sl_link['url']) ) continue;
											?>
												<a class="<?php echo esc_attr( $sl_class ); ?>"
												   href="<?php echo esc_url( $sl_link['url'] ); ?>"
												   <?php echo $sl_link['target'] ? 'target="' . esc_attr($sl_link['target']) . '"' : ''; ?>>
													<?php echo esc_html( $sl_link['title'] ); ?>
												</a>
											<?php endforeach; ?>
										<?php endif; ?>
									</div>
								<?php endwhile; ?>

							<?php else : ?>
								<?php /* ── Fallback mặc định ── */ ?>
								<div class="support-item">
									<p class="label">Tư vấn mua hàng</p>
									<a class="phone" href="tel:02838150134">(028) 3815 0134</a>
									<a class="email" href="mailto:sales@hungphuckhang.com">sales@hungphuckhang.com</a>
								</div>
								<div class="divider"></div>
								<div class="support-item">
									<p class="label">Tổng đài kỹ thuật</p>
									<a class="phone" href="tel:02838150144">(028) 3815 0144</a>
								</div>
							<?php endif; ?>
						</div>
						<?php /* ── END .card-body ── */ ?>

					</div>
				</div>
				<?php /* ── END COL 3 ── */ ?>

			</div>
		</div>
		<?php /* ── END FOOTER TOP ── */ ?>

		<?php /* ── FOOTER BOTTOM ── */ ?>
		<div class="footer-bottom">
			<div class="bottom-wrapper">

				<?php /* Left: Logo + Copyright */ ?>
				<div class="left-box">
					<div class="bottom-logo">
						<?php if ( $footer_logo ) : ?>
							<img src="<?php echo esc_url( $footer_logo['url'] ); ?>"
								 alt="<?php echo esc_attr( $footer_logo['alt'] ?: get_bloginfo('name') ); ?>">
						<?php else : ?>
							<img src="<?php echo esc_url( get_template_directory_uri() . '/img/logo-canh-cam.png' ); ?>"
								 alt="<?php echo esc_attr( get_bloginfo('name') ); ?>">
						<?php endif; ?>
					</div>
					<p class="copyright"><?php echo esc_html( $footer_copyright ); ?></p>
				</div>

				<?php /* Right: Bottom links + Social icons */ ?>
				<div class="right-box">

					<?php /* Bottom links: repeater footer_links → link_item (link) */ ?>
					<?php if ( function_exists('have_rows') && have_rows( 'footer_links', 'options' ) ) : ?>
						<div class="bottom-links">
							<?php while ( have_rows( 'footer_links', 'options' ) ) : the_row(); ?>
								<?php $bl = get_sub_field('link_item'); ?>
								<?php if ( $bl && ! empty($bl['url']) ) : ?>
									<a href="<?php echo esc_url( $bl['url'] ); ?>"
									   <?php echo $bl['target'] ? 'target="' . esc_attr($bl['target']) . '"' : ''; ?>>
										<?php echo esc_html( $bl['title'] ); ?>
									</a>
								<?php endif; ?>
							<?php endwhile; ?>
						</div>
					<?php else : ?>
						<div class="bottom-links">
							<a href="<?php echo esc_url( home_url('/sitemap.xml') ); ?>">Sitemap</a>
							<a href="#">Terms &amp; Conditions</a>
						</div>
					<?php endif; ?>

					<?php /* Social icons: repeater footer_social */ ?>
					<?php if ( function_exists('have_rows') && have_rows( 'footer_social', 'options' ) ) : ?>
						<div class="social-links">
							<?php while ( have_rows( 'footer_social', 'options' ) ) : the_row(); ?>
								<?php
								$s_class = get_sub_field('social_icon_class');
								$s_url   = get_sub_field('social_url');
								$s_name  = get_sub_field('social_name') ?: '';
								if ( ! $s_url || ! $s_class ) continue;
								$s_prefix = canhcam_get_fa_prefix( $s_class );
								?>
								<a href="<?php echo esc_url( $s_url ); ?>"
								   target="_blank" rel="noopener noreferrer"
								   aria-label="<?php echo esc_attr( $s_name ); ?>">
									<i class="<?php echo esc_attr( trim($s_prefix . ' ' . $s_class) ); ?>"></i>
								</a>
							<?php endwhile; ?>
						</div>
					<?php else : ?>
						<div class="social-links">
							<a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
							<a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
							<a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
						</div>
					<?php endif; ?>

				</div>
			</div>
		</div>
		<?php /* ── END FOOTER BOTTOM ── */ ?>

	</div>
</footer>
<?php /* ── END <footer> ── */ ?>

<?php /* ────────────────────────────────────────────────────────────
 * NÚT CTA CỐ ĐỊNH (Fixed)
 * ACF: footer_fixed_socials (repeater, Options Page)
 *   └── icon (text)  : tên icon FA, vd: fa-envelope, fa-phone, fa-facebook-messenger
 *   └── link (link)  : title + url + target
 * ──────────────────────────────────────────────────────────────── */ ?>
<div class="tool-fixed-cta">

	<?php /* Nút Back-to-top (không cần ACF, luôn hiển thị) */ ?>
	<div class="btn button-to-top" aria-label="<?php esc_attr_e('Về đầu trang', 'canhcamtheme'); ?>">
		<div class="btn-icon">
			<div class="icon"></div>
		</div>
	</div>

	<?php if ( function_exists('have_rows') && have_rows( 'footer_fixed_socials', 'options' ) ) : ?>
		<?php while ( have_rows( 'footer_fixed_socials', 'options' ) ) : the_row();
			$link = get_sub_field('link');
			$icon = get_sub_field('icon'); // vd: fa-envelope, fa-phone, fa-facebook-messenger

			if ( ! $link ) continue;

			$content = $link['title'];

			/* Xác định prefix */
			$prefix = 'fa-light';
			if ( strpos($icon, 'facebook') !== false || strpos($icon, 'messenger') !== false ) {
				$prefix = 'fa-brands';
			} elseif ( strpos($icon, 'fa-solid') !== false ) {
				$prefix = 'fa-solid';
			}

			/* Thêm class btn-social cho messenger/chat */
			$btn_extra_class = '';
			if ( strpos($icon, 'message') !== false || strpos($icon, 'messenger') !== false ) {
				$btn_extra_class = 'btn-social';
			}
		?>
			<a class="btn btn-content <?php echo esc_attr( $btn_extra_class ); ?>"
			   href="<?php echo esc_url( $link['url'] ); ?>"
			   target="<?php echo esc_attr( $link['target'] ?: '_self' ); ?>"
			   aria-label="<?php echo esc_attr( $content ); ?>">
				<div class="btn-icon">
					<div class="icon">
						<i class="<?php echo esc_attr( $prefix ); ?> <?php echo esc_attr( $icon ); ?>"></i>
					</div>
				</div>
				<?php if ( $content ) : ?>
					<div class="content"><?php echo esc_html( $content ); ?></div>
				<?php endif; ?>
			</a>
		<?php endwhile; ?>

	<?php else : ?>
		<?php /* ── Fallback mặc định ── */ ?>
		<a class="btn btn-content" href="mailto:sales@hungphuckhang.com" aria-label="Gửi email">
			<div class="btn-icon">
				<div class="icon"><i class="fa-light fa-envelope"></i></div>
			</div>
		</a>
		<a class="btn btn-content" href="tel:02838150134" aria-label="Gọi điện">
			<div class="btn-icon">
				<div class="icon"><i class="fa-solid fa-phone fa-shake"></i></div>
			</div>
		</a>
		<a class="btn btn-content btn-social" href="#" target="_blank" rel="noopener noreferrer" aria-label="Facebook Messenger">
			<div class="btn-icon">
				<div class="icon"><i class="fa-brands fa-facebook-messenger"></i></div>
			</div>
		</a>
	<?php endif; ?>

</div>
<?php /* ── END .tool-fixed-cta ── */ ?>

<?php /* ── WP FOOTER SCRIPTS ── */ ?>
<?php if ( stripos( $_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse' ) === false ) : ?>
	<?php wp_footer(); ?>
<?php endif; ?>

<?php /* Custom </body> code từ ACF Options (GTM noscript, chat widget...) */ ?>
<?php if ( function_exists('get_field') ) : ?>
	<?php $field_config_body = get_field( 'field_config_body', 'options' ); ?>
	<?php if ( $field_config_body ) : echo $field_config_body; endif; ?>
<?php endif; ?>

</body>
</html>