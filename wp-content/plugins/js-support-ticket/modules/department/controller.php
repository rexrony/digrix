<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTdepartmentController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'departments');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_departments':
                    JSSTincluder::getJSModel('department')->getDepartments();
                    break;
                case 'admin_adddepartment':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    JSSTincluder::getJSModel('department')->getDepartmentForForm($id);
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'department');
            JSSTincluder::include_file($layout, $module);
        }
    }

    function canaddfile() {
        if (isset($_POST['form_request']) && $_POST['form_request'] == 'jssupportticket')
            return false;
        elseif (isset($_GET['action']) && $_GET['action'] == 'jstask')
            return false;
        else
            return true;
    }

    static function savedepartment() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('department')->storeDepartment($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=department&jstlay=departments");
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'departments', 'jstlay'=>'departments'));
        }
        wp_redirect($url);
        exit;
    }

    static function deletedepartment() {
        $nonce = JSSTrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-department') ) {
            die( 'Security check Failed' );
        }
        $id = JSSTrequest::getVar('departmentid');
        JSSTincluder::getJSModel('department')->removeDepartment($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=department&jstlay=departments");
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'departments', 'jstlay'=>'departments'));
        }
        wp_redirect($url);
        exit;
    }

    static function changestatus() {
        $nonce = JSSTrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'change-status') ) {
            die( 'Security check Failed' );
        }
        $id = JSSTrequest::getVar('departmentid');
        JSSTincluder::getJSModel('department')->changeStatus($id);
        $url = admin_url("admin.php?page=department&jstlay=departments");
        if ($pagenum)
            $url .= '&pagenum=' . $pagenum;
        wp_redirect($url);
        exit;
    }

    static function ordering() {
        $nonce = JSSTrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'ordering') ) {
            die( 'Security check Failed' );
        }
        $id = JSSTrequest::getVar('departmentid');
        JSSTincluder::getJSModel('department')->setOrdering($id);
        $pagenum = JSSTrequest::getVar('pagenum');
        $url = "admin.php?page=department&jstlay=departments";
        if ($pagenum)
            $url .= '&pagenum=' . $pagenum;
        wp_redirect($url);
        exit;
    }

}

$departmentController = new JSSTdepartmentController();
?>
