<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreNodeSettings
 *
 * @author ramesh
 */
 namespace Core\Modules\CoreDevelopmentsettings\Data;
class CoreNodeSettings 
{
    //put your code here
    public function execute()
    {
        try
        {            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_node_settings");
            $registerController->setNodeNameData("core_node_settings");
            $registerController->setDisplayValue("Node Settings");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("core_developmentsettings");
            $registerController->setModuleId("core_developmentsettings");
            $registerController->setModuleDisplayId("core_developmentsettings");
            $registerController->setSortValue("2");
            $registerController->setIcon("");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("core_node_settings");           
            $registerController->setTablename("core_node_settings");
            $registerController->setAutokey("id");
            $registerController->setPrimarykey("core_registernode_id");
            $registerController->setDescriptorkey("core_registernode_id");
            $registerController->setMandotatoryAdd("core_registernode_id|tablename|primkey|descriptor");
            $registerController->setMandotatoryEdit("core_registernode_id|tablename|primkey|descriptor");
            $registerController->setUniquefields("core_registernode_id");
            $registerController->setHideAdd("dependee|defaultvalues|actionrestriction");
            $registerController->setHideEdit("dependee|defaultvalues|actionrestriction");
            $registerController->setHideView("dependee|defaultvalues|actionrestriction");
            $registerController->setHideAdmin("mandotatory_add|mandotatory_edit|uniquefields|hide_add|hide_edit|hide_view|hide_admin|readonly_add|readonly_edit|boolattributes|file|fck|checkbox|selectbox|multivalues|editlist|numberattribute|search|dependee|defaultvalues|exactsearch|total|colorattributes|core_node_actions_id|actionrestriction");
            $registerController->setReadonlyAdd("autokey");
            $registerController->setReadonlyEdit("core_registernode_id|tablename|autokey|primkey");
            $registerController->setBoolattributes("default_collection|is_archive");
            $registerController->setFile("");
            $registerController->setFck("");
            $registerController->setCheckbox("mandotatory_add|mandotatory_edit|uniquefields|hide_add|hide_edit|hide_view|hide_admin|readonly_add|readonly_edit|boolattributes|file|fck|checkbox|selectbox|multivalues|editlist|numberattribute|search|exactsearch|total|colorattributes|core_node_actions_id");
            $registerController->setSelectbox("core_registernode_id|default_action");
            $registerController->setMultivalues("mandotatory_add|mandotatory_edit|uniquefields|hide_add|hide_edit|hide_view|hide_admin|readonly_add|readonly_edit|boolattributes|file|fck|checkbox|selectbox|multivalues|editlist|numberattribute|search|exactsearch|total|colorattributes|core_node_actions_id");
            $registerController->setEditlist("");
            $registerController->setNumberattribute("");
            $registerController->setSearch("core_registernode_id|tablename");
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
            $relationController->setCoreNodeSettingsId("core_node_settings");
            $relationController->setCoreNodeColname("core_registernode_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_registernode");
            $relationController->setSortValue("1");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_node_settings");
            $relationController->setCoreNodeColname("core_node_actions_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_node_actions");
            $relationController->setSortValue("1");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_node_settings");
            $relationController->setCoreNodeColname("default_action");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_node_actions");
            $relationController->setSortValue("1");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_node_settings");
            $relationController->setCoreNodeColname("core_node_settings_id");
            $relationController->setCoreRelationTypeId("OTM");
            $relationController->setCoreNodeParent("core_uniquefieldset");
            $relationController->setSortValue("1");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_node_settings");
            $relationController->setCoreNodeColname("core_node_settings_id");
            $relationController->setCoreRelationTypeId("OTM");
            $relationController->setCoreNodeParent("core_node_relations");
            $relationController->setSortValue("2");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_node_settings");
            $relationController->setCoreNodeColname("core_node_settings_id");
            $relationController->setCoreRelationTypeId("OTM");
            $relationController->setCoreNodeParent("core_defaultvalues");
            $relationController->setSortValue("3");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_node_settings");
            $relationController->setCoreNodeColname("core_node_settings_id");
            $relationController->setCoreRelationTypeId("OTM");
            $relationController->setCoreNodeParent("core_node_fieldattributes");
            $relationController->setSortValue("4");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_node_settings");
            $relationController->setCoreNodeColname("core_node_settings_id");
            $relationController->setCoreRelationTypeId("OTM");
            $relationController->setCoreNodeParent("core_node_attribute_option");
            $relationController->setSortValue("5");
            $relationController->dataSave();
            
            
        }
        catch (Exception $ex)
        {
            \Core::Log($ex->getMessage(),"installdataexception.log");
        }
    }
}
