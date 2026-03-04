<?php
/* ── Section 2: Đối tác thuê máy ── */
$rent_partners_title = get_field('rent_partners_title') ?: 'ĐỐI TÁC THUÊ MÁY';
$rent_partners = get_field('rent_partners'); // Gallery
?>
<section class="chothue-2">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title"><?php echo esc_html($rent_partners_title); ?></h2>
		</div>
		<div class="partner-grid">
			<?php if ( $rent_partners ) : ?>
				<?php foreach ( $rent_partners as $idx => $partner ) : ?>
					<?php $hide_class = ($idx >= 8) ? 'hidden-item d-none' : ''; ?>
					<div class="item-col <?php echo $hide_class; ?>">
						<div class="partner-item">
							<div class="partner-logo">
								<img src="<?php echo esc_url($partner['url']); ?>" alt="<?php echo esc_attr($partner['alt'] ?: 'Partner'); ?>">
							</div>
						</div>
						<div class="hover-line"></div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<?php /* Fallback items */ ?>
				<?php for ($i=1; $i<=8; $i++) : ?>
					<div class="item-col">
						<div class="partner-item">
							<div class="partner-logo"><img src="<?php echo get_template_directory_uri(); ?>/img/logo_doitac.png" alt="Partner"></div>
						</div>
						<div class="hover-line"></div>
					</div>
				<?php endfor; ?>
			<?php endif; ?>
		</div>
		<?php if ( $rent_partners && count($rent_partners) > 8 ) : ?>
			<div class="btn-view-more-wrap">
				<a class="btn-view-more btn btn-primary btn-primary-hover" id="btn-load-more-partners" href="javascript:void(0)">
					<span><?php _e('XEM THÊM', 'canhcamtheme'); ?></span>
					<i class="fa-light fa-chevron-down"></i>
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>
