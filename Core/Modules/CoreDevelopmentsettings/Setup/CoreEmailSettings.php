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
class CoreEmailSettings
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_email_settings");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Email Settings");
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
                "name"=>"host_securetype",
                "displayValue"=>"Host Secure Type",            
                "default"=>NULL,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"host_port",
                "displayValue"=>"Host Port",            
                "default"=>NULL,  
                "type"=>"int",
                "size"=>"11"         
            ));
            $setup->addColumnName(array(
                "name"=>"host_name",
                "displayValue"=>"Host Name",            
                "default"=>NULL,  
                "type"=>"varchar",
                "size"=>"255"         
            ));
            $setup->addColumnName(array(
                "name"=>"host_username",
                "displayValue"=>"Host Username",            
                "default"=>NULL,  
                "type"=>"varchar",
                "size"=>"255"         
            ));
            $setup->addColumnName(array(
                "name"=>"host_password",
                "displayValue"=>"Host Passward",            
                "default"=>NULL,  
                "type"=>"varchar",
                "size"=>"255"         
            ));
            $setup->addColumnName(array(
                "name"=>"fromemail",
                "displayValue"=>"Form Email",            
                "default"=>NULL,  
                "type"=>"varchar",
                "size"=>"255"         
            ));
            $setup->addColumnName(array(
                "name"=>"fromname",
                "displayValue"=>"Form Name",            
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
