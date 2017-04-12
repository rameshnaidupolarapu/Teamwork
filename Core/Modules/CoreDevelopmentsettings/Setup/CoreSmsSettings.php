<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreSmsSettings
 *
 * @author ramesh
 */
  namespace Core\Modules\CoreDevelopmentsettings\Setup;
class CoreSmsSettings 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_sms_settings");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Sms Settings");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"Sms Settings Id",                
                "type"=>"int",
                "size"=>"11",
                "key"=>"primary",
                "auto_increment"=>1,           
            ));
            $setup->addColumnName(array(
                "name"=>"gateway",
                "displayValue"=>"Gate Way Url",            
                "default"=>NULL,                
                "type"=>"text"         
            ));
            $setup->addColumnName(array(
                "name"=>"username",
                "displayValue"=>"User Name",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"password",
                "displayValue"=>"Password",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"route",
                "displayValue"=>"Route Id",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"senderid",
                "displayValue"=>"Sender Id",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"active_status",
                "displayValue"=>"Is Active",            
                "default"=>false,
                "type"=>"tinyint",
                "size"=>"1"
            ));
            $setup->addColumnName(array(
                "name"=>"createdby",
                "displayValue"=>"Created User Id",            
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11",                
            ));
             $setup->addColumnName(array(
                "name"=>"createdat",
                "displayValue"=>"Created Datetime",            
                "default"=>NULL,
                "type"=>"datetime"
            ));
            $setup->addColumnName(array(
                "name"=>"updatedby",
                "displayValue"=>"Updated User Id",            
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11",                
            ));
            $setup->addColumnName(array(
                "name"=>"updatedat",
                "displayValue"=>"Updated Datetime",            
                "default"=>NULL,
                "type"=>"datetime"
            ));
             $setup->create();
        }
        $cc = new \CoreClass();
        $setup=$cc->getObject("\Core\DataBase\Setup");
        $setup->setTable("core_sms_settings");
        if($setup->tableExists($setup->getTable()))
        {
            $setup->addColumnName(array(
                "name"=>"updatedat",
                "displayValue"=>"Updated Datetime",            
                "default"=>NULL,
                "type"=>"datetime"
            ));
            $setup->addColumnName(array(
                "name"=>"ramesh",
                "displayValue"=>"Updated Datetime",            
                "default"=>NULL,
                "type"=>"datetime"
            ));
            $setup->alterTable();
        }
        
        $setup=$cc->getObject("\Core\DataBase\Setup");
        $setup->setTable("core_sms_settings");
        $setup->setFieldName("ramesh");
        if($setup->fieldExitsinTable())
        {
            $setup->addColumnName(array(
                "name"=>"ramesh",
                "displayValue"=>"Updated Datetime",            
                "default"=>NULL,
                "type"=>"datetime"
            ));
        }
        $setup->dropfieldTable();
    }
}
