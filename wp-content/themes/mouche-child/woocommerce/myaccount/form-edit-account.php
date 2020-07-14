<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<section class="block-bottom-padding-large">
  <div class="container-fluid p-l-25 p-r-25">
    <h2 class="medium p-b-25 border-bottom m-b-25">Profile</h2>
    <div class="row justify-content-between width-800 gutter-15 align-items-center">
      <div class="col-auto">
        <div class="row gutter-15 align-items-center">
          <img class="col-auto square-80 image-circle" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/profile-picture.png" alt="Profile picture">
          <div class="col">
            <div class="p-l-5">
              <p class="caps color-primary m-b-10 type-bold font-12">NAME</p>
              <p>John Smith</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-auto">
        <p class="caps color-primary m-b-10 type-bold font-12">Company</p>
        <p>HR New York, Inc.</p>
      </div>
      <div class="col-auto align-right">
        <a href="#" class="btn small primary aling-items-center">change <i class="icon-arrow_right_alt m-l-5"></i></a>
      </div>
    </div>
  </div>
</section>


<section class="block-bottom-padding-large">
  <div class="container-fluid p-l-25 p-r-25">
    <h2 class="medium p-b-25 border-bottom m-b-25">Account Information</h2>
    <div class="row justify-content-between width-800 gutter-15 align-items-center m-b-20">
      <div class="flex-26">
        Job Title
      </div>
      <div class="flex-26">
        President
      </div>
      <div class="col-auto align-right row align-items-center">
        <p class="font-12 caps p-r-30 type-bold" style="visibility: hidden;">REMOVE</p>
        <a href="#" class="btn small primary aling-items-center">change <i class="icon-arrow_right_alt m-l-5"></i></a>
      </div>
    </div>
    <div class="row justify-content-between width-800 gutter-15 align-items-center m-b-20">
      <div class="flex-26">
        Email
      </div>
      <div class="flex-26">
        john.smith@gmail.com
      </div>
      <div class="col-auto align-right row align-items-center">
        <p class="font-12 caps p-r-30 type-bold" style="visibility: hidden;">REMOVE</p>
        <a href="#" class="btn small primary aling-items-center">change <i class="icon-arrow_right_alt m-l-5"></i></a>
      </div>
    </div>
    <div class="row justify-content-between width-800 gutter-15 align-items-center m-b-20">
      <div class="flex-26">
        No. of Employees
      </div>
      <div class="flex-26">
        20
      </div>
      <div class="col-auto align-right row align-items-center">
        <p class="font-12 caps p-r-30 type-bold">REMOVE</p>
        <a href="#" class="btn small primary aling-items-center">change <i class="icon-arrow_right_alt m-l-5"></i></a>
      </div>
    </div>
    <div class="row justify-content-between width-800 gutter-15 align-items-center m-b-20">
      <div class="flex-26">
        Company Headquarters
      </div>
      <div class="flex-26">
        New York, New York
      </div>
      <div class="col-auto align-right row align-items-center">
        <p class="font-12 caps p-r-30 type-bold">REMOVE</p>
        <a href="#" class="btn small primary aling-items-center">change <i class="icon-arrow_right_alt m-l-5"></i></a>
      </div>
    </div>
    <div class="row justify-content-between width-800 gutter-15 align-items-center m-b-20">
      <div class="flex-26">
        Job Type
      </div>
      <div class="flex-26">
        Vendor consultant
      </div>
      <div class="col-auto align-right row align-items-center">
        <p class="font-12 caps p-r-30 type-bold" style="visibility: hidden;">REMOVE</p>
        <a href="#" class="btn small primary aling-items-center">change <i class="icon-arrow_right_alt m-l-5"></i></a>
      </div>
    </div>
    <div class="row justify-content-between width-800 gutter-15 align-items-center">
      <div class="flex-26">
        Interests
      </div>
      <div class="flex-26">
        Articles and Newsletter<br>Josh Bersin Academy
      </div>
      <div class="col-auto align-right row align-items-center">
        <p class="font-12 caps p-r-30 type-bold">REMOVE</p>
        <a href="#" class="btn small primary aling-items-center">change <i class="icon-arrow_right_alt m-l-5"></i></a>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container-fluid p-l-25 p-r-25">
    <h2 class="medium p-b-25 border-bottom m-b-25">Password</h2>
    <p class="m-b-35">To change your password, you’ll need to verify the current one first. Then create a password you’re not using elsewhere, and be sure to change it regularly as well as anytime you suspect it’s been compromised.</p>
    <div class="row justify-content-between gutter-15 align-items-center">
      <div class="col-auto">
        Current Password
      </div>
      <div class="flex-19">
        <p class="type-bold">***********</p>
      </div>
      <div class="col-auto">
        <a href="#" class="btn small primary aling-items-center">change <i class="icon-arrow_right_alt m-l-5"></i></a>
      </div>
    </div>
  </div>
</section>
<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
