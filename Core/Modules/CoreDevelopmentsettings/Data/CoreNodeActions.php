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
class CoreNodeActions
{
    //put your code here
    public function execute()
    {
        try
        {            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_node_actions");
            $registerController->setNodeNameData("core_node_actions");
            $registerController->setDisplayValue("Node Actions");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("core_developmentsettings");
            $registerController->setModuleId("core_developmentsettings");
            $registerController->setModuleDisplayId("core_developmentsettings");
            $registerController->setSortValue("4");
            $registerController->setIcon("");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("core_node_settings", "core_developmentsettings");
            $registerController->setRegisternodeId("core_node_actions");           
            $registerController->setTablename("core_node_actions");
            $registerController->setAutokey("id");
            $registerController->setPrimarykey("short_code");
            $registerController->setDescriptorkey("name");
            $registerController->setMandotatoryAdd("name|short_code");
            $registerController->setMandotatoryEdit("name|short_code");
            $registerController->setUniquefields("name|short_code");
            $registerController->setHideAdd("");
            $registerController->setHideEdit("");
            $registerController->setHideView("");
            $registerController->setHideAdmin("");
            $registerController->setReadonlyAdd("");
            $registerController->setReadonlyEdit("");
            $registerController->setBoolattributes("is_layout");
            $registerController->setFile("");
            $registerController->setFck("");
            $registerController->setCheckbox("core_action_type_id");
            $registerController->setSelectbox("");
            $registerController->setMultivalues("core_action_type_id");
            $registerController->setEditlist("");
            $registerController->setNumberattribute("sort_no");
            $registerController->setSearch("name|short_code");
            $registerController->setDependee("registernode_id");
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
            
            $nodeActionController=\CoreClass::getController("core_node_actions", "core_developmentsettings");
            
            $nodeActionController->setNodeActionName("ADMIN");
            $nodeActionController->setNodeActionShortCode("admin");
            $nodeActionController->setNodeActionType("SN");
            $nodeActionController->setNodeActionSortNo("1"); 
            $nodeActionController->setIsLayout(1);
            $nodeActionController->dataSave();
            
            $nodeActionController->setNodeActionName("ADD");
            $nodeActionController->setNodeActionShortCode("add");
            $nodeActionController->setNodeActionType("SN");
            $nodeActionController->setNodeActionSortNo("2");   
            $nodeActionController->setIsLayout(1);
            $nodeActionController->dataSave();
            
            
            $nodeActionController->setNodeActionName("EDIT");
            $nodeActionController->setNodeActionShortCode("edit");
            $nodeActionController->setNodeActionType("IN");
            $nodeActionController->setNodeActionSortNo("3"); 
            $nodeActionController->setIsLayout(1);
            $nodeActionController->dataSave();
            
            
            $nodeActionController->setNodeActionName("VIEW");
            $nodeActionController->setNodeActionShortCode("view");
            $nodeActionController->setNodeActionType("IN");
            $nodeActionController->setNodeActionSortNo("4"); 
            $nodeActionController->setIsLayout(1);
            $nodeActionController->dataSave();
            
            
            $nodeActionController->setNodeActionName("DELETE");
            $nodeActionController->setNodeActionShortCode("delete");
            $nodeActionController->setNodeActionType("IN|MRA");
            $nodeActionController->setNodeActionSortNo("5");            
            $nodeActionController->dataSave();
            
            
            $nodeActionController->setNodeActionName("EXPORT");
            $nodeActionController->setNodeActionShortCode("export");
            $nodeActionController->setNodeActionType("SN");
            $nodeActionController->setNodeActionSortNo("6");            
            $nodeActionController->dataSave();
            
            
            $nodeActionController->setNodeActionName("IMPORT");
            $nodeActionController->setNodeActionShortCode("import");
            $nodeActionController->setNodeActionType("SN");
            $nodeActionController->setNodeActionSortNo("7");            
            $nodeActionController->dataSave();
            
            
            $nodeActionController->setNodeActionName("MRA");
            $nodeActionController->setNodeActionShortCode("MRA");
            $nodeActionController->setNodeActionType("SN");
            $nodeActionController->setNodeActionSortNo("4");            
            $nodeActionController->dataSave();
            
            
            $nodeActionController->setNodeActionName("Verified");
            $nodeActionController->setNodeActionShortCode("VFY");
            $nodeActionController->setNodeActionType("IN|MRA");
            $nodeActionController->setNodeActionSortNo("8");            
            $nodeActionController->dataSave();
            
            $nodeActionController->setNodeActionName("Approved");
            $nodeActionController->setNodeActionShortCode("APD");
            $nodeActionController->setNodeActionType("IN|MRA");
            $nodeActionController->setNodeActionSortNo("9");            
            $nodeActionController->dataSave();
            
            $nodeActionController->setNodeActionName("Pending");
            $nodeActionController->setNodeActionShortCode("PND");
            $nodeActionController->setNodeActionType("IN|MRA");
            $nodeActionController->setNodeActionSortNo("10");            
            $nodeActionController->dataSave();
            
            $nodeActionController->setNodeActionName("Cancel");
            $nodeActionController->setNodeActionShortCode("CNL");
            $nodeActionController->setNodeActionType("IN|MRA");
            $nodeActionController->setNodeActionSortNo("11");            
            $nodeActionController->dataSave();
            
            $nodeActionController->setNodeActionName("Publish");
            $nodeActionController->setNodeActionShortCode("Publish");
            $nodeActionController->setNodeActionType("IN|MRA");
            $nodeActionController->setNodeActionSortNo("12");            
            $nodeActionController->dataSave();
            
            $nodeActionController->setNodeActionName("Un Publish");
            $nodeActionController->setNodeActionShortCode("UnPublish");
            $nodeActionController->setNodeActionType("IN|MRA");
            $nodeActionController->setNodeActionSortNo("13");            
            $nodeActionController->dataSave();
            
            $nodeActionController->setNodeActionName("Print");
            $nodeActionController->setNodeActionShortCode("Print");
            $nodeActionController->setNodeActionType("IN");
            $nodeActionController->setNodeActionSortNo("14");            
            $nodeActionController->dataSave();
            
            $nodeActionController->setNodeActionName("Final");
            $nodeActionController->setNodeActionShortCode("Final");
            $nodeActionController->setNodeActionType("MRA|IN");
            $nodeActionController->setNodeActionSortNo("15");            
            $nodeActionController->dataSave();
            
            $nodeActionController->setNodeActionName("UnFinal");
            $nodeActionController->setNodeActionShortCode("UNFINAL");
            $nodeActionController->setNodeActionType("MRA|IN");
            $nodeActionController->setNodeActionSortNo("16");            
            $nodeActionController->dataSave();
            
            
            $relationController=  \CoreClass::getController("core_node_relations","core_developmentsettings");
            $relationController->setCoreNodeSettingsId("core_node_actions");
            $relationController->setCoreNodeColname("core_action_type_id");
            $relationController->setCoreRelationTypeId("MTO");
            $relationController->setCoreNodeParent("core_action_type");
            $relationController->setSortValue("1");
            $relationController->dataSave();
            
            
        }
        catch (Exception $ex)
        {
            \Core::Log($ex->getMessage(),"installdataexception.log");
        }
    }
}
