<?php 
wp_enqueue_script( 'ticket-notify-app', 'https://www.gstatic.com/firebasejs/5.8.2/firebase-app.js' );
wp_enqueue_script( 'ticket-notify-message', 'https://www.gstatic.com/firebasejs/5.8.2/firebase-messaging.js' );
do_action('ticket-notify-generate-token'); ?>
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
<script>
            google.setOnLoadCallback(drawStackChartHorizontal);
            function drawStackChartHorizontal() {
            var data = google.visualization.arrayToDataTable([
                <?php
                echo jssupportticket::$_data['stack_chart_horizontal']['title'] . ',';
                echo jssupportticket::$_data['stack_chart_horizontal']['data'];
                ?>
            ]);
                    var view = new google.visualization.DataView(data);
                    var options = {
                    height:250,
                            legend: { position: 'top', maxLines: 3 },
                            bar: { groupWidth: '75%' },
                            isStacked: true,
                            colors:<?php echo jssupportticket::$_data['stack_chart_horizontal']['colors']; ?>,
                    };
                    var chart = new google.visualization.BarChart(document.getElementById("stack_chart_horizontal"));
                    chart.draw(view, options);
            }
</script>
<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">   
        <div id="js-main-cp-wrapper">
        <div id="js-main-head-cp">
            <div class="js-cptext"><?php echo __('Dashboard', 'js-support-ticket'); ?></div>
            <div class="js-cpmenu">
                <span class="dashboard-icon">
                    <?php
                        $url = 'http://www.joomsky.com/appsys/changelog/changelog.php';
                        $post_data = array();
                        $post_data['version'] = JSSTincluder::getJSModel('configuration')->getConfigurationByConfigName('versioncode');
                        $post_data['product'] = 'jsticketwp';
                        $post_data['dt'] = date('Y-m-d');
                        $response = array();

                        $response = wp_remote_post( $url, array('body' => $post_data,'timeout'=>7,'sslverify'=>false));
                        if( !is_wp_error($response) && $response['response']['code'] == 200 && isset($response['body']) ){
                            $call_result = $response['body'];
                        }else{
                            $call_result = false;
                            if(!is_wp_error($response)){
                               $error = $response['response']['message'];
                           }else{
                                $error = $response->get_error_message();
                           }
                        }
                        if($call_result){
                            $result = json_decode($call_result,true);
                        }else{
                            $result = array();
                        }

                        if(isset($result['result_flag']) && $result['result_flag'] == 1){
                           $response = $result['result_data'];
                        }
                        
                        $current_version = JSSTincluder::getJSModel('configuration')->getConfigurationByConfigName('versioncode');
                        $new_vesion = 0;
                        $latest_version = $result['latest_version'];
                        if($call_result != false){
                            if(version_compare($latest_version, $current_version,'<=')){
                                $image = jssupportticket::$_pluginpath.'includes/images/admincp/up-dated.png';
                                $lang = __('Your System Is Up To Date', 'js-support-ticket');
                                $class = "green";
                            }elseif(version_compare($latest_version, $current_version,'>')){
                                $image = jssupportticket::$_pluginpath.'includes/images/admincp/new-version.png';
                                $lang = __('New Version Is Available', 'js-support-ticket');
                                $class = "orange";
                                $new_vesion = 1;
                            }
                        }else{
                            $image = jssupportticket::$_pluginpath.'includes/images/admincp/connection-error.png';
                            $lang = $error;
                            $class = "red";
                        }

                    ?>
                    <?php if($new_vesion == 1){?>
                        <a href="admin.php?page=jsjobs&jsjobslt=stepone" >
                    <?php }?>
                        <span class="download <?php echo $class; ?>">
                            <img src="<?php echo $image; ?>" />
                            <span><?php echo $lang; ?></span>
                        </span>
                    <?php if($new_vesion == 1){?>
                        </a>
                    <?php }
                    if( $new_vesion == 1 && !empty($response)){?>
                        <span class="jsst-version-changes-popup" onclick="showPopUpVersionChnages();" >
                            <img src="<?php echo jssupportticket::$_pluginpath . "includes/images/admincp/version-available-icon.png"; ?>" />
                            <span class="jsst-smaal-icon-circle">&nbsp;</span>
                        </span>                
                        <?php 
                    }?>

                </span>
                <script >
                    function showPopUpVersionChnages(){
                        jQuery("#full_background").show();
                        jQuery("#jsst_popup_main").slideDown("slow");
                    }

                    function closePopupVersioChanges(){
                        jQuery("#jsst_popup_main").slideUp("slow");
                        jQuery("#full_background").fadeOut();
                    }
                </script>
                <div id="full_background" style="display:none;" onclick="closePopupVersioChanges()" ></div>
                <div id="jsst_popup_main" class="jsjobs-vesrion-changes-popup" style="display:none;">
                    <span class="popup-top"><span id="popup_title" >
                        <?php echo __("Your Version","js-jobs").':&nbsp;'.$data_array['version'];?>
                    </span><img id="popup_cross" alt="popup cross" onclick="closePopupVersioChanges()" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/popup-close.png"/>
                    </span>
                    <div class="jsst-version-changes-popup-data" >
                        <?php
                            if(!empty($response)) {?>
                                <?php
                                $version_count = 0;
                                foreach ($response as $version => $changes) {
                                    if(isset($changes['pro']) && !empty($changes['pro'])){
                                    ?>
                                    <div class="jsst-version-changes-popup-version-title version_count_num_<?php echo $version_count;?>" > <?php echo $version;?></div>
                                    <?php 
                                        if($version_count == 4){
                                            $version_count = 0;   
                                        }else{
                                            $version_count++;
                                        }
                                    }
                                    $pro_keys = array();

                                    foreach ($changes['free'] as $key => $val) {
                                        if($version != $current_version ){
                                            echo '<span class="jsst-version-changes-popup-changes" >'.$val.'</span>';
                                        }
                                        if(isset($changes['pro'])){
                                            if(isset($changes['pro'][$key])){
                                                echo '<span class="jsst-version-changes-popup-changes" > <img src="'.jssupportticket::$_pluginpath.'includes/images/admincp/line.jpg"/>'.$changes['pro'][$key].' <img class="version-change-second-image" src="'.jssupportticket::$_pluginpath.'includes/images/admincp/pro-icon.jpg"/></span>';
                                                $pro_keys[$key] = $key;
                                            }

                                        }
                                    }
                                    if(isset($changes['pro'])){
                                        foreach ($changes['pro'] as $key => $val) {
                                            if(! in_array($key, $pro_keys)){
                                                echo '<span class="jsst-version-changes-popup-changes" > <img src="'.jssupportticket::$_pluginpath.'includes/images/admincp/line.jpg"/>'.$changes['pro'][$key].' <img class="version-change-second-image" src="'.jssupportticket::$_pluginpath.'includes/images/admincp/pro-icon.jpg"/></span>';
                                            }

                                        }
                                    }
                                }
                            }?>
                    </div>
                    <div class="version-change-popup-button-wrapper" >
                        <a class="version-change-popup-first-button" target="_blank" href="<?php echo admin_url('plugins.php');?>" ><?php echo __('Update To Latest', 'js-support-ticket'); ?></a>
                        <a class="version-change-popup-second-button" target="_blank" href="https://joomsky.com/products/js-jobs-pro-wp.html"  ><?php echo __('Get PRO Version', 'js-support-ticket'); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <div id="js-total-count-cp">
            <div class="js-total-count">
                <img class="img" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/admincp/new.png" />
                <div class="data">
                    <span class="jstotal"><?php echo jssupportticket::$_data['ticket_total']['openticket']; ?></span>
                    <span class="jsstatus"><?php echo __('New','js-support-ticket'); ?></span>
                </div>
            </div>
            <div class="js-total-count">
                <img class="img" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/admincp/answered.png" />
                <div class="data">
                    <span class="jstotal"><?php echo jssupportticket::$_data['ticket_total']['answeredticket']; ?></span>
                    <span class="jsstatus"><?php echo __('Answered','js-support-ticket'); ?></span>
                </div>
            </div>
            <div class="js-total-count">
                <img class="img" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/admincp/pending.png" />
                <div class="data">
                    <span class="jstotal"><?php echo jssupportticket::$_data['ticket_total']['pendingticket']; ?></span>
                    <span class="jsstatus"><?php echo __('Pending','js-support-ticket'); ?></span>
                </div>
            </div>
        </div>

        <div id="js-pm-graphtitle">
            <img class="js-giamge" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/admincp/menu-icon.png" />
            <?php echo __('Statistics', 'js-support-ticket'); ?>
            <small> <?php $curdate = date_i18n('Y-m-d'); $fromdate = date_i18n('Y-m-d', strtotime("now -1 month")); echo " ($fromdate - $curdate)"; ?> </small>
        </div>
        <div id="js-pm-grapharea">
            <div id="stack_chart_horizontal" style="width:100%;"></div>
        </div>

        <span class="js-admin-menus-head"><?php echo __('Admin', 'js-support-ticket'); ?></span>
        <div id="js-wrapper-menus">
            <a class="js-admin-menu-link" href="?page=ticket&jstlay=tickets"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/ticket.png"/><div class="jsmenu-text"><?php echo __('Tickets', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=department&jstlay=departments"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/departments.png"/><div class="jsmenu-text"><?php echo __('Departments', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=priority&jstlay=priorities"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/priority.png"/><div class="jsmenu-text"><?php echo __('Priorities', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=email&jstlay=emails"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/system-email.png"/><div class="jsmenu-text"><?php echo __('System Emails', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=fieldordering&jstlay=fieldordering&fieldfor=1"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/fieldordering.png"/><div class="jsmenu-text"><?php echo __('Fields', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=systemerror&jstlay=systemerrors"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/system_error.png"/><div class="jsmenu-text"><?php echo __('System Errors', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=emailtemplate&jstlay=emailtemplates"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/email_template.png"/><div class="jsmenu-text"><?php echo __('Email Templates', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=reports&jstlay=overallreport"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/report_icon.png"/><div class="jsmenu-text"><?php echo __('Reports', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=jssupportticket&jstlay=aboutus"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/about_us.png"/><div class="jsmenu-text"><?php echo __('About Us','js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=jssupportticket&jstlay=translations"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/language-icon.png"/><div class="jsmenu-text"><?php echo __('Translations','js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=jssupportticket&jstlay=propage"><img class="jsmenu-img" style="height:60px;width:auto;" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/pro_icon.png"/><div class="jsmenu-text"><?php echo __('Pro Features', 'js-support-ticket'); ?></div></a>
        </div>
        <div id="wp-jobs-banner">
            <a href="https://www.joomsky.com/products/js-supprot-ticket-pro-wp.html" target="_blank">
                <img src="<?php echo jssupportticket::$_pluginpath."/includes/images/tickets-pro-banner.png"; ?>" />
            </a>
        </div>

        <span class="js-admin-menus-head"><?php echo __('Configuration', 'js-support-ticket'); ?></span>
        <div id="js-wrapper-menus">
            <a class="js-admin-menu-link" href="?page=configuration&jstlay=configurations"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/configuration.png"/><div class="jsmenu-text"><?php echo __('Configurations', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=proinstaller&jstlay=step1"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/update.png"/><div class="jsmenu-text"><?php echo __('Upgrade', 'js-support-ticket'); ?></div></a>
        </div>
        <?php
        $field_array = JSSTincluder::getJSModel('fieldordering')->getFieldTitleByFieldfor(1);
        ?>
        <div id="js-pm-graphtitle" class="tickettitle"> <img class="js-giamge" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/admincp/menu-icon.png" />
            <?php echo __('Latest Tickets', 'js-support-ticket'); ?>
        </div>
        <div class="js-ticket-admin-cp-tickets">
            <div class="js-row js-ticket-admin-cp-head js-ticket-admin-hide-head">
                <div class="js-col-xs-12 js-col-md-2"><?php echo __('Ticket ID', 'js-support-ticket'); ?></div>
                <div class="js-col-xs-12 js-col-md-3"><?php echo __($field_array['subject'], 'js-support-ticket'); ?></div>
                <div class="js-col-xs-12 js-col-md-1"><?php echo __($field_array['status'], 'js-support-ticket'); ?></div>
                <div class="js-col-xs-12 js-col-md-2"><?php echo __('From', 'js-support-ticket'); ?></div>
                <div class="js-col-xs-12 js-col-md-2"><?php echo __($field_array['priority'], 'js-support-ticket'); ?></div>
                <div class="js-col-xs-12 js-col-md-2"><?php echo __('Created', 'js-support-ticket'); ?></div>
            </div>
            <?php foreach (jssupportticket::$_data['tickets'] AS $ticket): ?>
                <div class="js-ticket-admin-cp-data">
                    <div class="js-col-xs-12 js-col-md-2"><span class="js-ticket-admin-cp-showhide"><?php
                            echo __('Ticket ID', 'js-support-ticket');
                            echo " : ";
                            ?></span> <a href="<?php echo admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $ticket->id); ?>"><?php echo $ticket->ticketid; ?></a></div>
                    <div class="js-col-xs-12 js-col-md-3 js-admin-cp-text-elipses"><span class="js-ticket-admin-cp-showhide" ><?php
                            echo __('Subject', 'js-support-ticket');
                            echo " : ";
                            ?></span> <?php echo $ticket->subject; ?></div>
                    <div class="js-col-xs-12 js-col-md-1">
                        <span class="js-ticket-admin-cp-showhide" ><?php
                        echo __('Status', 'js-support-ticket');
                        echo " : ";
                        ?></span>
                        <?php
                        if ($ticket->status == 0) {
                            $style = "red;";
                            $status = __('New', 'js-support-ticket');
                        } elseif ($ticket->status == 1) {
                            $style = "orange;";
                            $status = __('Waiting Staff Reply', 'js-support-ticket');
                        } elseif ($ticket->status == 2) {
                            $style = "#FF7F50;";
                            $status = __('In Progress', 'js-support-ticket');
                        } elseif ($ticket->status == 3) {
                            $style = "green;";
                            $status = __('Waiting Your Reply', 'js-support-ticket');
                        } elseif ($ticket->status == 4) {
                            $style = "blue;";
                            $status = __('Closed', 'js-support-ticket');
                        }
                        echo '<span style="color:' . $style . '">' . $status . '</span>';
                        ?>
                    </div>
                    <div class="js-col-xs-12 js-col-md-2"> <span class="js-ticket-admin-cp-showhide" ><?php
                            echo __('From', 'js-support-ticket');
                            echo " : ";
                            ?></span> <?php echo $ticket->name; ?></div>
                    <div class="js-col-xs-12 js-col-md-2" style="color:<?php echo $ticket->prioritycolour; ?>;"> <span class="js-ticket-admin-cp-showhide" ><?php
                            echo __('Priority', 'js-support-ticket');
                            echo " : ";
                            ?></span> <?php echo __($ticket->priority, 'js-support-ticket'); ?></div>
                    <div class="js-col-xs-12 js-col-md-2"><span class="js-ticket-admin-cp-showhide" ><?php
            echo __('Created', 'js-support-ticket');
            echo " : ";
            ?></span> <?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($ticket->created)); ?></div>
                </div>
        <?php endforeach; ?>
        </div>
        <span class="js-admin-menus-head"><?php echo __('Support Area', 'js-support-ticket'); ?></span>
        <div id="js-wrapper-menus">
            <a class="js-admin-menu-link" href="?page=jssupportticket&jstlay=shortcodes"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/short_code.png"/><div class="jsmenu-text"><?php echo __('Short Codes', 'js-support-ticket'); ?></div></a>

            <a class="js-admin-menu-link" target="_blank" href="https://www.joomsky.com/appsys/documentations/wp-support-ticket"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/documentation.png"/><div class="jsmenu-text"><?php echo __('Documentation', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" target="_blank" href="https://www.joomsky.com/appsys/forum/wp-support-ticket"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/forum.png"/><div class="jsmenu-text"><?php echo __('Forum', 'js-support-ticket'); ?></div></a>
            <?php /* <a class="js-admin-menu-link" target="_blank" href="https://www.joomsky.com/appsys/support/wp-support-ticket"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/support.png"/><div class="jsmenu-text"><?php echo __('Support', 'js-support-ticket'); ?></div></a> */ ?>

        <a class="banner" target="_blank" href="http://demo.joomsky.com/js-jobs/wp/pro"><img class="banner" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/new-banner-2.png"/></a>
        </div>
        <div id="jsreview-banner">
            <div class="review">
                <div class="review-left-wrp">
                    <div class="jsleft">
                        <img class="reviewpic" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/review/rating-icon.jpg">
                    </div>
                    <div class="jsright">
                        <div class="jsrighttext">
                            <div class="js_feedback_text">
                                <?php echo __('Your feedback help us', 'js-support-ticket'); ?>
                            </div>
                            <div class="js_feedback_heading">
                                <?php echo __('Contribute in JS support ticket', 'js-support-ticket'); ?>
                            </div> 
                            <div class="js_feedback_msg1">
                                <?php echo __('Your positive feedback help us to improve JS Support Ticket', 'js-support-ticket'); ?>
                            </div>
                            <div class="js_feedback_msg1">
                                <?php echo __('Please give us full rating and share it with your friends', 'js-support-ticket'); ?>
                            </div>         
                        </div>
                    </div>
                </div>
                <div class="review-right-wrp">
                    <div class="social_wrp">
                        <div class="js_wpdir">
                            <div class="js_wpdir_heading">
                                <?php echo __("Review on:","js-support-ticket"); ?>
                            </div>    
                            <div class="js_wpdir_button">
                                <a href="https://wordpress.org/support/plugin/js-support-ticket/reviews"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/review/star_single.png"><?php echo __("WP Extension Directory","js-support-ticket"); ?></a>
                            </div>    
                        </div>
                        <div class="js_social_link_wrp">
                            <div class="js_social_links">
                                <div class="js_social_links_heading">
                                    <?php echo __("Spread the words","js-support-ticket"); ?>:
                                </div>
                                <div class="js_social_links_images">
                                    <?php 
                                        $current_url = "https://joomsky.com/products/js-support-ticket-wp.html";
                                        $posttitle = __("JS Support Ticket for WordPress","js-support-ticket");
                                    ?>
                                    <a class="jsst_facebook" title="<?php echo esc_attr(__('Facebook Share','js-support-ticket')); ?>" href="www.facebook.com" onclick="window.open('http://www.facebook.com/sharer.php?u=<?php echo esc_url($current_url); ?>&t=<?php echo $posttitle; ?>', '_blank', 'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=550, height=440, toolbar=0, status=0');return false;"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/review/facebook.png"></a>
                                    <a class="jsst_twitter" title="<?php echo esc_attr(__('Twitter Share','js-support-ticket')); ?>" href="http://twitter.com" onclick="window.open('http://twitter.com/share?text=<?php echo $posttitle; ?>&url=<?php echo esc_url($current_url); ?>', '_blank', 'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=550, height=440, toolbar=0, status=0');return false;"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/review/twitter.png"></a>
                                    <a class="jsst_linkedin" title="<?php echo esc_attr(__('Linkedin Share','js-support-ticket')); ?>" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url($current_url); ?>&title=<?php echo $posttitle; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/review/linkedin.png"></a>
                                    <a class="jsst_instagram" title="<?php echo esc_attr(__('Instagram Share','js-support-ticket')); ?>" target="_blank" href="http://www.instagram.com/share?title=<?php echo $posttitle; ?> - <?php echo esc_url($current_url); ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/review/instagram.png"></a>
                                    <a class="jsst_pintrest" title="<?php echo esc_attr(__('Pintrest Share','js-support-ticket')); ?>" target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url($current_url); ?>&description=<?php echo $posttitle; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/review/pintrest.png"></a>
                                    <a class="jsst_blogger" title="<?php echo esc_attr(__('Blogger','js-support-ticket')); ?>" href="https://www.blogger.com/blog-this.g?u=<?php echo esc_url($current_url); ?>" onclick="window.open('http://www.blogger.com/blog_this.pyra?t&u=<?php echo esc_url($current_url); ?>&n=<?php echo $posttitle; ?>', '_blank', 'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=550, height=440, toolbar=0, status=0');return false;"><img alt="<?php echo esc_attr(__('Blogger','js-support-ticket')); ?>" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/review/bloger.png"></a>
                                    <a class="jsst_tumbler" title="<?php echo esc_attr(__('Tumbler Share','js-support-ticket')); ?>" href="#" onclick="window.open('http://www.tumblr.com/share/link?name=<?php echo $posttitle; ?>&url=<?php echo esc_url($current_url); ?>', '_blank', 'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=550, height=440, toolbar=0, status=0');return false;"><img alt="<?php echo esc_attr(__('Tumbler Share','js-support-ticket')); ?>" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/review/tumbler.png"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery("span.dashboard-icon").find('span.download').hover(function(){
                    jQuery(this).find('span').toggle("slide");
                    }, function(){
                    jQuery(this).find('span').toggle("slide");
                });
            });
        </script>
    </div>
</div>
