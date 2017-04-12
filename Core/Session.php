<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Session
 *
 * @author ramesh
 */
namespace Core;
class Session {

    private $siteObject;
    private $_sessionExists;
    public $_isProcessActive = 0;
    public $_api = 0;
    public $_identifier;
    public $_cp;
    function __construct() {
        global $rootObj;
        $this->siteObject =$rootObj;
        $cc = new \CoreClass();
        $this->_cp=$cc->getObject("\Core\CodeProcess");
        $identifier = $this->_cp->convertEncryptDecrypt('encrypt', $this->siteObject->websiteAdminUrl);
        $this->_identifier = $identifier;
    }

    public function setApi($apiValue) {
        $this->_api = $apiValue;
    }

    public function setProcessActive($active=1) {
        $this->_isProcessActive = $active;
    }

    private function checkSession() {
        global $actionRequestFrom;
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        
        if($actionRequestFrom=='admin')
        {
            $identifier = $this->_cp->convertEncryptDecrypt('encrypt', $this->siteObject->websiteAdminUrl);
        }
        else 
        {
            $identifier = $this->_cp->convertEncryptDecrypt('encrypt', $this->siteObject->websiteUrl);
        }
        if (\Core::keyInArray('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        }
        $_SESSION[$identifier]['ipaddress'] = $ipAddress;
        if (\Core::keyInArray("profile_id", $_SESSION[$identifier])) {
            $_SESSION[$identifier]['_lastactivity'] = strtotime(date('Y-m-d H:i:s'));
            $this->_sessionExists = true;
        } else {
            $this->_sessionExists = false;
        }
    }
    private function checkFrontendSession() {
        global $actionRequestFrom;
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        
        
        $identifier = $this->_cp->convertEncryptDecrypt('encrypt', $this->siteObject->websiteUrl);
        
        
        $_SESSION[$identifier]['ipaddress'] = $ipAddress;
        $_SESSION[$identifier]['_lastactivity'] = strtotime(date('Y-m-d H:i:s'));
        $this->_sessionExists = true;       
    }

    public function getSessionMaganager() 
    {
        global $actionRequestFrom;
        
        if($actionRequestFrom=='admin')
        {
            $identifier = $this->_cp->convertEncryptDecrypt('encrypt', $this->siteObject->websiteAdminUrl);
        }
        else 
        {
            $identifier = $this->_cp->convertEncryptDecrypt('encrypt', $this->siteObject->websiteUrl);
        }
        $this->checkSession();
        if ($this->_sessionExists) {
            if (is_array($_SESSION[$identifier])) {
                return $_SESSION[$identifier];
            } else {

                if ($actionRequestFrom == 'admin') {
                    global  $rootObj;
                    $wp = $rootObj;
                    \Core::redirectUrl($wp->websiteAdminUrl . "core_users/logout");
                }
            }
        } 
		else 
		{
            if ($this->_api == 1) 
			{
                
            } else {
                if ($actionRequestFrom == 'admin') {
                    global  $rootObj;
                    $wp = $rootObj;
                    \Core::redirectUrl($wp->websiteAdminUrl . "core_users/logout");
                }
            }
        }
    }

    public function getSessionData() {
        global $actionRequestFrom;
        if($actionRequestFrom=='admin')
        {
            $identifier = $this->_cp->convertEncryptDecrypt('encrypt', $this->siteObject->websiteAdminUrl);
        }
        else 
        {
            $identifier = $this->_cp->convertEncryptDecrypt('encrypt', $this->siteObject->websiteUrl);
        }
        $this->checkSession();
        if ($this->_sessionExists) {
            return $_SESSION[$identifier];
        } else {
            return FALSE;
        }
    }

    public function destroySession() {
        
        $identifier = $this->_cp->convertEncryptDecrypt('encrypt', $this->siteObject->websiteAdminUrl);
        unset($_SESSION[$identifier]);
    }
    public function destroyFrontendSession() {
        $identifier = $this->_cp->convertEncryptDecrypt('encrypt', $this->siteObject->websiteUrl);
        unset($_SESSION[$identifier]);
    }
    public function getFrontendSession()
    {
        $identifier = $this->_cp->convertEncryptDecrypt('encrypt', $this->siteObject->websiteUrl);
        $this->checkFrontendSession();
        return \Core::getValueFromArray($_SESSION,$identifier);
    }
    public function setFrontendSessionValue($key,$value)
    {        
        $identifier = $this->_cp->convertEncryptDecrypt('encrypt', $this->siteObject->websiteUrl);
        $this->checkFrontendSession();
        $_SESSION[$identifier][$key]=$value;
        return true;
    }
    public function getFrontendSessionValue($key)
    {
        $identifier = $this->_cp->convertEncryptDecrypt('encrypt', $this->siteObject->websiteUrl);
        $this->checkFrontendSession();
        return \Core::getValueFromArray($_SESSION[$identifier],$key);        
    }
    public function removeFrontendSessionValue($key)
    {
        $identifier = $this->_cp->convertEncryptDecrypt('encrypt', $this->siteObject->websiteUrl);
        $this->checkFrontendSession();
        unset($_SESSION[$identifier][$key]);
    }
}
