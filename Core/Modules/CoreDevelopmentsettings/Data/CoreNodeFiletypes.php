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
class CoreNodeFiletypes
{
    //put your code here
    public function execute()
    {
        try
        {            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_node_filetypes");
            $registerController->setNodeNameData("core_node_filetypes");
            $registerController->setDisplayValue("Node File Types");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("core_codebasedsettings");
            $registerController->setModuleId("core_codebasedsettings");
            $registerController->setModuleDisplayId("core_developmentsettings");
            $registerController->setSortValue("8");
            $registerController->setIcon("");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("core_node_filetypes");           
            $registerController->setTablename("core_node_filetypes");
            $registerController->setAutokey("id");
            $registerController->setPrimarykey("id");
            $registerController->setDescriptorkey("id");
            $registerController->setMandotatoryAdd("core_node_settings_id|core_cms_uploadfolders_id|colmanname");
            $registerController->setMandotatoryEdit("core_node_settings_id|core_cms_uploadfolders_id|colmanname");
            $registerController->setUniquefields("");
            $registerController->setHideAdd("");
            $registerController->setHideEdit("");
            $registerController->setHideView("");
            $registerController->setHideAdmin("");
            $registerController->setReadonlyAdd("");
            $registerController->setReadonlyEdit("core_node_settings_id|core_cms_uploadfolders_id|colmanname");
            $registerController->setBoolattributes("");
            $registerController->setFile("");
            $registerController->setFck("");
            $registerController->setCheckbox("core_cms_image_settings_id|core_file_types_id");
            $registerController->setSelectbox("");
            $registerController->setMultivalues("core_cms_image_settings_id|core_file_types_id");
            $registerController->setEditlist("");
            $registerController->setNumberattribute("");
            $registerController->setSearch("colmanname");
            $registerController->setDependee("node_settings_id");
            $registerController->setDefaultvalues("");
            $registerController->setExactsearch("");
            $registerController->setTotal("");
            $registerController->setColorattributes("");
            $registerController->setCoreNodeActionsId("add|admin|delete|edit");  
            $registerController->setActionrestriction("");  
            $registerController->setDefaultAction("admin"); 
            $registerController->setDefaultCollection('1');
            $registerController->setIsArchive("");  
            $registerController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_node_filetypes");
            $relationController->setCoreNodeColname("core_node_settings_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_node_settings");
            $relationController->setSortValue("1");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_cms_uploadfolders_id");
            $relationController->setCoreNodeColname("core_profile_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_cms_uploadfolders");
            $relationController->setSortValue("2");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_node_filetypes");
            $relationController->setCoreNodeColname("core_file_types_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_file_types");
            $relationController->setSortValue("3");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_node_filetypes");
            $relationController->setCoreNodeColname("core_cms_image_settings_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_cms_image_settings");
            $relationController->setSortValue("4");
            $relationController->dataSave();
            
            
        }
        catch (Exception $ex)
        {
            \Core::Log($ex->getMessage(),"installdataexception.log");
        }
    }
}
