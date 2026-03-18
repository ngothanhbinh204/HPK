<?php
/**
 * The single post template file
 */

get_header();

/* ── MAPPING NewsDetail.html → single.php ── */

while ( have_posts() ) :
	the_post();
	$current_id = get_the_ID();
	$categories = get_the_category();
?>

<section class="global-breadcrumb">
	<div class="container">
		<?php if ( function_exists('rank_math_the_breadcrumbs') ) : ?>
			<?php rank_math_the_breadcrumbs(); ?>
		<?php else : ?>
			<nav class="rank-math-breadcrumb" aria-label="breadcrumbs">
				<p><a href="<?php echo home_url(); ?>">Trang chủ</a><span class="separator"> | </span><span class="last"><?php the_title(); ?></span></p>
			</nav>
		<?php endif; ?>
	</div>
</section>

<section class="news-detail">
	<div class="container">
		<div class="wrapper-detail">
			<div class="news-detail-header">
				<h1><?php the_title(); ?></h1>
				<div class="news-item-meta">
					<div class="news-item-category">
						<?php if ( !empty($categories) ) echo esc_html($categories[0]->name); ?>
					</div>
					<div class="news-item-date">
						<i class="fa-light fa-calendar-day"></i>
						<span><?php echo get_the_date('d.m.Y'); ?></span>
					</div>
					<div class="news-meta-line"></div>
				</div>
			</div>
			<div class="news-detail-content">
				<div class="format-content">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>

	<?php
	// Tin tức liên quan
	$related_args = array(
		'post_type'      => 'post',
		'posts_per_page' => 6,
		'post__not_in'   => array($current_id),
		'category__in'   => (!empty($categories)) ? wp_list_pluck($categories, 'term_id') : array(),
	);
	$related_query = new WP_Query($related_args);
	if ( $related_query->have_posts() ) :
	?>
	<div class="container-ofSlide">
		<div class="news-detail-related">
			<div class="section-header">
				<h2><?php _e('Tin tức liên quan', 'canhcamtheme'); ?></h2>
			</div>
			<div class="news-related-swiper swiper-container">
				<div class="swiper-wrapper">
					<?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
						<div class="swiper-slide">
							<?php get_template_part('template-parts/content', 'news'); ?>
						</div>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
			<div class="swiper-nav-wrapper">
				<div class="swiper-button-prev related-prev"><i class="fa-thin fa-chevron-left"></i></div>
				<div class="swiper-button-next related-next"><i class="fa-thin fa-chevron-right"></i></div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>

<?php
endwhile;

get_footer();
