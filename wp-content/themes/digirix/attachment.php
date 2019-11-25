<?php
/**
 * The template for displaying attachments.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

<div class="container">
  <div class="wrap">
    <?php get_template_part( 'loop', 'attachment' );	?>
  </div>
</div>
<?php get_footer(); ?>
