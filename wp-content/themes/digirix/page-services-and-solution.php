<?php get_header(); ?>
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

<?php $index_query = new WP_Query(array( 'post_type' => 'services_and_solutio', 'posts_per_page' => -1,'order'=>'DESC' ));
				while ($index_query->have_posts()) : $index_query->the_post();?>    
        <div class="col-md-12 noPadd serv-sol" style="margin-bottom: 10px;">
           <section class="col-md-8 servsol-text s_text">
               <h5><?php the_title(); ?></h5>
                <?php the_content(); ?>
            </section>
            <section class="col-md-4 noPadd">
            <?php the_post_thumbnail('full'); ?>
            </section>
       </div>
          <?php endwhile; wp_reset_postdata(); ?>
       
    </div>
</div>
<?php get_footer(); ?>