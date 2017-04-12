<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\MemberManagement\Data;

/**
 * Description of ModuleCreate
 *
 * @author Ramesh Naidu
 */
class ModuleCreate {
    //put your code here
    //put your code here
    public function execute()
    {
        try
        {            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("member_management");
            $registerController->setNodeNameData("member_management");
            $registerController->setDisplayValue("MemberManagement");
            $registerController->setIsModule("1");            
            $registerController->setSortValue("65");
            $registerController->setIcon("");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();            
            
        }
        catch (Exception $ex)
        {
            \Core::Log($ex->getMessage(),"installdataexception.log");
        }
    }
}
