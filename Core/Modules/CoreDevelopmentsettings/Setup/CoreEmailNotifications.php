<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreBackupType
 *
 * @author ramesh
 */
  namespace Core\Modules\CoreDevelopmentsettings\Setup;
class CoreEmailNotifications
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_email_notifications");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Email Notifications");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"User Id",
                "prmiary"=>1,
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11",
                "auto_increment"=>1,           
            ));
            $setup->addColumnName(array(
                "name"=>"core_registernode_id",
                "displayValue"=>"Registration Node Id",            
                "default"=>NULL,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"core_node_actions_id",
                "displayValue"=>"Node Action Id",            
                "default"=>NULL,  
                "type"=>"varchar",
                "size"=>"255"         
            ));
            $setup->addColumnName(array(
                "name"=>"subject",
                "displayValue"=>"Subject",            
                "default"=>NULL,  
                "type"=>"text"         
            ));
            $setup->addColumnName(array(
                "name"=>"template",
                "displayValue"=>"Templete",            
                "default"=>NULL,  
                "type"=>"longtext"   
            ));
            $setup->addColumnName(array(
                "name"=>"defaultemails",
                "displayValue"=>"Default Emails",            
                "default"=>NULL,  
                "type"=>"longtext"    
            ));
            $setup->addColumnName(array(
                "name"=>"defaulttemplate",
                "displayValue"=>"Default Template",            
                "default"=>NULL,  
                "type"=>"longtext"    
            ));
            $setup->addColumnName(array(
                "name"=>"colname",
                "displayValue"=>"Col Name",            
                "default"=>NULL,  
                "type"=>"varchar",
                "size"=>"255"         
            ));
            $setup->addColumnName(array(
                "name"=>"active_status",
                "displayValue"=>"Active Status",            
                "default"=>NULL,  
                "type"=>"tinyint",
                "size"=>"1"         
            ));
            $setup->addColumnName(array(
                "name"=>"createdby",
                "displayValue"=>"Created Id",            
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11"
            ));
            $setup->addColumnName(array(
                "name"=>"createdat",
                "displayValue"=>"Created Datetime",            
                "default"=>NULL,
                "type"=>"datetime"
            ));
            $setup->addColumnName(array(
                "name"=>"updatedby",
                "displayValue"=>"Updated Id",            
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11"
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
