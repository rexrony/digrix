<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTreplyModel {

    function getReplies($id) {
        if (!is_numeric($id))
            return false;
        // Data
        $query = "SELECT replies.*,replies.id AS replyid,tickets.id
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_replies` AS replies 
					JOIN `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS tickets ON  replies.ticketid = tickets.id 
					WHERE tickets.id = " . $id . " ORDER BY replies.id ASC ";
        jssupportticket::$_data[4] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        $attachmentmodel = JSSTincluder::getJSModel('attachment');
        foreach (jssupportticket::$_data[4] AS $reply) {
            $reply->attachments = $attachmentmodel->getAttachmentForReply($reply->id, $reply->replyid);
        }
        return;
    }

    function getTicketNameForReplies() {
        $query = "SELECT id, ticketid AS text FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets`";
        $list = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $list;
    }

    function getRepliesForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = "SELECT replies.*,tickets.id 
						FROM `" . jssupportticket::$_db->prefix . "js_ticket_replies` AS replies 
						JOIN `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS tickets ON  replies.ticketid = tickets.id 
						WHERE replies.id = " . $id;
            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        return;
    }
    function getAttachmentByReplyId($id){
        if(!is_numeric($id)) return false;
        $query = "SELECT attachment.filename , ticket.attachmentdir 
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_attachments` AS attachment
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket ON ticket.id = attachment.ticketid AND attachment.replyattachmentid = ".$id ;
        $replyattachments = jssupportticket::$_db->get_results($query);
        return $replyattachments;
    }

    function storeReplies($data) {

        //validate reply for break down
        $ticketid   = $data['ticketrandomid'];
        $hash       = $data['hash'];
        $query = "SELECT id FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE ticketid='$ticketid' AND hash='$hash'";
        $id = jssupportticket::$_db->get_var($query);
        if($id != $data['ticketid']){
            return;
        }//end

        $sendEmail = true;
        if (is_user_logged_in()) {
            $current_user = get_userdata(get_current_user_id());
            $currentUserName = $current_user->display_name;
        } else {
            $currentUserName = '';
        }
        $data['id'] = isset($data['id']) ? $data['id'] : '';
        $data['status'] = isset($data['status']) ? $data['status'] : '';
        $data['closeonreply'] = isset($data['closeonreply']) ? $data['closeonreply'] : '';

        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        $data['message'] = wpautop(wptexturize(stripslashes($_POST['jsticket_message'])));
        //check signature
        if (!isset($data['nonesignature'])) {
            if (isset($data['departmentsignature']) && $data['departmentsignature'] == 1) {
                $data['message'] .= '<br/>' . JSSTincluder::getJSModel('department')->getSignatureByID($data['departmentid']);
            }
        }

        $query_array = array('id' => $data['id'],
            'uid' => $data['uid'],
            'ticketid' => $data['ticketid'],
            'name' => $currentUserName,
            'message' => $data['message'],
            'status' => $data['status'],
            'created' => date_i18n('Y-m-d H:i:s')
        );
        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_replies', $query_array);
        $replyid = jssupportticket::$_db->insert_id;
        if (jssupportticket::$_db->last_error == null) {
            //tickets attachments store
            $data['replyattachmentid'] = jssupportticket::$_db->insert_id;
            JSSTincluder::getJSModel('attachment')->storeAttachments($data);
            //reply stored change action		
            if (is_admin())
                JSSTincluder::getJSModel('ticket')->setStatus(3, $data['ticketid']); // 3 -> waiting for customer reply
            else {
                JSSTincluder::getJSModel('ticket')->setStatus(1, $data['ticketid']); // 1 -> waiting for admin/staff reply
            }
            JSSTincluder::getJSModel('ticket')->updateLastReply($data['ticketid']);
            JSSTmessage::setMessage(__('Reply posted', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');

            // Reply notification
			if(1 ==  2){
				$ticketuid = JSSTincluder::getJSModel('ticket')->getUIdById($query_array['ticketid']);

				// to admin
				$dataarray = array();
				$dataarray['title'] = __("Reply posted on ticket","js-support-ticket");
				$dataarray['body'] =  JSSTincluder::getJSModel('ticket')->getTicketSubjectById($query_array['ticketid']);

				// To admin
				$devicetoken = JSSTincluder::getJSModel('notification')->checkSubscriptionForAdmin();
				if($devicetoken){
					$dataarray['link'] = admin_url("admin.php?page=ticket&task=ticketdetail&jssupportticketid=".$data['ticketid']);
					$dataarray['devicetoken'] = $devicetoken;
					$value = jssupportticket::$_config[md5(JSTN)];
					if($value != ''){
					  do_action('send_push_notification',$dataarray);
					}else{
					  do_action('resetnotificationvalues');
					}
				}

				$dataarray['link'] = jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'ticketdetail', "jssupportticketid"=>$data['ticketid'],'jsstpageid'=>jssupportticket::getPageid()));
				if($ticketuid != 0 && ($ticketuid != get_current_user_id())){
					$devicetoken = JSSTincluder::getJSModel('notification')->getUserDeviceToken($ticketuid);
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
				if($ticketuid == 0){ // for visitor
					$tokenarray['emailaddress'] = JSSTincluder::getJSModel('ticket')->getTicketEmailById($query_array['ticketid']);
					$tokenarray['trackingid'] = JSSTincluder::getJSModel('ticket')->getTrackingIdById($query_array['ticketid']);
					$token = json_encode($tokenarray);
					include_once jssupportticket::$_path . 'includes/encoder.php';
					$encoder = new JSSTEncoder();
					$encryptedtext = $encoder->encrypt($token);
					$dataarray['link'] = jssupportticket::makeUrl(array('jstmod'=>'ticket' ,'task'=>'showticketstatus','action'=>'jstask','token'=>$encryptedtext,'jsstpageid'=>jssupportticket::getPageid()));
					$dataarray['title'] = __("visitor","js-support-ticket");
					$notificationid = JSSTincluder::getJSModel('ticket')->getNotificationIdById($query_array['ticketid']);
					$devicetoken = JSSTincluder::getJSModel('notification')->getUserDeviceToken($notificationid,0);
					if($devicetoken != '' && !empty($devicetoken)){
						$value = jssupportticket::$_config[md5(JSTN)];
						if($value != ''){
						  do_action('send_push_notification',$dataarray);
						}else{
						  do_action('resetnotificationvalues');
						}
					}
				}
				// End notification
			}
            
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Reply has not been posted', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }

        $ticketid = $data['ticketid']; // get the ticket id
        // Send Emails
        if ($sendEmail == true) {
            if (is_admin()) {
                JSSTincluder::getJSModel('email')->sendMail(1, 4, $ticketid); // Mailfor, Reply Ticket
            } else {
                JSSTincluder::getJSModel('email')->sendMail(1, 5, $ticketid); // Mailfor, Reply Ticket
            }
            $ticketreplyobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_replies` WHERE id = " . $replyid);
            do_action('jsst-ticketreply', $ticketreplyobject);
        }
        // if Close on reply is cheked
        if ($data['closeonreply'] == 1) {
            JSSTincluder::getJSModel('ticket')->closeTicket($ticketid);
        }

        return;
    }

    function getLastReply($ticketid) {
        if (!is_numeric($ticketid))
            return false;
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_replies` WHERE ticketid =  " . $ticketid . " ORDER BY created desc";
        $lastreply = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
        }
        return $lastreply;
    }

    function removeTicketReplies($ticketid) {
        if (!is_numeric($ticketid))
            return false;
        jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_replies', array('ticketid' => $ticketid));
        return;
    }

}

?>
