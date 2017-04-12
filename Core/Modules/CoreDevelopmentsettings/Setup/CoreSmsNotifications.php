<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreSmsNotifications
 *
 * @author ramesh
 */
  namespace Core\Modules\CoreDevelopmentsettings\Setup;
class CoreSmsNotifications 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_sms_notifications");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("SMS Notifications");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"SMS Notification Id",                
                "type"=>"int",
                "size"=>"11",
                "key"=>"primary",
                "auto_increment"=>1,           
            ));
            $setup->addColumnName(array(
                "name"=>"core_registernode_id",
                "displayValue"=>"Node Name",            
                "default"=>NULL,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"core_node_actions_id",
                "displayValue"=>"Node Action Code",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"template",
                "displayValue"=>"Template",            
                "default"=>false,
                "type"=>"longtext"
            ));
            $setup->addColumnName(array(
                "name"=>"defaultnos",
                "displayValue"=>"Default Nos",            
                "default"=>false,
                "type"=>"longtext"
            ));
             $setup->addColumnName(array(
                "name"=>"colname",
                "displayValue"=>"Column Name",            
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
    }
}
