<?php get_header() ?>
<div class="content-page">
    <?php get_template_part('template-parts/section/global/breadcrumb'); ?>
	<div class="container">
        
		<div class="content-page-wrapper">
            <div class="title-page">
                <h1><?php the_title(); ?></h1>
            </div>
			<div class="content-page-main">
				<?php the_content() ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer() ?>