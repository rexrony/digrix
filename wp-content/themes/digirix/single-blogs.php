<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

<div class="container">
<div class="row">
<div class="col-md-9 padleft">
    <?php	get_template_part( 'loop', 'single' );		?>
  </div>
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
      
  <!-- #content --> 
</div></div>
<!-- #container -->

<?php // get_sidebar(); ?>
<?php get_footer(); ?>
