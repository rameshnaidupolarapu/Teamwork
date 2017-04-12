<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreElementDisplaytype
 *
 * @author venkatesh
 */

namespace Core\Modules\CoreDevelopmentsettings\Controllers;

use \Core\Controllers\NodeController;

class CoreElementDisplaytype extends NodeController {

    //put your code here
    private $_name = NULL;
    private $_short_code = NULL;

    public function setElementDisplaytypeName($name) {
        $this->_name = $name;
    }

    public function getElementDisplaytypeName() {
        return $this->_name;
    }

    public function setElementDisplaytypeShortCode($code) {
        $this->_short_code = $code;
    }

    public function getElementDisplaytypeShortCode() {
        return $this->_short_code;
    }

    public function dataSave() {
        try {
            $cc = new \CoreClass();
            $db1 = $cc->getObject("\Core\DataBase\ProcessQuery");
            $db1->setTable("core_element_displaytype");
            $db1->addField("id");
            $db1->addWhere("short_code='" . $this->getElementDisplaytypeShortCode() . "'");
            $registernodeid = $db1->getValue();
            $db = $cc->getObject("\Core\DataBase\ProcessQuery");
            $db->setTable("core_element_displaytype");
            $db->addFieldArray(array("name" => $this->getElementDisplaytypeName()));
            $db->addFieldArray(array("short_code" => $this->getElementDisplaytypeShortCode()));
            $db->addFieldArray(array("updatedat" => \Core::getDateTime()));
            if ($registernodeid) {
                $db->addWhere("short_code='" . $this->getElementDisplaytypeShortCode() . "'");
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
