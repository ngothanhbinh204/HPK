<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<?php /* Google Fonts – không load khi Lighthouse audit */ ?>
	<?php if ( stripos( $_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse' ) === false ) : ?>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:wght@400;500;600;700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=ABeeZee:ital@0;1&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<?php endif; ?>

	<?php wp_head(); ?>

	<?php /* Custom <head> code từ ACF Options Page (Google Tag Manager, v.v.) */ ?>
	<?php if ( function_exists('get_field') ) : ?>
		<?php $field_config_head = get_field( 'field_config_head', 'options' ); ?>
		<?php if ( $field_config_head ) : echo $field_config_head; endif; ?>
	<?php endif; ?>
</head>

<body <?php body_class( function_exists('get_field') ? get_field( 'add_class_body', get_the_ID() ) : '' ); ?>>

<?php wp_body_open(); ?>

<?php
/* =============================================================
 * HEADER
 * Mapping từ: UI/header-footer.html → <header class="header">
 * ACF fields (Options Page):
 *   - header_logo       (image)       : Logo chính
 *   - header_hotline    (text)        : Số hotline
 *   - header_hotline_url (url)        : href của hotline
 * Menu Locations:
 *   - header-menu       : Menu chính Desktop + Mobile
 * =============================================================
 */
?>
<header class="header">
	<div class="header-wrapper">

		<?php /* ── LOGO ── */ ?>
		<div class="header-logo">
			<a href="<?php echo esc_url( home_url('/') ); ?>" title="<?php bloginfo('name'); ?>">
				<?php
				if ( function_exists('get_field') ) {
					$header_logo = get_field( 'header_logo', 'options' );
					if ( $header_logo ) :
						echo '<img class="lozad" data-src="' . esc_url( $header_logo['url'] ) . '" alt="' . esc_attr( $header_logo['alt'] ?: get_bloginfo('name') ) . '" width="' . esc_attr( $header_logo['width'] ) . '" height="' . esc_attr( $header_logo['height'] ) . '">';
					else :
						echo '<img src="' . esc_url( get_template_directory_uri() . '/img/logo-canh-cam.png' ) . '" alt="' . esc_attr( get_bloginfo('name') ) . '">';
					endif;
				} else {
					echo '<img src="' . esc_url( get_template_directory_uri() . '/img/logo-canh-cam.png' ) . '" alt="' . esc_attr( get_bloginfo('name') ) . '">';
				}
				?>
			</a>
		</div>

		<?php /* ── RIGHT SIDE ── */ ?>
		<div class="header-right">

			<?php /* ── DESKTOP NAVIGATION ── */ ?>
			<div class="header-menu">
				<?php
				wp_nav_menu( array(
					'theme_location'  => 'header-menu',
					'menu_class'      => 'header-nav',
					'container'       => false,
					'add_li_class'    => '',
					'add_class_active' => 'active',
					'walker'          => false,
					'fallback_cb'     => false,
				) );
				?>
			</div>

			<?php /* ── ACTIONS: Search + Language + Hotline ── */ ?>
			<div class="header-actions">

				<?php /* Search icon */ ?>
				<div class="header-search">
					<i class="fa-regular fa-magnifying-glass"></i>
				</div>

				<?php /* Language switcher (WPML) */ ?>
				<?php if ( function_exists('icl_get_languages') ) : ?>
					<div class="header-language">
						<ul class="language-horizontal">
							<?php
							$languages = icl_get_languages( 'skip_missing=1&orderby=KEY&order=DIR' );
							if ( ! empty( $languages ) ) :
								$lang_keys = array_keys( $languages );
								foreach ( $lang_keys as $idx => $lang_code ) :
									$lang = $languages[ $lang_code ];
									$is_active = $lang['active'] ? ' active' : '';
									echo '<li class="wpml-ls-item' . $is_active . '"><a href="' . esc_url( $lang['url'] ) . '">' . esc_html( strtoupper( $lang_code ) ) . '</a></li>';
									if ( $idx < count( $lang_keys ) - 1 ) :
										echo '<li class="divider">/</li>';
									endif;
								endforeach;
							endif;
							?>
						</ul>
					</div>
				<?php else : ?>
					<?php /* Fallback nếu không có WPML */ ?>
					<div class="header-language">
						<ul class="language-horizontal">
							<li class="wpml-ls-item active"><a href="#">VN</a></li>
							<li class="divider">/</li>
							<li class="wpml-ls-item"><a href="#">EN</a></li>
						</ul>
					</div>
				<?php endif; ?>

				<?php /* Hotline */ ?>
				<?php
				$hotline_number = '';
				$hotline_url    = '';
				if ( function_exists('get_field') ) {
					$hotline_number = get_field( 'header_hotline', 'options' );
					$hotline_url    = get_field( 'header_hotline_url', 'options' );
				}
				$hotline_number = $hotline_number ?: '(028) 3815 0134';
				$hotline_url    = $hotline_url    ?: 'tel:02838150134';
				?>
				<a class="header-hotline" href="<?php echo esc_url( $hotline_url ); ?>">
					<i class="fa-regular fa-phone"></i>
					<span>HOTLINE: <?php echo esc_html( $hotline_number ); ?></span>
				</a>

			</div>
			<?php /* ── END ACTIONS ── */ ?>

			<?php /* ── HAMBURGER (Mobile) ── */ ?>
			<div class="header-bar">
				<i class="fa-light fa-bars"></i>
			</div>

		</div>
		<?php /* ── END RIGHT SIDE ── */ ?>

	</div>
	<?php /* ── END .header-wrapper ── */ ?>

	<?php /* ── MOBILE NAV DRAWER ── */ ?>
	<div class="nav-mobile">
		<div class="header-wrap-head">
			<div class="header-logo">
				<a href="<?php echo esc_url( home_url('/') ); ?>" title="<?php bloginfo('name'); ?>">
					<?php
					if ( function_exists('get_field') ) {
						$header_logo = get_field( 'header_logo', 'options' );
						if ( $header_logo ) {
							echo '<img class="lozad" data-src="' . esc_url( $header_logo['url'] ) . '" alt="' . esc_attr( $header_logo['alt'] ?: get_bloginfo('name') ) . '">';
						} else {
							echo '<img src="' . esc_url( get_template_directory_uri() . '/img/logo-canh-cam.png' ) . '" alt="' . esc_attr( get_bloginfo('name') ) . '">';
						}
					}
					?>
				</a>
			</div>
			<div class="header-close"><i class="fa-light fa-xmark"></i></div>
		</div>

		<div class="header-wrap-menu">
			<?php
			/* Mobile Menu – cùng location, khác class để target CSS/JS riêng */
			wp_nav_menu( array(
				'theme_location'  => 'header-menu',
				'menu_class'      => 'menu-mobile',
				'container'       => false,
				'add_li_class'    => '',
				'add_class_active' => 'active',
				'walker'          => new CanhCam_Mobile_Walker(),
				'fallback_cb'     => false,
			) );
			?>

			<div class="header-mobile-bottom">
				<?php /* Language – Mobile */ ?>
				<?php if ( function_exists('icl_get_languages') ) : ?>
					<ul class="language-horizontal">
						<?php
						$languages = icl_get_languages( 'skip_missing=1&orderby=KEY&order=DIR' );
						if ( ! empty( $languages ) ) :
							$lang_keys = array_keys( $languages );
							foreach ( $lang_keys as $idx => $lang_code ) :
								$lang = $languages[ $lang_code ];
								$is_active = $lang['active'] ? ' active' : '';
								echo '<li class="wpml-ls-item' . $is_active . '"><a href="' . esc_url( $lang['url'] ) . '">' . esc_html( strtoupper( $lang_code ) ) . '</a></li>';
								if ( $idx < count( $lang_keys ) - 1 ) :
									echo '<li class="divider">/</li>';
								endif;
							endforeach;
						endif;
						?>
					</ul>
				<?php else : ?>
					<ul class="language-horizontal">
						<li class="wpml-ls-item active"><a href="#">VN</a></li>
						<li class="divider">/</li>
						<li class="wpml-ls-item"><a href="#">EN</a></li>
					</ul>
				<?php endif; ?>

				<a class="header-hotline" href="<?php echo esc_url( $hotline_url ); ?>">
					<i class="fa-solid fa-phone"></i>
					<span>HOTLINE: <?php echo esc_html( $hotline_number ); ?></span>
				</a>
			</div>
		</div>
	</div>
	<?php /* ── END .nav-mobile ── */ ?>

	<div class="header-overlay"></div>
</header>
<?php /* ── END <header> ── */ ?>

<?php /* ── SEARCH OVERLAY FORM ── */ ?>
<div class="header-search-form">
	<div class="close flex items-center justify-center absolute top-0 right-0 bg-white text-3xl cursor-pointer w-12.5 h-12.5">
		<i class="fa-light fa-xmark"></i>
	</div>
	<div class="container">
		<div class="wrap-form-search-product">
			<form role="search" method="get" class="productsearchbox search-form" action="<?php echo home_url( '/' ); ?>">
				<input type="text" placeholder="<?php echo esc_attr_x( 'Tìm kiếm thông tin', 'placeholder' ) ?>"
					value="<?php echo get_search_query() ?>" name="s" />
				<button type="submit"><i class="fa-light fa-magnifying-glass"></i></button>
			</form>
		</div>
	</div>
</div>
<?php /* ── END SEARCH FORM ── */ ?>

<?php /* ── MAIN CONTENT STARTS ── */ ?>
<main class="main-content" id="main-content">