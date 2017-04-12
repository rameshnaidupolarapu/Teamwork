<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Project\Data;

/**
 * Description of ProjectDetails
 *
 * @author Ramesh Naidu
 */
class ProjectMember {
    public function execute()
    {
        try
        {   
           $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("projectmember");
            $registerController->setNodeNameData("projectmember");
            $registerController->setDisplayValue("Project Member");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("project");
            $registerController->setModuleId("project");
            $registerController->setModuleDisplayId("project");
            $registerController->setSortValue("2");           
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("projectmember");           
            $registerController->setTablename("tw_project_member");
            $registerController->setAutokey("tw_project_member_id");
            $registerController->setPrimarykey("tw_project_member_id");
            $registerController->setDescriptorkey("status_name");
            $registerController->setMandotatoryAdd("tw_project_id|tw_member_id");
            $registerController->setMandotatoryEdit("tw_project_id|tw_member_id");  
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
