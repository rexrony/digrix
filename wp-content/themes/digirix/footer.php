<?php
/**
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
global $options;global $logo;global $copyrite;
$options = get_option('cOptn');
?>
</div>
<footer class="footer">
<div class="footer-top">
  <div class="container">
  <div class="col-md-2 footerboxes center-block floatnone wow fadeInUp" data-wow-delay="0.3s">
        <div class="foo-logo noPadd-lft">
           <a href="<?php echo home_url( '/' ); ?>">
             <h2>Digrix</h2>
             <p>Where Excellence Meets Perfection</p>
            <!-- <img src="<?php bloginfo('stylesheet_directory'); ?>/images/footer-logo.png" alt="" title="" />-->
            </a>
        </div>
      </div>
  <div class="col-md-4 footerboxes center-block floatnone wow fadeInUp" data-wow-delay="0.6s">
      <div class="footer-contact-list">
          <ul>
             <li> <i class="fa fa-home" aria-hidden="true"></i>&nbsp; <?php echo $options['address']; ?></li>
              <li><a href="tel:<?php echo $options['phone']; ?>"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp; <?php echo $options['phone']; ?></a></li>
              <li><a href="mail:<?php echo $options['email']; ?>"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; <?php echo $options['email']; ?></a></li>
              
          </ul>
</div><!--.footer-contact-list-->
  </div><!--.footerboxes---> 
  <div class="col-md-12 footerboxes center-block floatnone wow fadeInUp" data-wow-delay="0.8s">
      <div class="social-icons-footer">
           <ul class="footer-social-icons">
                            <li><a target="_blank" href="<?php echo $options['facebook']; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="<?php echo $options['twitter']; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="<?php echo $options['linkedin']; ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="<?php echo $options['youtube']; ?>"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
               <li><a target="_blank" href="<?php echo $options['instagram']; ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
      </div>
  </div>
  <div class="col-md-12 footerboxes center-block floatnone wow fadeInUp" data-wow-delay="0.10s">
  <div class="footer-menu col-md-9 center-block floatnone"> 
  <?php $defaults = array( 'menu' => 'footer', 'theme_location' => '' ); wp_nav_menu( $defaults ); ?>
        </div>
      </div><!--.footerboxes--->
 
    </div><!--.container--->
  </div><!--.footer-top--->
<div class="footer-bottom">
      <div class="copyright">
    <div class="container">
        <div class="col-md-6 center-block floatnone">
          <p><?php echo $options['copyright']; ?> &nbsp; </p>
        </div>

    </div>
  </div><!--.copyright--->
  
 </div> <!--.footer-bottom-->

</footer><!-- .site-footer -->
</div>
<!------------------------ Back to top ------------------------------------>
<div id="back-top"> <a href="#top"> <span class="fa fa-arrow-circle-o-up"></span></a> </div>

<!--<div id="winSize"></div>-->


<!------------------------ Jquery CDN ---------------------------------
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>--->
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery-2.2.0.min.js"></script>
<!------------------------ Javascript ------------------------------------>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/library.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/main.js"></script>

<!------------------------ WOW Animation CDN-----------------------------
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/main.js"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/wow.min.js"></script>------->
<script>new WOW({
        offset: 15, 
        
    }).init();

    $("#es_txt_name").attr("placeholder", "Your Name");
    $("#es_txt_email").attr("placeholder", "Email Address");
</script>

<script>
$('#toggle').click(function() {
   $(this).toggleClass('active');
   $('#overlay').toggleClass('open');
    $('body').toggleClass('fixedscroll');
    //$('#overlay').addClass('open');
  });
  

</script>

<script>

var wrap = $(".headertop");

wrap.on("scroll", function(e) {
    
  if (this.scrollTop > 147) {
    wrap.addClass("fix-search");
  } else {
    wrap.removeClass("fix-search");
  }
  
});

/**
 * A simple script to prevent empty searches
 */
$(document).ready(function(){        
    $('#searchform').submit(function(e) { // run the submit function, pin an event to it
        var s = $( this ).find("#s").val($.trim($( this ).find("#s").val())); // find the #s, which is the search input id and trim any spaces from the start and end
        if (!s.val()) { // if s has no value, proceed
            e.preventDefault(); // prevent the default submission
            alert("Your search is empty!"); // alert that the search is empty
            $('#s').focus(); // focus on the search input
        }
    });
       $('#searchform2').submit(function(e) { // run the submit function, pin an event to it
        var s = $( this ).find("#s").val($.trim($( this ).find("#s").val())); // find the #s, which is the search input id and trim any spaces from the start and end
    if (!s.val()) { // if s has no value, proceed
            e.preventDefault(); // prevent the default submission
            alert("Your search is empty!"); // alert that the search is empty
            $('#s').focus(); // focus on the search input
        }
    });
// --------------------------------------------------Toggle Search------------------------------------------------------------------------//


  $(".searchtoggle").click(function(event){
     event.preventDefault();
     $(".searchpanel").toggleClass('se-open');
     $(".searchtoggle").toggleClass('pa-open');
     //$('.searchpanel').toggleClass('se-open');
    //$(".searchpanel").toggle();
    console.log('1 test');
  });
  /*  $(".pa-open").click(function(ev){
        ev.preventDefault();
        alert('check');
        $(".searchtoggle").removeClass('se-open');
        console.log('2 test');
    });*/
});
</script>


<?php wp_footer(); ?>
</body>
</html>
