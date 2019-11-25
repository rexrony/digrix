<?php
/**
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title>
            <?php
            global $page, $paged;
            wp_title( '|', true, 'right' );
            bloginfo( 'name' );
            $site_description = get_bloginfo( 'description', 'display' );
            if ( $site_description && ( is_home() || is_front_page() ) )
                echo " | $site_description";
            if ( $paged >= 2 || $page >= 2 )
                echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );
            ?>
        </title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.ico" type="image/x-icon">
        
        <?php if (qtrans_getLanguage() == 'ar'){ ?>
<link href="<?php bloginfo('stylesheet_directory'); ?>/arabic-style.css" rel="stylesheet">
<?php } else { ?> 
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
<?php } ?>

        <!------------------------ CSS Library ------------------------------------>
        <link href="<?php bloginfo('stylesheet_directory'); ?>/css/library.css" rel="stylesheet" type="text/css" />
        <link href="<?php bloginfo('stylesheet_directory'); ?>/css/hover.css" rel="stylesheet" type="text/css" />
        <link href="<?php bloginfo( 'stylesheet_url' ); ?>" rel="stylesheet" media="all" />
        
    <!--.animate Css-->
        <link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_url' ); ?>/css/animate.css">
        <link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_url' ); ?>/css/hover.css">
       
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php
        /* We add some JavaScript to pages with the comment form
* to support sites with threaded comments (when in use).
*/
        if ( is_singular() && get_option( 'thread_comments' ) )
            wp_enqueue_script( 'comment-reply' );
        global $options;global $logo;global $copyrite;
        $options = get_option('cOptn');
        $logo = $options['logo'];
        $favicon = $options['favicon'];
        $copyright = $options['copyright'];
        $twitter_link = $options['twitter_link'];
        $facebook_link = $options['facebook_link'];
        $googleplus_link = $options['googleplus_link'];
        $rss_link = $options['rss_link'];
        $email_link = $options['email_link'];
        $phone_num = $options['phone_num'];
        $fax_num = $options['fax_num'];
        $email = $options['email'];
        $flicker_link = $options['flicker_link'];
        $header_caption = $options['header_caption'];
        $linkedin = $options['linkedin'];
        $youtube = $options['youtube'];
        $size = 444;
        $options['logo'] = wp_get_attachment_image($logo, array($size, $size), false);
        $att_img = wp_get_attachment_image($logo, array($size, $size), false); 
        $logoSrc = wp_get_attachment_url($logo);
        $att_src_thumb = wp_get_attachment_image_src($logo, array($size, $size), false);
        $sizefavicon = 32;
        $options['favicon'] = wp_get_attachment_image($favicon, array($sizefavicon, $sizefavicon), false);
        $att_img = wp_get_attachment_image($favicon, array($sizefavicon, $sizefavicon), false); 
        $faviconSrc = wp_get_attachment_url($favicon);
        $att_src_thumb = wp_get_attachment_image_src($logo, array($size, $size), false);
        /* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
        wp_head();
        ?>
    </head>
    <div class="clear" style="clear:both"></div>
    <body <?php body_class(); ?>>
        <!-- -----------------------Push Responsive Menu   ---------------------- -->
  <div class="button_container" id="toggle">
  <span class="top"></span>
  <span class="middle"></span>
  <span class="bottom"></span>
</div>
<div class="overlay" id="overlay">
  <nav class="overlay-menu">
     <?php $defaults = array( 'menu' => 'main-menu', 'container' => ' ', 'container_class' => '', 'container_id' => '', 'menu_class' => '', 'menu_id' => '', 'theme_location' => 'primary' );
     wp_nav_menu( $defaults ); ?>
  </nav>

</div>

        <!-- -----------------------Push Responsive Menu   ---------------------- -->
        <header class="mainheader col-md-12">
<div id="scrol" class="headertop">

                <div class="container">
                    <div class="social-icon-top col-md-8">
                    <?php if (qtranxf_getLanguage() == 'ar') { ?>
                       
                        <ul>
                            <li><span>اتصل بنا</span><br>
                                <a href="tel:<?php echo $options['phone']; ?>"><?php echo $options['phone']; ?></a></li>
                            <li><span>البريد الإلكتروني الآن</span><br>
                                <a href="mailto:<?php echo $options['email']; ?>"><?php echo $options['email']; ?></a></li>
                            <li><span>موقعك</span><br>
                                <?php echo $options['address']; ?></li>
                        </ul>
                        
                         <?php }else{ ?>
                       
                        <ul>
                            <li><span>Call Us</span><br>
                                <a href="tel:<?php echo $options['phone']; ?>"><?php echo $options['phone']; ?></a></li>
                            <li><span>Email Now</span><br>
                                <a href="mailto:<?php echo $options['email']; ?>"><?php echo $options['email']; ?></a></li>
                            <li><span>Location</span><br>
                                <?php echo $options['address']; ?></li>
                        </ul>
                        <?php } ?>    
                        
                        
                    </div><!--.social-icon-top--->
                    <div class="top-social-icons col-md-3">
                        <ul class="rht">
                            <li><a target="_blank" href="<?php echo $options['facebook']; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="<?php echo $options['twitter']; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="<?php echo $options['linkedin']; ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="<?php echo $options['youtube']; ?>"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                          <li><a target="_blank" href="<?php echo $options['instagram']; ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
                     
                    </div>
                    <div class="lang-swicther col-md-1">
                       <?php 
                            //echo do_shortcode('[google-translator]'); 
                            dynamic_sidebar('second-footer-widget-area');
                        ?>
                    </div>
                </div><!--.container--->
</div><!--.headertop--->
<div class="headerbottom">
                <div class="container">
                    <div class="col-sm-3 col-sm-6  col-xs-6 logoarea head-left noPadd wow fadeInLeft" data-wow-delay="2s" >
                        <div class="logo wow fadeInLeft" data-wow-delay="0.10s">
                            <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                                <?php echo $options['logo']; ?> </a>
                        </div>
                    </div><!--.logo-conatiner--> 
                    <div class="col-md-7 hidden-xs hidden-sm midarea head-rht noPadd-lft wow bounceInUp" data-wow-delay="1s">
                        <div class="mainmenu lft">
                            <section class="rht">
                                <?php $defaults = array( 'menu' => 'main-menu', 'container' => ' ', 'container_class' => '', 'container_id' => '', 'menu_class' => '', 'menu_id' => '', 'theme_location' => 'primary' );
                                wp_nav_menu( $defaults ); ?>
                            </section>
                            <div class="searchtoggle"><img src="<?php bloginfo('stylesheet_directory') ?>/images/search-icon.png" alt=""></div>
<div class="searchpanel">
<form method="get" id="searchform"  class="searchform2"  action="<?php bloginfo('url'); ?>/">
    <input type="submit" id="searchsubmit" value="Search" />
    <input type="search" value="<?php the_search_query(); ?>" name="s" id="s" placeholder="Search" />
</form>
</div>
                        </div> <!--.mainmenu--->
                    </div><!---.col-md-8-->
                    <div class="col-md-2 col-sm-6  col-xs-6 rightarea rht padd10 wow fadeInRight dub-2030" data-wow-delay="3s">
                        <img class="rht" src="<?php bloginfo('stylesheet_directory'); ?>/images/2030.png" alt="">
                    </div>
                </div>
            </div>      <!-- .headerbottom --->
        </header>
        <div class="clear"></div>