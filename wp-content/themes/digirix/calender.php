<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 * Template Name: Calendar
 */

get_header(); ?>
<div class="clear"></div>
<div id="primary" class="contentarea">
   <div class="heading-container">
       <div class="container">
           <div class="col-md-3 nopad lft">
               <?php if ( is_front_page() ) { ?>
						<h2 class="entry-title"><?php the_title(); ?></h2>
					<?php } else { ?>
						<h2 class="entry-title"><?php the_title(); ?></h2>
					<?php } ?>
           </div>
           <div class="col-md-2 nopad rht">
                 <div class="breadcrumbs">
                    <div class="breadcrumbs" typeof="BreadcrumbList">
                        <?php if(function_exists('bcn_display')){ bcn_display(); } ?>
                    </div>
                </div><!--.breadcrumbs--->
           </div>
       </div><!--.container--->
   </div><!--.heading-container--->
   <div class="clear"></div>
   
    <div class="container">
    <?php  get_template_part( 'loop', 'page' ); ?>
    </div>
    <!-- #container -->
</div>
<div class="clear"></div>
    <?php get_footer(); ?>