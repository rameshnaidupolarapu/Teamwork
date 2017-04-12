<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreNodeSettings
 *
 * @author venkatesh
 */
namespace Core\Modules\CoreDevelopmentsettings\Data\V102;
class CoreNodeSettings 
{
    //put your code here
    //put your code here
    public function execute()
    {
        try
        { 
            $Controller=  \CoreClass::getController("core_form_settings","core_developmentsettings");
            $Controller->setCoreNodeSettingsId("core_node_settings");
            $Controller->setCoreElementDisplaytypeId("ACRD");
            $Controller->setSettingsName("Mandatory Settings");
            $Controller->setSettingsCode("mandatory_settings");
            $Controller->setCoreNodeParent("");
            $Controller->setCoreParentLevel("1");
            $Controller->setSortValue("1");
            $Controller->dataSave(); 
            
            $Controller->setCoreNodeSettingsId("core_node_settings");
            $Controller->setCoreElementDisplaytypeId("ACRD");
            $Controller->setSettingsName("Hide Settings");
            $Controller->setSettingsCode("hide_settings");
            $Controller->setCoreNodeParent("");
            $Controller->setCoreParentLevel("1");
            $Controller->setSortValue("2");
            $Controller->dataSave(); 
            
            $Controller->setCoreNodeSettingsId("core_node_settings");
            $Controller->setCoreElementDisplaytypeId("ACRD");
            $Controller->setSettingsName("Input Type Settings");
            $Controller->setSettingsCode("inputtype_settings");
            $Controller->setCoreNodeParent("");
            $Controller->setCoreParentLevel("1");
            $Controller->setSortValue("3");
            $Controller->dataSave();
            
            $Controller->setCoreNodeSettingsId("core_node_settings");
            $Controller->setCoreElementDisplaytypeId("ACRD");
            $Controller->setSettingsName("Readonly Settings");
            $Controller->setSettingsCode("readonly_settings");
            $Controller->setCoreNodeParent("");
            $Controller->setCoreParentLevel("1");
            $Controller->setSortValue("4");
            $Controller->dataSave();
            
            $Controller->setCoreNodeSettingsId("core_node_settings");
            $Controller->setCoreElementDisplaytypeId("TAB");
            $Controller->setSettingsName("Search Settings");
            $Controller->setSettingsCode("search_settings");
            $Controller->setCoreNodeParent("");
            $Controller->setCoreParentLevel("1");
            $Controller->setSortValue("1");
            $Controller->dataSave(); 
            
            
            $Controller=  \CoreClass::getController("core_form_layout","core_developmentsettings");
            $Controller->setCoreNodeSettingsId("core_node_settings");            
            $Controller->setSettingsCode("mandatory_settings");      
            $Controller->setFiledName("mandotatory_add");
            $Controller->setSortValue("1");
            $Controller->dataSave(); 
            
            $Controller->setCoreNodeSettingsId("core_node_settings");            
            $Controller->setSettingsCode("mandatory_settings");      
            $Controller->setFiledName("mandotatory_edit");
            $Controller->setSortValue("2");
            $Controller->dataSave(); 
            
            $Controller->setCoreNodeSettingsId("core_node_settings");            
            $Controller->setSettingsCode("hide_settings");      
            $Controller->setFiledName("hide_edit");
            $Controller->setSortValue("1");
            $Controller->dataSave(); 
            
            $Controller->setCoreNodeSettingsId("core_node_settings");            
            $Controller->setSettingsCode("hide_settings");      
            $Controller->setFiledName("hide_view");
            $Controller->setSortValue("2");
            $Controller->dataSave(); 
            
            $Controller->setCoreNodeSettingsId("core_node_settings");            
            $Controller->setSettingsCode("hide_settings");      
            $Controller->setFiledName("hide_admin");
            $Controller->setSortValue("1");
            $Controller->dataSave();
            
            $Controller->setCoreNodeSettingsId("core_node_settings");            
            $Controller->setSettingsCode("inputtype_settings");      
            $Controller->setFiledName("file");
            $Controller->setSortValue("1");
            $Controller->dataSave();
            
            $Controller->setCoreNodeSettingsId("core_node_settings");            
            $Controller->setSettingsCode("inputtype_settings");      
            $Controller->setFiledName("fck");
            $Controller->setSortValue("2");
            $Controller->dataSave();
            
            
            $Controller->setCoreNodeSettingsId("core_node_settings");            
            $Controller->setSettingsCode("inputtype_settings");      
            $Controller->setFiledName("checkbox");
            $Controller->setSortValue("3");
            $Controller->dataSave();
            
            
            $Controller->setCoreNodeSettingsId("core_node_settings");            
            $Controller->setSettingsCode("inputtype_settings");      
            $Controller->setFiledName("selectbox");
            $Controller->setSortValue("4");
            $Controller->dataSave();
            
            
            $Controller->setCoreNodeSettingsId("core_node_settings");            
            $Controller->setSettingsCode("inputtype_settings");      
            $Controller->setFiledName("boolattributes");
            $Controller->setSortValue("5");
            $Controller->dataSave();
            
            
            $Controller->setCoreNodeSettingsId("core_node_settings");            
            $Controller->setSettingsCode("inputtype_settings");      
            $Controller->setFiledName("colorattributes");
            $Controller->setSortValue("6");
            $Controller->dataSave();
            
            
            $Controller->setCoreNodeSettingsId("core_node_settings");            
            $Controller->setSettingsCode("readonly_settings");      
            $Controller->setFiledName("readonly_add");
            $Controller->setSortValue("1");
            $Controller->dataSave();
            
            $Controller->setCoreNodeSettingsId("core_node_settings");            
            $Controller->setSettingsCode("readonly_settings");      
            $Controller->setFiledName("readonly_edit");
            $Controller->setSortValue("2");
            $Controller->dataSave();
            
            
            $Controller->setCoreNodeSettingsId("core_node_settings");            
            $Controller->setSettingsCode("search_settings");      
            $Controller->setFiledName("search");
            $Controller->setSortValue("1");
            $Controller->dataSave();
            
            $Controller->setCoreNodeSettingsId("core_node_settings");            
            $Controller->setSettingsCode("search_settings");      
            $Controller->setFiledName("exactsearch");
            $Controller->setSortValue("1");
            $Controller->dataSave();
            
        } 
        catch (Exception $ex) {

        }
    }
}
