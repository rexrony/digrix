<?php
/**
 Template Name: Blog
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

<div class="blog-container">
  <div class="container">
    <div class="row">
      <div class="col-md-9 nopad">
        <?php
$wp_query->query(array( 'post_type' => 'blogs', 'posts_per_page' => -1,'paged' => $paged,'order'=>'DESC' ));
if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
        <div class="loop loop-blogpost">
          <div class="col-md-12 padleft"> <a href="<?php the_permalink(); ?>" >
          <section class="bg-pos-img"><?php the_post_thumbnail('full'); ?></section>
            </a> </div>
          <div class="col-md-12 padleft">
            <h3 class="title"><a href="<?php the_permalink(); ?>" >
              <?php the_title(); ?>
              </a></h3>
              <section class="author_name"><span>by</span> <?php the_author(); ?></section>
              <section class="blog-details">
              <ul>
              <li><i class="fa fa-comments-o" aria-hidden="true"></i> <?php $comments_count = wp_count_comments();
              echo $comments_count->total_comments;
              ?></li>
              <li><i class="fa fa-eye" aria-hidden="true"></i> <?php
              setPostViews(get_the_ID());
              echo getPostViews(get_the_ID());
              ?></li>
              <li><i class="fa fa-bookmark-o" aria-hidden="true"></i> Coming form identity project</li>
              </ul>
              <div class="rht date-box">
              <span><?php echo date('d');?></span><br>
              <?php echo date('M');?>
              </div>
              </section>
              <section class="blog-texts">
              <?php $content=get_the_content(); echo substr($content,0, 300); ?>
              </section>
            <div class="more2 rht"><a href="<?php the_permalink(); ?>" >Read More</a></div>
            
          </div>
        </div>
        <?php endwhile; ?>
        <?php if (function_exists("pagination")) { pagination($additional_loop->max_num_pages);} ?>
        <?php endif; ?>
      </div>
      <div class="col-md-3 noPadd-rht">
        <div class="sidebar">
        
        <div class="col-md-12 noPadd">
          <div class="seacrh-form-sidebar">
            <form method="get" id="searchform2"   action="<?php bloginfo('url'); ?>/">
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
      </div>
    </div>
  </div>
</div>
</section>
<?php get_footer(); ?>
