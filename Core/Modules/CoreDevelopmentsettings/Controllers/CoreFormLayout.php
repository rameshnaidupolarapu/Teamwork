<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreFormLayout
 *
 * @author ramesh
 */

namespace Core\Modules\CoreDevelopmentsettings\Controllers;

use \Core\Controllers\NodeController;

class CoreFormLayout extends NodeController {

    public $_core_node_settings_id = NULL;
    public $_code = NULL;
    public $_sortorder = NULL;
    public $_fieldName = NULL;

    //put your code here
    public function getStructureAction() {
        $requestedData = $this->_requestedData;
        $cc = new \CoreClass();
        $core_form_settings_id = $requestedData['core_form_settings_id'];
        $db = $cc->getObject("\Core\DataBase\ProcessQuery");
        $db->setTable("core_form_settings");
        $db->addField("core_node_settings_id");
        $db->addWhere("id='" . $core_form_settings_id . "'");
        $db->buildSelect();
        $nodeName = $db->getValue();
        $defaultValue = $requestedData[$requestedData['idname']];
        $np = new Core_Model_NodeProperties();
        $np->setNode($nodeName);
        $nodestructure = $np->currentNodeStructure();

        $tb = new Core_Model_TableStructure();
        $tb->setTable($nodestructure['tablename']);
        $tableStructure = $tb->getStructure();
        $tableStructure = \Core::getKeysFromArray($tableStructure);
        $tableStructure = \Core::diffArray($tableStructure, $this->_defaulthideAttributes);

        $result = array();
        $i = 0;
        foreach ($tableStructure as $key) {
            $result[$i]['pid'] = $key;
            $result[$i]['pds'] = $this->getLabel($key);
            $i++;
        }
        $attributeType = "select";
        $attributeDetails = new Core_Attributes_LoadAttribute($attributeType);
        $attributeClass = Core_Attributes_ . $attributeDetails->_attributeName;
        $attribute = new $attributeClass;
        $attribute->setIdName($requestedData['idname']);
        $attribute->setOptions($result);
        $attribute->setValue($defaultValue);
        $attribute->loadAttributeTemplate($attributeType, $requestedData['idname']);
    }

    public function setCoreNodeSettingsId($node) {
        $this->_core_node_settings_id = $node;
    }

    public function getCoreNodeSettingsId() {
        return $this->_core_node_settings_id;
    }

    public function setSettingsCode($settingsCode) {
        $this->_code = $settingsCode;
    }

    public function getSettingsCode() {
        return $this->_code;
    }

    public function setSortValue($sortValue) {
        $this->_sortorder = $sortValue;
    }

    public function getSortValue() {
        return $this->_sortorder;
    }

    public function setFiledName($fieldName) {
        $this->_fieldName = $fieldName;
    }

    public function getFiledName() {
        return $this->_fieldName;
    }

    public function dataSave() {
        try {
            $cc = new \CoreClass();
            $db1 = $cc->getObject("\Core\DataBase\ProcessQuery");
            $db1->setTable("core_form_settings");
            $db1->addField("id");
            $db1->addWhere("core_node_settings_id='" . $this->getCoreNodeSettingsId() . "'");
            $db1->addWhere("code='" . $this->getSettingsCode() . "'");
            $core_form_settingsid = $db1->getValue();
            if ($core_form_settingsid > 0) {
                $db1 = $cc->getObject("\Core\DataBase\ProcessQuery");
                $db1->setTable("core_form_layout");
                $db1->addField("id");
                $db1->addWhere("core_form_settings_id='" . $core_form_settingsid . "'");
                $db1->addWhere("filedname='" . $this->getFiledName() . "'");
                $core_form_layoutid = $db1->getValue();

                $db = $cc->getObject("\Core\DataBase\ProcessQuery");
                $db->setTable("core_form_layout");
                $db->addFieldArray(array("core_form_settings_id" => $core_form_settingsid));
                $db->addFieldArray(array("filedname" => $this->getFiledName()));
                $db->addFieldArray(array("sort_value" => $this->getSortValue()));
                $db->addFieldArray(array("updatedat" => \Core::getDateTime()));
                if ($core_form_layoutid) {
                    $db->addWhere("id='" . $core_form_layoutid . "'");
                    $db->buildUpdate();
                } else {
                    $db->addFieldArray(array("createdat" => \Core::getDateTime()));
                    $db->buildInsert();
                }
                $db->executeQuery();
            }
        } catch (Exception $ex) {
            \Core::Log(__METHOD__ . $ex->getMessage(), "installdata.log");
        }
    }

}
