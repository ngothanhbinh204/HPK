<?php
/* ── Section 8: Tin tức nổi bật ── */
$home_news_title = get_field('home_news_title') ?: 'Tin tức nổi bật';
$home_news_cats = get_field('home_news_cats'); // Taxonomy: category
?>
<section class="home-8">
	<div class="container">
		<h2 class="block-title rem:text-[36px]" data-aos="fade-up"><?php echo esc_html($home_news_title); ?></h2>
		<div class="tabs-wrapper" data-aos="fade-up" data-aos-delay="200">
			<ul class="tabs-list">
				<li class="tab-item active" data-tab="all"><?php _e('Tất cả', 'canhcamtheme'); ?></li>
				<?php if ( $home_news_cats ) : ?>
					<?php foreach ( $home_news_cats as $cat ) : ?>
						<li class="tab-item" data-category-id="<?php echo $cat->term_id; ?>" data-tab="cat-<?php echo $cat->term_id; ?>"><?php echo esc_html($cat->name); ?></li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		</div>
		<div class="news-slider-relative" id="news-filter-result" data-aos="fade-up" data-aos-delay="400">
			<div class="loading-overlay">
				<div class="spinner"></div>
			</div>
			<div class="swiper home-8-swiper">
				<div class="swiper-wrapper">
					<?php
					$args = array(
						'post_type'      => 'post',
						'posts_per_page' => 9,
					);
					if ( $home_news_cats ) {
						$args['tax_query'] = array(
							array(
								'taxonomy' => 'category',
								'field'    => 'term_id',
								'terms'    => wp_list_pluck( $home_news_cats, 'term_id' ),
							),
						);
					}
					$query = new WP_Query($args);
					if ($query->have_posts()) :
						$count = 0;
						while ($query->have_posts()) : $query->the_post();
							// HTML expects 3 items per swiper-slide (1 big, 2 small)
							if ( $count % 3 === 0 ) echo '<div class="swiper-slide"><div class="news-group">';
							
							if ( $count % 3 === 0 ) : ?>
								<div class="news-item big-item">
									<a class="img" href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail('large'); ?>
									</a>
									<div class="content">
										<div class="meta">
											<span class="date"><?php echo get_the_date('d.m.Y'); ?></span>
											<span class="category"><?php echo get_the_category()[0]->name; ?></span>
										</div>
										<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										<p class="desc"><?php echo wp_trim_words(get_the_excerpt(), 999); ?></p>
									</div>
								</div>
								<div class="small-items">
							<?php else : ?>
								<div class="news-item small-item">
									<a class="img" href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail('medium'); ?>
									</a>
									<div class="content">
										<div class="meta">
											<span class="date"><?php echo get_the_date('d.m.Y'); ?></span>
											<span class="category"><?php echo get_the_category()[0]->name; ?></span>
										</div>
										<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										<p class="desc"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
									</div>
								</div>
							<?php endif;

							if ( $count % 3 === 2 || $count === $query->post_count - 1 ) {
								echo '</div></div></div>'; // Close small-items, news-group, swiper-slide
							}
							$count++;
						endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>
			</div>
			<div class="swiper-nav-wrapper">
				<div class="swiper-button-prev home-8-prev"><i class="fa-light fa-chevron-left"></i></div>
				<div class="swiper-button-next home-8-next"><i class="fa-light fa-chevron-right"></i></div>
			</div>
		</div>
		<div class="block-btn text-center" data-aos="fade-up" data-aos-delay="600">
			<a class="btn btn-primary" href="<?php echo get_post_type_archive_link('post'); ?>"><?php _e('Xem tất cả', 'canhcamtheme'); ?></a>
		</div>
	</div>
</section>
