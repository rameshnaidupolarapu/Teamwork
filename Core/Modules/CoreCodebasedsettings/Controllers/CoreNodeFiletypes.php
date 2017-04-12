<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreNodeFiletypes
 *
 * @author ramesh
 */
namespace Core\Modules\CoreCodebasedsettings\Controllers;
use \Core\Controllers\NodeController;
class CoreNodeFiletypes extends NodeController
{
    //put your code here
    public function getStructureAction()
    {
        $requestedData=$this->_requestedData;
        $nodeName=$requestedData['core_node_settings_id'];
        $defaultValue=$requestedData[$requestedData['idname']];
        $result=array();
        $i=0;
        if($nodeName)
        {
            $node= new \Core\Model\Node();
            $node->setNodeName($nodeName);
            if(\Core::countArray($node->_NodeFieldAttributes)>0)
            {
                foreach ($node->_NodeFieldAttributes as $key=>$type)
                {
                    if($type=='file')
                    {
                        $result[$i]['pid']=$key;
                        $result[$i]['pds']=$this->getLabel($key);
                        $i++;
                    }
                }
            }
        }        
        $attributeType="select";        
        $attributeDetails=new \Core\Attributes\LoadAttribute($attributeType);				
        $attributeClass="\Core\Attributes\\".$attributeDetails->_attributeName;
        $attribute=new $attributeClass;
        $attribute->setIdName($requestedData['idname']);
        $attribute->setOptions($result);
        $attribute->setValue($defaultValue);        
        $attribute->loadAttributeTemplate($attributeType,$requestedData['idname']);
    }
    public function coreNodeFiletypesAfterDataUpdate()
    {    
        $requestedData=$this->_requestedData;
        $nodeName= \Core::getValueFromArray($requestedData, 'core_node_settings_id');
        $cache=new \Core\Cache\Refresh();
        $cache->setNodeName($nodeName);
        $cache->setFilePath();
        return true;
    }
    
}
