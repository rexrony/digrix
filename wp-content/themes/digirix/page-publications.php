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
    <div class="heading-title-feat">
        <div class="container"><h2><?php the_title(); ?></h2>
            <div class="breadcrumbs col-md-5 center-block floatnone">
                       <?php if(function_exists('bcn_display')) { bcn_display(); }?>
                
                </div><!--.breadcrumbs--->
        </div>
    </div>
</div>
<div class="clear"></div>

<div id="primary" class="contentarea" style="background:#f1f1f1;">
   <div class="container">
   <div class="row">
<?php  get_template_part( 'loop', 'page' ); ?>
  
<?php if( have_rows('image_field_container') ): ?>
	<?php while( have_rows('image_field_container') ): the_row(); 

		// vars
		$image = get_sub_field('publication_image');
		$content = get_sub_field('publication_title');

		?>
<div class="col-md-2 noPadd-lft">
    
    <section class="publication-box">
        <img src="<?php echo $image; ?>" alt="">
       <p> <span><?php echo $content; ?></span></p>
    </section>
</div>
   <?php endwhile; ?>

    <?php endif; ?>
   </div><!--.row-->
    </div><!--.container--->

</div>
<div class="clear"></div>
    <?php get_footer(); ?>