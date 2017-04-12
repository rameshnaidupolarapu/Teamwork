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

class CoreRootAttributes extends NodeController {

    private $_attributeName = NULL;
    private $_attributecode = NULL;

    public function getAttributeName() {
        return $this->_attributeName;
    }

    public function setAttributeName($attributeName) {
        $this->_attributeName = $attributeName;
    }

    public function getAttributeCode() {
        return $this->_attributecode;
    }

    public function setAttributeCode($attributeCode) {
        $this->_attributecode = $attributeCode;
    }

    public function dataSave() {
        try {

            $cc = new \CoreClass();
            $db1 = $cc->getObject("\Core\DataBase\ProcessQuery");
            $db1->setTable("core_root_attributes");
            $db1->addField("id");
            $db1->addWhere("short_code='" . $this->_attributecode . "'");
            $registernodeid = $db1->getValue();
            $db = $cc->getObject("\Core\DataBase\ProcessQuery");
            $db->setTable("core_root_attributes");
            $db->addFieldArray(array("name" => $this->_attributeName));
            $db->addFieldArray(array("short_code" => $this->_attributecode));
            if ($registernodeid) {
                $db->addWhere("short_code='" . $this->_attributecode . "'");
                $db->buildUpdate();
            } else {
                $db->addFieldArray(array("createdat" => \Core::getDateTime()));
                $db->buildInsert();
            }
            $db->executeQuery();
        } catch (Exception $ex) {
            \Core::Log($ex->getMessage(), "installdata.log");
        }
    }

}
