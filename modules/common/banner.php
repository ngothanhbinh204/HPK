<?php
$queried_object = get_queried_object();
$id = '';

if ( is_category() || is_tax() || is_tag() ) {
	$id = $queried_object->taxonomy . '_' . $queried_object->term_id;
} else {
	$id = get_the_ID();
}

$banner_url = '';

$local_banners = get_field('banner_select_page', $id);
if ( $local_banners ) {
    $banner_post = is_array($local_banners) ? $local_banners[0] : $local_banners;
    $banner_url = get_the_post_thumbnail_url($banner_post->ID, 'full');
}

if ( !$banner_url ) {
    $archive_banner_global = get_field('archive_product_banner', 'options');
    if ( $archive_banner_global ) {
        $banner_url = is_array($archive_banner_global) ? $archive_banner_global['url'] : $archive_banner_global;
    }
}
if ( !$banner_url ) {
    $banner_url = get_template_directory_uri() . '/img/1.jpg';
}
?>

<section class="page-banner-main banner-2">
    <div class="img img-ratio">
        <img class="lozad" data-src="<?php echo esc_url($banner_url); ?>" alt="<?php echo is_archive() ? post_type_archive_title('', false) : get_the_title(); ?>" />
    </div>
</section>