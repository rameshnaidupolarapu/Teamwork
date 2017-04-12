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
class CoreSmsLog
{
    //put your code here
    public function execute()
    {
        try
        {            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_sms_log");
            $registerController->setNodeNameData("core_sms_log");
            $registerController->setDisplayValue("Sent SMS Details");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("core_reports");
            $registerController->setModuleId("core_reports");
            $registerController->setModuleDisplayId("core_reports");
            $registerController->setSortValue("3");
            $registerController->setIcon("");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("core_sms_log");           
            $registerController->setTablename("core_sms_log");
            $registerController->setAutokey("id");
            $registerController->setPrimarykey("id");
            $registerController->setDescriptorkey("senderid");
            $registerController->setMandotatoryAdd("");
            $registerController->setMandotatoryEdit("");
            $registerController->setUniquefields("");
            $registerController->setHideAdd("");
            $registerController->setHideEdit("");
            $registerController->setHideView("smstrackerid");
            $registerController->setHideAdmin("smstrackerid");
            $registerController->setReadonlyAdd("");
            $registerController->setReadonlyEdit("");
            $registerController->setBoolattributes("");
            $registerController->setFile("logo");
            $registerController->setFck("");
            $registerController->setCheckbox("");
            $registerController->setSelectbox("");
            $registerController->setMultivalues("");
            $registerController->setEditlist("");
            $registerController->setNumberattribute("");
            $registerController->setSearch("mobile_no|senderid|date");
            $registerController->setDependee("");
            $registerController->setDefaultvalues("");
            $registerController->setExactsearch("");
            $registerController->setTotal("");
            $registerController->setColorattributes("");
            $registerController->setCoreNodeActionsId("admin");  
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
