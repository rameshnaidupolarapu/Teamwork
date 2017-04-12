<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreRegisternode
 *
 * @author ramesh
 */
  namespace Core\Modules\CoreDevelopmentsettings\Setup;
class CoreRegisternode 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_registernode");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Node Details");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"Id",
                "prmiary"=>false,
                "key"=>"unique",
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11",
                "auto_increment"=>1            
            ));
            $setup->addColumnName(array(
                "name"=>"nodefile",
                "displayValue"=>"Node File",            
                "default"=>NULL,
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"nodename",
                "displayValue"=>"Node Name",            
                "default"=>false,
                "prmiary"=>1,
                "type"=>"varchar",
                "size"=>"255",
                "prmiary"=>true,
            ));
            $setup->addColumnName(array(
                "name"=>"displayvalue",
                "displayValue"=>"Display Value",
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"is_module",
                "displayValue"=>"Is Module",            
                "default"=>NULL,
                "type"=>"tinyint",
                "size"=>"1"
            ));
            $setup->addColumnName(array(
                "name"=>"core_root_module_id",
                "displayValue"=>"Root Module",
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));       
            $setup->addColumnName(array(
                "name"=>"core_module_id",
                "displayValue"=>"Code Module",
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"core_module_display_id",
                "displayValue"=>"Module Display ",
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"sort_value",
                "displayValue"=>"Sort Value",
                "default"=>false,
                "type"=>"int",
                "size"=>"11"
            ));
            $setup->addColumnName(array(
                "name"=>"icon",
                "displayValue"=>"Icon",
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"menu",
                "displayValue"=>"Is Menu",            
                "default"=>NULL,
                "type"=>"tinyint",
                "size"=>"1"
            ));
            $setup->addColumnName(array(
                "name"=>"is_notification",
                "displayValue"=>"Is Notification",            
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
