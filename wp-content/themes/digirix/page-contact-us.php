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
 */
get_header(); ?>
<div class="clear"></div>
<div id="primary" class="contentarea">
    <div class="container">
        <div class="wrap">
            <div class="col-md-12 content-left noPadd">
                <div class="breadcrumbs">
                    <div class="breadcrumbs" typeof="BreadcrumbList">
                        <?php if(function_exists('bcn_display'))
{
    bcn_display();
} ?>
                    </div>
                </div>
                <div class="clear"></div>
                <?php  get_template_part( 'loop', 'page' );			?>
            </div>

        </div>
        <!-- #content -->
    </div>
    <!-- #container -->
</div>
<div class="clear"></div>
    <?php get_footer(); ?>