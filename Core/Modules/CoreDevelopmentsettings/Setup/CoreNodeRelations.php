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
class CoreNodeRelations 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_node_relations");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Node Relations");
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
                "name"=>"core_node_settings_id",
                "displayValue"=>"Node Setting Id",            
                "default"=>NULL,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"core_node_colname",
                "displayValue"=>"Node ColName",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"          
            ));
             $setup->addColumnName(array(
                "name"=>"core_relation_type_id",
                "displayValue"=>"Relation TypeId",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"          
            ));
              $setup->addColumnName(array(
                "name"=>"core_node_parent",
                "displayValue"=>"Node Parent",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"          
            ));
               $setup->addColumnName(array(
                "name"=>"dependee_fields",
                "displayValue"=>"Dependee Fields",            
                "default"=>false,
                "type"=>"longtext",         
            ));
                $setup->addColumnName(array(
                "name"=>"sort_value",
                "displayValue"=>"Sort Value",            
                "default"=>false,
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
                "name"=>"updatedat",
                "displayValue"=>"Updated Datetime",            
                "default"=>NULL,
                "type"=>"datetime"
            ));
             $setup->create();
        }
    }
}
