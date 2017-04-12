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
class CoreOrganization
{
    //put your code here
    public function execute()
    {
        try
        {            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_organization");
            $registerController->setNodeNameData("core_organization");
            $registerController->setDisplayValue("Organization");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("core_organizationsetup");
            $registerController->setModuleId("core_organizationsetup");
            $registerController->setModuleDisplayId("core_organizationsetup");
            $registerController->setSortValue("1");
            $registerController->setIcon("");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("core_organization");           
            $registerController->setTablename("core_organization");
            $registerController->setAutokey("id");
            $registerController->setPrimarykey("id");
            $registerController->setDescriptorkey("name");
            $registerController->setMandotatoryAdd("name|code|email|phone_no|logo|address1|zipcode|active_status");
            $registerController->setMandotatoryEdit("name|code|email|phone_no|logo|address1|zipcode|active_status");
            $registerController->setUniquefields("name|code");
            $registerController->setHideAdd("");
            $registerController->setHideEdit("");
            $registerController->setHideView("");
            $registerController->setHideAdmin("email|phone_no|alternate_phone_no|address2|zipcode|description");
            $registerController->setReadonlyAdd("");
            $registerController->setReadonlyEdit("");
            $registerController->setBoolattributes("active_status");
            $registerController->setFile("logo");
            $registerController->setFck("");
            $registerController->setCheckbox("");
            $registerController->setSelectbox("");
            $registerController->setMultivalues("");
            $registerController->setEditlist("");
            $registerController->setNumberattribute("phone_no|zipcode|active_status");
            $registerController->setSearch("name|code");
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
            $relationController->setCoreNodeSettingsId("core_organization");
            $relationController->setCoreNodeColname("core_country_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_country");
            $relationController->setSortValue("1");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_organization");
            $relationController->setCoreNodeColname("core_list_state_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_list_state");
            $relationController->setSortValue("2");
            $relationController->dataSave();
            
            $nodefieldattributes=\CoreClass::getController("core_node_fieldattributes","core_developmentsettings");
            $nodefieldattributes->setCoreNodeSettingsId("core_organization");
            $nodefieldattributes->setFieldname("alternate_phone_no");
            $nodefieldattributes->setCoreRootAttributeId("PHN");
            $nodefieldattributes->setIsEncrypt("0");
            $nodefieldattributes->dataSave();
            
            $nodefieldattributes=\CoreClass::getController("core_node_fieldattributes","core_developmentsettings");
            $nodefieldattributes->setCoreNodeSettingsId("core_organization");
            $nodefieldattributes->setFieldname("email");
            $nodefieldattributes->setCoreRootAttributeId("EMD");
            $nodefieldattributes->setIsEncrypt("0");
            $nodefieldattributes->dataSave();
            
            $nodefieldattributes=\CoreClass::getController("core_node_fieldattributes","core_developmentsettings");
            $nodefieldattributes->setCoreNodeSettingsId("core_organization");
            $nodefieldattributes->setFieldname("phone_no");
            $nodefieldattributes->setCoreRootAttributeId("PHN");
            $nodefieldattributes->setIsEncrypt("0");
            $nodefieldattributes->dataSave();
            
        }
        catch (Exception $ex)
        {
            \Core::Log($ex->getMessage(),"installdataexception.log");
        }
    }
}
