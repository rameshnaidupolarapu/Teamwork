<?php

namespace Core\Attributes;

use \Core\Pages\PageLayout;

class Attribute extends PageLayout {

    public $_nodeName = NULL;
    public $_pkName = NULL;
    public $_onchange = NULL;
    public $_keyUp = NULL;
    public $_idName = NULL;
    public $_Value = NULL;
    public $_required = NULL;
    public $_readonly = NULL;
    public $_options = array();
    public $_action = NULL;
    public $_record = array();
    public $_multiedit = 0;
    public $_multiValues = 0;
    public $_filePath = NULL;
    public $_siteProperties;
    public $_isAjaxLoader = 0;

    function __construct() {
        global $rootObj;
        $this->_siteProperties = $rootObj;
    }

    public function setNodeName($nodeName) {
        $this->_nodeName = $nodeName;
    }

    public function setPkName($pkName) {
        $this->_pkName = $pkName;
    }

    public function setIdName($idName) {
        $this->_idName = $idName;
    }

    public function setIsAjaxLoader($flag) {
        $this->_isAjaxLoader = $flag;
    }

    public function setAction($action) {
        $this->_action = $action;
    }

    public function setFolderPath($path) {
        $this->_filePath = $path;
    }

    public function setValue($value) {
        $tempValue = $value;
        if ($tempValue) {
            $tempValue_list = \Core::convertStringToArray($tempValue, "|");
            if (count($tempValue_list) > 1) {
                $tempValue = $tempValue_list;
            }
        }
        $this->_Value = $tempValue;
    }

    public function setRequired() {
        $this->_required = "required";
    }

    public function setReadonly() {
        $this->_readonly = true;
    }

    function valiadte($action, $mode) {
        
    }

    function setRecord($record) {
        $this->_record = $record;
    }

    function setMultiEdit() {
        $this->_multiedit = 1;
    }

    function setMultiValues($flag) {
        if ($flag != 1) {
            $flag = 0;
        }
        $this->_multiValues = $flag;
    }

    public function setOptions($result) {
        $this->_options = $result;
    }

    public function setOnchange($param) {
        $this->_onchange.=$param;
    }

}

?>