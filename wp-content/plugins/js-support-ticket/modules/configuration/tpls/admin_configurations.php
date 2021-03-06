<?php
wp_enqueue_script( 'ticket-notify-app', 'https://www.gstatic.com/firebasejs/5.8.2/firebase-app.js' );
wp_enqueue_script( 'ticket-notify-message', 'https://www.gstatic.com/firebasejs/5.8.2/firebase-messaging.js' );
JSSTmessage::getMessage();
wp_enqueue_script('jquery-ui-tabs');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
wp_enqueue_style('jquery-ui-css', $protocol.'www.example.com/your-plugin-path/css/jquery-ui.css');
wp_enqueue_style('jquery-ui-css', $protocol.'ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
?>
<script>
    jQuery(document).ready(function () {
        jQuery(".tabs").tabs();
        jQuery('select#ticket_overdue_type').change(function(){
            var isselect = jQuery('select#ticket_overdue_type').val();
            if(isselect == 1){
                jQuery('span.ticket_overdue_type_text').html("<?php echo __('Days', 'js-support-ticket');?>");
            }else{
                jQuery('span.ticket_overdue_type_text').html("<?php echo __('Hours', 'js-support-ticket');?>");
            }
        });

    function showhidehostname(value) {
        if (value == 4) {
            jQuery("div#tve_hostname").show();
        } else {
            jQuery("div#tve_hostname").hide();
        }
    }

    jQuery(document).ready(function () {
        jQuery('select#set_login_link').change(function(){
           var value = jQuery(this).val();
           if (value == 2)
            {
               jQuery('.loginlink_field').attr('style','display: block');
            }else
            {
                jQuery('.loginlink_field').attr('style','display: none');
            }

            })
   
           var value = jQuery('select#set_login_link').val();
           if (value == 2)
            {
               jQuery('.loginlink_field').attr('style','display: block');
            }else
            {
                jQuery('.loginlink_field').attr('style','display: none');
            }

            });

        });
</script>
<?php
$captchaselection = array(
    (object) array('id' => '1', 'text' => __('Google Recaptcha', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Own Captcha', 'js-support-ticket'))
);
$owncaptchaoparend = array(
    (object) array('id' => '2', 'text' => '2'),
    (object) array('id' => '3', 'text' => '3')
);
$owncaptchatype = array(
    (object) array('id' => '0', 'text' => __('Any', 'js-support-ticket')),
    (object) array('id' => '1', 'text' => __('Addition', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Subtraction', 'js-support-ticket'))
);
$yesno = array(
    (object) array('id' => '1', 'text' => __('JYes', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('JNo', 'js-support-ticket'))
);
$showhide = array(
    (object) array('id' => '1', 'text' => __('Show', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Hide', 'js-support-ticket'))
);
$defaultcustom = array(
    (object) array('id' => '1', 'text' => __('Default', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Custom', 'js-support-ticket'))
);
$screentagposition = array(
    (object) array('id' => '1', 'text' => __('Top left', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Top right', 'js-support-ticket')),
    (object) array('id' => '3', 'text' => __('Middle left', 'js-support-ticket')),
    (object) array('id' => '4', 'text' => __('Middle right', 'js-support-ticket')),
    (object) array('id' => '5', 'text' => __('Bottom left', 'js-support-ticket')),
    (object) array('id' => '6', 'text' => __('Bottom right', 'js-support-ticket'))
);
$enableddisabled = array(
    (object) array('id' => '1', 'text' => __('Enabled', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Disabled', 'js-support-ticket'))
);
$mailreadtype = array(
    (object) array('id' => '1', 'text' => __('Only New Tickets', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Only Replies', 'js-support-ticket')),
    (object) array('id' => '3', 'text' => __('Both', 'js-support-ticket'))
);

$sequence = array(
    (object) array('id' => '1', 'text' => __('Random', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Sequence', 'js-support-ticket'))
);

$hosttype = array(
    (object) array('id' => '1', 'text' => __('Gmail', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Yahoo', 'js-support-ticket')),
    (object) array('id' => '3', 'text' => __('Aol', 'js-support-ticket')),
    (object) array('id' => '4', 'text' => __('Other', 'js-support-ticket'))
);
// wp roles combo for new user
global $wp_roles;
$roles = $wp_roles->get_names();
$userroles = array();
foreach ($roles as $key => $value) {
    $userroles[] = (object) array('id' => $key, 'text' => $value);
}
?>
<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">	
    <span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __("Configurations", 'js-support-ticket') ?></span></span>

        <form method="post" class="js-support-ticket-configurations" action="<?php echo admin_url("?page=configuration&task=saveconfiguration"); ?>"  enctype="multipart/form-data">
            <div id="tabs" class="tabs">
                <ul>
                    <li><a href="#general"><?php echo __('General Setting', 'js-support-ticket') ?></a></li>
                    <li><a href="#ticketsettig"><?php echo __('Ticket Setting', 'js-support-ticket') ?></a></li>
                    <li><a href="#defaultemail"><?php echo __('Default System Email', 'js-support-ticket') ?></a></li>
                    <?php /*
                      <li><a href="#staffmembers"><?php echo __('Staff Members','js-support-ticket') ?></a></li>
                      <li><a href="#Knowledegebase"><?php echo __('Knowledge Base','js-support-ticket') ?></a></li>
                     * 
                     */ ?>
                    <li><a href="#mailsetting"><?php echo __('Mail Setting', 'js-support-ticket'); ?></a></li>
                    <li><a href="#staffmenusetting"><?php echo __('Staff Menu Setting', 'js-support-ticket'); ?></a></li>
                    <li><a href="#usermenusetting"><?php echo __('User Menu Setting', 'js-support-ticket'); ?></a></li>
                    <li><a href="#feedback"><?php echo __('Feedback Setting', 'js-support-ticket'); ?></a></li>
                    <li><a href="#pushnotification"><?php echo __('Push Notification', 'js-support-ticket'); ?></a></li>
                </ul>
                <div class="tabInner">
                    <div id="general">
                        <h3 class="js-ticket-configuration-heading-main"><?php echo __('General Setting', 'js-support-ticket') ?></h3>
                        <div class="js-ticket-configuration-table">
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Title', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('title', jssupportticket::$_data[0]['title'], array('class' => 'inputbox')) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Set the heading of your plugin', 'js-support-ticket'); ?></small></div>
                            </div>
                            <?php /*
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('System Slug', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('system_slug', jssupportticket::$_data[0]['system_slug'], array('class' => 'inputbox')) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Set the slug name for JS Support Ticket. Make sure it is unique in pages and posts. In future, if same name page or post is create, system will rename and add a number with slug.', 'js-support-ticket'); ?></small></div>
                            </div>
                            */ ?>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticket Default Page', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('default_pageid', JSSTincluder::getJSModel('configuration')->getPageList(), jssupportticket::$_data[0]['default_pageid'], __('Select Page', 'js-support-ticket'), array('class' => 'inputbox', 'data-validation' => 'required')); ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Select JS Support Ticket default page, on action system will redirect on selected page. If not select default page, email links and support icon might not work.', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Support Icon', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('support_screentag', $showhide, jssupportticket::$_data[0]['support_screentag'], '', array('class' => 'inputbox', 'data-validation' => 'required')); ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Enable / disable your support icon', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Support Icon Position', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('screentag_position', $screentagposition, jssupportticket::$_data[0]['screentag_position'], __('Screen Tag Position', 'js-support-ticket'), array('class' => 'inputbox', 'data-validation' => 'required')); ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Select position for your support icon', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Offline', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('offline', array((object) array('id' => '1', 'text' => __('Offline', 'js-support-ticket')), (object) array('id' => '2', 'text' => __('Online', 'js-support-ticket'))), jssupportticket::$_data[0]['offline']); ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Set your plugin offline for front end', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Offline Message', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo wp_editor(jssupportticket::$_data[0]['offline_message'], 'offline_message', array('media_buttons' => false)); ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Set the offline message for your user', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Data Directory', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('data_directory', jssupportticket::$_data[0]['data_directory'], array('class' => 'inputbox')) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Set the name for your data directory', 'js-support-ticket'); ?><br/><?php echo __('You need to rename the existing data directory in file system before changing the data directory name','js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Date Format', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('date_format', array((object) array('id' => 'd-m-Y', 'text' => __("DD-MM-YYYY", 'js-support-ticket')), (object) array('id' => 'm-d-Y', 'text' => __("MM-DD-YYYY", 'js-support-ticket')), (object) array('id' => 'Y-m-d', 'text' => __("YYYY-MM-DD", 'js-support-ticket'))), jssupportticket::$_data[0]['date_format']); ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Set the default date format', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticket Overdue', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('ticket_overdue', jssupportticket::$_data[0]['ticket_overdue'], array('class' => 'inputbox')) ?><?php echo __('Days', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Set no. of days to mark ticket as overdue', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticket auto close', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('ticket_auto_close', jssupportticket::$_data[0]['ticket_auto_close'], array('class' => 'inputbox')) ?><?php echo __('Days', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Ticket auto close if user not respond within given days', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('No. of attachment', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('no_of_attachement', jssupportticket::$_data[0]['no_of_attachement'], array('class' => 'inputbox')) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('No. of attachment allowed at a time', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('File maximum size', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('file_maximum_size', jssupportticket::$_data[0]['file_maximum_size'], array('class' => 'inputbox')) ?><?php echo __('Kb', 'js-support-ticket') ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('File extension', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::textarea('file_extension', jssupportticket::$_data[0]['file_extension'], array('class' => 'inputbox')); ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('File extension allowed to attach', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Pagination default page size', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('pagination_default_page_size', jssupportticket::$_data[0]['pagination_default_page_size'], array('class' => 'inputbox')) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Set the no. of record per page', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Breadcrumbs', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('show_breadcrumbs', $showhide, jssupportticket::$_data[0]['show_breadcrumbs']) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Show hide breadcrumbs', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Top Header', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('show_header', $showhide, jssupportticket::$_data[0]['show_header']) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Show hide Top Header', 'js-support-ticket'); ?></small></div>
                            </div>>
                            <?php /*
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Login redirect', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('login_redirect', $yesno, jssupportticket::$_data[0]['login_redirect']) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Redirect user to JS Support Ticket control panel after login', 'js-support-ticket'); ?></small></div>
                            </div>
                            */ ?>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Show count on my tickets', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('count_on_myticket', $yesno, jssupportticket::$_data[0]['count_on_myticket']) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Show number of open, closed, answered ticket in my ticket', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Show  captcha on registration form', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('captcha_on_registration', $yesno, jssupportticket::$_data[0]['captcha_on_registration']) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Select whether you want to show captcha on registration form or not', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Default wp role for new users', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('wp_default_role', $userroles, jssupportticket::$_data[0]['wp_default_role']) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Select role you want to assign to new users', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Set Login Link', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('set_login_link', $defaultcustom, jssupportticket::$_data[0]['set_login_link']) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Set Login Link Default or Custom', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title">&nbsp;</div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('login_link', jssupportticket::$_data[0]['login_link'], array('class' => 'inputbox loginlink_field')) ?></div>
                            </div>
                        </div>
                    </div>
                    <div id="ticketsettig">
                        <h3 class="js-ticket-configuration-heading-main"><?php echo __('Ticket Setting', 'js-support-ticket') ?></h3>
                        <table >
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticketid sequence', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('ticketid_sequence', $sequence, jssupportticket::$_data[0]['ticketid_sequence']) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Set ticketid sequential or random', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Maximum tickets', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('maximum_tickets', jssupportticket::$_data[0]['maximum_tickets'], array('class' => 'inputbox')) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Maximum ticket per user', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Maximum open tickets', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('maximum_open_tickets', jssupportticket::$_data[0]['maximum_open_tickets'], array('class' => 'inputbox')) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Maximum opened tickets per user', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Reopen ticket within days', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('reopen_ticket_within_days', jssupportticket::$_data[0]['reopen_ticket_within_days'], array('class' => 'inputbox')) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Ticket can be reopen within given number of days', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('User can print ticket', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('print_ticket_user', $yesno, jssupportticket::$_data[0]['print_ticket_user']); ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Can user print ticket from ticket detail or not', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Visitor can create ticket', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('visitor_can_create_ticket', $yesno, jssupportticket::$_data[0]['visitor_can_create_ticket']); ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Can visitor create ticket or not', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Visitor ticket creation message', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo wp_editor(jssupportticket::$_data[0]['visitor_message'], 'visitor_message'); ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('This text will appear whenever visitor creates ticket', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Show captcha on visitor form ticket', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('show_captcha_on_visitor_from_ticket', $yesno, jssupportticket::$_data[0]['show_captcha_on_visitor_from_ticket']); ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Show captcha when visitor want to create ticket', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Captcha selection', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('captcha_selection', $captchaselection, jssupportticket::$_data[0]['captcha_selection']); ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Which captcha you want to add', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Google recaptcha public key', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('recaptcha_publickey', jssupportticket::$_data[0]['recaptcha_publickey'], array('class' => 'inputbox')) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Please enter the google recaptcha public key from', 'js-support-ticket') . ' https://www.google.com/recaptcha/admin '; ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Google recaptcha private key', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('recaptcha_privatekey', jssupportticket::$_data[0]['recaptcha_privatekey'], array('class' => 'inputbox')) ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Please enter the google recaptcha private key from', 'js-support-ticket') . ' https://www.google.com/recaptcha/admin '; ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Own captcha calculation type', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('owncaptcha_calculationtype', $owncaptchatype, jssupportticket::$_data[0]['owncaptcha_calculationtype']); ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Select calculation type addition or subtraction', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Own captcha operands', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('owncaptcha_totaloperand', $owncaptchaoparend, jssupportticket::$_data[0]['owncaptcha_totaloperand']); ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Select the total operands to be given', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Own captcha subtraction answer positive', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('owncaptcha_subtractionans', $yesno, jssupportticket::$_data[0]['owncaptcha_subtractionans']); ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Is subtraction answer should be positive', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('New ticket message', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo wp_editor(jssupportticket::$_data[0]['new_ticket_message'], 'new_ticket_message'); ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('This message will show on new ticket', 'js-support-ticket'); ?></small></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Allow Users To Reply via Email On Closed Ticket', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::select('reply_to_closed_ticket', $yesno, jssupportticket::$_data[0]['reply_to_closed_ticket']); ?></div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Select whether users can reply to closed ticket via email or not','js-support-ticket'); ?></small></div>
                            </div>
                        </table>
                    </div>
                    <div id="defaultemail">
                        <h3 class="js-ticket-configuration-heading-main"> <?php echo __('Default system emails', 'js-support-ticket') ?></h3>

                        <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                            <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Default alert email', 'js-support-ticket') ?></div>
                            <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-value"><?php echo JSSTformfield::select('default_alert_email', jssupportticket::$_data[1], jssupportticket::$_data[0]['default_alert_email']); ?></div>
                            <div class="js-col-xs-12 js-col-md-4"><small><?php echo __('If ticket department email is not selected then this email is used to send emails', 'js-support-ticket'); ?></small></div>
                        </div>
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                            <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Default admin email', 'js-support-ticket') ?></div>
                            <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-value"><?php echo JSSTformfield::select('default_admin_email', jssupportticket::$_data[1], jssupportticket::$_data[0]['default_admin_email']); ?></div>
                            <div class="js-col-xs-12 js-col-md-4"><small><?php echo __('Admin email address to receive emails', 'js-support-ticket'); ?></small></div>
                        </div>
                    </div>
                    <div id="mailsetting">
                        <h3 class="js-ticket-configuration-heading-main"><?php echo __('Ban email new ticket', 'js-support-ticket') ?></h3>

                        <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                            <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Mail to admin', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                            <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-value"><?php echo JSSTformfield::select('banemail_mail_to_admin', $enableddisabled, jssupportticket::$_data[0]['banemail_mail_to_admin']); ?></div>
                            <div class="js-col-xs-12 js-col-md-4"><small><?php echo __('Email send to admin when banned email try to create ticket', 'js-support-ticket'); ?></small></div>
                        </div>

                        <table id="js-support-ticket-table">
                            <h3 class="js-ticket-configuration-heading-main"><?php echo __('Ticket Operations Mail Setting', 'js-support-ticket') ?></h3>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row js-ticket-config-xs-hide">
                                <div class="js-col-xs-12 js-col-md-3"></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-conf-text-sub"><?php echo __('Admin', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-conf-text-sub"><?php echo __('Staff', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-conf-text-sub"><?php echo __('User', 'js-support-ticket') ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('New ticket', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Admin', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('new_ticket_mail_to_admin', $enableddisabled, jssupportticket::$_data[0]['new_ticket_mail_to_admin']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Staff', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('new_ticket_mail_to_staff_members', $enableddisabled, jssupportticket::$_data[0]['new_ticket_mail_to_staff_members']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('User', 'js-support-ticket') ?></span></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticket reassign', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Admin', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_reassign_admin', $enableddisabled, jssupportticket::$_data[0]['ticket_reassign_admin']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Staff', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_reassign_staff', $enableddisabled, jssupportticket::$_data[0]['ticket_reassign_staff']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('User', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_reassign_user', $enableddisabled, jssupportticket::$_data[0]['ticket_reassign_user']); ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticket close', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Admin', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_close_admin', $enableddisabled, jssupportticket::$_data[0]['ticket_close_admin']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Staff', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_close_staff', $enableddisabled, jssupportticket::$_data[0]['ticket_close_staff']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('User', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_close_user', $enableddisabled, jssupportticket::$_data[0]['ticket_close_user']); ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticket delete', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Admin', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_delete_admin', $enableddisabled, jssupportticket::$_data[0]['ticket_delete_admin']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Staff', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_delete_staff', $enableddisabled, jssupportticket::$_data[0]['ticket_delete_staff']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('User', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_delete_user', $enableddisabled, jssupportticket::$_data[0]['ticket_delete_user']); ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticket mark overdue', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Admin', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_mark_overdue_admin', $enableddisabled, jssupportticket::$_data[0]['ticket_mark_overdue_admin']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Staff', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_mark_overdue_staff', $enableddisabled, jssupportticket::$_data[0]['ticket_mark_overdue_staff']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('User', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_mark_overdue_user', $enableddisabled, jssupportticket::$_data[0]['ticket_mark_overdue_user']); ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticket ban email', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Admin', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_ban_email_admin', $enableddisabled, jssupportticket::$_data[0]['ticket_ban_email_admin']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Staff', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_ban_email_staff', $enableddisabled, jssupportticket::$_data[0]['ticket_ban_email_staff']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('User', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_ban_email_user', $enableddisabled, jssupportticket::$_data[0]['ticket_ban_email_user']); ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticket department transfer', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Admin', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_department_transfer_admin', $enableddisabled, jssupportticket::$_data[0]['ticket_department_transfer_admin']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Staff', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_department_transfer_staff', $enableddisabled, jssupportticket::$_data[0]['ticket_department_transfer_staff']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('User', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_department_transfer_user', $enableddisabled, jssupportticket::$_data[0]['ticket_department_transfer_user']); ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticket reply User', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Admin', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_reply_ticket_user_admin', $enableddisabled, jssupportticket::$_data[0]['ticket_reply_ticket_user_admin']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Staff', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_reply_ticket_user_staff', $enableddisabled, jssupportticket::$_data[0]['ticket_reply_ticket_user_staff']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('User', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_reply_ticket_user_user', $enableddisabled, jssupportticket::$_data[0]['ticket_reply_ticket_user_user']); ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticket Response Staff', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Admin', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_response_to_staff_admin', $enableddisabled, jssupportticket::$_data[0]['ticket_response_to_staff_admin']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Staff', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_response_to_staff_staff', $enableddisabled, jssupportticket::$_data[0]['ticket_response_to_staff_staff']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('User', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_response_to_staff_user', $enableddisabled, jssupportticket::$_data[0]['ticket_response_to_staff_user']); ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticket ban email and close ticket', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Admin', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticker_ban_eamil_and_close_ticktet_admin', $enableddisabled, jssupportticket::$_data[0]['ticker_ban_eamil_and_close_ticktet_admin']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Staff', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticker_ban_eamil_and_close_ticktet_staff', $enableddisabled, jssupportticket::$_data[0]['ticker_ban_eamil_and_close_ticktet_staff']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('User', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticker_ban_eamil_and_close_ticktet_user', $enableddisabled, jssupportticket::$_data[0]['ticker_ban_eamil_and_close_ticktet_user']); ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticket unban email', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Admin', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_lock_admin', $enableddisabled, jssupportticket::$_data[0]['ticket_lock_admin']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Staff', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('unban_email_staff', $enableddisabled, jssupportticket::$_data[0]['unban_email_staff']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('User', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_lock_user', $enableddisabled, jssupportticket::$_data[0]['ticket_lock_user']); ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticket lock', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Admin', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('unban_email_admin', $enableddisabled, jssupportticket::$_data[0]['unban_email_admin']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Staff', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_lock_staff', $enableddisabled, jssupportticket::$_data[0]['ticket_lock_staff']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('User', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('unban_email_user', $enableddisabled, jssupportticket::$_data[0]['unban_email_user']); ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticket unlock', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Admin', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_unlock_admin', $enableddisabled, jssupportticket::$_data[0]['ticket_unlock_admin']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Staff', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_unlock_staff', $enableddisabled, jssupportticket::$_data[0]['ticket_unlock_staff']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('User', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_unlock_user', $enableddisabled, jssupportticket::$_data[0]['ticket_unlock_user']); ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticket Change Priority', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Admin', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_priority_admin', $enableddisabled, jssupportticket::$_data[0]['ticket_priority_admin']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Staff', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_priority_staff', $enableddisabled, jssupportticket::$_data[0]['ticket_priority_staff']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('User', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_priority_user', $enableddisabled, jssupportticket::$_data[0]['ticket_priority_user']); ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Mark Ticket In Progress', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Admin', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_mark_progress_admin', $enableddisabled, jssupportticket::$_data[0]['ticket_mark_progress_admin']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Staff', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_mark_progress_staff', $enableddisabled, jssupportticket::$_data[0]['ticket_mark_progress_staff']); ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('User', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_mark_progress_user', $enableddisabled, jssupportticket::$_data[0]['ticket_mark_progress_user']); ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Reply To A Closed Ticket By Email', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Admin', 'js-support-ticket') ?></span>&nbsp;----&nbsp;</div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Staff', 'js-support-ticket') ?></span>&nbsp;----&nbsp;</div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('User', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_reply_closed_ticket_user', $enableddisabled, jssupportticket::$_data[0]['ticket_reply_closed_ticket_user']); ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Send Feedback Email To User', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Admin', 'js-support-ticket') ?></span>&nbsp;----&nbsp;</div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('Staff', 'js-support-ticket') ?></span>&nbsp;----&nbsp;</div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><span class="js-ticket-config-xs-show-hide"><?php echo __('User', 'js-support-ticket') ?></span><?php echo JSSTformfield::select('ticket_feedback_user', $enableddisabled, jssupportticket::$_data[0]['ticket_feedback_user']); ?></div>
                            </div>
                        </table>
                    </div>
                    <div id="staffmenusetting">
                        <h3 class="js-ticket-configuration-heading-main"><?php echo __('Control panel links', 'js-support-ticket') ?></h3>
                        <div class="js-ticket-configuration-table">
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Open Ticket', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_openticket_staff', $showhide, jssupportticket::$_data[0]['cplink_openticket_staff']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('My Tickets', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_myticket_staff', $showhide, jssupportticket::$_data[0]['cplink_myticket_staff']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Add Role', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_addrole_staff', $showhide, jssupportticket::$_data[0]['cplink_addrole_staff']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Roles', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_roles_staff', $showhide, jssupportticket::$_data[0]['cplink_roles_staff']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Add Staff', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_addstaff_staff', $showhide, jssupportticket::$_data[0]['cplink_addstaff_staff']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Staff', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_staff_staff', $showhide, jssupportticket::$_data[0]['cplink_staff_staff']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Add Department', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_adddepartment_staff', $showhide, jssupportticket::$_data[0]['cplink_adddepartment_staff']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Department', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_department_staff', $showhide, jssupportticket::$_data[0]['cplink_department_staff']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Add Category', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_addcategory_staff', $showhide, jssupportticket::$_data[0]['cplink_addcategory_staff']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Category', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_category_staff', $showhide, jssupportticket::$_data[0]['cplink_category_staff']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Add Knowledge Base', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_addkbarticle_staff', $showhide, jssupportticket::$_data[0]['cplink_addkbarticle_staff']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Knowledge Base', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_kbarticle_staff', $showhide, jssupportticket::$_data[0]['cplink_kbarticle_staff']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Add Download', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_adddownload_staff', $showhide, jssupportticket::$_data[0]['cplink_adddownload_staff']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Download', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_download_staff', $showhide, jssupportticket::$_data[0]['cplink_download_staff']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Add Announcement', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_addannouncement_staff', $showhide, jssupportticket::$_data[0]['cplink_addannouncement_staff']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Announcement', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_announcement_staff', $showhide, jssupportticket::$_data[0]['cplink_announcement_staff']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Add FAQ', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_addfaq_staff', $showhide, jssupportticket::$_data[0]['cplink_addfaq_staff']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __("FAQ's", 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_faq_staff', $showhide, jssupportticket::$_data[0]['cplink_faq_staff']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Mail', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_mail_staff', $showhide, jssupportticket::$_data[0]['cplink_mail_staff']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('My Profile', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_myprofile_staff', $showhide, jssupportticket::$_data[0]['cplink_myprofile_staff']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Staff reports', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_staff_report_staff', $showhide, jssupportticket::$_data[0]['cplink_staff_report_staff']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Department reports', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_department_report_staff', $showhide, jssupportticket::$_data[0]['cplink_department_report_staff']) ?></div>
                            </div>                    
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Login/Logout button', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_login_logout_staff', $showhide, jssupportticket::$_data[0]['cplink_login_logout_staff']) ?></div>
                            </div>
                        </div>
                        <h3 class="js-ticket-configuration-heading-main"><?php echo __('Staff Members Top Menu Links', 'js-support-ticket') ?></h3>
                        <div class="js-ticket-configuration-table">
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Home', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('tplink_home_staff', $showhide, jssupportticket::$_data[0]['tplink_home_staff']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Tickets', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('tplink_tickets_staff', $showhide, jssupportticket::$_data[0]['tplink_tickets_staff']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Knowledge Base', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('tplink_knowledgebase_staff', $showhide, jssupportticket::$_data[0]['tplink_knowledgebase_staff']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Announcements', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('tplink_announcements_staff', $showhide, jssupportticket::$_data[0]['tplink_announcements_staff']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Downloads', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('tplink_downloads_staff', $showhide, jssupportticket::$_data[0]['tplink_downloads_staff']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __("FAQ's", 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('tplink_faqs_staff', $showhide, jssupportticket::$_data[0]['tplink_faqs_staff']) ?></div>
                            </div>
                        </div>                        
                    </div>
                    <div id="usermenusetting">
                        <h3 class="js-ticket-configuration-heading-main"><?php echo __('Control panel links', 'js-support-ticket') ?></h3>
                        <div class="js-ticket-configuration-table">
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Open Ticket', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_openticket_user', $showhide, jssupportticket::$_data[0]['cplink_openticket_user']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('My Tickets', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_myticket_user', $showhide, jssupportticket::$_data[0]['cplink_myticket_user']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Check Ticket Status', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_checkticketstatus_user', $showhide, jssupportticket::$_data[0]['cplink_checkticketstatus_user']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Downloads', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_downloads_user', $showhide, jssupportticket::$_data[0]['cplink_downloads_user']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Announcements', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_announcements_user', $showhide, jssupportticket::$_data[0]['cplink_announcements_user']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __("FAQ's", 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_faqs_user', $showhide, jssupportticket::$_data[0]['cplink_faqs_user']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Knowledge Base', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_knowledgebase_user', $showhide, jssupportticket::$_data[0]['cplink_knowledgebase_user']) ?></div>    
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Login/Logout Button', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_login_logout_user', $showhide, jssupportticket::$_data[0]['cplink_login_logout_user']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Registration', 'js-support-ticket') ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('cplink_register_user', $showhide, jssupportticket::$_data[0]['cplink_register_user']) ?></div>    
                            </div>
                        </div>
                        <h3 class="js-ticket-configuration-heading-main"><?php echo __('Top menu links', 'js-support-ticket') ?></h3>
                        <div class="js-ticket-configuration-table">
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Home', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('tplink_home_user', $showhide, jssupportticket::$_data[0]['tplink_home_user']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Tickets', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('tplink_tickets_user', $showhide, jssupportticket::$_data[0]['tplink_tickets_user']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Knowledge Base', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('tplink_knowledgebase_user', $showhide, jssupportticket::$_data[0]['tplink_knowledgebase_user']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Announcements', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('tplink_announcements_user', $showhide, jssupportticket::$_data[0]['tplink_announcements_user']) ?></div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Downloads', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('tplink_downloads_user', $showhide, jssupportticket::$_data[0]['tplink_downloads_user']) ?></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __("FAQ's", 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                                <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-value"><?php echo JSSTformfield::select('tplink_faqs_user', $showhide, jssupportticket::$_data[0]['tplink_faqs_user']) ?></div>
                            </div>
                        </div>                        
                    </div>
                    <div id="feedback">
                        <h3 class="js-ticket-configuration-heading-main"> <?php echo __('Feedback Settings', 'js-support-ticket') ?></h3>

                        <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                            <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Feedback Email Delay Type', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                            <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-value"><?php echo JSSTformfield::select('feedback_email_delay_type',  array((object) array('id' => '1', 'text' => __('Days', 'js-support-ticket')), (object) array('id' => '2', 'text' => __('Hours', 'js-support-ticket'))), jssupportticket::$_data[0]['feedback_email_delay_type']); ?></div>
                            <div class="js-col-xs-12 js-col-md-4"><small><?php echo __('Select delay type for feedback email', 'js-support-ticket'); ?></small></div>
                        </div>
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                            <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Feedback Email Delay', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                            <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('feedback_email_delay', jssupportticket::$_data[0]['feedback_email_delay'], array('class' => 'inputbox')) ?></div>
                            <div class="js-col-xs-12 js-col-md-4"><small><?php echo __('Set no. of days or hours to send feedback email after ticket is closed', 'js-support-ticket'); ?></small></div>
                        </div>
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                            <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Feedback Successful message to customer', 'js-support-ticket') ?><font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font></div>
                            <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo wp_editor(jssupportticket::$_data[0]['feedback_thanks_message'], 'feedback_thanks_message'); ?></div>
                            <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('This text will appear whenever anyone submits feedback', 'js-support-ticket'); ?></small></div>
                        </div>
                    </div>

                    <div id="pushnotification">
                        <h3 class="js-ticket-configuration-heading-main"> <?php echo __('Firebase Notifications', 'js-support-ticket') ?></h3>                        
                        <?php 
                        if(!file_exists(WP_PLUGIN_DIR.'/js-ticket-desktop-notification/js-ticket-desktop-notification.php')){ ?>
                            <div class="jsst_error_messages" style="color: #000; margin-bottom: 15px;">
                                <span style="color: #000;" class="jsst_msg" id="jsst_error_message"><?php echo __("JS Support Ticket Desktop Notificaitons plugin is not installed. Please install the plugin to enable desktop notifications","js-support-ticket");?><a href="<?php echo admin_url("admin.php?page=premiumplugin"); ?>"><?php echo __("Click here to insert Install.","js-ticket-desktop-notification"); ?></a></span>
                            </div>    
                        <?php
                        }elseif(!class_exists('jsticketdesktopnotification')){ ?>
                            <div class="jsst_error_messages" style="color: #000; margin-bottom: 15px;">
                                <span style="color: #000;" class="jsst_msg" id="jsst_success_message"><?php echo __("JS Support Ticket Desktop Notificaitons plugin is Not active.","js-support-ticket");?></span>
                            </div> 
                            <?php
                        }?>
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                            <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Api key for user', 'js-support-ticket') ?></div>
                            <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('apiKey_firebase', jssupportticket::$_data[0]['apiKey_firebase'], array('class' => 'inputbox')) ?></div>
                            <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Firsebase api key for front user', 'js-support-ticket'); ?></small></div>
                        </div>
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                            <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Auth Domain', 'js-support-ticket') ?></div>
                            <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('authDomain_firebase', jssupportticket::$_data[0]['authDomain_firebase'], array('class' => 'inputbox')) ?></div>
                            <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Firsebase Auth Domain', 'js-support-ticket'); ?></small></div>
                        </div>
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                            <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Database Url', 'js-support-ticket') ?></div>
                            <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('databaseURL_firebase', jssupportticket::$_data[0]['databaseURL_firebase'], array('class' => 'inputbox')) ?></div>
                            <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Firsebase Database URL', 'js-support-ticket'); ?></small></div>
                        </div>
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                            <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Project Id', 'js-support-ticket') ?></div>
                            <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('projectId_firebase', jssupportticket::$_data[0]['projectId_firebase'], array('class' => 'inputbox')) ?></div>
                            <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Firsebase Project Id', 'js-support-ticket'); ?></small></div>
                        </div>
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                            <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Bucket Storage', 'js-support-ticket') ?></div>
                            <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('storageBucket_firebase', jssupportticket::$_data[0]['storageBucket_firebase'], array('class' => 'inputbox')) ?></div>
                            <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Firsebase Bucket Storage', 'js-support-ticket'); ?></small></div>
                        </div>
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                            <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Message Sender Id', 'js-support-ticket') ?></div>
                            <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('messagingSenderId_firebase', jssupportticket::$_data[0]['messagingSenderId_firebase'], array('class' => 'inputbox')) ?></div>
                            <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Firsebase Message Sender Id', 'js-support-ticket'); ?></small></div>
                        </div>
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                            <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Private Server Key', 'js-support-ticket') ?></div>
                            <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><?php echo JSSTformfield::text('server_key_firebase', jssupportticket::$_data[0]['server_key_firebase'], array('class' => 'inputbox')) ?></div>
                            <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><small><?php echo __('Firsebase Server Key', 'js-support-ticket'); ?></small></div>
                        </div>
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
                            <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Logo Image for Desktop Notificaitons', 'js-support-ticket') ?></div>
                            <div class="js-col-xs-12 js-col-md-5 js-ticket-configuration-value"><input type="file" name="logo_for_desktop_notfication" id="logo_for_desktop_notfication"></div>
                            <?php if(jssupportticket::$_config['logo_for_desktop_notfication_url'] != ''){ 
                                $maindir = wp_upload_dir();
                                $path = $maindir['baseurl'].'/'.jssupportticket::$_config['data_directory'].'/attachmentdata';
                                ?>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-description"><img height="60px" width="60px;" src="<?php echo $path.'/'.jssupportticket::$_config['logo_for_desktop_notfication_url']; ?>"/> <label><input type="checkbox" name="del_logo_for_desktop_notfication" value="1"><?php echo __('Remove Image','js-support-ticket')?></label> </div>
                            <?php } ?>

                        </div>
                    </div>

                </div>
            </div>
            <?php echo JSSTformfield::hidden('action', 'configuration_saveconfiguration'); ?>
            <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
            <div class="js-form-button">
                <?php echo JSSTformfield::submitbutton('save', __('Save Configurations', 'js-support-ticket'), array('class' => 'button')); ?>
            </div>
            <div class="js-form-button">
                <?php echo '<font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font>' . __('Pro version only', 'js-support-ticket'); ?>
            </div>
        </form>
    </div>
</div>
