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
class TaskMember {
    public function execute()
    {
        try
        {   
           $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("taskmember");
            $registerController->setNodeNameData("taskmember");
            $registerController->setDisplayValue("Task Member");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("task_management");
            $registerController->setModuleId("task_management");
            $registerController->setModuleDisplayId("task_management");
            $registerController->setSortValue("2");           
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("taskmember");           
            $registerController->setTablename("tw_task_member");
            $registerController->setAutokey("tw_task_member_id");
            $registerController->setPrimarykey("tw_task_member_id");
            $registerController->setDescriptorkey("tw_task_id");
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
