<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of From
 *
 * @author venkatesh
 */
namespace Core\Block;
use \Core\Block\Block;
class From extends Block 
{
    public $_accordionList=array();
    public $_defaultAcdAttributes=array();
    public $_accordionFields=array();
    public $_tabList=array();
    public $_tabFields=array();
    //put your code here
    public function getFromTabs()
    {
        $controllerObj=$this->_controllerObj;
        $this->getFormSettings($controllerObj->_nodeName,$controllerObj->_currentNodeModule,$controllerObj->_currentAction);  
        $this->_defaultAcdAttributes=$controllerObj->_showAttributes;
        $this->setFormTemplateAttributes();
    }
    function getFormSettings($node,$module,$action)
    {
        $blockProperties=[];
        $fileName=\Core::createFolder("","C").$action."Templates/".\Core::convertStringToFileName($module)."/".\Core::convertStringToFileName($node)."_".$action.".xml";
        if(\Core::fileExists($fileName))
        {
            $layoutContent=\Core::getFileContent($fileName);
            $blockProperties=\Core::processXmlData($layoutContent,'//accordion');
            $blockProperties=$this->sortXmlTagData($blockProperties);  
            $this->_accordionList=$blockProperties;
            $blockProperties=\Core::processXmlData($layoutContent,'//tab');
            $blockProperties=$this->sortXmlTagData($blockProperties);  
            $this->_tabList=$blockProperties;
        }        
    }
    function sortXmlTagData($blockProperties)
    {      
        for($i=0;$i<count($blockProperties);$i++)
        {
            for($j=$i;$j<count($blockProperties);$j++)
            {
                $fsortvalue=isset($blockProperties[$i]['@attributes']['sort_value'])?$blockProperties[$i]['@attributes']['sort_value']:"0";
                $ssortvalue=isset($blockProperties[$j]['@attributes']['sort_value'])?$blockProperties[$j]['@attributes']['sort_value']:"0";
                if($fsortvalue>$ssortvalue)
                {
                    $temp = $blockProperties[$i];
                    $blockProperties[$i] = $blockProperties[$j];
                    $blockProperties[$j] = $temp;                    
                }                
            }
        }
        return $blockProperties;
    }
    function setFormTemplateAttributes()
    {
        if(\Core::countArray($this->_accordionList)>0)
        {
            foreach ($this->_accordionList as $accordionData)
            {
                $defaultfields=isset($accordionData['@attributes']['defaultfields'])?$accordionData['@attributes']['defaultfields']:"0";
                $acdname=$accordionData['@attributes']['name'];
                if($defaultfields>0)
                {
                    $nodeModel=\CoreClass::getModel("core_form_layout");
                    $nodeModel->addCustomFieldToSelect("core_form_layout.id", "id");
                    $nodeModel->addCustomFieldToSelect("core_form_layout.filedname", "filedname");
                    $nodeModel->addCustomJoin("core_form_settings_id", "core_form_settings", "core_form_settings_id", "core_form_settings_id.id=core_form_layout.core_form_settings_id");
                    $nodeModel->addCustomFilter("core_form_settings_id.code='".$acdname."'");
                    $nodeModel->setCustomOrderBy();
                    $nodeModel->addCustomOrderBy("core_form_layout.sort_value");
                    $nodeModel->setCustomGroupBy();
                    $nodeModel->removeTotalCollection();
                    $nodeModel->getCollection();
                    
                    if(\Core::countArray($nodeModel->_collections)>0)
                    {
                        foreach ($nodeModel->_collections as $record)
                        {
                            $this->_defaultAcdAttributes=array_diff($this->_defaultAcdAttributes, array($record['filedname']));
                            $this->_accordionFields[$acdname][]=$record['filedname'];
                        }
                    }
                }                
            }
        }
        if(\Core::countArray($this->_tabList)>0)
        {
            foreach ($this->_tabList as $tabData)
            {
                $defaultfields=isset($tabData['@attributes']['defaultfields'])?$tabData['@attributes']['defaultfields']:"0";
                $tabname=$tabData['@attributes']['name'];
                if($defaultfields>0)
                {
                    $nodeModel=\CoreClass::getModel("core_form_layout");
                    $nodeModel->addCustomFieldToSelect("core_form_layout.id", "id");
                    $nodeModel->addCustomFieldToSelect("core_form_layout.filedname", "filedname");
                    $nodeModel->addCustomJoin("core_form_settings_id", "core_form_settings", "core_form_settings_id", "core_form_settings_id.id=core_form_layout.core_form_settings_id");
                    $nodeModel->addCustomFilter("core_form_settings_id.code='".$tabname."'");
                    $nodeModel->setCustomOrderBy();
                    $nodeModel->addCustomOrderBy("core_form_layout.sort_value");
                    $nodeModel->setCustomGroupBy();
                    $nodeModel->removeTotalCollection();
                    $nodeModel->getCollection();
                    
                    if(\Core::countArray($nodeModel->_collections)>0)
                    {
                        foreach ($nodeModel->_collections as $record)
                        {
                            $this->_defaultAcdAttributes=array_diff($this->_defaultAcdAttributes, array($record['filedname']));
                             $this->_tabFields[$tabname][]=$record['filedname'];
                        }
                    }
                }                
            }
        }
    }
}
