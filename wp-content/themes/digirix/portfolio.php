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
 * template Name: Portfolio
 */

//get_header(); ?>

		   <div class="portfoliotheme">
                <div class="filter-button-group ">
                    <button class="button is-checked" data-filter="*">all</button>
                    <?php
                    $terms = get_terms( array(
                        'taxonomy' => 'portfolio_categories',
                        'orderby' => 'id', 
                        'order' => 'desc',  
                        'hide_empty' => false,
                    ));
                    foreach($terms as $term):?>
                        <button class="button" data-filter=".<?php echo $term->slug;?>"><?php echo $term->name;?></button>
                    <?php endforeach;?>
                </div>
                <div class="grid">
                    <?php 
                    $i=1;
                    $loop = new WP_Query( array('post_type' => 'portfolio','page'=>'-1'));
                    if ( $loop->have_posts() ) :
                    while ( $loop->have_posts() ) : $loop->the_post(); 
                    $term_lists = wp_get_post_terms($post->ID, 'portfolio_categories', array("fields" => "all"));
                    $c_list="";
                    foreach($term_lists as $term_list):
                        $d_list=$term_list->slug;
                        $c_list.= $term_list->slug." ";
                    endforeach;
                    ?>
                    <div class="grid-item col-md-4 nopad  <?php echo $c_list . "a".$i;?> " data-category="<?php echo $d_list;?>">
                        <img src="<?php echo get_the_post_thumbnail_url($post->ID, 'portfolio-size');?>"/>
                        <section class="img-overlay-portfolio">
                           <img src="<?php bloginfo('stylesheet_directory'); ?>/images/search-ico.png" alt="">
                            <p>Image Description here</p>
                        </section>
                    </div>
                    <?php $i++;if($i>7){ $i=1;}endwhile; endif; wp_reset_query();?> 
                </div>
       
			<?php	//		get_template_part( 'loop', 'page' );			?>

			</div><!-- #content -->

<?php //get_sidebar(); ?>
<?php //get_footer(); ?>
