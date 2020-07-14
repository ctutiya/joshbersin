
<?php
/**
 * Downloads
 *
 * Shows downloads on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/downloads.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// TODO: Change has downloads function

$has_downloads = true; ?>

<?php if ( $has_downloads ) : ?>

<div class="container widt-850">
  <div class="row justify-content-between align-items-center myaccount-downloads-row gutter-40">
    <div class="col">
      <h3 class="medium">Why HR Technology Matters Now More Than Ever</h3>
    </div>
    <div class="col-auto">
      <a href="#" class="btn medium primary">DOWNLOAD <i class="icon-download m-l-10"></i></a>
    </div>
  </div>
  <div class="row justify-content-between align-items-center myaccount-downloads-row gutter-40">
    <div class="col">
      <h3 class="medium">Guide to Talent Acquisition for the Future</h3>
    </div>
    <div class="col-auto">
      <a href="#" class="btn medium primary">DOWNLOAD <i class="icon-download m-l-10"></i></a>
    </div>
  </div>
  <div class="row justify-content-between align-items-center myaccount-downloads-row gutter-40">
    <div class="col">
      <h3 class="medium">HR Technology for 2020 Slideset</h3>
    </div>
    <div class="col-auto">
      <a href="#" class="btn medium primary">DOWNLOAD <i class="icon-download m-l-10"></i></a>
    </div>
  </div>
  <div class="row justify-content-between align-items-center myaccount-downloads-row gutter-40">
    <div class="col">
      <h3 class="medium">HRPS Research on The New Workforce</h3>
    </div>
    <div class="col-auto">
      <a href="#" class="btn medium primary">DOWNLOAD <i class="icon-download m-l-10"></i></a>
    </div>
  </div>
  <div class="row justify-content-between align-items-center myaccount-downloads-row gutter-40">
    <div class="col">
      <h3 class="medium">Thriving In The Pandemic: Lessons From The World Happiness Study</h3>
    </div>
    <div class="col-auto">
      <a href="#" class="btn medium primary">DOWNLOAD <i class="icon-download m-l-10"></i></a>
    </div>
  </div>
</div>

<?php else : ?>
	<div class="woocommerce-Message woocommerce-Message--info woocommerce-info">
		<?php esc_html_e( 'No downloads available yet.', 'woocommerce' ); ?>
	</div>
<?php endif; ?>
