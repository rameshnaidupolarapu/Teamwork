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
class TaskDetails {
    public function execute()
    {
        try
        {   
           $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("taskdetails");
            $registerController->setNodeNameData("taskdetails");
            $registerController->setDisplayValue("TaskManagement");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("task_management");
            $registerController->setModuleId("task_management");
            $registerController->setModuleDisplayId("task_management");
            $registerController->setSortValue("1");           
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("taskdetails");           
            $registerController->setTablename("tw_task");
            $registerController->setAutokey("tw_task_id");
            $registerController->setPrimarykey("tw_task_id");
            $registerController->setDescriptorkey("task_code");
            $registerController->setMandotatoryAdd("task_name");
            $registerController->setMandotatoryEdit("task_name");
            $registerController->setHideAdd("task_code");
            $registerController->setSearch("task_name|task_code");
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
