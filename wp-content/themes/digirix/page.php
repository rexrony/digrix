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
 */
get_header(); ?>

   <div class="featuredimg-container col-md-12 noPadd" 
   <?php if ( wp_is_mobile() ) {?> style="background:url('<?php the_post_thumbnail_url('full'); ?>') no-repeat; background-size:cover;" <?php } ?>   >
        <?php if ( has_post_thumbnail()) {?>
        <?php if ( wp_is_mobile() ) { }else { the_post_thumbnail();}  ?>
        <?php } else { ?>
        <img src="<?php bloginfo( 'template_url' ); ?>/images/about-feat-img.png" alt="">
        <?php } ?>
        <div class="clear"></div>
        <div class="heading-title-feat wow fadeInUp" data-wow-delay="0.10s">
            <div class="container">
                <h2>
                    <?php the_title(); ?>
                </h2>
            </div>
            <!--.container--->
        </div>
        <!--.heading-title-feat-->
    </div>
    <div class="clear"></div>

<div id="primary" class="contentarea">
    <div class="container">
    <?php  get_template_part( 'loop', 'page' ); ?>
    </div>
    <!-- #container -->
</div>
<div class="clear"></div>
    <?php get_footer(); ?>