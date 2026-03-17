<?php
/* ── Product Detail: Accordions (Specs, Intro...) ── */
$accordions = get_field('product_accordions'); // Repeater (title, content_left, content_right_image, more_content)
?>
<section class="product-detail-accordion">
	<div class="container">
		<div class="accordion-wrapper bg-Utility-gray-50">
			<?php if ( $accordions ) : ?>
				<?php foreach ( $accordions as $idx => $acc ) : ?>
					<div class="accordion-item <?php echo ($idx === 0) ? 'active' : ''; ?>">
						<div class="accordion-header">
							<h2><?php echo esc_html($acc['title']); ?></h2>
							<div class="icon-toggle"><span></span></div>
						</div>
						<div class="accordion-content">
							<div class="view-more-wrap">
								<div class="inner">
									<div class="content-left">
										<?php echo $acc['content_left']; ?>
									</div>
									<?php if ( !empty($acc['content_right_image']) ) : ?>
										<div class="content-right">
											<div class="img"><img src="<?php echo esc_url($acc['content_right_image']['url']); ?>" alt="<?php echo esc_attr($acc['title']); ?>"></div>
										</div>
									<?php endif; ?>
								</div>
								<?php if ( !empty($acc['more_content']) ) : ?>
									<div class="more-content" style="display: none;">
										<div class="mt-10">
											<?php echo $acc['more_content']; ?>
										</div>
									</div>
								<?php endif; ?>
							</div>
							<?php if ( !empty($acc['more_content']) ) : ?>
								<div class="btn-view-more">
									<a class="btn-toggle-content btn btn-primary" href="javascript:void(0)"> 
										<span><?php _e('XEM THÊM', 'canhcamtheme'); ?></span><i class="fa-light fa-chevron-down"></i>
									</a>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<?php /* Fallback if no ACF data */ ?>
				<div class="accordion-item active">
					<div class="accordion-header">
						<h2>Thông số kỹ thuật <?php the_title(); ?></h2>
						<div class="icon-toggle"><span></span></div>
					</div>
					<div class="accordion-content">
						<div class="view-more-wrap">
							<div class="inner">
								<div class="content-left">
									<?php the_excerpt(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
