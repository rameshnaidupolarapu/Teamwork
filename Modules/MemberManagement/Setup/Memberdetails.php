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
 namespace Modules\MemberManagement\Setup;
class Memberdetails 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         
        $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("tw_member");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Memberdetails");
            $setup->addColumnName(array(
                "name"=>"tw_member_id",
                "displayValue"=>"Member Id",                
                "type"=>"int",
                "size"=>"11",
                "key"=>"primary",
                "auto_increment"=>1,           
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
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"emailid",
                "displayValue"=>"Email",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"mobile_no",
                "displayValue"=>"Mobile",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            
             $setup->addColumnName(array(
                "name"=>"tw_designation",
                "displayValue"=>"Designation",            
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
