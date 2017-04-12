<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreAttributeOption
 *
 * @author ramesh
 */
  namespace Core\Modules\CoreDevelopmentsettings\Setup;
class CoreAttributeOption 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_attribute_option");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Attributes Option Details");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"Attributes Option Id",                
                "key"=>"unique",
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11",
                "auto_increment"=>1            
            ));
            $setup->addColumnName(array(
                "name"=>"name",
                "displayValue"=>"Attribute Name",            
                "default"=>false,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"attribute_code",
                "displayValue"=>"Attribute Code",            
                "default"=>false,                
                "type"=>"varchar",
                "size"=>"255",
                "prmiary"=>1,
            ));
            $setup->addColumnName(array(
                "name"=>"core_root_attributes_id",
                "displayValue"=>"Input Type",            
                "default"=>false,                
                "type"=>"varchar",
                "size"=>"255"                
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
