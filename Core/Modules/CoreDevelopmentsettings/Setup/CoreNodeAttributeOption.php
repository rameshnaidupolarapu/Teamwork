<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreNodeAttributeOption
 *
 * @author ramesh
 */
  namespace Core\Modules\CoreDevelopmentsettings\Setup;
class CoreNodeAttributeOption 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_node_attribute_option");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Node Attributes Option Details");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"Node Attributes Option Id",                
                "key"=>"unique",
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11",
                "prmiary"=>1,
                "auto_increment"=>1            
            ));
            $setup->addColumnName(array(
                "name"=>"core_node_settings_id",
                "displayValue"=>"Node Name",            
                "default"=>false,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"core_attribute_name",
                "displayValue"=>"Attribute Name",            
                "default"=>false,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"core_attribute_option_id",
                "displayValue"=>"Attribute Code",            
                "default"=>false,                
                "type"=>"varchar",
                "size"=>"255",
                
            ));
            $setup->addColumnName(array(
                "name"=>"core_node_attributeset_id",
                "displayValue"=>"Attribute Set Id",            
                "default"=>false,                
                "type"=>"int",
                "size"=>"11",
                
            ));
	    $setup->addColumnName(array(
                "name"=>"is_filter",
                "displayValue"=>"Is Filter",            
                "default"=>NULL,                
                "type"=>"tinyint",
                "size"=>"2",
                
            ));
            $setup->addColumnName(array(
                "name"=>"is_readonly",
                "displayValue"=>"Is Readonly",            
                "default"=>false,                
                "type"=>"tinyint",
                "size"=>"1",
                
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
