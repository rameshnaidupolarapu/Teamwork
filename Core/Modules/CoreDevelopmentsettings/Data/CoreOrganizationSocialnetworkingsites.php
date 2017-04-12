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
class CoreOrganizationSocialnetworkingsites
{
    //put your code here
    public function execute()
    {
        try
        {            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_organization_socialnetworkingsites");
            $registerController->setNodeNameData("core_organization_socialnetworkingsites");
            $registerController->setDisplayValue("Org Social Networking Sites");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("core_organizationsetup");
            $registerController->setModuleId("core_organizationsetup");
            $registerController->setModuleDisplayId("core_organizationsetup");
            $registerController->setSortValue("4");
            $registerController->setIcon("");
            $registerController->setMenu("2");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("core_organization_socialnetworkingsites");           
            $registerController->setTablename("core_organization_socialnetworkingsites");
            $registerController->setAutokey("id");
            $registerController->setPrimarykey("id");
            $registerController->setDescriptorkey("socialnetworkingsites_id.name");
            $registerController->setMandotatoryAdd("organization_id|socialnetworkingsites_id|url|sortvalue");
            $registerController->setMandotatoryEdit("organization_id|socialnetworkingsites_id|url|sortvalue");
            $registerController->setUniquefields("");
            $registerController->setHideAdd("");
            $registerController->setHideEdit("");
            $registerController->setHideView("");
            $registerController->setHideAdmin("");
            $registerController->setReadonlyAdd("");
            $registerController->setReadonlyEdit("");
            $registerController->setBoolattributes("");
            $registerController->setFile("logo");
            $registerController->setFck("");
            $registerController->setCheckbox("");
            $registerController->setSelectbox("");
            $registerController->setMultivalues("");
            $registerController->setEditlist("");
            $registerController->setNumberattribute("organization_id|sortvalue");
            $registerController->setSearch("socialnetworkingsites_id");
            $registerController->setDependee("");
            $registerController->setDefaultvalues("");
            $registerController->setExactsearch("socialnetworkingsites_id");
            $registerController->setTotal("");
            $registerController->setColorattributes("");
            $registerController->setCoreNodeActionsId("add|admin|delete|edit");  
            $registerController->setActionrestriction("");  
            $registerController->setDefaultAction("admin"); 
            $registerController->setDefaultCollection('1');
            $registerController->setIsArchive("");  
            $registerController->dataSave();
            
        }
        catch (Exception $ex)
        {
            \Core::Log($ex->getMessage(),"installdataexception.log");
        }
    }
}
