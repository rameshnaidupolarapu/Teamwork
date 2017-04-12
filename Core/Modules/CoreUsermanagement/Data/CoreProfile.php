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
  namespace Core\Modules\CoreUsermanagement\Data;
class CoreProfile
{
    //put your code here
    public function execute()
    {
        try
        {            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_profile");
            $registerController->setNodeNameData("core_profile");
            $registerController->setDisplayValue("Profile Details");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("core_usermanagement");
            $registerController->setModuleId("core_usermanagement");
            $registerController->setModuleDisplayId("core_usermanagement");
            $registerController->setSortValue("2");
            $registerController->setIcon("");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("core_profile");           
            $registerController->setTablename("core_profile");
            $registerController->setAutokey("id");
            $registerController->setPrimarykey("short_code");
            $registerController->setDescriptorkey("name");
            $registerController->setMandotatoryAdd("name|short_code|core_profile_level_id");
            $registerController->setMandotatoryEdit("name|short_code|core_profile_level_id");
            $registerController->setUniquefields("name|short_code");
            $registerController->setHideAdd("");
            $registerController->setHideEdit("");
            $registerController->setHideView("");
            $registerController->setHideAdmin("");
            $registerController->setReadonlyAdd("");
            $registerController->setReadonlyEdit("short_code|core_profile_level_id");
            $registerController->setBoolattributes("api");
            $registerController->setFile("");
            $registerController->setFck("");
            $registerController->setCheckbox("");
            $registerController->setSelectbox("");
            $registerController->setMultivalues("");
            $registerController->setEditlist("");
            $registerController->setNumberattribute("");
            $registerController->setSearch("name|short_code|core_profile_level_id");
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
            $relationController->setCoreNodeSettingsId("core_profile");
            $relationController->setCoreNodeColname("core_profile_id");
            $relationController->setCoreRelationTypeId("OTM");
            $relationController->setCoreNodeParent("core_access");
            $relationController->setSortValue("1");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_profile");
            $relationController->setCoreNodeColname("core_profile_level_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_profile_level");
            $relationController->setSortValue("2");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_profile");
            $relationController->setCoreNodeColname("core_profile_id");
            $relationController->setCoreRelationTypeId("OTM");
            $relationController->setCoreNodeParent("core_users");
            $relationController->setSortValue("3");
            $relationController->dataSave();
            
        }
        catch (Exception $ex)
        {
            \Core::Log($ex->getMessage(),"installdataexception.log");
        }
    }
}
