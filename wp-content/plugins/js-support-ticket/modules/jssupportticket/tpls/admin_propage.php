<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">	
    <span class="js-adminhead-title"> <a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a> <span class="jsheadtext"><?php echo __("Pro Features", 'js-support-ticket') ?></span>
        </span>
        <div class="js-admin-propage">
            <div class="js-col-md-7"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/pro_led.png"></div>
            <div class="js-col-md-5">
                <span class="js-pro-title"><?php echo __('JS Support Ticket Pro', 'js-support-ticket'); ?></span>
                <span class="js-pro-description"><?php echo __('Feature available in pro version only', 'js-support-ticket'); ?></span>
                <a target="_blank" href="<?php echo 'https://www.joomsky.com/index.php/products/js-support-ticket-1/js-supprot-ticket-pro-wp'; ?>" id="js-pro-link"></a>
            </div>
        </div>
        <span class="js-admin-title"><?php echo __('JS Support Ticket Pro Feature', 'js-support-ticket'); ?></span>
        <div class="js-row js-pro-feature-wrapper">
            <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/theme.png" class="js-theme"/>
                        <span class="js-pro-feature-title"><?php echo __('Themes','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('Unlimited color tools to get desire result','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/internalmail.png" class="js-internalmail"/>
                        <span class="js-pro-feature-title"><?php echo __('Internal Mail','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __("Internal mail system are used for communication within staffs and administrator",'js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/acl.png" class="js-acl"/>
                        <span class="js-pro-feature-title"><?php echo __('Access Control Level','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('Access control level can limit your staff to do specific task','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/premade_message.png" class="js-premade" />
                        <span class="js-pro-feature-title"><?php echo __('Premade Messages','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('Staff member can create premade message which is available in ticket reply','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/staff.png" class="js-staff"/>
                        <span class="js-pro-feature-title"><?php echo __('Staff Members','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('Staff member can be created and reply on your customer tickets','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/helptopic.png" class="js-helptopic"/>
                        <span class="js-pro-feature-title"><?php echo __('Help Topic','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('Help topic can be add with respect to departments','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/knowledgebase.png" class="js-knowledgebase"/>
                        <span class="js-pro-feature-title"><?php echo __('Knowledge Base','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('You can create and maintain knowledge Base for your ticket system','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/downloads.png" class="js-downloads"/>
                        <span class="js-pro-feature-title"><?php echo __('Downloads','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('You can add downloads for your customers','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/announcements.png" class="js-announcements"/>
                        <span class="js-pro-feature-title"><?php echo __('Announcements','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('Add announcements for your support system','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/faqs.png" class="js-faqs"/>
                        <span class="js-pro-feature-title"><?php echo __("FAQs",'js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __("You can Manage FAQs",'js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/banned_email.png" class="js-banned_email"/>
                        <span class="js-pro-feature-title"><?php echo __('Banned Emails','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('You can ban and unban any spam email address','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/overdue.png" class="js-overdue"/>
                        <span class="js-pro-feature-title"><?php echo __('Ticket Overdue','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('If and only if customer not reply after certain days than ticket marked as overdue','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/via_email.png" class="js-viaemail"/>
                        <span class="js-pro-feature-title"><?php echo __('Ticket Via Email','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('System will read your email and create tickets','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/visitorticketopen.png" class="js-visitorticketopen"/>
                        <span class="js-pro-feature-title"><?php echo __('Visitor Ticket Open','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('Visitor can also open ticket in your support system','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/lockticket.png" class="js-lockticket"/>
                        <span class="js-pro-feature-title"><?php echo __('Lock Ticket','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('You can now lock or unlock any ticket at any time','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/internalnote.png" class="js-internalnote"/>
                        <span class="js-pro-feature-title"><?php echo __('Internal Notes','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('Internal notes are ticket based for staff members and administrator','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/stafftransfer.png" class="js-stafftransfer"/>
                        <span class="js-pro-feature-title"><?php echo __('Assign to Staff','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('Ticket can be transferred to any other staff member','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/departmenttransfer.png" class="js-departmenttransfer"/>
                        <span class="js-pro-feature-title"><?php echo __('Department Transfer','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('Ticket can also be transferred to any other department','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/activity_log.png" class="js-activitylog"/>
                        <span class="js-pro-feature-title"><?php echo __('Activity Log','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('Ticket action history with time and user name','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/departmetn-report.png" class="js-activitylog"/>
                        <span class="js-pro-feature-title"><?php echo __('Department Reports','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('Department reports can be used to evaluate performance of different departments','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/export.png" class="js-activitylog"/>
                        <span class="js-pro-feature-title"><?php echo __('Export Tickets','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('Admin can export tickets in csv format to keep record','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/feedback.png" class="js-activitylog"/>
                        <span class="js-pro-feature-title"><?php echo __('Customer Feedback','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('Customer can provide feedback that can be used to improve services','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/report-staff.png" class="js-activitylog"/>
                        <span class="js-pro-feature-title"><?php echo __('Staff Reports','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('staff reports can be used to evaluate performance of different staff members','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/rtl.png" class="js-activitylog"/>
                        <span class="js-pro-feature-title"><?php echo __('RTL Supported','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('JS Support Ticket auto adjusts to RTL or LTR without any problem.','js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-md-6 js-col-xs-12 js-pro-feature">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/pro_page/stafftime.png" class="js-activitylog"/>
                        <span class="js-pro-feature-title"><?php echo __('Staff Time Tracking','js-support-ticket'); ?></span>
                        <span class="js-pro-feature-description"><?php echo __('Staff member can provide time and description while working on a ticket','js-support-ticket'); ?></span>
                    </div>
        </div>
    </div>
</div>
