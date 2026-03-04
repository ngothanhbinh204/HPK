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
