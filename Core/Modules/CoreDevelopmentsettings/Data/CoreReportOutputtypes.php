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
class CoreReportOutputtypes
{
    //put your code here
    public function execute()
    {
        try
        {            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_report_outputtypes");
            $registerController->setNodeNameData("core_report_outputtypes");
            $registerController->setDisplayValue("Output Types");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("core_reports");
            $registerController->setModuleId("core_reports");
            $registerController->setModuleDisplayId("core_reports");
            $registerController->setSortValue("3");
            $registerController->setIcon("");
            $registerController->setMenu("2");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("core_reportsdetails");           
            $registerController->setTablename("core_reportsdetails");
            $registerController->setAutokey("id");
            $registerController->setPrimarykey("id");
            $registerController->setDescriptorkey("id");
            $registerController->setMandotatoryAdd("reportsdetails_id|output_type_id");
            $registerController->setMandotatoryEdit("reportsdetails_id|output_type_id");
            $registerController->setUniquefields("");
            $registerController->setHideAdd("");
            $registerController->setHideEdit("");
            $registerController->setHideView("");
            $registerController->setHideAdmin("qry");
            $registerController->setReadonlyAdd("");
            $registerController->setReadonlyEdit("reportsdetails_id");
            $registerController->setBoolattributes("");
            $registerController->setFile("");
            $registerController->setFck("");
            $registerController->setCheckbox("");
            $registerController->setSelectbox("");
            $registerController->setMultivalues("");
            $registerController->setEditlist("");
            $registerController->setNumberattribute("reportsdetails_id");
            $registerController->setSearch("output_type_id");
            $registerController->setDependee("");
            $registerController->setDefaultvalues("");
            $registerController->setExactsearch("output_type_id");
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
