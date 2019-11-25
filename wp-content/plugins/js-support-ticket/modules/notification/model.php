<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTnotificationModel {

  function subscribeForNotifications(){
    try{
      $token = JSSTrequest::getVar('token');
      $endpoint = base64_encode(JSSTrequest::getVar('endpoint'));
      
      //check if already subscribed
      $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_notification_data` WHERE `deviceid` = '$token'";
      $num = jssupportticket::$_db->get_var($query);
      if($num > 0){
        throw new Exception("Already Subscribed");
      }
      //prepare data
      $data = array();
      $data['deviceid'] = $token;
      $data['endpoint'] = $endpoint;
      $data['os'] = "web";
      $data['status'] = 1;
      $data['created'] = date_i18n('Y-m-d H:i:s');
      $data['uid'] = get_current_user_id();
      // For checking if already token store against user
      if($data['uid'] > 0){
        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_notification_data` WHERE `uid` =" . $data['uid'];
        $num = jssupportticket::$_db->get_var($query);
        if($num > 0){
          $query = "DELETE FROM `" . jssupportticket::$_db->prefix . "js_ticket_notification_data` WHERE `uid` =" . $data['uid'];
          jssupportticket::$_db->query($query);
        }
      }

      if(is_admin()){
        $data['role'] = 'admin';
      }else{
        $data['role'] = 'user';  
      }

      $data['id'] = '';
      do_action('ticket_notify_preferences',$data);
      $ticket_logo = plugin_dir_url( __DIR__ ) . '/js-ticket-desktop-notification/includes/images/notification_image.png';

      //$ticket_logo = plugin_dir_url( __DIR__ ) . '/js-ticket-desktop-notification/includes/images/notification_image.png';

      $file_name = JSSTincluder::getJSModel('configuration')->getConfigValue('logo_for_desktop_notfication_url');
      if($file_name != ''){
          $maindir = wp_upload_dir();
          $ticket_logo = $maindir['baseurl'].'/'.jssupportticket::$_config['data_directory'].'/attachmentdata/'.$file_name;
          $ticket_logo = str_replace('http://', 'https://', $ticket_logo);
      }else{
          $ticket_logo = plugin_dir_url( __DIR__ ) . '/js-ticket-desktop-notification/includes/images/notification_image.png';
      } 
      

      $notification = array(
        'title' => __("JS Support Ticket",'js-support-ticket'),
        'body'  => __("Thanks for subscribing",'js-support-ticket'),
        'icon'  => $ticket_logo,
      );
      $code = 'SUCCESS';
    }catch(Exception $ex){
      $code = 'ERROR';
    }
    echo json_encode(compact('code','notification'));
    exit();
  }

  function unsubscribeFromNotifications(){
    $token = JSSTincluder::getVar('token');
    $query = "DELETE FROM `" . jssupportticket::$_db->prefix . "js_ticket_notification_data` WHERE `deviceid` = '$token' LIMIT 1";
    jssupportticket::$_db->query($query);
    exit();
  }

  function checkSubscriptionForAdmin(){
    $query = "SELECT deviceid FROM `" . jssupportticket::$_db->prefix . "js_ticket_notification_data` WHERE role = 'admin'";
    $devicetoken = jssupportticket::$_db->get_var($query);
    if($devicetoken == ""){
      return false;
    }else{
      return $devicetoken;
    }
  }

  function getUserDeviceToken($id,$isuid=1){ // $isuid == 1;than check = uid
    if(!is_numeric($id))
        return false;
    if($isuid == 1){
        $check = "uid =" .$id;
    }else{
        $check = " id =" . $id;
    }
    $query = "SELECT deviceid FROM `" . jssupportticket::$_db->prefix . "js_ticket_notification_data` WHERE ".$check."";
    $devicetoken = jssupportticket::$_db->get_var($query);
    return $devicetoken;
  }

  function sendNotificationToDepartment($id,$dataarray){
    if(!is_numeric($id))
      return $id;
    
    $staffmembers = JSSTincluder::getJSModel('staff')->getAllStaffMemberByDepId($id);
    if(is_array($staffmembers) && !empty($staffmembers)){
      foreach ($staffmembers AS $staff) {
        if($staff->canemail == 1){
          $devicetoken = $this->getUserDeviceToken($staff->staffuid);
          $dataarray['devicetoken'] = $devicetoken;
          if($devicetoken != '' && !empty($devicetoken)){
            $value = jssupportticket::$_config[md5(JSTN)];
            if($value != ''){
              do_action('send_push_notification',$dataarray);
            }else{
              do_action('resetnotificationvalues');
            }
          }
        }
      }
    }
  }

  function sendNotificationToAllStaff($dataarray){
    $staffmembers = JSSTincluder::getJSModel('staff')->getAllStaffMemberByAllTicketPermission();
    if(is_array($staffmembers) && !empty($staffmembers)){
      foreach ($staffmembers AS $staff) {
        if($staff->canemail == 1){
          $devicetoken = $this->getUserDeviceToken($staff->staffuid);
          $dataarray['devicetoken'] = $devicetoken;
          if($devicetoken != '' && !empty($devicetoken)){
            $value = jssupportticket::$_config[md5(JSTN)];
            if($value != ''){
              do_action('send_push_notification',$dataarray);
            }else{
              do_action('resetnotificationvalues');
            }
          }    
        }
      }
    } 
  }

  function updateUserDevice(){
    $uid = get_current_user_id();
    if(is_admin()){
      $role = 'admin';
    }else if(JSSTincluder::getJSModel('staff')->isUserStaff()){
      $role = 'staff';
    }else{
      $role = 'user';  
    }
    if($uid != 0){
      $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_notification_data` WHERE `uid` =" . $uid;
      $num = jssupportticket::$_db->get_var($query);
      if($num > 0){
        $query = "DELETE FROM `" . jssupportticket::$_db->prefix . "js_ticket_notification_data` WHERE `uid` =" . $uid;
        jssupportticket::$_db->query($query);
      }
    }
    if($uid != 0){
      $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_notification_data` set uid=".$uid.", role = '".$role."' WHERE id = ". $_SESSION['js-support-ticket']['notificationid'];
      jssupportticket::$_db->query($query);
      if(jssupportticket::$_db->last_error == null){
        unset($_SESSION['js-support-ticket']['notificationid']);
        return 1;
      }
    }
  }

}

?>
