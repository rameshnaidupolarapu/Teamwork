<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreUrlRewrite
 *
 * @author venkatesh
 */
 namespace Core\Modules\CoreDevelopmentsettings\Data;
class CoreUrlRewrite 
{
    //put your code here
    public function execute()
    {
        try
        {            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_url_rewrite");
            $registerController->setNodeNameData("core_url_rewrite");
            $registerController->setDisplayValue("Url Rewrite");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("core_codebasedsettings");
            $registerController->setModuleId("core_codebasedsettings");
            $registerController->setModuleDisplayId("core_developmentsettings");
            $registerController->setSortValue("10");
            $registerController->setIcon("");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("core_url_rewrite");           
            $registerController->setTablename("core_url_rewrite");
            $registerController->setAutokey("id");
            $registerController->setPrimarykey("id");
            $registerController->setDescriptorkey("request_path");
            $registerController->setMandotatoryAdd("request_path");
            $registerController->setMandotatoryEdit("request_path");
            $registerController->setUniquefields("request_path");            
            $registerController->setCoreNodeActionsId("add|admin|delete|edit");
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
