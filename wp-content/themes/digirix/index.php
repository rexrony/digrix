<?php
/**
 * The main template file.
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>
<!-------------------------------------------Slider-------------------------------------------------->
<section class="section-slider">
    <div class="slider">
        <div class="main-slider">
            <?php $index_query = new WP_Query(array( 'post_type' => 'home_slider', 'posts_per_page' => -1,'order'=>'DESC' )); ?>
            <?php while ($index_query->have_posts()) : $index_query->the_post(); ?>
            <div class="inner-item" style="background:url( <?php if ( has_post_thumbnail() ) { the_post_thumbnail_url('full');} ?> ) no-repeat " >
                <div class="caption">
                    <div class="container">
                        <div class="slider-text-con">
                            <?php the_content(); ?>
                            <div class="slide-readmore"><a href="<?php echo get_permalink(7); ?>"><?php echo get_field('about_button_text',7); ?></a></div>
                        </div>


                    </div>

                </div>

            </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>

</section>
<div class="clear"></div>
<div id="abt-us" class="abt-us">
    <div class="container">
        <div class="row">
            <?php $index_query = new WP_Query(array( 'page_id' =>7, 'order'=>'DESC' )); ?>
            <?php while ($index_query->have_posts()) : $index_query->the_post(); ?>

            <div class="col-md-6 abt-us-lft">
                <h2><?php $title =  get_the_title(); 
                    echo multiColor($title, 1); ?></h2>
                <section>
                    <?php echo the_field('home_page_content'); ?>
                </section>
                <div class="rd-mre"><a href="<?php the_permalink(); ?>"><?php echo get_field('about_button_text',7); ?></a></div>
            </div>
            <div class="col-md-5 abt-us-rht rht">
                <img src="<?php echo the_field('about_image_index'); ?>" alt="">   

            </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div> 
    </div>

</div><!--abt-us--->
<div class="clear"></div>
<div class="serv-container">
    <div class="container">
        <div class="heading-title">  
        <?php  $headings = get_field( "services_heading",374 );
   if( $headings ) {?>
    <h2><?php multiColor($headings,1);?></h2>
<?php 
} else {

    echo ' ';
    
}?>
        </div>
        <?php $index_query = new WP_Query(array( 'post_type' => 'our_services', 'posts_per_page' => -1,'order'=>'ASC' )); ?>
        <?php while ($index_query->have_posts()) : $index_query->the_post(); ?>
        <div class="serv-box col-md-3 col-sm-6 wow fadeInUp">
            <div class="serv-con">
                <div class="serv-con-img">
                    <?php the_post_thumbnail(); ?>
                </div>
                <div class="clear"></div>
                <div class="serv-con-text">
                    <div class="serv-title">
                        <h5><?php the_title(); ?></h5>
                    </div>
                    <section>
                        <?php echo wp_trim_words( get_the_content(),22) ?>
                    </section>
                </div>
            </div><!--serv-con-->
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
</div>
<div class="contact-container">
        <div class="col-md-6 noPadd contct-text">
            <section class="con-text-box">
            <?php  $contact_content = get_field( "contact_area_text",374 );
   if( $contact_content ) {
       echo $contact_content;
} else {

    echo 'Not Content Available';
    
}?>

            </section>
        </div>
        <div class="col-md-6 noPadd contct-text-rht">
            <img src="<?php bloginfo( 'template_url' ); ?>/images/contact-bckgrnd.png" alt="">
        </div>
</div>
<div class="clear"></div>
<div class="ourclients_con">
    <div class="container">
           <div class="heading-title">  
            <?php  $headings2 = get_field( "our_client_heading",374 );
   if( $headings2 ) {?>
    <h2><?php multiColor($headings2,1);?></h2>
    <?php } else { echo ' '; }?>
        </div>
        <div class="clear"></div>
        <div class="btm_carsoual">
        <ul class="client_slides">
        <?php $index_query = new WP_Query(array( 'post_type' => 'our_clients', 'posts_per_page' => -1,'order'=>'ASC' )); ?>
        <?php while ($index_query->have_posts()) : $index_query->the_post(); ?>
        <li class="col-md-3">
        <section>
        <?php the_post_thumbnail(); ?>
        </section>
        </li>
        <?php endwhile; wp_reset_postdata(); ?>
        </ul> 
        </div>
       
    </div>
</div><!--ourclients_con--->
<?php get_footer(); ?>
