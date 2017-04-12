<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreActionType
 *
 * @author ramesh
 */
namespace Core\Modules\CoreDevelopmentsettings\Data;
class CoreFormSettings
{
    //put your code here
    public function execute()
    {
        try
        {            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_form_settings");
            $registerController->setNodeNameData("core_form_settings");
            $registerController->setDisplayValue("Form Settings");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("core_developmentsettings");
            $registerController->setModuleId("core_developmentsettings");
            $registerController->setModuleDisplayId("core_developmentsettings");
            $registerController->setSortValue("11");
            $registerController->setIcon("");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("core_form_settings");           
            $registerController->setTablename("core_form_settings");
            $registerController->setAutokey("id");
            $registerController->setPrimarykey("id");
            $registerController->setDescriptorkey("name");
            $registerController->setMandotatoryAdd("core_node_settings_id|core_element_displaytype_id|name|code|sortorder");
            $registerController->setMandotatoryEdit("core_node_settings_id|core_element_displaytype_id|name|code|sortorder");
            $registerController->setUniquefields("");
            $registerController->setHideAdd("parent_level");
            $registerController->setHideEdit("parent_level");
            $registerController->setHideView("parent_level");
            $registerController->setHideAdmin("parent_level");
            $registerController->setReadonlyAdd("");
            $registerController->setReadonlyEdit("core_node_settings_id");
            $registerController->setBoolattributes("");
            $registerController->setFile("");
            $registerController->setFck("");
            $registerController->setCheckbox("");
            $registerController->setSelectbox("parent");
            $registerController->setMultivalues("");
            $registerController->setEditlist("");
            $registerController->setNumberattribute("parent_level|sortorder");
            $registerController->setSearch("name");
            $registerController->setDependee("");
            $registerController->setDefaultvalues("");
            $registerController->setExactsearch("");
            $registerController->setTotal("");
            $registerController->setColorattributes("");
            $registerController->setCoreNodeActionsId("add|admin|delete|edit|view");  
            $registerController->setActionrestriction("");  
            $registerController->setDefaultAction("admin"); 
            $registerController->setDefaultCollection('1');
            $registerController->setIsArchive("");  
            $registerController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_form_settings");
            $relationController->setCoreNodeColname("core_node_settings_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_node_settings");
            $relationController->setSortValue("1");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_form_settings");
            $relationController->setCoreNodeColname("core_element_displaytype_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_element_displaytype");
            $relationController->setSortValue("2");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_form_settings");
            $relationController->setCoreNodeColname("parent");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_form_settings");
            $relationController->setSortValue("3");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_form_settings");
            $relationController->setCoreNodeColname("parent");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_form_settings");
            $relationController->setSortValue("4");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_form_settings");
            $relationController->setCoreNodeColname("core_form_settings_id");
            $relationController->setCoreRelationTypeId("OTM");
            $relationController->setCoreNodeParent("core_form_layout");
            $relationController->setSortValue("5");
            $relationController->dataSave();
            
        }
        catch (Exception $ex)
        {
            \Core::Log($ex->getMessage(),"installdataexception.log");
        }
    }
}
