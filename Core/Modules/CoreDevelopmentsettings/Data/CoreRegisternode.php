<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreRegisternode
 *
 * @author ramesh
 */
 namespace Core\Modules\CoreDevelopmentsettings\Data;
class CoreRegisternode 
{
    //put your code here
    public function execute()
    {
        try
        {
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_registernode");
            $registerController->setNodeNameData("core_registernode");
            $registerController->setDisplayValue("Register Nodes");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("core_developmentsettings");
            $registerController->setModuleId("core_developmentsettings");
            $registerController->setModuleDisplayId("core_developmentsettings");
            $registerController->setSortValue("2");
            $registerController->setIcon("icon-cogs");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();     
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("core_registernode");           
            $registerController->setTablename("core_registernode");
            $registerController->setAutokey("id");
            $registerController->setPrimarykey("nodename");
            $registerController->setDescriptorkey("displayvalue");
            $registerController->setMandotatoryAdd("nodefile|nodename|displayvalue|sort_value");
            $registerController->setMandotatoryEdit("nodefile|nodename|displayvalue|sort_value");
            $registerController->setUniquefields("nodefile|nodename");
            $registerController->setHideAdd("");
            $registerController->setHideEdit("");
            $registerController->setHideView("");
            $registerController->setHideAdmin("nodefile");
            $registerController->setReadonlyAdd("");
            $registerController->setReadonlyEdit("nodename|core_module_id");
            $registerController->setBoolattributes("is_module|menu|is_notification");
            $registerController->setFile("");
            $registerController->setFck("");
            $registerController->setCheckbox("");
            $registerController->setSelectbox("core_root_module_id|core_module_id|core_module_display_id");
            $registerController->setMultivalues("");
            $registerController->setEditlist("core_root_module_id|sort_value|icon|menu|is_notification");
            $registerController->setNumberattribute("is_module|sort_value|menu|is_notification");
            $registerController->setSearch("nodename|displayvalue|is_module|core_root_module_id|core_module_id|is_notification");
            $registerController->setDependee("");
            $registerController->setDefaultvalues("");
            $registerController->setExactsearch("");
            $registerController->setTotal("");
            $registerController->setColorattributes("");
            $registerController->setCoreNodeActionsId("add|admin|delete|edit|export|import|mra|view");  
            $registerController->setActionrestriction("");  
            $registerController->setDefaultAction("admin"); 
            $registerController->setDefaultCollection('1');
            $registerController->setIsArchive("");  
            $registerController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_registernode");
            $relationController->setCoreNodeColname("core_root_module_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_registernode");
            $relationController->setSortValue("1");
            $relationController->dataSave();
            
            $relationController->setCoreNodeSettingsId("core_registernode");
            $relationController->setCoreNodeColname("core_module_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_registernode");
            $relationController->setSortValue("2");
            $relationController->dataSave();
            
            
            $relationController->setCoreNodeSettingsId("core_registernode");
            $relationController->setCoreNodeColname("core_module_display_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_registernode");
            $relationController->setSortValue("3");
            $relationController->dataSave();
        }
        catch (Exception $ex)
        {
            \Core::Log($ex->getMessage(),"installdataexception.log");
        }
    }
}
