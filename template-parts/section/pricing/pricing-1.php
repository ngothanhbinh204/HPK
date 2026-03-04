<?php
$pricing_page_id = get_page_id_by_template('templates/template-pricing.php') ?: get_the_ID();
$pricing_title = get_field('rent_pricing_title', $pricing_page_id) ?: 'BẢNG GIÁ CHO THUÊ';
$pricing_plans = get_field('rent_pricing_plans', $pricing_page_id); // Repeater
?>
<section class="chothue-4">
	<div class="container">
		<div class="section-header" data-aos="fade-up">
			<h2 class="section-title"><?php echo esc_html($pricing_title); ?></h2>
		</div>
		<div class="pricing-grid">
			<?php if ( $pricing_plans ) : ?>
				<?php $delay = 0; foreach ( $pricing_plans as $plan ) : ?>
					<div class="pricing-col" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
						<div class="pricing-card">
							<div class="card-header">
								<div class="wrapper-package"><span><?php echo esc_html($plan['badge']); ?></span></div>
								<div class="price-block">
									<h3 class="price">
										<span class="value"><?php echo number_format($plan['price'], 0, ',', '.'); ?>đ</span>
										<span class="unit"> / <?php echo esc_html($plan['unit'] ?: 'Tháng'); ?></span>
									</h3>
								</div>
							</div>
							<div class="card-body">
								<ul class="feature-list">
									<?php if ( $plan['features'] ) : foreach ( $plan['features'] as $feature ) : ?>
										<li class="<?php echo ($feature['is_active']) ? '' : 'inactive'; ?>">
											<div class="icon">
												<?php if ( $feature['is_active'] ) : ?>
													<i class="fa-solid fa-circle-check"></i>
												<?php else : ?>
													<i class="fa-solid fa-circle-xmark"></i>
												<?php endif; ?>
											</div>
											<span class="text"><?php echo $feature['text']; ?></span>
										</li>
									<?php endforeach; endif; ?>
								</ul>
								<div class="card-footer">
									<p class="note"><?php echo esc_html($plan['note']); ?></p>
								</div>
							</div>
						</div>
					</div>
				<?php $delay += 100; endforeach; ?>				
			<?php endif; ?>
		</div>
	</div>
</section>
