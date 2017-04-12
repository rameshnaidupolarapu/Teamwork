<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\TaskManagement\Data;

/**
 * Description of ProjectDetails
 *
 * @author Ramesh Naidu
 */
class TaskStatus {
    public function execute()
    {
        try
        {   
           $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("taskstatus");
            $registerController->setNodeNameData("taskstatus");
            $registerController->setDisplayValue("Task Status");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("task_management");
            $registerController->setModuleId("task_management");
            $registerController->setModuleDisplayId("task_management");
            $registerController->setSortValue("2");           
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("taskstatus");           
            $registerController->setTablename("tw_task_status");
            $registerController->setAutokey("tw_task_status_id");
            $registerController->setPrimarykey("status_code");
            $registerController->setDescriptorkey("status_name");
            $registerController->setMandotatoryAdd("status_name|status_code");
            $registerController->setMandotatoryEdit("status_namestatus_code");
            $registerController->setUniquefields("status_name|status_code");     
            $registerController->setSearch("status_name|status_code");
            $registerController->setCoreNodeActionsId("add|admin|edit|delete|view");        
            $registerController->setDefaultAction("admin"); 
            $registerController->setDefaultCollection('1');
            $registerController->dataSave();            
        }
        catch (Exception $ex)
        {
            \Core::Log($ex->getMessage(),"installdataexception.log");
        }
    }
}
