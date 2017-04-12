<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreRelationType
 *
 * @author ramesh
 */

namespace Core\Modules\CoreDevelopmentsettings\Controllers;

use \Core\Controllers\NodeController;

class CoreRelationType extends NodeController {

    //p ut your code here
    private $_name = NULL;
    private $_short_code = NULL;

    public function setRelationTypeName($name) {
        $this->_name = $name;
    }

    public function getRelationTypeName() {
        return $this->_name;
    }

    public function setRelationTypeShortCode($short_code) {
        $this->_short_code = $short_code;
    }

    public function getRelationTypeShortCode() {
        return $this->_short_code;
    }

    public function dataSave() {
        try {
            $cc = new \CoreClass();
            $db1 = $cc->getObject("\Core\DataBase\ProcessQuery");
            $db1->setTable("core_relation_type");
            $db1->addField("id");
            $db1->addWhere("short_code='" . $this->getRelationTypeShortCode() . "'");
            $registernodeid = $db1->getValue();
            $db = $cc->getObject("\Core\DataBase\ProcessQuery");
            $db->setTable("core_relation_type");
            $db->addFieldArray(array("name" => $this->getRelationTypeName()));
            $db->addFieldArray(array("short_code" => $this->getRelationTypeShortCode()));
            $db->addFieldArray(array("updatedat" => \Core::getDateTime()));
            if ($registernodeid) {
                $db->addWhere("short_code='" . $this->getRelationTypeShortCode() . "'");
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
