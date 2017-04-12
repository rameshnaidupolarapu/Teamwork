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
class CoreOrganization
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_organization");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Core Organization");
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
                "name"=>"name",
                "displayValue"=>"User Name",            
                "default"=>NULL,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"code",
                "displayValue"=>"Code",            
                "default"=>NULL,  
                "type"=>"varchar",
                "size"=>"50"         
            ));
            $setup->addColumnName(array(
                "name"=>"email",
                "displayValue"=>"Email",            
                "default"=>NULL,  
                "type"=>"varchar",
                "size"=>"200"         
            ));
            $setup->addColumnName(array(
                "name"=>"phone_no",
                "displayValue"=>"Phone No",            
                "default"=>NULL,  
                "type"=>"bigint",
                "size"=>"12"         
            ));
            $setup->addColumnName(array(
                "name"=>"alternate_phone_no",
                "displayValue"=>"Alternate Phone No",            
                "default"=>NULL,  
                "type"=>"varchar",
                "size"=>"255"         
            ));
            $setup->addColumnName(array(
                "name"=>"logo",
                "displayValue"=>"Logo",            
                "default"=>NULL,  
                "type"=>"longtext",   
            ));
            $setup->addColumnName(array(
                "name"=>"core_country_id",
                "displayValue"=>"Country Id",            
                "default"=>NULL,  
                "type"=>"varchar",
                "size"=>"50"         
            ));
            $setup->addColumnName(array(
                "name"=>"core_list_state_id",
                "displayValue"=>"List State Id",            
                "default"=>NULL,  
                "type"=>"bigint",
                "size"=>"11"         
            ));
            $setup->addColumnName(array(
                "name"=>"address1",
                "displayValue"=>"Address 1",            
                "default"=>NULL,  
                "type"=>"varchar",
                "size"=>"255"         
            ));
            $setup->addColumnName(array(
                "name"=>"address2",
                "displayValue"=>"Address 2",            
                "default"=>NULL,  
                "type"=>"varchar",
                "size"=>"255"         
            ));
            $setup->addColumnName(array(
                "name"=>"zipcode",
                "displayValue"=>"Zip Code",            
                "default"=>NULL,  
                "type"=>"int",
                "size"=>"8"         
            ));
            $setup->addColumnName(array(
                "name"=>"description",
                "displayValue"=>"Description",            
                "default"=>NULL,  
                "type"=>"longtext",   
            ));
            $setup->addColumnName(array(
                "name"=>"locationiframe",
                "displayValue"=>"location Frame",         
                "default"=>NULL,  
                "type"=>"text"       
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
