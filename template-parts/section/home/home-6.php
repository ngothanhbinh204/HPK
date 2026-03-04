<?php
/* ── Section 6: Cam kết chất lượng (Reusable) ── */
$home_6_title = get_field('home_6_title') ?: 'Cam kết chất lượng';
$home_6_items = get_field('home_6_items'); // Repeater
?>
<section class="home-6">
	<div class="bg-pattern"><img src="<?php echo get_template_directory_uri(); ?>/img/bg_partent_2.svg" alt="Pattern"></div>
	<div class="container">
		<h2 class="block-title text-center text-white uppercase mb-10 font-bold rem:text-[36px]"><?php echo esc_html($home_6_title); ?></h2>
		<div class="wrapper">
			<?php if ( $home_6_items ) : ?>
				<?php $delay = 100; foreach ( $home_6_items as $item ) : ?>
					<div class="item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo $delay; ?>">
						<div class="icon-box">
							<div class="circle-dashed"></div>
							<?php if ( !empty($item['icon']) ) : ?>
								<img src="<?php echo esc_url($item['icon']['url']); ?>" alt="<?php echo esc_attr($item['title']); ?>">
							<?php else : ?>
								<img src="<?php echo get_template_directory_uri(); ?>/img/icon_box.svg" alt="Icon">
							<?php endif; ?>
						</div>
						<h3 class="title"><?php echo esc_html($item['title']); ?></h3>
						<p class="desc"><?php echo esc_html($item['description']); ?></p>
					</div>
				<?php $delay += 100; endforeach; ?>
			<?php else : ?>
				<?php /* Default items */ ?>
				<div class="item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
					<div class="icon-box"><div class="circle-dashed"></div><img src="<?php echo get_template_directory_uri(); ?>/img/icon_box.svg" alt="Giao hàng"></div>
					<h3 class="title">Giao hàng tận nơi</h3>
					<p class="desc">Sản phẩm sẽ được giao tận nơi và lắp đặt cho khách hàng</p>
				</div>
				<div class="item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
					<div class="icon-box"><div class="circle-dashed"></div><img src="<?php echo get_template_directory_uri(); ?>/img/icon_box.svg" alt="Hỏa tốc"></div>
					<h3 class="title">Hỏa tốc</h3>
					<p class="desc">Giao trong ngày đối với khu vực nội thành</p>
				</div>
				<div class="item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
					<div class="icon-box"><div class="circle-dashed"></div><img src="<?php echo get_template_directory_uri(); ?>/img/icon_box.svg" alt="An toàn"></div>
					<h3 class="title">An toàn tuyệt đối</h3>
					<p class="desc">Sản phẩm được bảo vệ an toàn, tránh hư hỏng trong quá trình vận chuyển</p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
