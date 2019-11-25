    <div id="jsstadmin-wrapper">
        <div id="jsstadmin-leftmenu">
            <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
        </div>
    <div id="jsstadmin-data">   
        <span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Premium Plugin', 'js-support-ticket'); ?></span></span>

        <div id="jssupportticket-content">
            <div id="black_wrapper_translation"></div>
            <div id="jstran_loading">
                <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/spinning-wheel.gif" />
            </div>
            <div id="jsst-lower-wrapper">
                <div class="jsst_notification_installer_wrapper" id="jsst-installer_id">    
                    <div class="jsst_notification_wrp_bg">
                        <div class="jsst_notification_wrp_trans_bg">
                            <div class="jsst-notification-top">
                                <div class="jsst-notification-text"><?php echo __("JS Ticket Notification","js-support-ticket"); ?></div>
                                <div class="jsst-notification-sub-text"><?php echo __("JS Ticket Notification handling notification for js support ticket","js-support-ticket"); ?></div>
                            </div>
                            <div class="jsst-notification-lower">
                                <div class="jsst-notification-plugin-for">
                                    <div class="jsst-notification-text"><?php echo __("Notification plugin for js support ticket","js-support-ticket"); ?></div>
                                </div>
                                <?php 
                                if(class_exists('jsticketdesktopnotification')){ ?>
                                    <div class="jsst_success_messages">
                                        <span class="jsst_msg" id="jsst_success_message"><?php echo __("JS Support Ticket Desktop Notificaitons plugin is active.","js-support-ticket");?><a href="<?php echo admin_url("admin.php?page=configuration#pushnotification"); ?>"><?php echo __("Click here to insert firebase values.","js-ticket-desktop-notification"); ?></a></span>
                                    </div> 
                                    <?php
                                }elseif(file_exists(WP_PLUGIN_DIR.'/js-ticket-desktop-notification/js-ticket-desktop-notification.php')){ ?>
                                    <div class="jsst_error_messages">
                                        <span class="jsst_msg" id="jsst_error_message"><?php echo __("JS Support Ticket Desktop Notificaitons plugin is not active. Please activate the plugin enable desktop notifications","js-support-ticket");?></span>
                                    </div>    
                                <?php
                                }else{ ?>
                                    <form id="jsticketfrom" action="<?php echo admin_url('admin.php?page=notification&task=verifyactivationkey&action=jstask'); ?>" method="post">
                                        <div class="jsst_middle" id="jsst_middle">
                                            <div class="jsst_form_field_wrp">
                                                <input type="text" name="transactionkey" id="transactionkey" class="jsst_key_field" value="<?php echo isset(jssupportticket::$_data['transactionkey']) ? jssupportticket::$_data['transactionkey'] : '';?>" placeholder="<?php echo __('Activation key','js-support-ticket'); ?>"/>
                                            </div>
                                        </div>
                                        <?php if(!isset($_SESSION['js_ticket_activation_response'])){ ?>
                                            <div class="jsst_bottom">
                                                <div class="jsst_submit_btn">
                                                    <button type="submit" class="jsst_btn" role="submit" onclick="jsShowLoading();"><?php echo __("Start","js-support-ticket"); ?></button>
                                                </div>
                                            </div>
                                        <?php echo JSSTformfield::hidden('form_request', 'jssupportticket');
                                        }else if(isset($_SESSION['js_ticket_activation_response'])){
                                            //$response = base64_decode($_SESSION['js_ticket_activation_response']);
                                            $response = $_SESSION['js_ticket_activation_response'];
                                            unset($_SESSION['js_ticket_activation_response']); ?>
                                            <div class="jsst_error_messages_wrp">
                                                  <?php if($response[0] != 1){ ?>
                                                    <div class="jsst_error_messages">
                                                        <span class="jsst_msg" id="jsst_error_message"><?php echo $response[1]?></span>
                                                    </div>    
                                                    <?php  
                                                  }else if($response[0] == 1){ ?>
                                                    <div class="jsst_success_messages">
                                                        <span class="jsst_msg" id="jsst_success_message"><?php echo $response[1]?><a href="<?php echo admin_url("admin.php?page=configuration#pushnotification"); ?>"><?php echo __("Click here to insert firebase values.","js-ticket-desktop-notification"); ?></a></span>
                                                    </div>    
                                                  <?php } ?>
                                            </div>                 
                                        <?php  } ?>
                                        <input type="hidden" name="serialnumber" id="serialnumber" value="" />
                                        <input type="hidden" name="productcode" id="productcode" value="<?php echo isset(jssupportticket::$_data['productcode']) ? jssupportticket::$_data['productcode'] : 'jssupportticket'; ?>" />
                                        <input type="hidden" name="productversion" id="productversion" value="<?php echo isset(jssupportticket::$_data['versioncode']) ? jssupportticket::$_data['versioncode'] : '1.0.2'; ?>" />
                                        <input type="hidden" name="producttype" id="producttype" value="<?php echo isset(jssupportticket::$_data['producttype']) ? jssupportticket::$_data['producttype'] : 'free'; ?>" />
                                        <input type="hidden" name="domain" id="domain" value="<?php echo site_url(); ?>" />
                                        <input type="hidden" name="JVERSION" id="JVERSION" value="<?php echo get_bloginfo('version'); ?>" />
                                        <input type="hidden" name="installerversion" value="1.0" />            
                                    </form>
                                    <div class="jsst_error_messages">
                                        <span class="jsst_msg" id="jsst_error_message"><?php echo __("Do Not Have Activation key","js-support-ticket");?>!!<a href="http://192.168.10.17/joomsky/index.php/products/js-support-ticket-pro-wp.html"><?php echo __("Click here to get activation key.","js-ticket-desktop-notification"); ?></a></span>
                                    </div>  
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery('#jsticketfrom').on('submit', function() {
            jsShowLoading();        
        });
    });

    function jsShowLoading(){
        jQuery('div#black_wrapper_translation').show();
        jQuery('div#jstran_loading').show();
    }  
</script>