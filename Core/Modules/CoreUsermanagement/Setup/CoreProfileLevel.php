<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreProfileLevel
 *
 * @author ramesh
 */
  namespace Core\Modules\CoreUsermanagement\Setup;
class CoreProfileLevel
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();
        $setup=$cc->getObject("\Core\DataBase\Setup");   
        $setup->setTable("core_profile_level");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Profile Level Details");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"Access Id",
                "prmiary"=>false,
                "key"=>"unique",
                "default"=>NULL,
                "type"=>"bigint",
                "size"=>"11",               
                "auto_increment"=>1            
            ));
            $setup->addColumnName(array(
                "name"=>"sortvalue",
                "displayValue"=>"Sort Value",            
                "default"=>false,                
                "type"=>"int",
                "size"=>"11",
                 "prmiary"=>1,
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
