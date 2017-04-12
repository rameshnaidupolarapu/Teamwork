<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreAdminthemeSettings
 *
 * @author ramesh
 */
  namespace Core\Modules\CoreDevelopmentsettings\Setup;
class CoreAdminthemeSettings 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_adminthemesettings");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Admin Theme Settings");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"Admin Theme Setting Id",                
                "type"=>"int",
                "size"=>"11",
                "key"=>"primary",
                "auto_increment"=>1,           
            ));
            $setup->addColumnName(array(
                "name"=>"loading_image",
                "displayValue"=>"Load Image Url",            
                "default"=>NULL,                
                "type"=>"text"        
            ));
            $setup->addColumnName(array(
                "name"=>"sidemunebgcolor",
                "displayValue"=>"Menu Background Color",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"sidemenucolor",
                "displayValue"=>"Menu Color",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"menuitembgcolor",
                "displayValue"=>"Menu Item Background Color",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
             $setup->addColumnName(array(
                "name"=>"menuitemcolor",
                "displayValue"=>"Menu Item Color",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
             $setup->addColumnName(array(
                "name"=>"totalbgcolor",
                "displayValue"=>"Total Background Color",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
             $setup->addColumnName(array(
                "name"=>"active_status",
                "displayValue"=>"Is Active",            
                "default"=>false,
                "type"=>"tinyint",
                "size"=>"1"
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
