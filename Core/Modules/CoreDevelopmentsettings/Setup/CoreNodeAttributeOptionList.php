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
class CoreNodeAttributeOptionList 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_node_attribute_option_list");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Node Attributes Option List");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"Node Attributes Option List Id",                
                "key"=>"unique",
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11",
                "prmiary"=>1,
                "auto_increment"=>1            
            ));
            $setup->addColumnName(array(
                "name"=>"core_node_attribute_option_id",
                "displayValue"=>"Attribute OPtion Id",            
                "default"=>NULL,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"short_code",
                "displayValue"=>"Code",            
                "default"=>false,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"value",
                "displayValue"=>"Value",            
                "default"=>false,                
                "type"=>"varchar",
                "size"=>"255",
                
            ));
            $setup->addColumnName(array(
                "name"=>"is_default",
                "displayValue"=>"Is Default",            
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
