<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTPostinstallationModel {

    function updateInstallationStatusConfiguration(){
            $flag = get_option('jssupport_post_installation');
            if($flag == false){
                add_option( 'jssupport_post_installation', '1', '', 'yes' );
            }else{
                update_option( 'jssupport_post_installation', '1');
            }
    }

	function storeConfigurations($data){
        if (empty($data))
            return false;
        $error = false;
        unset($data['action']);
        unset($data['form_request']);

        if(isset($data['js_menu_id'])){
            if($data['js_menu_id'] != 0){

                // get page if exists or create page
                $query = "SELECT ID FROM ".jssupportticket::$_db->prefix."posts WHERE post_content LIKE '%[jssupportticket]%'";
                $page_id = jssupportticket::$_db->get_var($query);
                if($page_id == ''){
                    $post = array(
                        'post_name' => 'js-support-ticket',
                        'post_title' => 'Support',
                        'post_status' => 'publish',
                        'post_content' => '[jssupportticket]',
                        'post_type' => 'page'
                    );
                    $page_id = wp_insert_post($post);
                } 
                
                // add page to menu
                $itemData =  array(
                    "menu-item-object-id" => $page_id,
                    "menu-item-parent-id" => 0,
                    "menu-item-object" => "page",
                    "menu-item-type"      => "post_type",
                    "menu-item-status"    => "publish"
                  );
                wp_update_nav_menu_item($data['js_menu_id'], 0, $itemData);// add link to selected menu
                unset($data['js_menu_id']);
            }

        }


        foreach ($data as $key => $value) {
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_config` SET `configvalue` = '" . $value . "' WHERE `configname`= '" . $key . "'";
            jssupportticket::$_db->query($query);
            if(jssupportticket::$_db->last_error == null){
                $status = 0;
            }else{
                $status = 1;
            }
        }
        if ($status == 0) {
            JSSTmessage::setMessage(__('Configuration','js-support-ticket').' '.__('has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Configuration','js-support-ticket').' '.__('has not been changed', 'js-support-ticket'), 'error');
        }
        return;
    }

    function getConfigurationValues() {
        $this->updateInstallationStatusConfiguration();
        $query = "SELECT configname,configvalue
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_config` ";//WHERE configfor != 'ticketviaemail'";
        $data = jssupportticket::$_db->get_results($query);
        
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        foreach ($data AS $config) {
            jssupportticket::$_data[0][$config->configname] = $config->configvalue;
        }
        return;
    }


    function getPageList() {
        $query = "SELECT ID AS id, post_title AS text FROM `" . jssupportticket::$_db->prefix . "posts` WHERE post_type = 'page' AND post_status = 'publish' ";
        $pages = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $pages;
    }

}?>