<?php
/**
 * The template for displaying the blog posts index (Trang Tin tức / Posts Page)
 */

get_header();

// 1. Banner
get_template_part('template-parts/section/global/banner-archive');

// 2. Breadcrumb
get_template_part('template-parts/section/global/breadcrumb');
?>

<section class="news">
	<div class="container">
		<h1 class="rem:text-[36px] font-bold uppercase mb-8 text-left"><?php single_post_title(); ?></h1>
		
		<ul class="nav-primary">
			<?php
			$posts_page_id = get_option( 'page_for_posts' );
			$all_news_url = $posts_page_id ? get_permalink( $posts_page_id ) : home_url('/tin-tuc/');
			// Vì home.php là chuyên trang bài viết nên tab "Tất cả" luôn active
			$is_all_active = 'active';
			?>
			<li class="<?php echo $is_all_active; ?>">
				<a href="<?php echo esc_url($all_news_url); ?>"><?php _e('Tất cả', 'canhcamtheme'); ?></a>
			</li>
			<?php
			$categories = get_categories(array('hide_empty' => true));
			foreach ( $categories as $cat ) :
				$active = (is_category($cat->term_id)) ? 'active' : '';
			?>
				<li class="<?php echo $active; ?>">
					<a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>

		<div class="news-list">
			<?php if ( have_posts() ) : ?>
				<?php $delay = 0; while ( have_posts() ) : the_post(); ?>
					<div class="news-col" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
						<?php get_template_part('template-parts/content', 'news'); ?>
					</div>
				<?php $delay += 100; endwhile; ?>
			<?php else : ?>
				<p class="text-center"><?php _e('Chưa có tin tức nào.', 'canhcamtheme'); ?></p>
			<?php endif; ?>
		</div>

		<div class="pagination-wrapper">
			<?php
			the_posts_pagination( array(
				'prev_text' => '<i class="fa-light fa-chevron-left"></i>',
				'next_text' => '<i class="fa-light fa-chevron-right"></i>',
				'type'      => 'list',
			) );
			?>
		</div>
	</div>
</section>

<?php
get_footer();
