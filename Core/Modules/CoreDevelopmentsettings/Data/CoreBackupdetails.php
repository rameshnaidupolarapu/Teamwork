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
class CoreBackupdetails
{
    //put your code here
    public function execute()
    {
        try
        {            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_backupdetails");
            $registerController->setNodeNameData("core_backupdetails");
            $registerController->setDisplayValue("Backup History");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("core_backup");
            $registerController->setModuleId("core_backup");
            $registerController->setModuleDisplayId("core_backup");
            $registerController->setSortValue("11");
            $registerController->setIcon("");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("core_backupdetails");           
            $registerController->setTablename("core_backupdetails");
            $registerController->setAutokey("id");
            $registerController->setPrimarykey("id");
            $registerController->setDescriptorkey("core_backup_type_id");
            $registerController->setMandotatoryAdd("core_backup_type_id");
            $registerController->setMandotatoryEdit("");
            $registerController->setUniquefields("");
            $registerController->setHideAdd("filepath|dateandtime");
            $registerController->setHideEdit("");
            $registerController->setHideView("");
            $registerController->setHideAdmin("");
            $registerController->setReadonlyAdd("");
            $registerController->setReadonlyEdit("");
            $registerController->setBoolattributes("active_status");
            $registerController->setFile("filepath");
            $registerController->setFck("");
            $registerController->setCheckbox("");
            $registerController->setSelectbox("core_backup_type_id");
            $registerController->setMultivalues("");
            $registerController->setEditlist("");
            $registerController->setNumberattribute("");
            $registerController->setSearch("core_backup_type_id|filepath");
            $registerController->setDependee("");
            $registerController->setDefaultvalues("");
            $registerController->setExactsearch("core_backup_type_id");
            $registerController->setTotal("");
            $registerController->setColorattributes("");
            $registerController->setCoreNodeActionsId("admin|delete");  
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
