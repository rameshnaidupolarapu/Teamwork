<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreAccess
 *
 * @author ramesh
 */
  namespace Core\Modules\CoreUsermanagement\Setup;
class CoreWebsiteusers 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();
        $setup=$cc->getObject("\Core\DataBase\Setup");
        $setup->setTable("core_websiteusers");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Websiteusers Details");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"Websiteuser Id",
                "prmiary"=>false,
                "key"=>"unique",
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11",
                "prmiary"=>1,
                "auto_increment"=>1            
            ));
            $setup->addColumnName(array(
                "name"=>"first_name",
                "displayValue"=>"First Name",            
                "default"=>false,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"last_name",
                "displayValue"=>"Last Name",                
                "type"=>"varchar",
                "size"=>"255"                
            ));   
            $setup->addColumnName(array(
                "name"=>"username",
                "displayValue"=>"User Name",                
                "type"=>"varchar",
                "size"=>"255"                
            ));   
            $setup->addColumnName(array(
                "name"=>"usercode",
                "displayValue"=>"Created User Code",            
                "default"=>NULL,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"email_id",
                "displayValue"=>"Email Id",            
                "default"=>NULL,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"phone_no",
                "displayValue"=>"Phone No",            
                "default"=>NULL,
                "type"=>"int",
                "size"=>"14"
            ));
            $setup->addColumnName(array(
                "name"=>"password",
                "displayValue"=>"Password",            
                "default"=>NULL,
                "type"=>"text"
            ));
            $setup->addColumnName(array(
                "name"=>"profile_id",
                "displayValue"=>"Profile Id",            
                "default"=>NULL,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"createdby",
                "displayValue"=>"Created By",            
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
                "displayValue"=>"Updated By",            
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11"
            ));
            $setup->addColumnName(array(
                "name"=>"updatedat",
                "displayValue"=>"Updated Date",            
                "default"=>NULL,
                "type"=>"datetime"
            ));
            $setup->create();
        }
    }
}
