<?php

class JSSTpremiumpluginController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $module = "premiumplugin";
        if ($this->canAddLayout()) {
            $layout = JSSTrequest::getVar('jstlay', null, 'admin_step1');
            switch ($layout) {
                case 'admin_step1':
                    jssupportticket::$_data['versioncode'] = JSSTincluder::getJSModel('configuration')->getConfigurationByConfigName('versioncode');
                    jssupportticket::$_data['productcode'] = JSSTincluder::getJSModel('configuration')->getConfigurationByConfigName('productcode');
                    jssupportticket::$_data['producttype'] = JSSTincluder::getJSModel('configuration')->getConfigurationByConfigName('producttype');
                break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'premiumplugin');
            JSSTincluder::include_file($layout, $module);
        }
    }

    function canAddLayout() {
        if (isset($_POST['form_request']) && $_POST['form_request'] == 'jssupportticket')
            return false;
        elseif (isset($_GET['action']) && $_GET['action'] == 'jstask')
            return false;
        else
            return true;
    }
}


$JSSTpremiumpluginController = new JSSTpremiumpluginController();
 
?>