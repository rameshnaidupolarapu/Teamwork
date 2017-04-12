<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreProfile
 *
 * @author venkatesh
 */
 namespace Core\Modules\CoreUsermanagement\Attribute;
 use \Core\Attributes\Setup;
class CoreProfile extends Setup
{
    //put your code here
    function execute()
    {
        $this->updateAttribute("attribute_user_count","User Count","text");
    }
    function updateAttribute($attributeCode,$attributeName,$attributeType) {
        $this->_attributeName=$attributeName;
        $this->_attributeCode=$attributeCode;
        $this->_attributeType=$attributeType;        
        $this->addAttribute();
        $cc = new \CoreClass();
        $dp = $cc->getObject("\Core\DataBase\ProcessQuery");
        $dp->setTable("core_node_attribute_option");
        $dp->addField("id");
        $dp->addWhere("core_attribute_option_id='" . $this->_attributeCode . "'");
        $dp->buildSelect();
        $existingRow = $dp->getRow();
        
        $dp = $cc->getObject("\Core\DataBase\ProcessQuery");
        $dp->setTable("core_node_attribute_option");
        $dp->addFieldArray(array("core_attribute_name"=>$this->_attributeName));
        $dp->addFieldArray(array("core_attribute_option_id"=>$this->_attributeCode));
        $dp->addFieldArray(array("core_node_settings_id"=>"core_profile"));
        if(count($existingRow)>0)
        {
            $dp->addWhere("id='" . $existingRow['id'] . "'");
            $dp->buildUpdate();
        }
        else
        {
            $dp->buildInsert();
        }
        $recordId=$dp->executeQuery();
        
    }
}
