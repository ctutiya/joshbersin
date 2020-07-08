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
			<div class="width-550 margin-auto">

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

						<?php do_action( 'woocommerce_register_form' ); ?>

						<p class="form-row half_width newr" id="afreg_additionalshowhide_129">
							<input type="password" class="input-text" name="afreg_additional_129" id="afreg_additional_129" value="" placeholder="Confirm Password*">
						</p>

						<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>

						<p class="color-dark font-14 m-b-30"><span class="color-red">*</span>required</p>
						<button type="submit" class="sign-in-btn btn primary small woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?> <i class="m-l-5 icon-arrow_right_alt"></i></button>

						<?php do_action( 'woocommerce_register_form_end' ); ?>

					</form>
					<div class="p-t-20 m-t-25 border-top inline-block full-width">Already have an account?<a class="color-tertiary m-l-10" href="<?php echo home_url('/my-account') ?>">Sign in</a></div>
				</div>

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
	</div>
</section>

<?php if ( isset( $_GET['redirect-url'] ) ): ?>
	<div class="registration-overlay row no-gutters justify-content-center align-items-center">
		<div class="registration-popup relative bg-white m-t-50 m-b-50 width-350 p-l-35 p-r-35 p-t-50 p-b-50 align-center color-tertiary">
			<img class="m-b-20" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/josh-bersin-logo-square.png" alt="Register to continue">
			<h2 class="small m-b-5">Thanks for your interest.</h2>
			<p class="m-b-20 font-14">Register now to have access to valuable research-based resources and our complimentary newsletter.</p>
			<a href="#" class="btn small primary close-registration-popup">Register <i class="m-l-5 icon-arrow_right_alt"></i></a>
			<a href="#" class="close-registration-popup registration-popup-icon-close">
				<svg height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg">
					<path d="m10 8.59823895 6.3079247-6.30792473c.3870857-.38708563 1.0146755-.38708563 1.4017611 0 .3870856.38708562.3870856 1.01467542 0 1.40176105l-6.3079247 6.30792473 6.3079247 6.3079247c.3870856.3870857.3870856 1.0146755 0 1.4017611s-1.0146754.3870856-1.4017611 0l-6.3079247-6.3079247-6.30792473 6.3079247c-.38708563.3870856-1.01467543.3870856-1.40176105 0-.38708563-.3870856-.38708563-1.0146754 0-1.4017611l6.30792473-6.3079247-6.30792473-6.30792473c-.38708563-.38708563-.38708563-1.01467543 0-1.40176105.38708562-.38708563 1.01467542-.38708563 1.40176105 0z" fill="#bcbfc2" fill-rule="evenodd" transform="translate(-2 -2)"/>
				</svg>
			</a>
		</div>
	</div>
<?php endif; ?>

<?php

$footer = get_field('footer', 'options') ?: null;

get_footer( $footer );

?>
