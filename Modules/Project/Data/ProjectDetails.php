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
class ProjectDetails {
    public function execute()
    {
        try
        {   
           $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("projectdetails");
            $registerController->setNodeNameData("projectdetails");
            $registerController->setDisplayValue("Project Details");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("project");
            $registerController->setModuleId("project");
            $registerController->setModuleDisplayId("project");
            $registerController->setSortValue("1");           
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("projectdetails");           
            $registerController->setTablename("tw_project");
            $registerController->setAutokey("tw_project_id");
            $registerController->setPrimarykey("tw_project_id");
            $registerController->setDescriptorkey("project_name");
            $registerController->setMandotatoryAdd("project_name");
            $registerController->setMandotatoryEdit("project_name");
            $registerController->setUniquefields("project_name");
            $registerController->setHideAdd("project_code");
            $registerController->setSearch("project_name|project_code");
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
