<?php 
/*---------------------------------------------- Custom Post type Home Slider ------------------------------------*/
add_action('init', 'home_slider');
function home_slider() {
$labels = array(
	'name' => _x('Home Slider', 'post type general name'),
	'singular_name' => _x('home_slider', 'post type singular name'),
	'add_new' => _x('Add New', 'Home Slider'),
	'add_new_item' => __('Add New Home Slider'),
	'edit_item' => __('Edit Home Slider'),
	'new_item' => __('New Home Slider'),
	'view_item' => __('View Home Slider'),
	'search_items' => __('Search home_slider'),
	'not_found' =>  __('Nothing found'),
	'not_found_in_trash' => __('Nothing found in Trash'), 
	'parent_item_colon' => ''
);
$args = array(
	'labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true,
	'query_var' => true,
	'menu_icon' => get_stylesheet_directory_uri() . '/images/slider.png',
	'rewrite' => true,
	'capability_type' => 'post',
	'hierarchical' => false,
	'menu_position' => null,
	'supports' => array('title','thumbnail','editor')
  ); 
register_post_type( 'home_slider' , $args );}

/*---------------------------------------------- Custom Post type Testimonials ------------------------------------*/
add_action('init', 'our_testimonials');
function our_testimonials() {
$labels = array(
	'name' => _x('Testimonials', 'post type general name'),
	'singular_name' => _x('our_testimonials', 'post type singular name'),
	'add_new' => _x('Add New', 'Testimonials'),
	'add_new_item' => __('Add New Testimonials'),
	'edit_item' => __('Edit Testimonials'),
	'new_item' => __('New Testimonials'),
	'view_item' => __('View Testimonials'),
	'search_items' => __('Search our_testimonials'),
	'not_found' =>  __('Nothing found'),
	'not_found_in_trash' => __('Nothing found in Trash'), 
	'parent_item_colon' => ''
);
$args = array(
	'labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true,
	'query_var' => true,
	'menu_icon' => get_stylesheet_directory_uri() . '/images/testimonials.png',
	'rewrite' => true,
	'capability_type' => 'post',
	'hierarchical' => false,
	'menu_position' => null,
	'supports' => array('title','thumbnail','editor')
  ); 
register_post_type( 'our_testimonials' , $args );}

/*---------------------------------------------- Custom Post type Clients ------------------------------------*/
add_action('init', 'our_clients');
function our_clients() {
$labels = array(
	'name' => _x('Our Clients', 'post type general name'),
	'singular_name' => _x('our_clients', 'post type singular name'),
	'add_new' => _x('Add New', 'Our Clients'),
	'add_new_item' => __('Add New Our Clients'),
	'edit_item' => __('Edit Our Clients'),
	'new_item' => __('New Our Clients'),
	'view_item' => __('View Our Clients'),
	'search_items' => __('Search our_clients'),
	'not_found' =>  __('Nothing found'),
	'not_found_in_trash' => __('Nothing found in Trash'), 
	'parent_item_colon' => ''
);
$args = array(
	'labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true,
	'query_var' => true,
	'menu_icon' => get_stylesheet_directory_uri() . '/images/clients.png',
	'rewrite' => true,
	'capability_type' => 'post',
	'hierarchical' => false,
	'menu_position' => null,
	'supports' => array('title','thumbnail','editor')
  ); 
register_post_type( 'our_clients' , $args );}


/*---------------------------------------------- Custom Post type Our Services ------------------------------------*/
add_action('init', 'our_services');
function our_services() {
$labels = array(
	'name' => _x('Our Services', 'post type general name'),
	'singular_name' => _x('our_services', 'post type singular name'),
	'add_new' => _x('Add New', 'Our Services'),
	'add_new_item' => __('Add New Our Services'),
	'edit_item' => __('Edit Our Services'),
	'new_item' => __('New Our Services'),
	'view_item' => __('View Our Services'),
	'search_items' => __('Search our_services'),
	'not_found' =>  __('Nothing found'),
	'not_found_in_trash' => __('Nothing found in Trash'), 
	'parent_item_colon' => ''
);
$args = array(
	'labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true,
	'query_var' => true,
	'menu_icon' => get_stylesheet_directory_uri() . '/images/services.png',
	'rewrite' => true,
	'capability_type' => 'post',
	'hierarchical' => false,
	'menu_position' => null,
	'supports' => array('title','thumbnail','editor')
  ); 
register_post_type( 'our_services' , $args );}

/* ------------------------------------------Custom Post Type for Blog  ----------------------------------------------------------- */
add_action( 'init', 'create_book_taxonomies', 0 );
function create_book_taxonomies() {
  $labels = array(
	'name' => _x( 'Blog Category', 'taxonomy general name' ),
	'singular_name' => _x( 'Blog Category', 'taxonomy singular name' ),
	'search_items' =>  __( 'Search Blog Category' ),
	'all_items' => __( 'All Blog Category' ),
	'parent_item' => __( 'Parent Blog Category' ),
	'parent_item_colon' => __( 'Parent Blog Category:' ),
	'edit_item' => __( 'Edit Blog Category' ), 
	'update_item' => __( 'Update  Blog Category' ),
	'add_new_item' => __( 'Add New Blog Category' ),
	'new_item_name' => __( 'New Blog Category' ),
	'menu_name' => __( 'Blog Category' ),
  );           
  register_taxonomy('blog_categories',array('blogs'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'blog_categories' ),
  ));
  // Add new taxonomy, NOT hierarchical (like tags)
  $labels = array(
    'name' => _x( 'Tags', 'taxonomy general name' ),
    'singular_name' => _x( 'Tags', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Tags' ),
    'popular_items' => __( 'Popular Tags' ),
    'all_items' => __( 'All Tags' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Tags' ), 
    'update_item' => __( 'Update Tags' ),
    'add_new_item' => __( 'Add New Tags' ),
    'new_item_name' => __( 'New Tags Name' ),
    'separate_items_with_commas' => __( 'Separate Tags with commas' ),
    'add_or_remove_items' => __( 'Add or remove Tags' ),
    'choose_from_most_used' => __( 'Choose from the most used Tags' ),
    'menu_name' => __( 'Tags' ),
  ); 
  register_taxonomy('writer','blogs',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'writer' ),
  ));
}
add_action( 'init', 'codex_custom_init' );
function codex_custom_init() {
  $labels = array(
    'name' => _x('Blog', 'post type general name'),
    'singular_name' => _x('Blog', 'post type singular name'),
    'add_new' => _x('Add New Blog', 'Blog'),
    'add_new_item' => __('Add New Blog'),
    'edit_item' => __('Edit Blog'),
    'new_item' => __('New Blog'),
    'all_items' => __('All Blog'),
    'view_item' => __('View Blog'),
    'search_items' => __('Search Blog'),
    'not_found' =>  __('No Blog found'),
    'not_found_in_trash' => __('No Blog found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Blog',
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
	'menu_icon' => get_stylesheet_directory_uri() . '/images/blog.png',
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
  ); 
  register_post_type('blogs',$args);}
  
  
/* ------------------------------------------Custom Post Type for Portfolio  ----------------------------------------------------------- */
add_action('init', 'portfolio');
function portfolio() {
$labels = array(
	'name' => _x('Portfolio', 'post type general name'),
	'singular_name' => _x('portfolio', 'post type singular name'),
	'add_new' => _x('Add New', 'Portfolio'),
	'add_new_item' => __('Add New Portfolio'),
	'edit_item' => __('Edit Portfolio'),
	'new_item' => __('New Portfolio'),
	'view_item' => __('View Portfolio'),
	'search_items' => __('Search portfolio'),
	'not_found' =>  __('Nothing found'),
	'not_found_in_trash' => __('Nothing found in Trash'), 
	'parent_item_colon' => ''
);
$args = array(
	'labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true,
	'query_var' => true,
	'menu_icon' => get_stylesheet_directory_uri() . '/images/portfolio.png',
	'rewrite' => true,
	'capability_type' => 'post',
	'hierarchical' => false,
	'menu_position' => null,
	'supports' => array('title','thumbnail','editor')
  ); 
register_post_type( 'portfolio' , $args );}
  register_taxonomy('portfolio_categories',array('portfolio'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'portfolio_categories' ),
  ));  
  