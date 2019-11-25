<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTnotificationController {

    function canaddfile() {
        if (isset($_POST['form_request']) && $_POST['form_request'] == 'jssupportticket')
            return false;
        elseif (isset($_GET['action']) && $_GET['action'] == 'jstask')
            return false;
        else
            return true;
    }

    // function verifyactivationkey(){
    //     $data =  JSSTrequest::get('post');
    //     $response = apply_filters('verifyactivationkey',$data['activationkey']);
    //     $response = base64_encode($response);
    //     $_SESSION['js_ticket_activation_response'] = $response;
    //     $response = base64_decode($response);
    //     $response = json_decode($response);
    //     $url = admin_url("admin.php?page=ticket-notification-setting");
    //     wp_redirect($url);
    //     die();
    // }

    function verifyactivationkey(){
        /* pro installer code */
        $enable = true;
        $disabled = explode(', ', ini_get('disable_functions'));
        if ($disabled)
            if (in_array('set_time_limit', $disabled))
                $enable = false;

        if (!ini_get('safe_mode')) {
            if ($enable)
                set_time_limit(0);
        }
        $post_data['transactionkey'] = JSSTrequest::getVar('transactionkey');
        $post_data['serialnumber'] = JSSTrequest::getVar('serialnumber');
        $post_data['domain'] = JSSTrequest::getVar('domain');
        $post_data['producttype'] = JSSTrequest::getVar('producttype');
        $post_data['productcode'] = JSSTrequest::getVar('productcode');
        $post_data['productversion'] = JSSTrequest::getVar('productversion');
        $post_data['JVERSION'] = JSSTrequest::getVar('JVERSION');
        
        $post_data['installnew'] = JSSTrequest::getVar('installnew');
        $post_data['productversioninstall'] = JSSTrequest::getVar('productversioninstall');
        $post_data['count'] = JSSTrequest::getVar('count_config');
        $post_data['prmplg'] = 'ticketdsknotification';
        //echo '<pre>';print_r($post_data);echo '</pre>';

        $url = JCONSTINST;
        $response = wp_remote_post( $url, array('body' => $post_data,'timeout'=>7,'sslverify'=>false));
        // echo '<pre>';print_r($response);echo '</pre>';
        // echo '<pre>';var_dump($response['body']);echo '</pre>';
        // exit();
        if( !is_wp_error($response) && $response['response']['code'] == 200 && isset($response['body']) ){
            $result = $response['body'];
            $result = json_decode($result);
        }else{
            $result = false;
            if(!is_wp_error($response)){
               $error = $response['response']['message'];
           }else{
                $error = $response->get_error_message();
           }
        }

        if(is_array($result) && isset($result) && $result[0] == 1){
            eval($result[1]);
            $result[1] = __("JS Support Ticket Desktop Notificaitons plugin installed successfully.","js-support-ticket");
        }
    
        $_SESSION['js_ticket_activation_response'] = $result;
    
        $url = admin_url("admin.php?page=premiumplugin");
        wp_redirect($url);
        die();
    }
}

$JSSTnotificationController = new JSSTnotificationController();
?>
