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

<div id="primary" class="contentarea">
   <div class="container">
   <div class="row">
<?php  get_template_part( 'loop', 'page' ); ?>
  
<?php if( have_rows('user_fields') ): ?>
	<?php while( have_rows('user_fields') ): the_row(); 

		// vars
		$user_name = get_sub_field('user_name');
		$user_des = get_sub_field('user_designation');
        $user_detail = get_sub_field('user_details');
        $user_pic = get_sub_field('user_picture');

		?>
<div class="col-md-3 noPadd-lft">
    
    <section class="public-box">
        <img src="<?php echo $user_pic; ?>" alt="">
       <span>
        <h3><?php echo $user_name; ?></h3>
        <small><?php echo $user_des; ?></small>
        <p><?php echo $user_detail; ?></p>
        <ul>
            <li><a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            <li><a href=""><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
            <li><a href=""><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
        </ul>
       </span>
    </section>
</div>
   <?php endwhile; ?>

    <?php endif; ?>
   </div><!--.row-->
    </div><!--.container--->

</div>
<div class="clear"></div>
    <?php get_footer(); ?>