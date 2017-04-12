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
class CoreReportTemplate
{
    //put your code here
    public function execute()
    {
        try
        {            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_report_template");
            $registerController->setNodeNameData("core_report_template");
            $registerController->setDisplayValue("Report Template");
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
            $registerController->setRegisternodeId("core_report_template");           
            $registerController->setTablename("core_report_template");
            $registerController->setAutokey("id");
            $registerController->setPrimarykey("short_code");
            $registerController->setDescriptorkey("name");
            $registerController->setMandotatoryAdd("name|short_code|template");
            $registerController->setMandotatoryEdit("name|short_code|template");
            $registerController->setUniquefields("name|short_code");
            $registerController->setHideAdd("is_progressreport");
            $registerController->setHideEdit("is_progressreport");
            $registerController->setHideView("is_progressreport");
            $registerController->setHideAdmin("is_progressreport|template");
            $registerController->setReadonlyAdd("");
            $registerController->setReadonlyEdit("short_code");
            $registerController->setBoolattributes("is_progressreport");
            $registerController->setFile("");
            $registerController->setFck("");
            $registerController->setCheckbox("");
            $registerController->setSelectbox("");
            $registerController->setMultivalues("");
            $registerController->setEditlist("");
            $registerController->setNumberattribute("is_progressreport");
            $registerController->setSearch("name|short_code");
            $registerController->setDependee("");
            $registerController->setDefaultvalues("");
            $registerController->setExactsearch("");
            $registerController->setTotal("");
            $registerController->setColorattributes("");
            $registerController->setCoreNodeActionsId("add|admin|delete|edit");  
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
