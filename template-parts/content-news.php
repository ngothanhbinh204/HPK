<?php
/* ── Content Part: News Item ── */
?>
<div class="news-item">
	<div class="img">
		<a href="<?php the_permalink(); ?>">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail('large', array('class' => 'lozad')); ?>
			<?php else : ?>
				<img class="lozad" src="<?php echo get_template_directory_uri(); ?>/img/1.jpg" alt="<?php the_title(); ?>" />
			<?php endif; ?>
		</a>
	</div>
	<div class="content">
		<div class="date">
			<i class="fa-light fa-calendar-day"></i>
			<span><?php echo get_the_date('d.m.Y'); ?></span>
		</div>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	</div>
</div>
