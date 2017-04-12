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
class CoreReportsdetails
{
    //put your code here
    public function execute()
    {
        try
        {            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_reportsdetails");
            $registerController->setNodeNameData("core_reportsdetails");
            $registerController->setDisplayValue("Reports Details");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("core_reports");
            $registerController->setModuleId("core_reports");
            $registerController->setModuleDisplayId("core_codebasedsettings");
            $registerController->setSortValue("1");
            $registerController->setIcon("");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("core_reportsdetails");           
            $registerController->setTablename("core_reportsdetails");
            $registerController->setAutokey("id");
            $registerController->setPrimarykey("id");
            $registerController->setDescriptorkey("name");
            $registerController->setMandotatoryAdd("node_id|name");
            $registerController->setMandotatoryEdit("node_id|name");
            $registerController->setUniquefields("name");
            $registerController->setHideAdd("qry");
            $registerController->setHideEdit("qry");
            $registerController->setHideView("qry");
            $registerController->setHideAdmin("qry");
            $registerController->setReadonlyAdd("is_publish");
            $registerController->setReadonlyEdit("node_id|is_publish");
            $registerController->setBoolattributes("show_dashboard|is_custom|is_publish");
            $registerController->setFile("");
            $registerController->setFck("");
            $registerController->setCheckbox("core_output_type_id|db_output_type_id");
            $registerController->setSelectbox("");
            $registerController->setMultivalues("core_output_type_id|db_output_type_id");
            $registerController->setEditlist("show_dashboard|sortvalue");
            $registerController->setNumberattribute("show_dashboard|is_publish|sortvalue");
            $registerController->setSearch("node_id|name|is_publish");
            $registerController->setDependee("");
            $registerController->setDefaultvalues("");
            $registerController->setExactsearch("");
            $registerController->setTotal("");
            $registerController->setColorattributes("");
            $registerController->setCoreNodeActionsId("add|admin|delete|edit|PB|UPB|view");  
            $registerController->setActionrestriction("");  
            $registerController->setDefaultAction("admin"); 
            $registerController->setDefaultCollection('1');
            $registerController->setIsArchive("");  
            $registerController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_reportsdetails");
            $relationController->setCoreNodeColname("node_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_registernode");
            $relationController->setSortValue("1");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_reportsdetails");
            $relationController->setCoreNodeColname("core_output_type_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_output_type");
            $relationController->setSortValue("2");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_reportsdetails");
            $relationController->setCoreNodeColname("db_output_type_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_output_type");
            $relationController->setSortValue("3");
            $relationController->dataSave();
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_reportsdetails");
            $relationController->setCoreNodeColname("core_reportsdetails_id");
            $relationController->setCoreRelationTypeId("OTM");
            $relationController->setCoreNodeParent("core_reportsdetails_settings");
            $relationController->setSortValue("4");
            $relationController->dataSave();
            
            
        }
        catch (Exception $ex)
        {
            \Core::Log($ex->getMessage(),"installdataexception.log");
        }
    }
}
