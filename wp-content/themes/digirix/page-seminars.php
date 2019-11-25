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
 Template Name: seminars
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
      <div class="col-md-12 nopad blogs">
        <?php //,'paged' => $paged,
$wp_query->query(array( 'post_type' => 'seminars', 'posts_per_page' => 4,'order'=>'ASC' ));
if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
        <div class="col-md-6 noPadd sem-wrap">
           <section>
           <?php the_post_thumbnail( 'full' ); ?> <br>
            
            <h3 class="title"><?php the_title(); ?></h3>
            <?php echo $content = get_the_content();  ?>
        </section>
        </div>
        <?php endwhile; ?>
        <?php if (function_exists("pagination")) { pagination($additional_loop->max_num_pages);} ?>
        <?php endif; ?>
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