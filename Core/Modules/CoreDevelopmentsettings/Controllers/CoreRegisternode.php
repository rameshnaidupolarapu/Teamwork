<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreRegisternode
 *
 * @author ramesh
 */

namespace Core\Modules\CoreDevelopmentsettings\Controllers;

use \Core\Controllers\NodeController;

class CoreRegisternode extends NodeController {

    private $_nodeFileName = NULL;
    private $_nodeNameData = NULL;
    private $_displayValue = NULL;
    private $_is_module = NULL;
    private $_core_root_module_id = NULL;
    private $_core_module_id = NULL;
    private $_core_module_display_id = NULL;
    private $_sort_value = NULL;
    private $_icon = NULL;
    private $_menu = NULL;
    private $_is_notification = NULL;

    //put your code here
    public function coreRegisternodeCoreRootModuleIdFilter() {
        return $this->_nodeName . ".is_module='1' and (" . $this->_nodeName . ".core_root_module_id='' || " . $this->_nodeName . ".core_root_module_id is NULL ) ";
    }

    public function coreRegisternodeCoreModuleDisplayIdFilter() {
        return $this->_nodeName . ".is_module='1'";
    }

    public function coreRegisternodeCoreModuleIdFilter() {
        return $this->_nodeName . ".is_module='1'";
    }

    public function coreNodeSettingsCoreRegisternodeIdFilter() {
        return $this->_nodeName . ".is_module!='1'";
    }

    public function coreRegisternodeAfterDataUpdate() {
        $cc = new \CoreClass();
        $cache = $cc->getObject("\Core\Cache\Refresh");
        $cache->nodeFiles();
        return TRUE;
    }

    public function setNodeFileName($nodeFileName) {
        $this->_nodeFileName = $nodeFileName;
    }

    public function getNodeFileName() {
        return $this->_nodeFileName;
    }

    public function setNodeNameData($nodeNameData) {
        $this->_nodeNameData = $nodeNameData;
    }

    public function getNodeNameData() {
        return $this->_nodeNameData;
    }

    public function setDisplayValue($displayValue) {
        $this->_displayValue = $displayValue;
    }

    public function getDisplayValue() {
        return $this->_displayValue;
    }

    public function setIsModule($ismodule) {
        $this->_is_module = $ismodule;
    }

    public function getIsModule() {
        return $this->_is_module;
    }

    public function setRootModuleId($core_root_module_id) {
        $this->_core_root_module_id = $core_root_module_id;
    }

    public function getRootModuleId() {
        return $this->_core_root_module_id;
    }

    public function setModuleId($module_id) {
        $this->_core_module_id = $module_id;
    }

    public function getModuleId() {
        return $this->_core_module_id;
    }

    public function setModuleDisplayId($module_display_id) {
        $this->_core_module_display_id = $module_display_id;
    }

    public function getModuleDisplayId() {
        return $this->_core_module_display_id;
    }

    public function setSortValue($sort_value) {
        $this->_sort_value = $sort_value;
    }

    public function getSortValue() {
        return $this->_sort_value;
    }

    public function setIcon($icon) {
        $this->_icon = $icon;
    }

    public function getIcon() {
        return $this->_icon;
    }

    public function setMenu($menu) {
        $this->_menu = $menu;
    }

    public function getMenu() {
        return $this->_menu;
    }

    public function setIsNotification($is_notification) {
        $this->_is_notification = $is_notification;
    }

    public function getIsNotification() {
        return $this->_is_notification;
    }

    public function dataSave() {
        try {
            $cc = new \CoreClass();
            $db1 = $cc->getObject("\Core\DataBase\ProcessQuery");
            $db1->setTable("core_registernode");
            $db1->addField("id");
            $db1->addWhere("nodename='" . $this->getNodeNameData() . "'");
            $registernodeid = $db1->getValue();
            $db = $cc->getObject("\Core\DataBase\ProcessQuery");
            $db->setTable("core_registernode");
            $db->addFieldArray(array("nodefile" => $this->getNodeFileName()));
            $db->addFieldArray(array("nodename" => $this->getNodeNameData()));
            $db->addFieldArray(array("displayvalue" => $this->getDisplayValue()));
            $db->addFieldArray(array("is_module" => $this->getIsModule()));
            $db->addFieldArray(array("core_root_module_id" => $this->getRootModuleId()));
            $db->addFieldArray(array("core_module_id" => $this->getModuleId()));
            $db->addFieldArray(array("core_module_display_id" => $this->getModuleDisplayId()));
            $db->addFieldArray(array("sort_value" => $this->getSortValue()));
            $db->addFieldArray(array("icon" => $this->getIcon()));
            $db->addFieldArray(array("menu" => $this->getMenu()));
            $db->addFieldArray(array("is_notification" => $this->getIsNotification()));
            $db->addFieldArray(array("updatedat" => \Core::getDateTime()));
            if ($registernodeid) {
                $db->addWhere("nodename='" . $this->getNodeNameData() . "'");
                $db->buildUpdate();
            } else {
                $db->addFieldArray(array("createdat" => \Core::getDateTime()));
                $db->buildInsert();
            }
            $db->executeQuery();
        } catch (\Exception $ex) {
            \Core::Log($ex->getMessage(), "installdata.log");
        }
    }

}
