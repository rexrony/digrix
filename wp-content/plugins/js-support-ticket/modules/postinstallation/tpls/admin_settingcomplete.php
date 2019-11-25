<?php
if (!defined('ABSPATH')) die('Restricted Access'); ?>
<div id="js-tk-admin-wrapper">
    <div id="js-tk-cparea">
        <div id="jsst-main-wrapper" class="post-installation">
            <div class="js-admin-title-installtion">
                <span class="jsst_heading"><?php echo __('JS Support Ticket Settings','js-support-ticket'); ?></span>
                <div class="close-button-bottom">
                    <a href="?page=jssupportticket" class="close-button">
                        <img src="<?php echo jssupportticket::$_pluginpath.'includes/images/postinstallation/close-icon.png';?>" />
                    </a>
                </div>
            </div>
            <div class="post-installtion-content-wrapper">
                <div class="post-installtion-content-header">
                    <ul class="update-header-img step-1">
                        <li class="header-parts first-part">
                            <a href="<?php echo admin_url("admin.php?page=postinstallation&jstlay=stepone"); ?>" title="link" class="tab_icon">
                                <img class="start" src="<?php echo jssupportticket::$_pluginpath.'includes/images/postinstallation/general-settings.png';?>" />
                                <span class="text"><?php echo __('General','js-support-ticket'); ?></span>
                            </a>
                        </li>
                        <li class="header-parts second-part">
                            <a href="<?php echo admin_url("admin.php?page=postinstallation&jstlay=steptwo"); ?>" title="link" class="tab_icon">
                                <img class="start" src="<?php echo jssupportticket::$_pluginpath.'includes/images/postinstallation/ticket.png';?>" />
                                <span class="text"><?php echo __('Ticket Settings','js-support-ticket'); ?></span>
                            </a>
                        </li>
                        <li class="header-parts third-part">
                           <a href="<?php echo admin_url("admin.php?page=postinstallation&jstlay=stepthree"); ?>" title="link" class="tab_icon">
                               <img class="start" src="<?php echo jssupportticket::$_pluginpath.'includes/images/postinstallation/feedback.png';?>" />
                                <span class="text"><?php echo __('Feedback Settings','js-support-ticket'); ?></span>
                            </a>
                        </li>
                        <li class="header-parts forth-part active">
                            <a href="<?php echo admin_url("admin.php?page=postinstallation&jstlay=settingcomplete"); ?>" title="link" class="tab_icon">
                               <img class="start" src="<?php echo jssupportticket::$_pluginpath.'includes/images/postinstallation/complete.png';?>" />
                                <span class="text"><?php echo __('Complete','js-support-ticket'); ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="post-installtion-content_wrapper_right">
                    <div class="jsst-config-topheading">
                        <span class="heading-post-ins jsst-configurations-heading"><?php echo __('Configurations complete','js-support-ticket');?></span>
                        <span class="heading-post-ins jsst-config-steps"><?php echo __('Step 4 of 4','js-support-ticket');?></span>
                    </div>
                    <div class="post-installtion-content">
                        <form id="jslearnmanager-form-ins" method="post" action="#">
                            <div class="jsst_setting_complete_heading"><h1 class="Jsst_heading"><?php echo __('Setting Completed','js-support-ticket'); ?></h1></div>
                            <div class="jsst_img_wrp">
                                <img  src="<?php echo jssupportticket::$_pluginpath.'includes/images/postinstallation/complete-setting.png';?>" alt="Seting Log" title="Setting Logo"> 
                            </div>
                            <div class="jsst_text_below_img">
                                <?php echo __('Setting you have applied has been save successfully','js-support-ticket');?>
                            </div>
                            <div class="pic-button-part">
                                <a class="next-step finish full-width" href="?page=jssupportticket">
                                    <?php echo __('Finish','js-support-ticket'); ?>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
