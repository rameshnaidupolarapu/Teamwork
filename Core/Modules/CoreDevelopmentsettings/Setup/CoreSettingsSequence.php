<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreSettingsSequence
 *
 * @author ramesh
 */
  namespace Core\Modules\CoreDevelopmentsettings\Setup;
class CoreSettingsSequence 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_settings_sequence");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Settings Sequence");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"Settings Sequence Id",                
                "type"=>"int",
                "size"=>"11",
                "key"=>"primary",
                "auto_increment"=>1,           
            ));
            $setup->addColumnName(array(
                "name"=>"identity",
                "displayValue"=>"Identity",            
                "default"=>NULL,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"prefix",
                "displayValue"=>"prefix",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"sequence_from",
                "displayValue"=>"Sequence From",            
                "default"=>false,
                "type"=>"int",
                "size"=>"11"
            ));
            $setup->addColumnName(array(
                "name"=>"left_padding",
                "displayValue"=>"Left Padding",            
                "default"=>false,
                "type"=>"int",
                "size"=>"11"
            ));
            $setup->addColumnName(array(
                "name"=>"current_sequence",
                "displayValue"=>"Current Sequence",            
                "default"=>false,
                "type"=>"int",
                "size"=>"11"
            ));
            $setup->addColumnName(array(
                "name"=>"createdby",
                "displayValue"=>"Created User Id",            
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11",                
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
                "size"=>"11",                
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
