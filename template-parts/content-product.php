<?php
/* ── Template Part: Product Item ── */
$product_id = get_the_ID();
$price_current = get_field('product_price', $product_id);
$price_old = get_field('product_price_old', $product_id);
$discount_tag = get_field('product_discount_tag', $product_id);
$bestseller_tag = get_field('product_is_bestseller', $product_id);
$specs = get_field('product_specs_summary', $product_id); // Repeater: icon + info
?>
<div class="product-item">
	<div class="img">
		<a href="<?php the_permalink(); ?>">
			<?php if ( has_post_thumbnail() ) : ?>
				<img data-src="<?php echo get_the_post_thumbnail_url( $product_id, 'full' ); ?>" class="lozad" alt="<?php the_title(); ?>">
			<?php else : ?>
				<img data-src="<?php echo get_template_directory_uri(); ?>/img/pro1.png" alt="<?php the_title(); ?>">
			<?php endif; ?>
		</a>
	</div>
	<div class="content">
		<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<div class="tags">
			<?php if ( $discount_tag ) : ?>
				<span class="tag discount"><?php echo esc_html($discount_tag); ?></span>
			<?php endif; ?>
			<?php if ( $bestseller_tag ) : ?>
				<span class="tag bestseller">bestseller</span>
			<?php endif; ?>
		</div>
		<div class="price">
			<?php if ( $price_current ) : ?>
				<span class="current"><?php echo number_format($price_current, 0, ',', '.'); ?>đ</span>
			<?php endif; ?>
			<?php if ( $price_old ) : ?>
				<span class="old"><?php echo number_format($price_old, 0, ',', '.'); ?>đ</span>
			<?php endif; ?>
		</div>
		<?php if ( $specs ) : ?>
			<div class="specs">
				<ul>
					<?php foreach ( $specs as $spec ) : ?>
						<li>
							<span class="icon"><i class="fa-solid fa-check"></i></span>
							<span><?php echo esc_html($spec['info']); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php else : ?>
			<div class="specs">
				<ul>
					<li><span class="icon"><i class="fa-solid fa-check"></i></span><span>Tốc độ: 43 tờ/ phút</span></li>
					<li><span class="icon"><i class="fa-solid fa-check"></i></span><span>Giấy: A4 - A5 - A6</span></li>
					<li><span class="icon"><i class="fa-solid fa-check"></i></span><span>Tính năng: Đa năng</span></li>
				</ul>
			</div>
		<?php endif; ?>
	</div>
</div>
