<?php
/* ── Product Detail: Summary (Gallery, Title, Price, Meta) ── */
$product_id = get_the_ID();
$gallery = get_field('product_gallery'); // Gallery field
$sku = get_field('product_sku');
$price = get_field('product_price');
$price_old = get_field('product_price_old');
$is_bestseller = get_field('product_is_bestseller');
$discount_tag = '';

$price = (float) $price;
$price_old = (float) $price_old;

if ( $price && $price_old && $price_old > $price ) {
	$discount_tag = '-' . round( ( $price_old - $price ) / $price_old * 100 ) . '%';
}
$configs = get_field('product_configs'); // Repeater (icon_class, label)
$promotions = get_field('product_promotions'); // Repeater (text)
$summary_specs = get_field('product_summary_specs'); // Repeater (label, value)
$catalog_file = get_field('product_catalog'); // File
$rental_note = get_field('product_rental_note'); // Textarea
?>
<section class="product-detail-summary">
	<div class="container">
		<div class="wrapper">
			<div class="col-left" data-aos="fade-right">
				<div class="gallery-main">
					<div class="swiper main-swiper">
						<div class="swiper-wrapper">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="swiper-slide">
									<a href="<?php echo get_the_post_thumbnail_url($product_id, 'full'); ?>" data-fancybox="product-gallery">
										<div class="img"><?php the_post_thumbnail('full'); ?></div>
									</a>
								</div>
							<?php endif; ?>
							<?php if ( $gallery ) : foreach ( $gallery as $img ) : ?>
								<div class="swiper-slide">
									<a href="<?php echo esc_url($img['url']); ?>" data-fancybox="product-gallery">
										<div class="img"><img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>"></div>
									</a>
								</div>
							<?php endforeach; endif; ?>
						</div>
						<div class="swiper-nav-wrapper">
							<div class="swiper-button-prev"><i class="fa-light fa-chevron-left"></i></div>
							<div class="swiper-button-next"><i class="fa-light fa-chevron-right"></i></div>
						</div>
					</div>
					<div class="swiper thumb-swiper">
						<div class="swiper-wrapper">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="swiper-slide"><div class="img"><?php the_post_thumbnail('thumbnail'); ?></div></div>
							<?php endif; ?>
							<?php if ( $gallery ) : foreach ( $gallery as $img ) : ?>
								<div class="swiper-slide">
									<div class="img"><img src="<?php echo esc_url($img['sizes']['thumbnail']); ?>" alt="<?php echo esc_attr($img['alt']); ?>"></div>
								</div>
							<?php endforeach; endif; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-right" data-aos="fade-left">
				<div class="summary-top">
					<div class="tags">
						<?php if ( $discount_tag ) : ?><span class="tag discount"><?php echo esc_html($discount_tag); ?></span><?php endif; ?>
						<?php if ( $is_bestseller ) : ?><span class="tag bestseller">bestseller</span><?php endif; ?>
					</div>
					<?php if ( $sku ) : ?><div class="sku">SKU <?php echo esc_html($sku); ?></div><?php endif; ?>
				</div>
				<h1 class="product-title"><?php the_title(); ?></h1>
				<div class="price-block">
					<div class="price">
						<span class="current"><?php echo $price ? number_format($price, 0, ',', '.') . 'đ' : __('Liên hệ', 'canhcamtheme'); ?></span>
						<?php if ( $price_old ) : ?><span class="old"><?php echo number_format($price_old, 0, ',', '.') . 'đ'; ?></span><?php endif; ?>
					</div>
					<div class="vat-note"><?php _e('Giá chưa bao gồm VAT 10%', 'canhcamtheme'); ?></div>
				</div>
				
				<?php if ( $configs ) : ?>
				<div class="config-block">
					<div class="label"><?php _e('Cấu hình', 'canhcamtheme'); ?></div>
					<div class="buttons">
						<?php foreach ( $configs as $conf ) : ?>
							<a class="btn-config" href="#">
								<i class="fa-light <?php echo esc_attr($conf['icon_class']); ?>"></i>
								<span><?php echo esc_html($conf['label']); ?></span>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
				<?php endif; ?>

				<?php if ( $promotions ) : ?>
				<div class="promotion-box">
					<div class="box-title"><?php _e('Ưu đãi đặc quyền', 'canhcamtheme'); ?></div>
					<ul class="promo-list">
						<?php foreach ( $promotions as $idx => $promo ) : ?>
							<li><span class="num"><?php echo $idx + 1; ?></span><span class="text"><?php echo $promo['text']; ?></span></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>

				<?php if ( $summary_specs ) : ?>
				<div class="description-summary">
					<div class="label"><?php _e('Mô tả', 'canhcamtheme'); ?></div>
					<ul class="checkmark-list">
						<?php foreach ( $summary_specs as $spec ) : ?>
							<li><strong><?php echo esc_html($spec['label']); ?>:</strong> <span><?php echo esc_html($spec['value']); ?></span></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>

				<div class="action-buttons">
					<a class="btn btn-primary-solid btn-large" href="<?php echo esc_url(get_permalink(get_page_by_path('lien-he'))); ?>"><span><?php _e('LIÊN HỆ NGAY', 'canhcamtheme'); ?></span></a>
					<?php if ( $rental_note ) : ?>
						<div class="note">
							<?php echo $rental_note; ?>
						</div>
					<?php else : ?>
						<div class="note">
							<?php _e('Nếu muốn sử dụng nhiều máy cùng 1 lúc mà không cần đầu tư vốn quá nhiều, bạn hãy tham khảo dịch vụ', 'canhcamtheme'); ?> 
							<a href="<?php echo esc_url(get_permalink(get_page_by_path('cho-thue-may-photocopy'))); ?>"><?php _e('cho thuê máy photocopy', 'canhcamtheme'); ?></a>
						</div>
					<?php endif; ?>
					<?php if ( $catalog_file ) : ?>
						<a class="btn btn-detail-full" href="<?php echo esc_url($catalog_file['url']); ?>" target="_blank">
							<i class="fa-light fa-download"></i>
							<span><?php _e('Tính năng chi tiết', 'canhcamtheme'); ?> <?php the_title(); ?></span>
						</a>
					<?php endif; ?>
				</div>
				<div class="share-block">
					<span><?php _e('Chia sẻ', 'canhcamtheme'); ?></span>
					<div class="social-links">
						<a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
						<a class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
