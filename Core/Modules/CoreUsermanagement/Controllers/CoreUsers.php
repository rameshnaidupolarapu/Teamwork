<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreUsers
 *
 * @author ramesh
 */
namespace Core\Modules\CoreUsermanagement\Controllers;
use Core\Controllers\NodeController;
class CoreUsers extends NodeController {

    //put your code here
    function checkSession() {
        if ($this->_currentAction != 'validateLogin' && $this->_currentAction != 'logout' && $this->_currentAction != 'login') {
            parent::checkSession();
        }
        return true;
    }

    function validateLoginAction() {
        $requestedData = $this->_requestedData;
        $errorsArray = array();
        $Url = $this->_websiteHostUrl . $this->_currentAction;
        if (trim($requestedData['username']) == "") {
            $errorsArray['username'] = " Please Enter User Name";
        }
        if (trim($requestedData['userpassword']) == "") {
            $errorsArray['userpassword'] = " Please Enter Password";
        }
        if (count($errorsArray) > 0) {
            $output['status'] = "error";
        } else {
            if (!$this->userLoginCheck()) {
                $output['status'] = "error";
                $errorsArray['username'] = "Enter Valid Credentials";
            } else {
                $Url = $this->_websiteAdminUrl;
                $output['status'] = "success";
            }
        }
        $output['errors'] = $errorsArray;
        $output['redirecturl'] = $Url;
        echo json_encode($output);
        exit;
    }

    function userLoginCheck() {
        global $rootObj;
        $ws = $rootObj;
        $cc=new \CoreClass();
        $cp = $cc->getObject("\Core\CodeProcess");
        $identifier = $cp->convertEncryptDecrypt('encrypt', $ws->websiteAdminUrl);
        if (ADMINPASS == $this->_requestedData['userpassword'] && ADMINNAME == $this->_requestedData['username']) {
            if (!isset($_SESSION)) {
                session_start();
            }
            $cp = $cc->getObject("\Core\CodeProcess");
            $identifier = $cp->convertEncryptDecrypt('encrypt', $ws->websiteAdminUrl);
            $_SESSION[$identifier]['profile_id'] = "ROOT";
            $_SESSION[$identifier]['name'] = "Ramesh";
            $_SESSION[$identifier]['user_id'] = 0;
            $_SESSION[$identifier]['_lastactivity'] = time();
        } else {
            $db =$cc->getObject("\Core\DataBase\ProcessQuery");
            $db->setTable($this->_tableName);
            $db->addField("*");
            $db->addWhere("username='" . $this->_requestedData['username'] . "' and password='" . $_REQUEST['userpassword'] . "'");
            $db->buildSelect();

            $userData = $db->getRow();
            if (count($userData) > 0) {
                $_SESSION[$identifier]['profile_id'] = $userData['core_profile_id'];
                $_SESSION[$identifier]['name'] = $userData['name'];
                $_SESSION[$identifier]['user_id'] = $userData['id'];
                $_SESSION[$identifier]['image'] = $userData['user_image'];
                $_SESSION[$identifier]['last_activity'] = time();

                $ipAddress = $_SERVER['REMOTE_ADDR'];
                if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
                    $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
                }

                $db =$cc->getObject("\Core\DataBase\ProcessQuery");
                $db->setTable("core_loginhistory");
                $db->addFieldArray(array("core_user_id" => $userData['id']));
                $db->addFieldArray(array("name" => $userData['name']));
                $db->addFieldArray(array("datetime" => date('Y-m-d H:i:s')));
                $db->addFieldArray(array("host" => $ipAddress));
                $db->addFieldArray(array("sesssionid" => session_id()));
                $db->addFieldArray(array("createdat" => date('Y-m-d H:i:s')));
                $db->addFieldArray(array("updatedat" => date('Y-m-d H:i:s')));
            } else {
                return false;
            }
        }
        session_write_close();
        return true;
    }

    public function logoutAction() {
        $sm = new \Core\Session();
        $sm->destroySession();
        global $rootObj;
        $wp = $rootObj;
        \Core::redirectUrl($wp->websiteAdminUrl . "core_users/login");
    }

    public function loginAction() {
        $block = new \Core\Block\Block($this);
        $block->setBlockName("loginblock");
        $block->setTemplate("login");
        $block->execute();
    }

    public function changepasswordAction() {
        $this->getAdminLayout();
        $this->renderLayout();
    }

    public function savepasswordAction() {
        $cc=new \CoreClass();
        $backUrl = $this->_websiteAdminUrl;
        $requestedData = $this->_requestedData;
        $currentpassword = $requestedData['currentpassword'];
        $newpassword = $requestedData['newpassword'];
        $renewpassword = $requestedData['renewpassword'];
        $errorsArray = array();
        $status = "success";
        if ($currentpassword == "") {
            $status = "error";
            $errorsArray['currentpassword'] = "Please Current Password";
        }
        if ($newpassword == "") {
            $status = "error";
            $errorsArray['newpassword'] = "Please New Password";
        }
        if ($renewpassword == "") {
            $status = "error";
            $errorsArray['renewpassword'] = "Please Re-New Password";
        }
        if ($newpassword != $renewpassword) {
            $status = "error";
            $errorsArray['renewpassword'] = "Password is Mismatch";
        }
        $sm = new Core_Session();
        $sessionData = $sm->getSessionData();
        $db =$cc->getObject("\Core\DataBase\ProcessQuery");
        $db->setTable($this->_tableName);
        $db->addField("*");
        $db->addWhere("id='" . $sessionData['user_id'] . "' and password='" . $currentpassword . "'");
        $db->buildSelect();
        $userData = $db->getRow();
        if (count($userData) == 0) {
            $status = "error";
            $errorsArray['currentpassword'] = "Please Enter Current Valid Password";
        }
        if ($status == 'success') {
           $db =$cc->getObject("\Core\DataBase\ProcessQuery");
            $db->setTable($this->_tableName);
            $db->addFieldArray(array("password" => $renewpassword));
            $db->addWhere("id='" . $sessionData['user_id'] . "'");
            $db->buildUpdate();
            $db->executeQuery();
        }
        $output['status'] = $status;
        $output['errors'] = $errorsArray;
        $output['redirecturl'] = $backUrl;
        echo json_encode($output);
        exit;
    }
}