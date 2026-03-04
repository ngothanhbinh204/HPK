<?php
/* ── Section 5: Dịch vụ của chúng tôi (Accordion) ── */
$home_service_title = get_field('home_service_title') ?: 'DỊCH VỤ CỦA CHÚNG TÔI';
$home_service_items = get_field('home_service_items');
?>
<section class="home-5">
	<div class="home5-wrapper">
		<div class="col-left">
			<div class="image-block">
				<div class="img-main">
					<?php if ( $home_service_items ) : ?>
						<?php foreach ( $home_service_items as $idx => $item ) : ?>
							<?php
							$active_class = ($idx === 0) ? 'class="active"' : '';
							$img = $item['image']['url'] ?? get_template_directory_uri() . '/img/service-fallback.png';
							?>
							<img <?php echo $active_class; ?> src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($item['title']); ?>">
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="col-right">
			<div class="content-inner">
				<h2 class="block-title"><?php echo esc_html($home_service_title); ?></h2>
				<div class="accordion-list">
					<?php if ( $home_service_items ) : ?>
						<?php foreach ( $home_service_items as $idx => $item ) : ?>
							<?php
							$active_class = ($idx === 0) ? 'active' : '';
							$icon = $item['icon'];
							$link = $item['link'];
							?>
							<div class="accordion-item <?php echo $active_class; ?>" data-index="<?php echo $idx; ?>">
								<div class="item-icon">
									<div class="icon-wrap">
										<?php if ( $icon ) : ?>
											<img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($item['title']); ?>">
										<?php else : ?>
											<img src="<?php echo get_template_directory_uri(); ?>/img/photocopy_icon.svg" alt="Icon">
										<?php endif; ?>
									</div>
								</div>
								<div class="item-content">
									<div class="title-wrap">
										<h3><?php echo esc_html($item['title']); ?></h3>
									</div>
									<div class="item-body">
										<div class="inner">
											<p class="desc"><?php echo esc_html($item['description']); ?></p>
											<?php if ( $link ) : ?>
												<a class="btn-more" href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
													<span><?php echo esc_html($link['title'] ?: 'Tìm hiểu thêm'); ?></span>
													<i class="fa-light fa-chevron-right"></i>
												</a>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
