<?php
namespace Core\Attributes\Setup;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Setup
 *
 * @author venkatesh
 */
class NodeAttribute extends \Core\Attributes\Setup 
{    
	public $_attributeNodeName;
	
	public function setAttributeNodeName($nodeName)
	{
		$this->_attributeNodeName=$nodeName;
	}
	public function getAttributeNodeName()
	{
		return $this->_attributeNodeName;
	}
	public function setAttributeName($attributeName)
	{
		$this->_attributeName=$attributeName;
	}
	public function getAttributeName()
	{
		return $this->_attributeName;
	}
	public function setAttributeCode($attributeCode)
	{
		$this->_attributeCode=$attributeCode;
	}
	public function getAttributeCode()
	{
		return $this->_attributeCode;
	}
	public function setAttributeType($attributeType)
	{
		$this->_attributeType=$attributeType;
	}
	public function getAttributeType()
	{
		return $this->_attributeType;
	}
	
    public function updateAttribute() 
	{      
        $this->addAttribute();
        $dp = new Core_DataBase_ProcessQuery();
        $dp->setTable("core_node_attribute_option");
        $dp->addField("id");
        $dp->addWhere("core_attribute_option_id='" . $this->_attributeCode . "'");
        $dp->buildSelect();
        $existingRow = $dp->getRow();
        
        $dp = new Core_DataBase_ProcessQuery();
        $dp->setTable("core_node_attribute_option");
        $dp->addFieldArray(array("core_attribute_name"=>$this->_attributeName));
        $dp->addFieldArray(array("core_attribute_option_id"=>$this->_attributeCode));
        $dp->addFieldArray(array("core_node_settings_id"=>$this->_attributeNodeName));
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
		return $recordId;
        
    }
}
