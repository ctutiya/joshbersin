<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php

		$navigation_theme = get_field('navigation_theme', 'options');

		if ( $navigation_theme == 'dark' ) {
			$logo = get_field('white_logo', 'options');
		} else {
			$logo = get_field('black_logo', 'options');
		}

		$sticky_logo = get_field('sticky_menu_logo', 'options');

	?>

	<nav class="navigation_4">
		<div class="container-fluid p-l-50 p-r-50">
			<div class="main-menu row no-gutters justify-content-center align-items-center">
				<div class="col logo-column">
					<a class="logo" href="<?php echo home_url(); ?>">
						<?php if ( $logo ): ?>
							<img src="<?php echo $logo; ?>" alt="Logo" class="inline-block">
						<?php
							else:
								?>

									LOGO

								<?php
							endif;
						?>
					</a>
				</div>
				<div class="col-auto menu-wrapper row align-items-center p-r-15">
					<?php
						wp_nav_menu(array(
							'theme_location' => 'Primary',
							'menu' => 'menu-1',
							'menu_class' => 'navigation-list',
						));
					?>
			</div>
			<div class="col navigation-extra-elements row flex-column align-items-end">
        
			</div>
			</div>
		</div>
	</nav>
	<div class="mobile-menu">
		<div id="mb-menu" class="container-fluid p-l-50 p-r-50">
			<div class="main-menu row no-gutters justify-content-center align-items-center">
				<div class="col logo-column">
					<a class="logo" href="<?php echo home_url(); ?>">
						<?php if ( $logo ): ?>
							<img src="<?php echo $logo; ?>" alt="Logo" class="inline-block">
						<?php
							else:
								?>

									LOGO

								<?php
							endif;
						?>
					</a>
				</div>
			<div class="col navigation-extra-elements row flex-column align-items-end">
				<a href="#" class="close-mobile-menu">
					<svg height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m11.3846344 10 8.6153656 8.6153656-1.3846344 1.3846344-8.6153656-8.6153656-8.6153656 8.6153656-1.3846344-1.3846344 8.6153656-8.6153656-8.6153656-8.6153656 1.3846344-1.3846344 8.6153656 8.6153656 8.6153656-8.6153656 1.3846344 1.3846344z" fill="#808080" fill-rule="evenodd"/></svg>
				</a>
			</div>
			</div>
		</div>
		<div class="container-fluid">
			<?php echo get_search_form(); ?>
			<div class="menu-wrapper">
				<?php
					wp_nav_menu(array(
						'theme_location' => 'Primary',
						'menu' => 'menu-1',
						'menu_class' => 'navigation-list',
					));
				?>
			</div>
		</div>
		<div class="row justify-content-center m-b-70 m-t-60">
			<?php
			if ( have_rows( 'social_networks', 'options' ) ):
				while ( have_rows( 'social_networks', 'options' ) ) {
					the_row();

					$name = get_sub_field('name');
					$url = get_sub_field('url');
					$icon = 'icon-' . $name;

					?>
					<div class="col-auto">
						<a href="<?php echo $url; ?>" class="block square-50 circle social-icon-circle relative">
							<span class="block social-icon-link absolute">
								<i class="<?php echo $icon; ?> "></i>
							</span>
						</a>
					</div>
					<?php
				}
			endif;
			?>
		</div>
	</div>
