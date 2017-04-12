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
class CoreUsers
{
    //put your code here
    public function execute()
    {
        try
        {            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_users");
            $registerController->setNodeNameData("core_users");
            $registerController->setDisplayValue("User Details");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("core_usermanagement");
            $registerController->setModuleId("core_usermanagement");
            $registerController->setModuleDisplayId("core_usermanagement");
            $registerController->setSortValue("5");
            $registerController->setIcon("");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("core_users");           
            $registerController->setTablename("core_users");
            $registerController->setAutokey("id");
            $registerController->setPrimarykey("id");
            $registerController->setDescriptorkey("name");
            $registerController->setMandotatoryAdd("name|username|password|core_profile_id");
            $registerController->setMandotatoryEdit("name|username|password|core_profile_id");
            $registerController->setUniquefields("username");
            $registerController->setHideAdd("");
            $registerController->setHideEdit("");
            $registerController->setHideView("");
            $registerController->setHideAdmin("");
            $registerController->setReadonlyAdd("");
            $registerController->setReadonlyEdit("");
            $registerController->setBoolattributes("active_status");
            $registerController->setFile("user_image");
            $registerController->setFck("");
            $registerController->setCheckbox("");
            $registerController->setSelectbox("");
            $registerController->setMultivalues("");
            $registerController->setEditlist("");
            $registerController->setNumberattribute("active_status");
            $registerController->setSearch("name|username|active_status");
            $registerController->setDependee("");
            $registerController->setDefaultvalues("");
            $registerController->setExactsearch("");
            $registerController->setTotal("");
            $registerController->setColorattributes("");
            $registerController->setCoreNodeActionsId("add|admin|delete|edit|export|view");  
            $registerController->setActionrestriction("");  
            $registerController->setDefaultAction("admin"); 
            $registerController->setDefaultCollection('1');
            $registerController->setIsArchive("");  
            $registerController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_users");
            $relationController->setCoreNodeColname("core_profile_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_profile");
            $relationController->setSortValue("1");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_users");
            $relationController->setCoreNodeColname("core_user_id");
            $relationController->setCoreRelationTypeId("OTM");
            $relationController->setCoreNodeParent("core_app_settings");
            $relationController->setSortValue("2");
            $relationController->dataSave();
            
            $nodefieldattributes=\CoreClass::getController("core_node_fieldattributes","core_developmentsettings");
            $nodefieldattributes->setCoreNodeSettingsId("core_users");
            $nodefieldattributes->setFieldname("core_user_id");
            $nodefieldattributes->setCoreRootAttributeId("PSD");
            $nodefieldattributes->setIsEncrypt("1");
            $nodefieldattributes->dataSave();
            
        }
        catch (Exception $ex)
        {
            \Core::Log($ex->getMessage(),"installdataexception.log");
        }
    }
}
