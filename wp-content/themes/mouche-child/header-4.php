<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<?php

global $current_user;

get_currentuserinfo();

if ( $current_user ) {
  $user_meta = get_user_meta( $current_user->ID );
}

?>

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
		<div class="container-fluid width-1150 margin-auto">
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
			<div class="col navigation-extra-elements row justify-content-end no-gutters">

				<?php if ( !is_user_logged_in() ): ?>

				<div class="col-auto">
					<div class="row no-gutters align-items-center sign-in-button">
						<img class="m-r-10" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/man.svg" alt="Sign in">
						<a class="font-14 type-bold subtitle m-r-35" href="<?php echo home_url('my-account') ?>">Sign In</a>
						<div class="absolute sign-in-dropdown p-t-20 p-b-20 p-l-15 p-r-15">
							<div class="row justify-content-between align-items-center p-b-15 border-bottom m-b-20">
								<div class="col-auto">
									<h2 class="small">Sign in</h2>
								</div>
								<div class="col-auto">
									<a href="<?php echo home_url('/my-account') ?>?register" class="font-16 type-regular">Create an Account</a>
								</div>
							</div>
							<form class="woocommerce-form woocommerce-form-login login" method="post">
						  	<?php do_action( 'woocommerce_login_form_start' ); ?>
								<label class="block m-b-20">
									<div class="type-bold font-14">Email*</div>
									<input placeholder="Email" autocomplete="off" id="login-email" type="text" class="m-t-10 woocommerce-Input woocommerce-Input--text input-text full-width" name="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
						    </label>
								<label class="block">
									<div class="type-bold font-14">Password*</div>
									<input class="full-width" autocomplete="off" type="password" name="password" value="" placeholder="Password">
								</label>
								<div class="row no-gutters justify-content-end">
									<a class="m-t-10 block font-14 type-regular m-b-10" href="<?php echo esc_url( wp_lostpassword_url() ); ?>">
							      Lost your password?
							    </a>
								</div>
								<?php do_action( 'woocommerce_login_form' ); ?>
								<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
						  	<button id="sign-in-btn" type="submit" class="m-b-20 btn primary align-items-center full-width large woocommerce-button button woocommerce-form-login__submit justify-content-center" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Sign in', 'woocommerce' ); ?></button>
								<div class="row gutter-10 align-items-center m-b-20 justify-content-center">
									<div class="col">
										<div class="horizontal-line"></div>
									</div>
									<p class="font-13 col-auto">or continue with</p>
									<div class="col">
										<div class="horizontal-line"></div>
									</div>
								</div>
								<div class="row gutter-20 justify-content-center">
									<div class="col-auto">
										<div class="border  height-30 social-login-icon">
											<img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/facebook.png" alt="Login with facebook">
										</div>
									</div>
									<div class="col-auto">
										<div class="border  height-30 social-login-icon">
											<img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/twitter.png" alt="Login with twitter">
										</div>
									</div>
									<div class="col-auto">
										<div class="border  height-30 social-login-icon">
											<img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/google.png" alt="Login with google">
										</div>
									</div>
								</div>
						  </form>
						</div>
					</div>
				</div>
				<div class="col-auto">
					<div class="row no-gutters align-items-center register-button">
						<img class="m-r-10" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/mail.svg" alt="Register">
						<a class="font-14 type-bold subtitle" href="<?php echo home_url('/my-account') ?>?register">Register</a>
					</div>
				</div>

				<?php else: ?>

					<div class="col-auto">
						<div class="row no-gutters align-items-center register-button">
							<img class="m-r-10" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/man.svg" alt="Register">
							<ul class="navigation-list">
								<li class="menu-item-has-children">
									<a class="font-14 type-bold subtitle no-caps" href="#"><?php echo $user_meta['first_name'][0] . ' ' . $user_meta['last_name'][0]; ?></a>
									<ul class="sub-menu">
										<li class="menu-item">
											<a href="<?php echo home_url('/my-account'); ?>" class="type-bold">MY ACCOUNT</a>
										</li>
										<li class="menu-item">
											<a href="<?php echo wc_logout_url(); ?>" class="type-bold">LOG OUT</a>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>

				<?php endif; ?>

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
