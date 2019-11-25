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
 Template Name: Workshop
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
<blog>
  <div class="container">
    <div class="row">
      <div class="col-md-9 nopad blogs">
        <?php
$wp_query->query(array( 'post_type' => 'workshop', 'posts_per_page' => 4,'paged' => $paged,'order'=>'ASC' ));
if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
        <div class="loop">
          <div class="col-md-4 padleft"> <a href="<?php the_permalink(); ?>" >
            <?php the_post_thumbnail( 'medium' ); ?>
            </a> </div>
          <div class="col-md-8 padleft">
            <h3 class="title"><a href="<?php the_permalink(); ?>" >
              <?php the_title(); ?>
              </a></h3>
            <small><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;
            <?php the_time('F j, Y'); ?>
            </small>
            <p>
              <?php $content=get_the_content(); echo substr($content,0, 350); ?>
            </p>
            <div class="more"><a href="<?php the_permalink(); ?>" >Read More</a></div>
        
          </div>
        </div>
        <?php endwhile; ?>
        <?php if (function_exists("pagination")) { pagination($additional_loop->max_num_pages);} ?>
        <?php endif; ?>
      </div>
      <div class="col-md-3 padright">
        <div class="sidebar">
          <recentposts>
            <div class="section">
              <h4>Recent Posts</h4>
              <ul class="recent">
                <?php $index_query = new WP_Query(array( 'post_type' => 'blogs', 'posts_per_page' => 2,'order'=>'DESC' )); ?>
                <?php while ($index_query->have_posts()) : $index_query->the_post(); ?>
                <li>
                  <h5> <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                    </a> </h5>
                  
                </li>
                <?php  endwhile; wp_reset_query(); ?>
              </ul>
            </div>
          </recentposts>
        </div>
      </div>
    </div>
  </div>
</blog>
       </div><!--.row-->
    </div><!--.container--->
    <div class="clear"></div>
 
    <!-- #container -->
</div>
<div class="clear"></div>
    <?php get_footer(); ?>