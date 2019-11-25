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
 
 Template Name: About Us
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

    <div id="primary" class="contentarea page-<?php the_ID(); ?>">
        <div class="container">
            <div class="col-md-7 noPadd-lft nopadd-lft-ar wow bounceInLeft">
                <?php while ( have_posts() ) : the_post(); ?>
                <?php echo the_content(); 
    endwhile;
    ?>
            </div>
            <div class="col-md-5 abt-cont-rht wow bounceInRight">
                <section>
                 <?php echo the_field('histroy title'); ?>
                    <?php echo the_field('our_histroy'); ?>
                </section>
            </div>
        </div>
        <!--.container--->
        <div class="clear"></div>
        <div class="message-ceo padd30">
            <div class="container">
                <div class="ceo-img col-md-4 wow bounceInLeft" data-wow-delay="0.2s">
                    <?php if( get_field('ceo_image') ): ?>
                    <img src="<?php the_field('ceo_image'); ?>" alt="">
                    <?php endif; ?>
                </div>
                <div class="col-md-8 ceo-mgs wow bounceInRight" data-wow-delay="0.2s">
                <?php the_field('ceo_title'); ?>
                    <?php if( get_field('msg_ceo') ): ?>
                    <?php the_field('msg_ceo'); ?>
                    <?php endif; ?>

                </div>

            </div>
        </div>
        <div class="clear"></div>
        <div class="vision-mission-container">
        <?php if( have_rows('mission_vision') ):
            $ids =1;
		  while ( have_rows('mission_vision') ): the_row();
		  
        $title = get_sub_field('vm_title');
        $content = get_sub_field('visionmission');
   
        ?>
        <div id="vmbox_<?php echo $ids;?>" class="col-md-6 vm-box wow fadeIn" data-wow-delay="0.<?php echo $ids;?>s">
        <section>
        <h2><?php echo $title;?></h2>
        <?php echo $content;?>
        </section>
        </div>
        <?php  
        $ids++;
        endwhile;
        endif; ?>
        
            <!--<div class="container">
                
            </div>-->

        </div>
        <div class="clear"></div>
        <div class="value-container">
        <div class="container">
        <div class="clear"></div>
     
                <section>
                    <?php if( get_field('our_vision') ): ?>
                  <?php the_field('our_vision'); ?>
                    <?php endif; ?>
                </section>
        </div><!--.container-->
        </div>
    </div>
    <div class="clear"></div>
    <?php get_footer(); ?>


