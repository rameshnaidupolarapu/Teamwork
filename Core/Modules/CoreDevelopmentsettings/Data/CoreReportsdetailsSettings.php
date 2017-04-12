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
class CoreReportsdetailsSettings
{
    //put your code here
    public function execute()
    {
        try
        {            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_reportsdetails_settings");
            $registerController->setNodeNameData("core_reportsdetails_settings");
            $registerController->setDisplayValue("Report Settings");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("core_reports");
            $registerController->setModuleId("core_reports");
            $registerController->setModuleDisplayId("core_reports");
            $registerController->setSortValue("2");
            $registerController->setIcon("");
            $registerController->setMenu("0");
            $registerController->setIsNotification("2");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("core_reportsdetails_settings");           
            $registerController->setTablename("core_reportsdetails_settings");
            $registerController->setAutokey("id");
            $registerController->setPrimarykey("id");
            $registerController->setDescriptorkey("core_reportsdetails_id");
            $registerController->setMandotatoryAdd("core_reportsdetails_id|node_id|core_queryclause_id");
            $registerController->setMandotatoryEdit("core_reportsdetails_id|node_id|core_queryclause_id");
            $registerController->setUniquefields("");
            $registerController->setHideAdd("");
            $registerController->setHideEdit("");
            $registerController->setHideView("");
            $registerController->setHideAdmin("");
            $registerController->setReadonlyAdd("");
            $registerController->setReadonlyEdit("");
            $registerController->setBoolattributes("");
            $registerController->setFile("logo");
            $registerController->setFck("");
            $registerController->setCheckbox("");
            $registerController->setSelectbox("fieldsdata");
            $registerController->setMultivalues("fieldsdata");
            $registerController->setEditlist("sortno");
            $registerController->setNumberattribute("sortno");
            $registerController->setSearch("");
            $registerController->setDependee("");
            $registerController->setDefaultvalues("");
            $registerController->setExactsearch("");
            $registerController->setTotal("");
            $registerController->setColorattributes("");
            $registerController->setCoreNodeActionsId("add|admin|delete|edit|view");  
            $registerController->setActionrestriction("");  
            $registerController->setDefaultAction("admin"); 
            $registerController->setDefaultCollection('1');
            $registerController->setIsArchive("");  
            $registerController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_reportsdetails_settings");
            $relationController->setCoreNodeColname("core_reportsdetails_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_reportsdetails");
            $relationController->setSortValue("1");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_reportsdetails_settings");
            $relationController->setCoreNodeColname("core_queryclause_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_queryclause");
            $relationController->setSortValue("2");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_reportsdetails_settings");
            $relationController->setCoreNodeColname("core_aggregate_function_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_aggregate_function");
            $relationController->setSortValue("3");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_reportsdetails_settings");
            $relationController->setCoreNodeColname("core_orderclausetype_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_orderclausetype");
            $relationController->setSortValue("4");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_reportsdetails_settings");
            $relationController->setCoreNodeColname("node_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_node_settings");
            $relationController->setSortValue("5");
            $relationController->dataSave();
            
           
            
        }
        catch (Exception $ex)
        {
            \Core::Log($ex->getMessage(),"installdataexception.log");
        }
    }
}
