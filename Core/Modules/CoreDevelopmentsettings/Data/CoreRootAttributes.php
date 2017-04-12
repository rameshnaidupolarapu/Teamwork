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
class CoreRootAttributes
{
    //put your code here
    public function execute()
    {
        try
        {            
            $registerController=\CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_root_attributes");
            $registerController->setNodeNameData("core_root_attributes");
            $registerController->setDisplayValue("Root Attributes");
            $registerController->setIsModule("0");
            $registerController->setRootModuleId("core_developmentsettings");
            $registerController->setModuleId("core_developmentsettings");
            $registerController->setModuleDisplayId("core_developmentsettings");
            $registerController->setSortValue("5");
            $registerController->setIcon("");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
            
            $registerController=\CoreClass::getController("CoreNodeSettings", "core_developmentsettings");
            $registerController->setRegisternodeId("core_root_attributes");           
            $registerController->setTablename("core_root_attributes");
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
            $registerController->setBoolattributes("");
            $registerController->setFile("");
            $registerController->setFck("");
            $registerController->setCheckbox("");
            $registerController->setSelectbox("");
            $registerController->setMultivalues("");
            $registerController->setEditlist("");
            $registerController->setNumberattribute("");
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
			
			$attributetypeData=array("Text"=>"text","Boolean"=>"checkbox","File"=>"file","Image"=>"image","Video"=>"video","Url"=>"url","Select"=>"select","Radio"=>"radio","Date"=>"date","Time"=>"time","Date and Time"=>"datetime","Time Zone"=>"timezone","IP Address"=>"ipaddress","HTML Editor"=>"htmleditor","Color"=>"color","Number"=>"number","Integer"=>"integer","Email"=>"email","Password"=>"password","Range"=>"range");
			foreach($attributetypeData as $name=>$key)
			{
				$attributeController=\CoreClass::getController("core_root_attributes", "core_developmentsettings");           
				$attributeController->setAttributeName($name);
				$attributeController->setAttributeCode($key);
				$attributeController->dataSave();
			}
            
        }
        catch (Exception $ex)
        {
            \Core::Log($ex->getMessage(),"installdataexception.log");
        }
    }
}
