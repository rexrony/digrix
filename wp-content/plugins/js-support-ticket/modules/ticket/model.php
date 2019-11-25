<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTticketModel {

    private $ticketid;

    function getTicketsForAdmin() {
        $this->getOrdering();
        // Filter
        $search_userfields = JSSTincluder::getObjectClass('customfields')->userFieldsForSearch(1);
        $subject = trim(JSSTrequest::getVar('subject'));
        $name = trim(JSSTrequest::getVar('name'));
        $email = trim(JSSTrequest::getVar('email'));
        $ticketid = trim(JSSTrequest::getVar('ticketid'));
        $datestart = trim(JSSTrequest::getVar('datestart'));
        $dateend = trim(JSSTrequest::getVar('dateend'));
        $priorityid = trim(JSSTrequest::getVar('priorityid'));
        $departmentid = trim(JSSTrequest::getVar('departmentid'));
        if (!empty($search_userfields)) {
            foreach ($search_userfields as $uf) {
                $value_array[$uf->field] = JSSTrequest::getVar($uf->field);
            }
        }
        $sortby = trim(JSSTrequest::getVar('sortby'));
        $inquery = '';
        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $list = (isset($_SESSION['JSST_list']) && $_SESSION['JSST_list'] != '') ? $_SESSION['JSST_list'] : 1;
        }else{
            $list = JSSTrequest::getVar('list', null, 1);    
            $_SESSION['JSST_list'] = $list;
        }
        switch ($list) {
            // Ticket Default Status
            // 0 -> New Ticket
            // 1 -> Waiting admin/staff reply
            // 3 -> waiting for customer reply
            // 4 -> close ticket
            case 1:$inquery .= " AND ticket.status != 4 ";
                break;
            case 2:$inquery .= " AND ticket.isanswered = 1 ";
                break;
            case 4:$inquery .= " AND ticket.status = 4 ";
                break;
            case 5://$inquery .= " AND ticket.uid =" . get_current_user_id();
                break;
        }

        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['subject'] = $subject;
            $_SESSION['JSST_SEARCH']['name'] = $name;
            $_SESSION['JSST_SEARCH']['email'] = $email;
            $_SESSION['JSST_SEARCH']['ticketid'] = $ticketid;
            $_SESSION['JSST_SEARCH']['departmentid'] = $departmentid;
            $_SESSION['JSST_SEARCH']['priorityid'] = $priorityid;
            $_SESSION['JSST_SEARCH']['datestart'] = $datestart;
            $_SESSION['JSST_SEARCH']['dateend'] = $dateend;
			$_SESSION['JSST_SEARCH']['sortby'] = $sortby;
            if (!empty($search_userfields)) {
                foreach ($search_userfields as $uf) {
                    if(isset($_SESSION['JSST_SEARCH'])){
                        $_SESSION['JSST_SEARCH'][$uf->field] = JSSTrequest::getVar($uf->field, 'post');
                    }
                }
            }
        }elseif(JSSTrequest::getVar('pagenum', 'get', null) == null){
            if(isset($_SESSION['JSST_SEARCH'])){
                foreach ($_SESSION['JSST_SEARCH'] as $key => $value) {
                    unset($_SESSION['JSST_SEARCH'][$key]);
                }
            }
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $subject = (isset($_SESSION['JSST_SEARCH']['subject']) && $_SESSION['JSST_SEARCH']['subject'] != '') ? $_SESSION['JSST_SEARCH']['subject'] : null;
            $name = (isset($_SESSION['JSST_SEARCH']['name']) && $_SESSION['JSST_SEARCH']['name'] != '') ? $_SESSION['JSST_SEARCH']['name'] : null;
            $email = (isset($_SESSION['JSST_SEARCH']['email']) && $_SESSION['JSST_SEARCH']['email'] != '') ? $_SESSION['JSST_SEARCH']['email'] : null;
            $ticketid = (isset($_SESSION['JSST_SEARCH']['ticketid']) && $_SESSION['JSST_SEARCH']['ticketid'] != '') ? $_SESSION['JSST_SEARCH']['ticketid'] : null;
            $departmentid = (isset($_SESSION['JSST_SEARCH']['departmentid']) && $_SESSION['JSST_SEARCH']['departmentid'] != '') ? $_SESSION['JSST_SEARCH']['departmentid'] : null;
            $priorityid = (isset($_SESSION['JSST_SEARCH']['priorityid']) && $_SESSION['JSST_SEARCH']['priorityid'] != '') ? $_SESSION['JSST_SEARCH']['priorityid'] : null;
            $datestart = (isset($_SESSION['JSST_SEARCH']['datestart']) && $_SESSION['JSST_SEARCH']['datestart'] != '') ? $_SESSION['JSST_SEARCH']['datestart'] : null;
            $dateend = (isset($_SESSION['JSST_SEARCH']['dateend']) && $_SESSION['JSST_SEARCH']['dateend'] != '') ? $_SESSION['JSST_SEARCH']['dateend'] : null;
			$sortby = (isset($_SESSION['JSST_SEARCH']['sortby']) && $_SESSION['JSST_SEARCH']['sortby'] != '') ? $_SESSION['JSST_SEARCH']['sortby'] : null;
            if (!empty($search_userfields)) {
                foreach ($search_userfields as $uf) {
                    $value_array[$uf->field] = (isset($_SESSION['JSST_SEARCH'][$uf->field]) && $_SESSION['JSST_SEARCH'][$uf->field] != '') ? $_SESSION['JSST_SEARCH'][$uf->field] : null;
                }
            }
        }

        if ($ticketid != null)
            $inquery .= " AND ticket.ticketid LIKE '%$ticketid%'";
        if ($subject != null)
            $inquery .= " AND ticket.subject LIKE '%$subject%'";
        if ($name != null)
            $inquery .= " AND ticket.name LIKE '%$name%'";
        if ($email != null)
            $inquery .= " AND ticket.email LIKE '%$email%'";
        if ($departmentid != null)
            $inquery .= " AND ticket.departmentid = $departmentid";
        if ($priorityid != null)
            $inquery .= " AND ticket.priorityid = $priorityid";
        if ($datestart != null)
            $inquery .= " AND DATE(ticket.created) >= '$datestart'";
        if ($dateend != null)
            $inquery .= " AND DATE(ticket.created) <= '$dateend'";
        $valarray = array();
        if (!empty($search_userfields)) {
            foreach ($search_userfields as $uf) {
                if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
                    $valarray[$uf->field] = $value_array[$uf->field];
                }else{
                    $valarray[$uf->field] = JSSTrequest::getVar($uf->field, 'post');
                }
                if (isset($valarray[$uf->field]) && $valarray[$uf->field] != null) {
                    switch ($uf->userfieldtype) {
                        case 'text':
                        case 'file':
                        case 'email':
                            $inquery .= ' AND ticket.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                            break;
                        case 'combo':
                            $inquery .= ' AND ticket.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                            break;
                        case 'depandant_field':
                            $inquery .= ' AND ticket.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                            break;
                        case 'radio':
                            $inquery .= ' AND ticket.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                            break;
                        case 'checkbox':
                            $finalvalue = '';
                            foreach($valarray[$uf->field] AS $value){
                                $finalvalue .= $value.'.*';
                            }
                            $inquery .= ' AND ticket.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($finalvalue) . '.*"\' ';
                            break;
                        case 'date':
                            $inquery .= ' AND ticket.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                            break;
                        case 'textarea':
                            $inquery .= ' AND ticket.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                            break;
                        case 'multiple':
                            $finalvalue = '';
                            foreach($valarray[$uf->field] AS $value){
                                if($value != null){
                                    $finalvalue .= $value.'.*';
                                }    
                            }
                            if($finalvalue !=''){
                                $inquery .= ' AND ticket.params REGEXP \'"' . $uf->field . '":"[^"]*'.htmlspecialchars($finalvalue).'.*"\'';
                            }
                            break;
                    }
                    jssupportticket::$_data['filter']['params'] = $valarray;
                }
            }
        }
        //end
        jssupportticket::$_data['filter']['subject'] = $subject;
        jssupportticket::$_data['filter']['ticketid'] = $ticketid;
        jssupportticket::$_data['filter']['name'] = $name;
        jssupportticket::$_data['filter']['email'] = $email;
        jssupportticket::$_data['filter']['departmentid'] = $departmentid;
        jssupportticket::$_data['filter']['priorityid'] = $priorityid;
        jssupportticket::$_data['filter']['datestart'] = $datestart;
        jssupportticket::$_data['filter']['dateend'] = $dateend;
        jssupportticket::$_data['filter']['sortby'] = $sortby;
        // Pagination
        $query = "SELECT COUNT(ticket.id) "
                . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                . "WHERE 1 = 1";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        /*
          list variable detail
          1=>For open ticket
          2=>For answered  ticket
          4=>For Closed tickets
          5=>For mytickets tickets
         */
        jssupportticket::$_data['list'] = $list; // assign for reference
        // Data
        $query = "SELECT ticket.*,department.departmentname AS departmentname ,priority.priority AS priority,priority.prioritycolour AS prioritycolour
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                    WHERE 1 = 1";
        $query .= $inquery;
        $query .= " ORDER BY " . jssupportticket::$_ordering . " LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();

        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        // check email is bane 
        //Hook action
        do_action('jsst-ticketbeforelisting', jssupportticket::$_data[0]);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        if (jssupportticket::$_config['count_on_myticket'] == 1) {
            $query = "SELECT COUNT(ticket.id) "
                    . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                    . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                    . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                    . "WHERE ticket.status != 4";
            jssupportticket::$_data['count']['openticket'] = jssupportticket::$_db->get_var($query);

            $query = "SELECT COUNT(ticket.id) "
                    . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                    . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                    . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                    . "WHERE ticket.isanswered = 1";
            jssupportticket::$_data['count']['answeredticket'] = jssupportticket::$_db->get_var($query);

            $query = "SELECT COUNT(ticket.id) "
                    . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                    . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                    . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                    . "WHERE ticket.isoverdue = 1";
            jssupportticket::$_data['count']['overdueticket'] = jssupportticket::$_db->get_var($query);

            $query = "SELECT COUNT(ticket.id) "
                    . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                    . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                    . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                    . "WHERE ticket.status = 4";
            jssupportticket::$_data['count']['closedticket'] = jssupportticket::$_db->get_var($query);

            $query = "SELECT COUNT(ticket.id) "
                    . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                    . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                    . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                    . "WHERE 1 = 1";
            jssupportticket::$_data['count']['allticket'] = jssupportticket::$_db->get_var($query);
        }
        return;
    }

    function getOrdering() {
        $sort = JSSTrequest::getVar('sortby', '');
        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $sort = $_SESSION['JSST_SORTBY'];
        }
        $_SESSION['JSST_SORTBY'] = $sort;
        if ($sort == '') {
            $list = JSSTrequest::getVar('list', null, 1);
            if ($list == 1)
                $sort = 'statusasc';
            elseif ($list == 2)
                $sort = 'createddesc';
            elseif ($list == 3)
                $sort = 'statusasc';
            elseif ($list == 4)
                $sort = 'createddesc';
            elseif ($list == 5)
                $sort = 'statusasc';
        }
        $this->getTicketListOrdering($sort);
        $this->getTicketListSorting($sort);
    }

    function combineOrSingleSearch() {
        $ticketkeys = trim(JSSTrequest::getVar('jsst-ticketsearchkeys', 'post'));
        
        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['ticketkeys'] = $ticketkeys;
        }elseif(JSSTrequest::getVar('pagenum', 'get', null) == null){
            if(isset($_SESSION['JSST_SEARCH']['ticketkeys'])){
                unset($_SESSION['JSST_SEARCH']['ticketkeys']);
            }
        }
        
        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $ticketkeys = isset($_SESSION['JSST_SEARCH']['ticketkeys']) ? $_SESSION['JSST_SEARCH']['ticketkeys']: false;
        }
        $inquery = '';
        if ($ticketkeys) {
            if (strlen($ticketkeys) == 9)
                $inquery = " AND ticket.ticketid = '$ticketkeys'";
            else if (strpos($ticketkeys, '@') && strpos($ticketkeys, '.'))
                $inquery = " AND ticket.email LIKE '%$ticketkeys%'";
            else
                $inquery = " AND ticket.subject LIKE '%$ticketkeys%'";

            jssupportticket::$_data['filter']['ticketsearchkeys'] = $ticketkeys;
        }else {
            $search_userfields = JSSTincluder::getObjectClass('customfields')->userFieldsForSearch(1);
            $ticketid = JSSTrequest::getVar('jsst-ticket', 'post');
            $from = JSSTrequest::getVar('jsst-from', 'post');
            $email = JSSTrequest::getVar('jsst-email', 'post');
            $departmentid = JSSTrequest::getVar('jsst-departmentid', 'post');
            $priorityid = JSSTrequest::getVar('jsst-priorityid', 'post');
            $subject = JSSTrequest::getVar('jsst-subject', 'post');
            $datestart = JSSTrequest::getVar('jsst-datestart', 'post');
            $dateend = JSSTrequest::getVar('jsst-dateend', 'post');
            //custom field search
            if (!empty($search_userfields)) {
                foreach ($search_userfields as $uf) {
                    $value_array[$uf->field] = JSSTrequest::getVar($uf->field, 'post');
                }
            }

            $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
            if ($formsearch == 'JSST_SEARCH') {
                $_SESSION['JSST_SEARCH']['subject'] = $subject;
                $_SESSION['JSST_SEARCH']['from'] = $from;
                $_SESSION['JSST_SEARCH']['email'] = $email;
                $_SESSION['JSST_SEARCH']['ticketid'] = $ticketid;
                $_SESSION['JSST_SEARCH']['departmentid'] = $departmentid;
                $_SESSION['JSST_SEARCH']['priorityid'] = $priorityid;
                $_SESSION['JSST_SEARCH']['datestart'] = $datestart;
                $_SESSION['JSST_SEARCH']['dateend'] = $dateend;
            //custom field search
                if (!empty($search_userfields)) {
                    foreach ($search_userfields as $uf) {
                        if(isset($_SESSION['JSST_SEARCH'])){
                            $_SESSION['JSST_SEARCH'][$uf->field] = JSSTrequest::getVar($uf->field, 'post');
                        }
                    }
                }
            }elseif(JSSTrequest::getVar('pagenum', 'get', null) == null){
                if(isset($_SESSION['JSST_SEARCH'])){
                    foreach ($_SESSION['JSST_SEARCH'] as $key => $value) {
                        unset($_SESSION['JSST_SEARCH'][$key]);
                    }
                }
            }

            if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
                $subject = (isset($_SESSION['JSST_SEARCH']['subject']) && $_SESSION['JSST_SEARCH']['subject'] != '') ? $_SESSION['JSST_SEARCH']['subject'] : null;
                $from = (isset($_SESSION['JSST_SEARCH']['from']) && $_SESSION['JSST_SEARCH']['from'] != '') ? $_SESSION['JSST_SEARCH']['from'] : null;
                $email = (isset($_SESSION['JSST_SEARCH']['email']) && $_SESSION['JSST_SEARCH']['email'] != '') ? $_SESSION['JSST_SEARCH']['email'] : null;
                $ticketid = (isset($_SESSION['JSST_SEARCH']['ticketid']) && $_SESSION['JSST_SEARCH']['ticketid'] != '') ? $_SESSION['JSST_SEARCH']['ticketid'] : null;
                $departmentid = (isset($_SESSION['JSST_SEARCH']['departmentid']) && $_SESSION['JSST_SEARCH']['departmentid'] != '') ? $_SESSION['JSST_SEARCH']['departmentid'] : null;
                $priorityid = (isset($_SESSION['JSST_SEARCH']['priorityid']) && $_SESSION['JSST_SEARCH']['priorityid'] != '') ? $_SESSION['JSST_SEARCH']['priorityid'] : null;
                $datestart = (isset($_SESSION['JSST_SEARCH']['datestart']) && $_SESSION['JSST_SEARCH']['datestart'] != '') ? $_SESSION['JSST_SEARCH']['datestart'] : null;
                $dateend = (isset($_SESSION['JSST_SEARCH']['dateend']) && $_SESSION['JSST_SEARCH']['dateend'] != '') ? $_SESSION['JSST_SEARCH']['dateend'] : null;
                //custom field search
                if (!empty($search_userfields)) {
                    foreach ($search_userfields as $uf) {
                        $value_array[$uf->field] = (isset($_SESSION['JSST_SEARCH'][$uf->field]) && $_SESSION['JSST_SEARCH'][$uf->field] != '') ? $_SESSION['JSST_SEARCH'][$uf->field] : null;
                    }
                }
            }
        
            if ($ticketid != null) {
                $inquery .= " AND ticket.ticketid LIKE '$ticketid'";
                jssupportticket::$_data['filter']['ticketid'] = $ticketid;
            }
            if ($from != null) {
                $inquery .= " AND ticket.name LIKE '%$from%'";
                jssupportticket::$_data['filter']['from'] = $from;
            }
            if ($email != null) {
                $inquery .= " AND ticket.email LIKE '$email'";
                jssupportticket::$_data['filter']['email'] = $email;
            }
            if ($departmentid != null) {
                $inquery .= " AND ticket.departmentid LIKE '$departmentid'";
                jssupportticket::$_data['filter']['departmentid'] = $departmentid;
            }
            if ($priorityid != null) {
                $inquery .= " AND ticket.priorityid LIKE '$priorityid'";
                jssupportticket::$_data['filter']['priorityid'] = $priorityid;
            }
            if ($subject != null) {
                $inquery .= " AND ticket.subject LIKE '%$subject%'";
                jssupportticket::$_data['filter']['subject'] = $subject;
            }
            if ($datestart != null) {
                $inquery .= " AND '$datestart' <= DATE(ticket.created)";
                jssupportticket::$_data['filter']['datestart'] = $datestart;
            }
            if ($dateend != null) {
                $inquery .= " AND '$dateend' >= DATE(ticket.created)";
                jssupportticket::$_data['filter']['dateend'] = $dateend;
            }
            $valarray = array();
            if (!empty($search_userfields)) {
                foreach ($search_userfields as $uf) {
                    if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
                        $valarray[$uf->field] = $value_array[$uf->field];
                    }else{
                        $valarray[$uf->field] = JSSTrequest::getVar($uf->field, 'post');
                    }
                    if (isset($valarray[$uf->field]) && $valarray[$uf->field] != null) {
                        switch ($uf->userfieldtype) {
                            case 'text':
                            case 'email':
                            case 'file':
                                $inquery .= ' AND ticket.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                                break;
                            case 'combo':
                                $inquery .= ' AND ticket.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                                break;
                            case 'depandant_field':
                                $inquery .= ' AND ticket.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                                break;
                            case 'radio':
                                $inquery .= ' AND ticket.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                                break;
                            case 'checkbox':
                                $finalvalue = '';
                                foreach($valarray[$uf->field] AS $value){
                                    $finalvalue .= $value.'.*';
                                }
                                $inquery .= ' AND ticket.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($finalvalue) . '.*"\' ';
                                break;
                            case 'date':
                                $inquery .= ' AND ticket.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                                break;
                            case 'textarea':
                                $inquery .= ' AND ticket.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                                break;
                            case 'multiple':
                                $finalvalue = '';
                                foreach($valarray[$uf->field] AS $value){
                                    if($value != null){
                                        $finalvalue .= $value.'.*';
                                    }    
                                }
                                if($finalvalue !=''){
                                    $inquery .= ' AND ticket.params REGEXP \'"' . $uf->field . '":"[^"]*'.htmlspecialchars($finalvalue).'.*"\'';
                                }
                                break;
                        }
                        jssupportticket::$_data['filter']['params'] = $valarray;
                    }
                }
            }
            //end

            if ($inquery == '')
                jssupportticket::$_data['filter']['combinesearch'] = false;
            else
                jssupportticket::$_data['filter']['combinesearch'] = true;
        }

        return $inquery;
    }

    function getMyTickets() {
        $this->getOrdering();
        // Filter
        /*
          list variable detail
          1=>For open ticket
          2=>For closed ticket
          3=>For open answered ticket
          4=>For all my tickets
         */
        $inquery = $this->combineOrSingleSearch();

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $list = (isset($_SESSION['JSST_list']) && $_SESSION['JSST_list'] != '') ? $_SESSION['JSST_list'] : 1;
        }else{
            $list = JSSTrequest::getVar('list', null, 1);    
            $_SESSION['JSST_list'] = $list;
        }
        jssupportticket::$_data['list'] = $list; // assign for reference
        
        switch ($list) {
            // Ticket Default Status
            // 0 -> New Ticket
            // 1 -> Waiting admin/staff reply
            // 3 -> waiting for customer reply
            // 4 -> close ticket
            case 1:$inquery .= " AND ticket.status != 4 ";
                break;
            case 2:$inquery .= " AND ticket.status = 4 ";
                break;
            case 3:$inquery .= " AND ticket.status = 3 ";
                break;
            case 4:$inquery .= " ";
                break;
        }

        $uid = get_current_user_id();
        if ($uid) {
            // Pagination
            $query = "SELECT COUNT(ticket.id) 
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket 
                        LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                        JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                        WHERE ticket.uid = $uid ";
            $query .= $inquery;
            $total = jssupportticket::$_db->get_var($query);
            jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

            // Data
            $query = "SELECT ticket.*,department.departmentname AS departmentname ,priority.priority AS priority,priority.prioritycolour AS prioritycolour
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                        LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                        JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id";
            $query .= " WHERE ticket.uid = $uid " . $inquery;
            $query .= " ORDER BY " . jssupportticket::$_ordering . " LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
            jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
            }
            if (jssupportticket::$_config['count_on_myticket'] == 1) {
                $query = "SELECT COUNT(ticket.id) "
                        . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                        . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                        . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                        . "WHERE ticket.uid = $uid AND ticket.status != 4";
                jssupportticket::$_data['count']['openticket'] = jssupportticket::$_db->get_var($query);
                ;

                $query = "SELECT COUNT(ticket.id) "
                        . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                        . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                        . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                        . "WHERE ticket.uid = $uid AND ticket.status = 3";
                jssupportticket::$_data['count']['answeredticket'] = jssupportticket::$_db->get_var($query);
                ;

                $query = "SELECT COUNT(ticket.id) "
                        . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                        . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                        . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                        . "WHERE ticket.uid = $uid AND ticket.status = 4";
                jssupportticket::$_data['count']['closedticket'] = jssupportticket::$_db->get_var($query);
                ;

                $query = "SELECT COUNT(ticket.id) "
                        . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket "
                        . "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id "
                        . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id "
                        . "WHERE ticket.uid = $uid";
                jssupportticket::$_data['count']['allticket'] = jssupportticket::$_db->get_var($query);
                ;
            }
        }
        return;
    }

    function getTicketsForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = "SELECT ticket.*,department.departmentname AS departmentname ,priority.priority AS priority,priority.prioritycolour AS prioritycolour,user.user_nicename AS user_login
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                        LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                        JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                        LEFT JOIN `".jssupportticket::$_wpprefixforuser."users` AS user ON user.id = ticket.uid 
                        WHERE ticket.id = " . $id;
            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }else{
                //to store hash value of id against old tickets
                if( jssupportticket::$_data[0]->hash == null ){
                    $hash = $this->generateHash($id);
                    $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET `hash`='".$hash."' WHERE id=".$id;
                    jssupportticket::$_db->query($query);
                } //end
            }
        }
        JSSTincluder::getJSModel('attachment')->getAttachmentForForm($id);
        JSSTincluder::getJSModel('fieldordering')->getFieldsOrderingforForm(1);
        return;
    }

    function getTicketForDetail($id) {
        if (!is_numeric($id))
            return $id;

        if (is_user_logged_in()) {
            if (is_admin())
                jssupportticket::$_data['permission_granted'] = true;
            else
                jssupportticket::$_data['permission_granted'] = $this->validateTicketDetailForUser($id);
        }else{
            jssupportticket::$_data['permission_granted'] = $this->validateTicketDetailForVisitor($id);
        }
        if (!jssupportticket::$_data['permission_granted']) { // validation failed
            return;
        }

        $query = "SELECT ticket.*,department.departmentname AS departmentname ,priority.priority AS priority,priority.prioritycolour AS prioritycolour
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                    WHERE ticket.id = " . $id;
        jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        JSSTincluder::getJSModel('reply')->getReplies($id);
        jssupportticket::$_data['ticket_attachment'] = JSSTincluder::getJSModel('attachment')->getAttachmentForReply($id, 0);
        jssupportticket::$_data['custom']['ticketid'] = $id;
        //Hooks
        do_action('jsst-ticketbeforeview', jssupportticket::$_data);

        return;
    }

    function getRandomTicketId() {
        $query = "SELECT ticketid FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets`";
        do {
            $ticketid = "";
            $length = 9;
            $sequence = jssupportticket::$_config['ticketid_sequence'];
            if($sequence == 1){
                $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
                // we refer to the length of $possible a few times, so let's grab it now
                $maxlength = strlen($possible);
                if ($length > $maxlength) { // check for length overflow and truncate if necessary
                    $length = $maxlength;
                }
                // set up a counter for how many characters are in the ticketid so far
                $i = 0;
                // add random characters to $password until $length is reached
                while ($i < $length) {
                    // pick a random character from the possible ones
                    $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
                    if (!strstr($ticketid, $char)) {
                        if ($i == 0) {
                            if (ctype_alpha($char)) {
                                $ticketid .= $char;
                                $i++;
                            }
                        } else {
                            $ticketid .= $char;
                            $i++;
                        }
                    }
                }
            }else{ // Sequential ticketid
                if($ticketid == ""){
                    $ticketid = 0; // by default its set to zero                    
                }
                $maxquery = "SELECT max(convert(ticketid, SIGNED INTEGER)) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets`";
                
                $maxticketid = jssupportticket::$_db->get_var($maxquery);
                if(is_numeric($maxticketid)){
                    $ticketid = $maxticketid + 1;
                }else{
                    $ticketid = $ticketid + 1;
                }
            }
            $rows = jssupportticket::$_db->get_results($query);
                foreach ($rows as $row) {
                    if ($ticketid == $row->ticketid)
                        $match = 'Y';
                    else
                        $match = 'N';
                }
        }while ($match == 'Y');
        return $ticketid;
    }

    function getRandomFolderName() {
        $foldername = "";
        $length = 7;
        $possible = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
        // we refer to the length of $possible a few times, so let's grab it now
        $maxlength = strlen($possible);
        if ($length > $maxlength) { // check for length overflow and truncate if necessary
            $length = $maxlength;
        }
        // set up a counter for how many characters are in the ticketid so far
        $i = 0;
        // add random characters to $password until $length is reached
        while ($i < $length) {
            // pick a random character from the possible ones
            $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
            if (!strstr($foldername, $char)) {
                if ($i == 0) {
                    if (ctype_alpha($char)) {
                        $foldername .= $char;
                        $i++;
                    }
                } else {
                    $foldername .= $char;
                    $i++;
                }
            }
        }
        return $foldername;
    }

    function getIpAddress() {
        //if client use the direct ip
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    function captchaValidate() {
        if (!is_user_logged_in()) {
            if (jssupportticket::$_config['show_captcha_on_visitor_from_ticket'] == 1) {
                if (jssupportticket::$_config['captcha_selection'] == 1) { // Google recaptcha
                    $gresponse = $_POST['g-recaptcha-response'];
                    $resp = googleRecaptchaHTTPPost(jssupportticket::$_config['recaptcha_privatekey'],$gresponse);
                    if ($resp == true) {
                        return true;
                    } else {
                        JSSTmessage::setMessage(__('Incorrect Captcha code', 'js-support-ticket'), 'error');
                        return false;
                    }
                } else { // own captcha
                    $captcha = new JSSTcaptcha;
                    $result = $captcha->checkCaptchaUserForm();
                    if ($result == 1) {
                        return true;
                    } else {
                        JSSTmessage::setMessage(__('Incorrect Captcha code', 'js-support-ticket'), 'error');
                        return false;
                    }
                }
            }
        }
		return true;
    }
    
    function storeTickets($data) {
        if (!is_admin()) { //if not admin
            if (!$this->captchaValidate()) {
                return 'captcha_failed';
            }
        }
        $sendEmail = true;

        if ($data['id']) {
            $sendEmail = false;
            $updated = date_i18n('Y-m-d H:i:s');
            $created = $data['created'];
            //to check hash
            $query = "SELECT hash,uid FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE ticketid='".$data['ticketid']."'";
            $row = jssupportticket::$_db->get_row($query);
            $edituid = $row->uid;
            if( $row->hash != $this->generateHash($data['id']) ){
                return false;
            }//end
        } else {
            $data['ticketid'] = $this->getRandomTicketId();
            $data['attachmentdir'] = $this->getRandomFolderName();
            $created = date_i18n('Y-m-d H:i:s');
            $updated = '';
        }
        $data['status'] = isset($data['status']) ? $data['status'] : '';
        $data['lastreply'] = isset($data['lastreply']) ? $data['lastreply'] : '';
        $data['message'] = wpautop(wptexturize(stripslashes($data['jsticket_message'])));
        if (empty($data['message'])) {
            JSSTmessage::setMessage(__('Message field cannot be empty', 'js-support-ticket'), 'error');
            return false;
        }
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
//custom field code start
        $customflagforadd = false;
        $customflagfordelete = false;
        $custom_field_namesforadd = array();
        $custom_field_namesfordelete = array();
        $userfield = JSSTincluder::getJSModel('fieldordering')->getUserfieldsfor(1);
        $params = array();
        $maxfilesizeallowed = jssupportticket::$_config['file_maximum_size'];        
        foreach ($userfield AS $ufobj) {
            $vardata = '';
            if($ufobj->userfieldtype == 'file'){
                if(isset($data[$ufobj->field.'_1']) && $data[$ufobj->field.'_1']== 0){
                    $vardata = $data[$ufobj->field.'_2'];
                }
                // else{
                //     $uploadfilesize = $_FILES[$ufobj->field]['size'] / 1024; //kb
                //     if($uploadfilesize <= $maxfilesizeallowed){
                //         $filetyperesult = '';
                //         $filetyperesult = wp_check_filetype($_FILES[$ufobj->field]['name']);
                //         if(!empty($filetyperesult['ext']) && !empty($filetyperesult['type'])){
                //             $image_file_types = JSSTincluder::getJSModel('configuration')->getConfigValue('file_extension');
                //             if(strstr($image_file_types, $filetyperesult['ext'])){
                //                 $vardata = sanitize_file_name($_FILES[$ufobj->field]['name']);
                //             }
                //         }
                //     }
                // }
                $customflagforadd=true;
                $custom_field_namesforadd[]=$ufobj->field;
            }else{
                $vardata = isset($data[$ufobj->field]) ? $data[$ufobj->field] : '';
            }
            if(isset($data[$ufobj->field.'_1']) && $data[$ufobj->field.'_1'] == 1){
                $customflagfordelete = true;
                $custom_field_namesfordelete[]= $data[$ufobj->field.'_2'];
                }
            if($vardata != ''){

                if(is_array($vardata)){
                    $vardata = implode(', ', $vardata);
                }
                $params[$ufobj->field] = htmlspecialchars($vardata);
            }
        }

        if($data['id'] != ''){
            if(is_numeric($data['id'])){
                $query = "SELECT params FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $data['id'];
                $oParams = jssupportticket::$_db->get_var($query);

                if(!empty($oParams)){
                    $oParams = json_decode($oParams,true);
                    $unpublihsedFields = JSSTincluder::getJSModel('fieldordering')->getUserUnpublishFieldsfor(1);
                    foreach($unpublihsedFields AS $field){
                        if(isset($oParams[$field->field])){
                            $params[$field->field] = $oParams[$field->field];
                        }
                    }
                }
            }
        }

        //if (!empty($params)) {
            $params = json_encode($params);
        //}
        $data['params'] = $params;
//custom field code end
        $data['message'] = wpautop(wptexturize(stripslashes($_POST['jsticket_message'])));
        $query_array = array('id' => $data['id'],
            'email' => $data['email'],
            'name' => $data['name'],
            'uid' => $data['uid'],
            'phone' => $data['phone'],
            'departmentid' => $data['departmentid'],
            'priorityid' => $data['priorityid'],
            'subject' => $data['subject'],
            'message' => $data['message'],
            'status' => $data['status'],
            'duedate' => '',
            'attachmentdir' => $data['attachmentdir'],
            'lastreply' => $data['lastreply'],
            'created' => $created,
            'updated' => $updated,
            'params' => $data['params'],
            'ticketid' => $data['ticketid']
        );
         if(isset($data['phoneext'])){
            $query_array['phoneext'] = $data['phoneext'];
        }
        if($data['id']){
           $query_array['uid'] = $edituid;
        }
        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_tickets', $query_array);
        $ticketid = jssupportticket::$_db->insert_id; // get the ticket id
        $sendnotification = false;
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
            JSSTmessage::setMessage(__('Ticket has not been created', 'js-support-ticket'), 'error');
        } else {
            $sendnotification = true;
            $messagetype = __('Successfully', 'js-support-ticket');

            //update hash value against ticket
            $hash = $this->generateHash($ticketid);
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET `hash`='".$hash."' WHERE id=".$ticketid;
            jssupportticket::$_db->query($query);
            
            // Storing Attachments
            $data['ticketid'] = $ticketid;
            JSSTincluder::getJSModel('attachment')->storeAttachments($data);
            JSSTmessage::setMessage(__('Ticket created', 'js-support-ticket'), 'updated');

            //removing custom field attachments
            if($customflagfordelete == true){
                foreach ($custom_field_namesfordelete as $key) {
                    $res = $this->removeFileCustom($ticketid,$key);
                }
            }
            //storing custom field attachments
            if($customflagforadd == true){
                foreach ($custom_field_namesforadd as $key) {
                    if ($_FILES[$key]['size'] > 0) { // logo
                        $res = $this->uploadFileCustom($ticketid,$key);
                    }
                }
            }
        }

        /* Push Notification */
        if($data['id'] == '' && $sendnotification == true && 1 == 2){
            $dataarray = array();
            $dataarray['title'] = $query_array['subject'];
            $dataarray['body'] = __("has been created","js-support-ticket");
            
            //send notification to admin
            $devicetoken = JSSTincluder::getJSModel('notification')->checkSubscriptionForAdmin();
            if($devicetoken){
                $dataarray['link'] = admin_url("admin.php?page=ticket&task=ticketdetail&jssupportticketid=".$ticketid);
                $dataarray['devicetoken'] = $devicetoken;
                $value = jssupportticket::$_config[md5(JSTN)];
                if($value != ''){
                  do_action('send_push_notification',$dataarray);
                }else{
                  do_action('resetnotificationvalues');
                }
            }
            
            $dataarray['link'] = jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'ticketdetail', "jssupportticketid"=>$ticketid,'jsstpageid'=>jssupportticket::getPageid()));
            // send notification to uid(ticket create for)
            if($query_array['uid'] > 0 && is_numeric($query_array['uid']) && ($query_array['uid'] != get_current_user_id())){
                $devicetoken = JSSTincluder::getJSModel('notification')->getUserDeviceToken($query_array['uid']);
                $dataarray['devicetoken'] = $devicetoken;
                if($devicetoken != '' && !empty($devicetoken)){
                    $value = jssupportticket::$_config[md5(JSTN)];
                    if($value != ''){
                      do_action('send_push_notification',$dataarray);
                    }else{
                      do_action('resetnotificationvalues');
                    }
                }
            }else if($data['uid'] == 0 && isset($query_array['notificationid']) && $query_array['notificationid'] != ""){ //visitor
                $tokenarray['emailaddress'] = $query_array['email'];
                $tokenarray['trackingid'] = $query_array['ticketid'];
                $token = json_encode($tokenarray);
                include_once jssupportticket::$_path . 'includes/encoder.php';
                $encoder = new JSSTEncoder();
                $encryptedtext = $encoder->encrypt($token);
                $dataarray['link'] = jssupportticket::makeUrl(array('jstmod'=>'ticket' ,'task'=>'showticketstatus','action'=>'jstask','token'=>$encryptedtext,'jsstpageid'=>jssupportticket::getPageid()));
                $devicetoken = JSSTincluder::getJSModel('notification')->getUserDeviceToken($query_array['notificationid'],0);
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

        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(1, 1, $ticketid); // Mailfor, Create Ticket, Ticketid
            //For Hook
            $ticketobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $ticketid);
            do_action('jsst-ticketcreate', $ticketobject);
        }
        return $ticketid;
    }

    function storeUploadFieldValueInParams($ticketid,$filename,$field){
        $query = "SELECT params FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE id = ".$ticketid;
        $params = jssupportticket::$_db->get_var($query);
        $decoded_params = json_decode($params,true);
        $decoded_params[$field] = $filename;
        $encoded_params = json_encode($decoded_params);
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET params = '" . $encoded_params . "' WHERE id = " . $ticketid;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function uploadFileCustom($id,$field){
        JSSTincluder::getObjectClass('uploads')->storeTicketCustomUploadFile($id,$field);
    }

    function removeFileCustom($id,$key){
        $filename = str_replace(' ', '_', $key);
        $maindir = wp_upload_dir();
        $basedir = $maindir['basedir'];
        $datadirectory = jssupportticket::$_config['data_directory'];
        $path = $basedir . '/' . $datadirectory. '/attachmentdata/ticket';
        
        $query = "SELECT attachmentdir FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE id = ".$id;
        $foldername = jssupportticket::$_db->get_var($query);
        $userpath = $path . '/' . $foldername.'/'.$filename;
        unlink($userpath);
        return ;
    }

    function removeTicket($id) {
        $sendEmail = true;
        if (!is_numeric($id))
            return false;

        if ($this->canRemoveTicket($id)) {
            jssupportticket::$_data['ticketid'] = $this->getTrackingIdById($id);
            jssupportticket::$_data['ticketemail'] = $this->getTicketEmailById($id);
            jssupportticket::$_data['ticketsubject'] = $this->getTicketSubjectById($id);
            // delete attachments
            $this->removeTicketAttachmentsByTicketid($id);
            jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_tickets', array('id' => $id));

            if (jssupportticket::$_db->last_error == null) {
                $messagetype = __('Successfully', 'js-support-ticket');
                JSSTmessage::setMessage(__('Ticket deleted', 'js-support-ticket'), 'updated');
                // delete user fields
                jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_userfield_data', array('referenceid' => $id));
            } else {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
                JSSTmessage::setMessage(__('Ticket has not been deleted', 'js-support-ticket'), 'error');
                $messagetype = __('Error', 'js-support-ticket');
                $sendEmail = false;
            }

            // Send Emails
            if ($sendEmail == true) {
                JSSTincluder::getJSModel('email')->sendMail(1, 3); // Mailfor, Delete Ticket
                $ticketobject = (object) array('ticketid' => jssupportticket::$_data['ticketid'], 'ticketemail' => jssupportticket::$_data['ticketemail']);
                do_action('jsst-ticketdelete', $ticketobject);
            }
        } else {
            JSSTmessage::setMessage(__('Ticket', 'js-support-ticket') . ' ' . __('in use cannot be deleted', 'js-support-ticket'), 'error');
        }

        return;
    }

    function removeEnforceTicket($id) {
        $sendEmail = true;
        if (!is_numeric($id))
            return false;

        jssupportticket::$_data['ticketid'] = $this->getTrackingIdById($id);
        jssupportticket::$_data['ticketemail'] = $this->getTicketEmailById($id);
        jssupportticket::$_data['ticketsubject'] = $this->getTicketSubjectById($id);
        // delete attachments
        $this->removeTicketAttachmentsByTicketid($id);
        jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_tickets', array('id' => $id));

        if (jssupportticket::$_db->last_error == null) {
            $messagetype = __('Successfully', 'js-support-ticket');
            JSSTmessage::setMessage(__('Ticket deleted', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Ticket has not been deleted', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }

        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(1, 3); // Mailfor, Delete Ticket
            $ticketobject = (object) array('ticketid' => jssupportticket::$_data['ticketid'], 'ticketemail' => jssupportticket::$_data['ticketemail']);
            do_action('jsst-ticketdelete', $ticketobject);
        }
        // delete replies
        JSSTincluder::getJSModel('reply')->removeTicketReplies($id);
        return;
    }

    private function removeTicketAttachmentsByTicketid($id){
        if(!is_numeric($id)) return false;
        $datadirectory = jssupportticket::$_config['data_directory'];
        $maindir = wp_upload_dir();
        $mainpath = $maindir['basedir'];
        $mainpath = $mainpath .'/'.$datadirectory;
        $mainpath = $mainpath . '/attachmentdata';
        $query = "SELECT ticket.attachmentdir
                    FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` AS ticket 
                    WHERE ticket.id = ".$id;
        $foldername = jssupportticket::$_db->get_var($query);
        if(!empty($foldername)){
            $folder = $mainpath . '/ticket/'.$foldername;
            if(file_exists($folder)){
                $path = $mainpath . '/ticket/'.$foldername.'/*.*';
                $files = glob($path);
                array_map('unlink', $files);//deleting files
                rmdir($folder);
                $query = "DELETE FROM `".jssupportticket::$_db->prefix."js_ticket_attachments` WHERE ticketid = ".$id;
                jssupportticket::$_db->query($query);
            }
        }
    }

    private function canRemoveTicket($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT (
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_attachments` WHERE ticketid = " . $id . ")
                    +(SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_replies` WHERE ticketid = " . $id . ")
                    ) AS total";
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        if ($result == 0)
            return true;
        else
            return false;
    }

    function getTicketSubjectById($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT subject FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $id;
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        $subject = jssupportticket::$_db->get_var($query);
        return $subject;
    }

    function getTrackingIdById($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT ticketid FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $id;
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        $ticketid = jssupportticket::$_db->get_var($query);
        return $ticketid;
    }

    function getTicketEmailById($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT email FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $id;
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        $ticketemail = jssupportticket::$_db->get_var($query);
        return $ticketemail;
    }

    function setStatus($status, $ticketid) {
        // 0 -> New Ticket
        // 1 -> Waiting admin/staff reply
        // 2 -> in progress
        // 3 -> waiting for customer reply
        // 4 -> close ticket
        if (!is_numeric($status))
            return false;
        if (!is_numeric($ticketid))
            return false;
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET status = " . $status . " WHERE id = " . $ticketid;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function updateLastReply($id) {
        if (!is_numeric($id))
            return false;
        $date = date_i18n('Y-m-d H:i:s');
        $isanswered = " , isanswered = 0 ";
        if (is_admin()) {
            $isanswered = " , isanswered = 1 ";
        }
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET lastreply = '" . $date . "' " . $isanswered . " WHERE id = " . $id;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function closeTicket($id) {
        if (!is_numeric($id))
            return false;
        //Check if its allowed to close ticket
        if (!$this->checkActionStatusSame($id, array('action' => 'closeticket'))) {
            JSSTmessage::setMessage(__('Ticket already closed', 'js-support-ticket'), 'error');
            return;
        }
        $sendEmail = true;
        $date = date_i18n('Y-m-d H:i:s');
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET status = 4, closed = '" . $date . "' WHERE id = " . $id;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Ticket closed', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Ticket has not been closed', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }


        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(1, 2, $id); // Mailfor, Close Ticket, Ticketid
            $ticketobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $id);
            do_action('jsst-ticketclose', $ticketobject);
        }

        return;
    }

    function getTicketListOrdering($sort) {
        switch ($sort) {
            case "subjectdesc":
                jssupportticket::$_ordering = "ticket.subject DESC";
                jssupportticket::$_sorton = "subject";
                jssupportticket::$_sortorder = "DESC";
                break;
            case "subjectasc":
                jssupportticket::$_ordering = "ticket.subject ASC";
                jssupportticket::$_sorton = "subject";
                jssupportticket::$_sortorder = "ASC";
                break;
            case "prioritydesc":
                jssupportticket::$_ordering = "priority DESC";
                jssupportticket::$_sorton = "priority";
                jssupportticket::$_sortorder = "DESC";
                break;
            case "priorityasc":
                jssupportticket::$_ordering = "priority ASC";
                jssupportticket::$_sorton = "priority";
                jssupportticket::$_sortorder = "ASC";
                break;
            case "ticketiddesc":
                jssupportticket::$_ordering = "ticket.ticketid DESC";
                jssupportticket::$_sorton = "ticketid";
                jssupportticket::$_sortorder = "DESC";
                break;
            case "ticketidasc":
                jssupportticket::$_ordering = "ticket.ticketid ASC";
                jssupportticket::$_sorton = "ticketid";
                jssupportticket::$_sortorder = "ASC";
                break;
            case "isanswereddesc":
                jssupportticket::$_ordering = "ticket.isanswered DESC";
                jssupportticket::$_sorton = "isanswered";
                jssupportticket::$_sortorder = "DESC";
                break;
            case "isansweredasc":
                jssupportticket::$_ordering = "ticket.isanswered ASC";
                jssupportticket::$_sorton = "isanswered";
                jssupportticket::$_sortorder = "ASC";
                break;
            case "statusdesc":
                jssupportticket::$_ordering = "ticket.status DESC";
                jssupportticket::$_sorton = "status";
                jssupportticket::$_sortorder = "DESC";
                break;
            case "statusasc":
                jssupportticket::$_ordering = "ticket.status ASC";
                jssupportticket::$_sorton = "status";
                jssupportticket::$_sortorder = "ASC";
                break;
            case "createddesc":
                jssupportticket::$_ordering = "ticket.created DESC";
                jssupportticket::$_sorton = "created";
                jssupportticket::$_sortorder = "DESC";
                break;
            case "createdasc":
                jssupportticket::$_ordering = "ticket.created ASC";
                jssupportticket::$_sorton = "created";
                jssupportticket::$_sortorder = "ASC";
                break;
            default: jssupportticket::$_ordering = "ticket.id DESC";
        }
        return;
    }

    function getSortArg($type, $sort) {
        $mat = array();
        if (preg_match("/(\w+)(asc|desc)/i", $sort, $mat)) {
            if ($type == $mat[1]) {
                return ( $mat[2] == "asc" ) ? "{$type}desc" : "{$type}asc";
            } else {
                return $type . $mat[2];
            }
        }
        return "iddesc";
    }

    function getTicketListSorting($sort) {
        jssupportticket::$_sortlinks['subject'] = $this->getSortArg("subject", $sort);
        jssupportticket::$_sortlinks['priority'] = $this->getSortArg("priority", $sort);
        jssupportticket::$_sortlinks['ticketid'] = $this->getSortArg("ticketid", $sort);
        jssupportticket::$_sortlinks['isanswered'] = $this->getSortArg("isanswered", $sort);
        jssupportticket::$_sortlinks['status'] = $this->getSortArg("status", $sort);
        jssupportticket::$_sortlinks['created'] = $this->getSortArg("created", $sort);
        return;
    }

    function changeTicketPriority($id, $priorityid) {
        if (!is_numeric($id))
            return false;
        if (!is_numeric($priorityid))
            return false;
        if (!$this->checkActionStatusSame($id, array('action' => 'priority', 'id' => $priorityid))) {
            JSSTmessage::setMessage(__('Ticket already have same priority', 'js-support-ticket'), 'error');
            return;
        }
        $sendEmail = true;
        $date = date_i18n('Y-m-d H:i:s');
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET priorityid = " . $priorityid . ", updated = '" . $date . "' WHERE id = " . $id;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Priority changed', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Priority has not been changed', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }
        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(1, 11, $id, 'js_ticket_tickets'); // Mailfor, Ban email, Ticketid
        }

        return;
    }

    /* check can a ticket be opened with in the given days */

    function checkCanReopenTicket($ticketid) {
        if (!is_numeric($ticketid))
            return false;
        $lastreply = JSSTincluder::getJSModel('reply')->getLastReply($ticketid);
        if (!$lastreply)
            $lastreply = date_i18n('Y-m-d H:i:s');
        $days = jssupportticket::$_config['reopen_ticket_within_days'];
        $date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($lastreply)) . " +" . $days . " day"));
        if ($date < date_i18n('Y-m-d H:i:s'))
            return false;
        else
            return true;
    }

    function reopenTicket($data) {
        $ticketid = $data['ticketid'];
        $lastreply = isset($data['lastreplydate']) ? $data['lastreplydate'] : '';
        if (!is_numeric($ticketid))
            return false;
        /* check can a ticket be opened with in the given days */
        if ($this->checkCanReopenTicket($ticketid)) {
            $sendEmail = true;
            $date = date_i18n('Y-m-d H:i:s');
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET status = 0 , updated = '" . $date . "' WHERE id = " . $ticketid;
            jssupportticket::$_db->query($query);
            if (jssupportticket::$_db->last_error == null) {
                JSSTmessage::setMessage(__('Ticket reopened', 'js-support-ticket'), 'updated');
                $messagetype = __('Successfully', 'js-support-ticket');
            } else {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
                JSSTmessage::setMessage(__('Ticket has not been reopened', 'js-support-ticket'), 'error');
                $messagetype = __('Error', 'js-support-ticket');
                $sendEmail = false;
            }
        } else {
            JSSTmessage::setMessage(__('TICKET_REOPEN_TIME_LIMIT_END', 'js-support-ticket'), 'error');
        }


        return;
    }

    function updateTicketStatusCron() {
        // close ticket
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_tickets` SET status = 4 WHERE date(DATE_ADD(lastreply,INTERVAL " . jssupportticket::$_config['ticket_auto_close'] . " DAY)) < CURDATE() AND isanswered = 1";
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
    }

    function validateTicketDetailForUser($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT uid FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $id;
        $uid = jssupportticket::$_db->get_var($query);

        if ($uid == get_current_user_id()) {
            return true;
        } else {
            return false;
        }
    }

    function checkActionStatusSame($id, $array) {
        switch ($array['action']) {
            case 'priority':
                $result = jssupportticket::$_db->get_var('SELECT COUNT(id) FROM `' . jssupportticket::$_db->prefix . 'js_ticket_tickets` WHERE id = ' . $id . ' AND priorityid = ' . $array['id']);
                break;
            case 'closeticket':
                $result = jssupportticket::$_db->get_var('SELECT COUNT(id) FROM `' . jssupportticket::$_db->prefix . 'js_ticket_tickets` WHERE id = ' . $id . ' AND status = 4');
                break;
        }
        if ($result > 0) {
            return false;
        } else {
            return true;
        }
    }

    function getTicketidForVisitor($token) {
        include_once jssupportticket::$_path . 'includes/encoder.php';
        $encoder = new JSSTEncoder(jssupportticket::$_config['encoder_key']);
        $decryptedtext = $encoder->decrypt($token);
        $array = json_decode($decryptedtext, true);
        $emailaddress = $array['emailaddress'];
        $trackingid = $array['trackingid'];
        $query = "SELECT id FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE email = '" . $emailaddress . "' AND ticketid = '" . $trackingid . "'";
        $ticketid = jssupportticket::$_db->get_var($query);
        return $ticketid;
    }

    function createTokenByEmailAndTrackingId($emailaddress, $trackingid) {
        include_once jssupportticket::$_path . 'includes/encoder.php';
        $encoder = new JSSTEncoder(jssupportticket::$_config['encoder_key']);
        $token = $encoder->encrypt(json_encode(array('emailaddress' => $emailaddress, 'trackingid' => $trackingid)));
        return $token;
    }
    
    function validateTicketDetailForVisitor($id) {
        if (!isset($_SESSION['js-support-ticket']['token'])) {
            return false;
        }
        $token = $_SESSION['js-support-ticket']['token'];
        include_once jssupportticket::$_path . 'includes/encoder.php';
        $encoder = new JSSTEncoder();
        $decryptedtext = $encoder->decrypt($token);
        $array = json_decode($decryptedtext, true);
        $emailaddress = $array['emailaddress'];
        $trackingid = $array['trackingid'];
        $query = "SELECT id FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE email = '" . $emailaddress . "' AND ticketid = '" . $trackingid . "'";
        $ticketid = jssupportticket::$_db->get_var($query);

        if ($ticketid == $id) {
            return true;
        } else {
            return false;
        }
    }
    function getAttachmentByTicketId($id){
        if(!is_numeric($id)) return false;
        $query = "SELECT attachment.filename , ticket.attachmentdir 
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_attachments` AS attachment
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket ON ticket.id = attachment.ticketid AND ticket.id =".$id. " AND attachment.replyattachmentid = 0 ";
        $attachments = jssupportticket::$_db->get_results($query);
        return $attachments;
    }

    static function generateHash($id){
        if(!is_numeric($id))
            return null;
        return base64_encode(json_encode(base64_encode($id)));
    }

    function getUIdById($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT uid FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $id;
        $ticketuid = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $ticketuid;
    }

    function getNotificationIdById($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT notificationid FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $id;
        $notificationid = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $notificationid;
    }
    
}

?>
