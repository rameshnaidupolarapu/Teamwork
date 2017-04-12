<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreReportsdetail
 *
 * @author ramesh
 */
  namespace Core\Modules\CoreDevelopmentsettings\Setup;
class CoreReportDetails 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_reportsdetails");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Report Details");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"Report Id",
                "prmiary"=>1,
                "key"=>"unique",
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11",
                "auto_increment"=>1            
            ));
            $setup->addColumnName(array(
                "name"=>"node_id",
                "displayValue"=>"Node Name",            
                "default"=>false,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"name",
                "displayValue"=>"Name",            
                "default"=>false,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"core_output_type_id",
                "displayValue"=>"Output Type",                
                "type"=>"varchar",
                "size"=>"255"                
            ));  
            $setup->addColumnName(array(
                "name"=>"db_output_type_id",
                "displayValue"=>"Dashboad Output Type",               
                "type"=>"varchar",
                "size"=>"255"                
            ));
            $setup->addColumnName(array(
                "name"=>"qry",
                "displayValue"=>"Qry",                
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"show_dashboard",
                "displayValue"=>"Is Show In Dashboard",               
                "type"=>"tinyint",
                "size"=>"1"                
            ));
            $setup->addColumnName(array(
                "name"=>"is_custom",
                "displayValue"=>"Is Custom",               
                "type"=>"tinyint",
                "size"=>"1"                
            ));
            $setup->addColumnName(array(
                "name"=>"is_publish",
                "displayValue"=>"Is Publish",               
                "type"=>"tinyint",
                "size"=>"1"                
            ));
            $setup->addColumnName(array(
                "name"=>"sortvalue",
                "displayValue"=>"Sort Value",               
                "type"=>"int",
                "size"=>"11"                
            ));
            $setup->addColumnName(array(
                "name"=>"createdby",
                "displayValue"=>"Created User Id",            
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
                "displayValue"=>"Updated User Id",            
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
