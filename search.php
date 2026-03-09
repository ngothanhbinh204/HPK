<?php
/**
 * The template for displaying search results pages
 */

get_header();

// 1. Banner
get_template_part('template-parts/section/global/banner-archive');

// 2. Breadcrumb
get_template_part('template-parts/section/global/breadcrumb');

$search_query = get_search_query();
?>

<section class="search-results section bg-Utility-gray-50 rem:py-16">
	<div class="container">
		<div class="section-header mb-12 text-center">
			<h1 class="rem:text-[40px] font-bold uppercase mb-4"><?php _e('Kết quả tìm kiếm', 'canhcamtheme'); ?></h1>
			<p class="text-Utility-gray-600 rem:text-lg">
				<?php printf( __('Kết quả tìm kiếm cho từ khóa: "%s"', 'canhcamtheme'), '<strong>' . esc_html($search_query) . '</strong>' ); ?>
			</p>
		</div>

		<?php if ( have_posts() ) : ?>
			<?php
			$products = array();
			$news     = array();

			// Categorize posts from the current query page
			while ( have_posts() ) {
				the_post();
				if ( get_post_type() === 'product' ) {
					$products[] = get_the_ID();
				} else {
					$news[] = get_the_ID();
				}
			}
			?>

			<?php if ( ! empty($products) ) : ?>
				<div class="product-search-section mb-16">
					<div class="flex items-center gap-4 mb-8">
						<div class="rem:w-1 rem:h-8 bg-Primary-600"></div>
						<h2 class="rem:text-2xl font-bold uppercase"><?php _e('Sản phẩm', 'canhcamtheme'); ?></h2>
					</div>
					<div class="product-grid grid grid-cols-2 lg:grid-cols-4 gap-6">
						<?php 
						global $post;
						foreach ( $products as $prod_id ) {
							$post = get_post($prod_id);
							setup_postdata($post);
							?>
							<div class="product-column">
								<?php get_template_part('template-parts/content', 'product'); ?>
							</div>
							<?php
						}
						wp_reset_postdata();
						?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty($news) ) : ?>
				<div class="news-search-section">
					<div class="flex items-center gap-4 mb-8">
						<div class="rem:w-1 rem:h-8 bg-Primary-600"></div>
						<h2 class="rem:text-2xl font-bold uppercase"><?php _e('Bài viết & Tin tức', 'canhcamtheme'); ?></h2>
					</div>
					<div class="news-list grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
						<?php 
						global $post;
						$delay = 0;
						foreach ( $news as $news_id ) {
							$post = get_post($news_id);
							setup_postdata($post);
							?>
							<div class="news-col" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
								<?php get_template_part('template-parts/content', 'news'); ?>
							</div>
							<?php
							$delay += 100;
						}
						wp_reset_postdata();
						?>
					</div>
				</div>
			<?php endif; ?>


			<div class="pagination-wrapper mt-16 flex justify-center">
				<?php
				the_posts_pagination( array(
					'prev_text' => '<i class="fa-light fa-chevron-left"></i>',
					'next_text' => '<i class="fa-light fa-chevron-right"></i>',
					'type'      => 'list',
				) );
				?>
			</div>

		<?php else : ?>
			<div class="no-results text-center py-20">
				<div class="rem:text-6xl text-Utility-gray-300 mb-6">
					<i class="fa-light fa-magnifying-glass"></i>
				</div>
				<h3 class="rem:text-xl font-medium mb-4"><?php _e('Rất tiếc, không tìm thấy kết quả nào phù hợp.', 'canhcamtheme'); ?></h3>
				<p class="text-Utility-gray-500"><?php _e('Vui lòng thử lại với từ khóa khác.', 'canhcamtheme'); ?></p>
				<div class="mt-8">
					<a href="<?php echo home_url(); ?>" class="btn btn-primary"><?php _e('Quay lại Trang chủ', 'canhcamtheme'); ?></a>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();