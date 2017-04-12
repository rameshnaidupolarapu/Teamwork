<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreOutputType
 *
 * @author ramesh
 */
  namespace Core\Modules\CoreDevelopmentsettings\Setup;
class CoreOutputType 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_output_type");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Output Type");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"Action Type Id",
                "prmiary"=>false,
                "key"=>"unique",
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11",
                "auto_increment"=>1            
            ));
            $setup->addColumnName(array(
                "name"=>"name",
                "displayValue"=>"Name",            
                "default"=>false,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"short_code",
                "displayValue"=>"Short Code",
                "prmiary"=>1,
                "type"=>"varchar",
                "size"=>"255"                
            )); 
            $setup->addColumnName(array(
                "name"=>"is_chart",
                "displayValue"=>"Is Chart",                
                "type"=>"tinyint",
                "size"=>"1"                
            )); 
            $setup->addColumnName(array(
                "name"=>"is_export",
                "displayValue"=>"Is Export",                
                "type"=>"tinyint",
                "size"=>"1"                
            )); 
            $setup->addColumnName(array(
                "name"=>"active_status",
                "displayValue"=>"Is Active",                
                "type"=>"tinyint",
                "size"=>"1"                
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
