<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreNodeFieldattributes
 *
 * @author ramesh
 */

namespace Core\Modules\CoreDevelopmentsettings\Controllers;

use \Core\Controllers\NodeController;

class CoreNodeFieldattributes extends NodeController {

    //put your code here
    private $core_node_settings_id = NULL;
    private $fieldname = NULL;
    private $core_root_attribute_id = NULL;
    private $is_encrypt = NULL;

    public function getStructureAction() {
        $requestedData = $this->_requestedData;
        $defaultValue = $requestedData['fieldname'];
        $np = new Core_Model_NodeProperties();
        $np->setNode($requestedData['core_node_settings_id']);
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

    public function coreNodeFieldattributesAfterDataUpdate() {
        $cache = new Core_Cache_Refresh();
        $cache->setNodeName($this->_requestedData['core_node_settings_id']);
        $cache->setFieldAttributes();
        return TRUE;
    }

    public function setCoreNodeSettingsId($core_node_settings_id) {
        $this->core_node_settings_id = $core_node_settings_id;
    }

    public function getCoreNodeSettingsId() {
        return $this->core_node_settings_id;
    }

    public function setFieldname($fieldname) {
        $this->fieldname = $fieldname;
    }

    public function getFieldname() {
        return $this->fieldname;
    }

    public function setCoreRootAttributeId($core_root_attribute_id) {
        $this->core_root_attribute_id = $core_root_attribute_id;
    }

    public function getCoreRootAttributeId() {
        return $this->core_root_attribute_id;
    }

    public function setIsEncrypt($is_encrypt) {
        $this->is_encrypt = $is_encrypt;
    }

    public function getIsEncrypt() {
        return $this->is_encrypt;
    }

    public function dataSave() {
        try {
            $cc = new \CoreClass();
            $db1 = $cc->getObject("\Core\DataBase\ProcessQuery");
            $db1->setTable("core_node_fieldattributes");
            $db1->addField("id");
            $db1->addWhere("core_node_settings_id='" . $this->getCoreNodeSettingsId() . "'");
            $db1->addWhere("fieldname='" . $this->getFieldname() . "'");
            $registernodeid = $db1->getValue();
            $db = $cc->getObject("\Core\DataBase\ProcessQuery");
            $db->setTable("core_node_fieldattributes");
            $db->addFieldArray(array("core_node_settings_id" => $this->getCoreNodeSettingsId()));
            $db->addFieldArray(array("fieldname" => $this->getFieldname()));
            $db->addFieldArray(array("core_root_attribute_id" => $this->getCoreRootAttributeId()));
            $db->addFieldArray(array("is_encrypt" => $this->getIsEncrypt()));
            $db->addFieldArray(array("updatedat" => \Core::getDateTime()));
            if ($registernodeid) {
                $db->addWhere("id='" . $registernodeid . "'");
                $db->buildUpdate();
            } else {
                $db->addFieldArray(array("createdat" => \Core::getDateTime()));
                $db->buildInsert();
            }
            $db->executeQuery();
        } catch (Exception $ex) {
            \Core::Log(__METHOD__ . $ex->getMessage(), "installdata.log");
        }
    }

}
