<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreLoginhistory
 *
 * @author ramesh
 */
  namespace Core\Modules\CoreUsermanagement\Setup;
class CoreLoginhistory 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();
        $setup=$cc->getObject("\Core\DataBase\Setup"); 
        $setup->setTable("core_loginhistory");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Login History");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"History Id",
                "prmiary"=>false,
                "key"=>"unique",
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11",
                "auto_increment"=>1,
                "prmiary"=>1,
            ));
            $setup->addColumnName(array(
                "name"=>"core_user_id",
                "displayValue"=>"User Id",            
                "default"=>false,                
                "type"=>"bigint",
                "size"=>"20"          
            ));
            $setup->addColumnName(array(
                "name"=>"name",
                "displayValue"=>"User Name",                
                "type"=>"varchar",
                "size"=>"255"                
            ));       
            $setup->addColumnName(array(
                "name"=>"datetime",
                "displayValue"=>"Datetime",            
                "default"=>NULL,
                "type"=>"datetime"
            ));
            $setup->addColumnName(array(
                "name"=>"status",
                "displayValue"=>"Status",            
                "default"=>NULL,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"host",
                "displayValue"=>"host",            
                "default"=>NULL,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"sesssionid",
                "displayValue"=>"Sesssion Id",            
                "default"=>NULL,
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
