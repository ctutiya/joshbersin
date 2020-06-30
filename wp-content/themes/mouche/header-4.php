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

	<div id="menu-subscribe">
		<div class="container width-1190">
			<div class="row gutter-50 justify-content-between align-items-center relative">
				<div class="col-auto tab-lg-m-b-30 mob-md-align-center font-20">
					Sign up to receive new posts in your inbox
				</div>
				<div class="flex-670">
					<?php echo do_shortcode('[contact-form-7 id="98" title="Subscribe section"]'); ?>
				</div>
				<div class="absolute" id="subscribe-menu-close-wrapper">
					<a href="#" id="subscribe-menu-close">
						<svg height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m11.3846344 10 8.6153656 8.6153656-1.3846344 1.3846344-8.6153656-8.6153656-8.6153656 8.6153656-1.3846344-1.3846344 8.6153656-8.6153656-8.6153656-8.6153656 1.3846344-1.3846344 8.6153656 8.6153656 8.6153656-8.6153656 1.3846344 1.3846344z" fill="#808080" fill-rule="evenodd"/></svg>
					</a>
				</div>
			</div>
		</div>
	</div>
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
					<?php echo get_search_form(); ?>
					<?php
						wp_nav_menu(array(
							'theme_location' => 'Primary',
							'menu' => 'menu-1',
							'menu_class' => 'navigation-list',
						));
					?>
			</div>
			<div class="col navigation-extra-elements row flex-column align-items-end">

				<?php
				if( have_rows('extra_navigation_elements', 'options') ):

					?>

						<div class="relative">

							<?php

								while ( have_rows('extra_navigation_elements', 'options') ) : the_row();
									$item = get_sub_field('item');

									switch ( $item ) {
										case 'button':
											break;
										case 'social_icons':
											if ( have_rows( 'social_networks', 'options' ) ):
												while ( have_rows( 'social_networks', 'options' ) ) {
													the_row();

													$name = get_sub_field('name');
													$url = get_sub_field('url');
													$icon = 'icon-' . $name;

													?>

													<div class="col-auto">
														<a href="<?php echo $url; ?>">
															<i class="<?php echo $icon; ?>"></i>
														</a>
													</div>

													<?php
												}
											endif;
										case 'button':
											$url = get_sub_field('url') ?: '#';
											$label = get_sub_field('label');
											$target = get_sub_field('target');
											$color = get_sub_field('color');
											$round = get_field( 'round', 'options' );
											$size = get_sub_field('size');
											?>

											<a href="<?php echo $url; ?>" class="btn <?php echo $color; ?> <?php echo $size; ?> <?php echo $round; ?> " target="<?php echo $target; ?>">
												<?php echo $label; ?>
											</a>
										<?php
										case 'custom_icon':
											$url = get_sub_field('icon_url');
											$icon_class = get_sub_field('icon_class');
											$item_class = get_sub_field('item_class');
											?>

											<a href="<?php echo $url; ?>" class="<?php echo $item_class; ?>">
												<i class="<?php echo $icon_class; ?>"></i>
											</a>

											<?php
										default:
											break;
									}
								endwhile;

							?>
							<a href="#" class="open-mobile-menu m-l-10">
								<svg height="14" viewBox="0 0 18 14" width="18" xmlns="http://www.w3.org/2000/svg"><path d="m18 14h-18v-2h18zm0-6h-18v-2h18zm-18-6v-2h18v2z" fill="#808080" fill-rule="evenodd"/></svg>
							</a>
						</div>

					<?php
				endif;
				?>

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

	<div id="loader" style="/* display: none; */">
	  <div class="logo">
	  	<div class="equilizer">
	  		<div class="bar bar1Loader"></div>
	  		<div class="bar bar2Loader"></div>
	  		<div class="bar bar3Loader"></div>
	  		<div class="bar bar4Loader"></div>
	  	</div>
	  	<svg xmlns="http://www.w3.org/2000/svg" width="175.701" height="32.747" viewBox="0 0 175.701 32.747"><g id="logo" transform="translate(-20 1.668)">
				<g>
					<path id="Prophecy.io" d="M125.163,28.625a7.153,7.153,0,0,1-1.172-.094V26.25a5.885,5.885,0,0,0,1.063.077c1.523,0,2.359-.736,2.984-2.624l.374-1.141-6-16.265h2.906l4.5,13.531h.047l4.5-13.531h2.859l-6.391,17.39C129.449,27.472,128.124,28.625,125.163,28.625Zm-72.985-.657H49.459V6.3h2.578V8.938H52.1a6.011,6.011,0,0,1,5.25-2.8c4.159,0,6.953,3.328,6.953,8.281S61.533,22.7,57.412,22.7a5.657,5.657,0,0,1-5.172-2.8h-.062v8.061Zm4.64-19.421a4.162,4.162,0,0,0-3.365,1.631,6.75,6.75,0,0,0-1.291,4.244,6.754,6.754,0,0,0,1.291,4.25A4.164,4.164,0,0,0,56.818,20.3a4.228,4.228,0,0,0,3.412-1.6,6.743,6.743,0,0,0,1.291-4.274,6.739,6.739,0,0,0-1.291-4.267A4.227,4.227,0,0,0,56.818,8.547ZM112.7,22.7c-4.547,0-7.484-3.251-7.484-8.282a8.789,8.789,0,0,1,2.051-6.015,7.047,7.047,0,0,1,5.4-2.266A7.213,7.213,0,0,1,117.483,7.8a5.946,5.946,0,0,1,2.027,3.826h-2.656a3.9,3.9,0,0,0-4.172-3.094c-2.813,0-4.7,2.367-4.7,5.891a6.715,6.715,0,0,0,1.318,4.317,4.273,4.273,0,0,0,3.416,1.574c2.244,0,3.72-1.065,4.156-3h2.672a5.905,5.905,0,0,1-2.186,3.891A7.362,7.362,0,0,1,112.7,22.7Zm-18.168,0a7.148,7.148,0,0,1-5.465-2.217,8.727,8.727,0,0,1-2.02-6,8.994,8.994,0,0,1,2.01-6.065A6.9,6.9,0,0,1,94.4,6.141a6.7,6.7,0,0,1,5.182,2.147,8.617,8.617,0,0,1,1.912,5.837v1.031H89.842v.157a5.193,5.193,0,0,0,1.3,3.658,4.6,4.6,0,0,0,3.447,1.373c2,0,3.581-.963,4.031-2.453H101.3a5.307,5.307,0,0,1-2.246,3.461A7.846,7.846,0,0,1,94.53,22.7ZM94.358,8.5a4.47,4.47,0,0,0-4.5,4.531h8.828C98.623,10.321,96.884,8.5,94.358,8.5ZM37.431,22.7a7.176,7.176,0,0,1-5.489-2.248A8.781,8.781,0,0,1,29.9,14.422a8.781,8.781,0,0,1,2.043-6.039,7.181,7.181,0,0,1,5.489-2.242,7.156,7.156,0,0,1,5.474,2.242,8.79,8.79,0,0,1,2.041,6.039,8.789,8.789,0,0,1-2.041,6.034A7.151,7.151,0,0,1,37.431,22.7Zm0-14.172c-2.985,0-4.766,2.2-4.766,5.891s1.782,5.891,4.766,5.891a4.31,4.31,0,0,0,3.493-1.556,6.85,6.85,0,0,0,1.256-4.334,6.85,6.85,0,0,0-1.256-4.334A4.31,4.31,0,0,0,37.431,8.531ZM71.673,22.548H68.955V0h2.718V8.953h.063a5.329,5.329,0,0,1,5.156-2.812,5.556,5.556,0,0,1,4.2,1.656,6.264,6.264,0,0,1,1.523,4.375V22.546H79.892V12.672c0-2.66-1.365-4.125-3.844-4.125a4.233,4.233,0,0,0-3.2,1.273A4.852,4.852,0,0,0,71.673,13.2v9.344Zm-49.114,0H19.841V6.3H22.4V8.953h.062A3.93,3.93,0,0,1,26.4,6.141a5.782,5.782,0,0,1,1.094.094V8.89a5.55,5.55,0,0,0-1.453-.156A3.319,3.319,0,0,0,23.51,9.779a4.019,4.019,0,0,0-.951,2.767v10Zm-19.747,0H0V0H8.047a6.914,6.914,0,0,1,7.219,7.234,7.3,7.3,0,0,1-2.037,5.238A7.283,7.283,0,0,1,8.015,14.5h-5.2v8.046Zm0-20.047V12h4.5a5.321,5.321,0,0,0,3.738-1.258,4.676,4.676,0,0,0,1.324-3.508c0-3.009-1.845-4.734-5.063-4.734Z" transform="translate(38.188 2.453)" fill="#fff"/>
				</g>
			</svg>
	  </div>
	</div>
