<?php
/**
* Template Name: Resources
*/

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );
?>


<?php get_footer( $footer ); ?>
