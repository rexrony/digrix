<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>
   <div class="featuredimg-container col-md-12 noPadd">
        <?php if ( has_post_thumbnail()) {?>
        <?php //the_post_thumbnail();  ?>
        <img src="<?php bloginfo( 'template_url' ); ?>/images/about-feat-img.png" alt="">
        <?php } else { ?>
        <img src="<?php bloginfo( 'template_url' ); ?>/images/about-feat-img.png" alt="">
        <?php } ?>
        <div class="clear"></div>
        <div class="heading-title-feat wow fadeInUp" data-wow-delay="0.10s">
            <div class="container">
                <h2>Blog Category </h2>
            </div>
            <!--.container--->
        </div>
        <!--.heading-title-feat-->
    </div>
    <div class="clear"></div>

<div class="container">
<div class="row">
<div class="col-md-9 padleft">
  <div class="wrap">
    <?php
	/* Queue the first post, that way we know
	 * what date we're dealing with (if that is the case).
	 *
	 * We reset this later so we can run the loop
	 * properly with a call to rewind_posts().
	 */
	if ( have_posts() )
		the_post();
?>
    <h1 class="page-title">
      <?php if ( is_day() ) : ?>
      <?php printf( __( 'Daily Archives: <span>%s</span>', 'twentyten' ), get_the_date() ); ?>
      <?php elseif ( is_month() ) : ?>
      <?php printf( __( 'Monthly Archives: <span>%s</span>', 'twentyten' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'twentyten' ) ) ); ?>
      <?php elseif ( is_year() ) : ?>
      <?php printf( __( 'Yearly Archives: <span>%s</span>', 'twentyten' ), get_the_date( _x( 'Y', 'yearly archives date format', 'twentyten' ) ) ); ?>
      <?php else : ?>
      <?php _e( 'Blog Archives', 'twentyten' ); ?>
      <?php endif; ?>
    </h1>
    <?php
	/* Since we called the_post() above, we need to
	 * rewind the loop back to the beginning that way
	 * we can run the loop properly, in full.
	 */
	rewind_posts();

	/* Run the loop for the archives page to output the posts.
	 * If you want to overload this in a child theme then include a file
	 * called loop-archive.php and that will be used instead.
	 */
	 get_template_part( 'loop', 'archive' );
?>
  </div>
  <!-- #content --> 
  </div><!--.col-md-9--->
  <div class="col-md-3 padright">
        <div class="sidebar">
        
        <div class="col-md-12 noPadd">
          <div class="seacrh-form-sidebar">
            <form method="get" id="searchform"   action="<?php bloginfo('url'); ?>/">
            <input type="search" value="<?php the_search_query(); ?>" name="s" id="s" placeholder="Search Blog..." />
            <input type="hidden" value="blogs" name="post_type" />
              <input type="submit" id="searchsubmit" value="Search" />
              
            </form>
          </div>
        </div>
            
          <div class="clear"></div>
          <recentposts>
            <div class="section lastest-article">
              <h4>Latest Article</h4>
              <ul class="recent">
                <?php $index_query = new WP_Query(array( 'post_type' => 'blogs', 'posts_per_page' => 2,'order'=>'DESC' )); ?>
                <?php while ($index_query->have_posts()) : $index_query->the_post(); ?>
                <li>
                <div class="col-md-3 noPadd lastest-post-img">
                <?php the_post_thumbnail(array(69,69));?>
                </div>
                <div class="col-md-9 noPadd-rht lastest-post-content">
                  <h5> <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                    </a> </h5>
                  <p>
                    <?php $content = get_the_content(); echo substr($content,0,40).'...'; ?>
                  </p>
                  </div>
                </li>
                <?php  endwhile; wp_reset_query(); ?>
              </ul>
            </div>
          </recentposts>
          <div class="clear"></div>
          
          <categories>
            <div class="section categories_section">
              <h4>Categories</h4> 
                      <?php 
			$terms = get_terms( 'blog_categories' );
			echo '<ul class="cat">';
			foreach ( $terms as $term ) {
			$term_link = get_term_link( $term );
			if ( is_wp_error( $term_link ) ) {
			continue;}
			echo '<li><a href="' . esc_url( $term_link ) . '">' . $term->name . '</a></li>';}
			echo '</ul>';	
		?></div>

          </categories>
          <div class="clear"></div>
         <?php get_sidebar(); ?>

  </div><!--sidebar--->

  <?php wp_reset_postdata(); // always reset post data after a custom query ?>

        </div>
  </div><!-- .row -->
</div>
<!-- #container -->

<?php get_footer(); ?>
