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
class CoreFormSettings
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_form_settings");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Form Settings");
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
                "displayValue"=>"Node Settings Id",            
                "default"=>NULL,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"core_element_displaytype_id",
                "displayValue"=>"Element Display Id",            
                "default"=>NULL,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"name",
                "displayValue"=>"User Name",            
                "default"=>NULL,
                "type"=>"Varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"code",
                "displayValue"=>"Code",            
                "default"=>NULL,
                "type"=>"Varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"parent",
                "displayValue"=>"Parent",            
                "default"=>NULL,
                "type"=>"Varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"parent_level",
                "displayValue"=>"Parent Level",            
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11"
            ));
             $setup->addColumnName(array(
                "name"=>"sortorder",
                "displayValue"=>"Sort Order",           
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11"
            ));
           $setup->addColumnName(array(
                "name"=>"createdat",
                "displayValue"=>"Create Datetime",            
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
