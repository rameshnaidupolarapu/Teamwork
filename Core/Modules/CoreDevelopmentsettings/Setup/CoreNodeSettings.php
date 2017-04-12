<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreNodeSettings
 *
 * @author ramesh
 */
  namespace Core\Modules\CoreDevelopmentsettings\Setup;
class CoreNodeSettings 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_node_settings");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Node Settings");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"Node Settings Id",
                "prmiary"=>false,
                "key"=>"unique",
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11",
                "auto_increment"=>1            
            ));
            $setup->addColumnName(array(
                "name"=>"core_registernode_id",
                "displayValue"=>"Node Name",            
                "default"=>false,
                "prmiary"=>1,
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"tablename",
                "displayValue"=>"Table Name",
                "type"=>"varchar",
                "size"=>"255"                
            ));
            $setup->addColumnName(array(
                "name"=>"autokey",
                "displayValue"=>"Auto Key",
                "type"=>"varchar",
                "size"=>"255"                
            ));
            $setup->addColumnName(array(
                "name"=>"primkey",
                "displayValue"=>"Primary Key",
                "type"=>"varchar",
                "size"=>"255"                
            ));
            $setup->addColumnName(array(
                "name"=>"descriptor",
                "displayValue"=>"Descriptor Display",
                "type"=>"varchar",
                "size"=>"255"                
            ));
            $setup->addColumnName(array(
                "name"=>"mandotatory_add",
                "displayValue"=>"Mandotatory Add",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"mandotatory_edit",
                "displayValue"=>"Mandotatory Edit",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"uniquefields",
                "displayValue"=>"Unique Fields",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"hide_add",
                "displayValue"=>"Hide Add",
                "type"=>"longtext"           
            )); 
            $setup->addColumnName(array(
                "name"=>"hide_edit",
                "displayValue"=>"Hide Edit",
                "type"=>"longtext"           
            )); 
            $setup->addColumnName(array(
                "name"=>"hide_view",
                "displayValue"=>"Hide View",
                "type"=>"longtext"           
            )); 
            $setup->addColumnName(array(
                "name"=>"hide_admin",
                "displayValue"=>"Hide Grid",
                "type"=>"longtext"           
            )); 
            $setup->addColumnName(array(
                "name"=>"readonly_add",
                "displayValue"=>"Readonly Add",
                "type"=>"longtext"           
            )); 
            $setup->addColumnName(array(
                "name"=>"readonly_edit",
                "displayValue"=>"Readonly Edit",
                "type"=>"longtext"           
            )); 
            $setup->addColumnName(array(
                "name"=>"boolattributes",
                "displayValue"=>"Bool Attributes",
                "type"=>"longtext"           
            )); 
            $setup->addColumnName(array(
                "name"=>"file",
                "displayValue"=>"File Attributes",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"fck",
                "displayValue"=>"Fck Attributes",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"checkbox",
                "displayValue"=>"Checkbox Attributes",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"selectbox",
                "displayValue"=>"Selectbox Attributes",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"multivalues",
                "displayValue"=>"Multi Value Attributes",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"editlist",
                "displayValue"=>"Edit List Attributes",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"numberattribute",
                "displayValue"=>"Number Attributes",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"search",
                "displayValue"=>"Search Attributes",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"dependee",
                "displayValue"=>"Dependee Attributes",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"defaultvalues",
                "displayValue"=>"Default Value Attributes",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"exactsearch",
                "displayValue"=>"Exact Search Attributes",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"total",
                "displayValue"=>"Total Attributes",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"colorattributes",
                "displayValue"=>"Color Attributes",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"core_node_actions_id",
                "displayValue"=>"Node Action",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"actionrestriction",
                "displayValue"=>" Action Restriction",
                "type"=>"longtext"           
            ));
            $setup->addColumnName(array(
                "name"=>"default_action",
                "displayValue"=>"Default Action",
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"default_collection",
                "displayValue"=>"Is Default Collection",
                "type"=>"tinyint",
                "size"=>"1"
            ));
            
            $setup->addColumnName(array(
                "name"=>"is_archive",
                "displayValue"=>"Is Archive",            
                "default"=>NULL,
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
