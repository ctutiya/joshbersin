<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<?php

$navigation = get_field('navigation', 'options') ?: null;

get_header( $navigation );

?>

<section class="header-top-padding-normal header-bottom-padding-normal bg-secondary">
  <div class="container width-950 align-center p-t-50 p-b-50">
    <h1 class="large m-b-25">My Account</h1>
    <a href="#" onclick="history.back();">
      <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/arrow-primary.svg" alt="Go back">
    </a>
  </div>
</section>

<section class="block-top-padding-large block-bottom-padding-large">
	<div class="container">

		<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

		<?php
		if ( isset( $_GET['register'] ) ): ?>
			<!-- Register -->
			<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
				<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
					<?php do_action( 'woocommerce_register_form_start' ); ?>
					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
						<label>
							<input placeholder=" " type="text" class="m-t-10 full-width" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
							<span>Username</span>
						</label>
						<label class="pure-material-textfield-outlined m-t-20">
							<input placeholder=" " type="email" class="m-t-10 full-width" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
				      <span>Email</span>
				    </label>
					<?php endif; ?>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
						<label class="pure-material-textfield-outlined m-t-20">
				      <input id="reg_password" type="password" name="password" value="" placeholder=" ">
				      <span>Password</span>
				    </label>
					<?php else : ?>

						<?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?>

					<?php endif; ?>
						<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
						<button type="submit" class="sign-in-btn btn btn-primary btn-large m-t-20 woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
						<div class="login-signup-alternative m-t-20">
					    <div class="label-s2 dark align-center">
					      or continue with
					    </div>
					  </div>
						<?php
						echo do_shortcode('[woocommerce_social_login_buttons return_url="https://vesple.com/my-account"]');
						?>
					<?php do_action( 'woocommerce_register_form_end' ); ?>

				</form>
			<?php endif; ?>
			<?php else: ?>
			<!-- Sign in -->
			<form class="woocommerce-form woocommerce-form-login login width-300 margin-auto" method="post">
				<h2 class="medium align-center m-b-50">Sign In</h2>
		  	<?php do_action( 'woocommerce_login_form_start' ); ?>
				<label class="block m-b-20">
					<div class="type-bold font-14">Email</div>
					<input placeholder="Email" id="login-email" type="text" class="m-t-10 woocommerce-Input woocommerce-Input--text input-text full-width" name="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
		    </label>
				<label class="block m-b-15">
					<div class="type-bold font-14">Password</div>
					<input class="full-width" type="password" name="password" value="" placeholder="Password">
				</label>
				<?php do_action( 'woocommerce_login_form' ); ?>
				<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme" for="rememberme">Remember me</label>
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
		  	<button id="sign-in-btn" type="submit" class="btn primary full-width large m-t-15 woocommerce-button button woocommerce-form-login__submit row no-gutters justify-content-center align-items-center" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Sign in', 'woocommerce' ); ?> <i class="m-l-10 icon-arrow_right_alt"></i></button>
				<a class="m-t-15 block type-bold font-16" href="<?php echo esc_url( wp_lostpassword_url() ); ?>">
		      Forgot your password?
		    </a>
				<div class="m-t-15 font-16">Don’t have an account? <a class="type-bold" href="<?php echo home_url('/my-account') ?>?register">Register Here</a></div>
		  </form>
		<?php endif; ?>
		<?php if (isset( $_GET['register'] )): ?>
			<div class="label-s2 white align-center m-t-20 m-b-50">Already have an account? <a class="dark-bg" href="<?php echo home_url('/my-account') ?>">Sign in</a></div>
		<?php endif; ?>
	</div>
</section>

<?php

$footer = get_field('footer', 'options') ?: null;

get_footer( $footer );

?>
