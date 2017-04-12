<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreUniquefieldset
 *
 * @author ramesh
 */
namespace Core\Modules\CoreDevelopmentsettings\Controllers;
use \Core\Controllers\NodeController;
class CoreUniquefieldset extends NodeController
{
    //put your code here
    public function coreUniquefieldsetAfterDataUpdate()
    {        
        $cache=new Core_Cache_Refresh();
        $cache->setNodeName($this->_requestedData['core_node_settings_id']);
        $cache->setUniqueSetValues();         
        return TRUE;  
    }
    public function getStructureAction()
    {
        $requestedData=$this->_requestedData;
        $defaultValue=$requestedData['uniquefieldset'];
        $np=new Core_Model_NodeProperties();
        $np->setNode($requestedData['core_node_settings_id']);
        $nodestructure=$np->currentNodeStructure();
        
        $tb=new Core_Model_TableStructure();
        $tb->setTable($nodestructure['tablename']);
        $tableStructure=$tb->getStructure();
        $tableStructure=\Core::getKeysFromArray($tableStructure);
        $tableStructure=\Core::diffArray($tableStructure, $this->_defaulthideAttributes);
        
        $result=array();
        $i=0;
        foreach ($tableStructure as $key) 
        {
            $result[$i]['pid']=$key;
            $result[$i]['pds']=$this->getLabel($key);
            $i++;
        }
        $attributeType="checkbox";        
        $attributeDetails=new Core_Attributes_LoadAttribute($attributeType);				
        $attributeClass=Core_Attributes_.$attributeDetails->_attributeName;
        $attribute=new $attributeClass;
        $attribute->setIdName($requestedData['idname']);
        $attribute->setOptions($result);
        $attribute->setValue($defaultValue);        
        $attribute->loadAttributeTemplate($attributeType,$requestedData['idname']);
    }
}
