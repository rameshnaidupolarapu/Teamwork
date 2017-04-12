<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreModuleCreate
 *
 * @author ramesh
 */
  namespace Core\Modules\CoreUsermanagement\Data;
class CoreModuleCreate 
{
    //put your code here
    public function execute()
    {
        try
        {            
            
            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_usermanagement");
            $registerController->setNodeNameData("core_usermanagement");
            $registerController->setDisplayValue("User Management");
            $registerController->setIsModule("1");
            $registerController->setRootModuleId("");
            $registerController->setModuleId("");
            $registerController->setModuleDisplayId("");
            $registerController->setSortValue("3");
            $registerController->setIcon("icon-group");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            
        }
        catch(\Exception $ex)
        {
            \Core::Log($ex->getMessage(),"installdata.log");
        }
    }
}
