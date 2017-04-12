<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\MemberManagement\Data;

/**
 * Description of ProjectDetails
 *
 * @author Ramesh Naidu
 */
class MemberDetails {
    public function execute()
    {
        try
        {   
           $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("memberdetails");
            $registerController->setNodeNameData("memberdetails");
            $registerController->setDisplayValue("Member Details");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("member_management");
            $registerController->setModuleId("member_management");
            $registerController->setModuleDisplayId("member_management");
            $registerController->setSortValue("1");           
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("memberdetails");           
            $registerController->setTablename("tw_member");
            $registerController->setAutokey("tw_member_id");
            $registerController->setPrimarykey("tw_member_id");
            $registerController->setDescriptorkey("first_name");
            $registerController->setMandotatoryAdd("first_name|last_name|emailid");
            $registerController->setMandotatoryEdit("first_name|last_name|emailid");
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
