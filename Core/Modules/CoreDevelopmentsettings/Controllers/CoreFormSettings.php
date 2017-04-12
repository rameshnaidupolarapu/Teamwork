<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreFormSettings
 *
 * @author ramesh
 */
namespace Core\Modules\CoreDevelopmentsettings\Controllers;
use \Core\Controllers\NodeController;
class CoreFormSettings extends  NodeController
{
    public $_core_node_settings_id=NULL;
    public $_core_element_displaytype_id=NULL;
    public $_name=NULL;
    public $_code=NULL;
    public $_parent=NULL;
    public $_parent_level=NULL;
    public $_sortorder=NULL;
    
    public function coreFormSettingsParentFilter() 
    {          
        $requestedData=$this->_requestedData;        
        return $this->_tableName.".core_node_settings_id='".$requestedData['core_node_settings_id']."'";
    }
    public function setCoreNodeSettingsId($node)
    {
        $this->_core_node_settings_id=$node;
    }
    public function getCoreNodeSettingsId()
    {
        return $this->_core_node_settings_id;
    }
    public function setCoreElementDisplaytypeId($elementdisplayid)
    {
        $this->_core_element_displaytype_id=$elementdisplayid;
    }
    public function getCoreElementDisplaytypeId()
    {
        return $this->_core_element_displaytype_id;
    }
    public function setSettingsName($settingsName)
    {
        $this->_name=$settingsName;
    }
    public function getSettingsName()
    {
        return $this->_name;
    }
    public function setSettingsCode($settingsCode)
    {
        $this->_code=$settingsCode;
    }
    public function getSettingsCode()
    {
        return $this->_code;
    }
    public function setCoreNodeParent($parent)
    {
        $this->_parent=$parent;
    }
    public function getCoreNodeParent()
    {
        return $this->_parent;
    }
    public function setCoreParentLevel($parent_level)
    {
        $this->_parent_level=$parent_level;
    }
    public function getCoreParentLevel()
    {
        return $this->_parent_level;
    }
    public function setSortValue($sortValue)
    {
        $this->_sortorder=$sortValue;
    }
    public function getSortValue()
    {
        return $this->_sortorder;
    }
    public function dataSave()
    {        
        try
        {
            $cc = new \CoreClass();
            $db1 = $cc->getObject("\Core\DataBase\ProcessQuery");
            $db1->setTable("core_form_settings");
            $db1->addField("id");
            $db1->addWhere("core_node_settings_id='".$this->getCoreNodeSettingsId()."'");
            $db1->addWhere("code='".$this->getSettingsCode()."'");
            $registernodeid=$db1->getValue();
            
            $db = $cc->getObject("\Core\DataBase\ProcessQuery"); 
            $db->setTable("core_form_settings");
            $db->addFieldArray(array("core_node_settings_id"=>$this->getCoreNodeSettingsId()));
            $db->addFieldArray(array("core_element_displaytype_id"=>$this->getCoreElementDisplaytypeId()));
            $db->addFieldArray(array("name"=>$this->getSettingsName()));
            $db->addFieldArray(array("code"=>$this->getSettingsCode()));
            $db->addFieldArray(array("parent"=>$this->getCoreNodeParent()));
            $db->addFieldArray(array("parent_level"=>$this->getCoreParentLevel()));
            $db->addFieldArray(array("sortorder"=>$this->getSortValue()));
            $db->addFieldArray(array("updatedat"=>\Core::getDateTime()));
            if($registernodeid)
            {
                $db->addWhere("id='".$registernodeid."'");
                $db->buildUpdate();
            }
            else
            {
                $db->addFieldArray(array("createdat"=>\Core::getDateTime()));
                $db->buildInsert();
            }           
            $db->executeQuery();        
        }
        catch(Exception $ex)
        {
            \Core::Log(__METHOD__.$ex->getMessage(),"installdata.log");
        }
    }
}