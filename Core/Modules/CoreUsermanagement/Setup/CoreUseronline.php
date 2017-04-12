<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreUseronline
 *
 * @author ramesh
 */
  namespace Core\Modules\CoreUsermanagement\Setup;
class CoreUseronline 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();
        $setup=$cc->getObject("\Core\DataBase\Setup");
        $setup->setTable("core_useronline");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Online User Details");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"Id",
                "prmiary"=>1,
                "key"=>"primary",
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11",
                "auto_increment"=>1            
            ));
            $setup->addColumnName(array(
                "name"=>"core_user_id",
                "displayValue"=>"User Id",            
                "default"=>false,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"name",
                "displayValue"=>"user Name",            
                "default"=>false,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"host",
                "displayValue"=>"Host",                
                "type"=>"varchar",
                "size"=>"255"                
            ));  
            $setup->addColumnName(array(
                "name"=>"sesssionid",
                "displayValue"=>"Sesssion Id",               
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
