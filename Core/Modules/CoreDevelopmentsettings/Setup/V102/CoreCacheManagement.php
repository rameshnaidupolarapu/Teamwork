<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreSetupschema
 *
 * @author venkatesh
 */
 namespace Core\Modules\CoreDevelopmentsettings\Setup\V102;
class CoreCacheManagement
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_cachemanagement");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Cache Management");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"Cache Id",
                "prmiary"=>false,
                "key"=>"unique",
                "default"=>NULL,
                "type"=>"bigint",
                "size"=>"11",
                "prmiary"=>1,
                "auto_increment"=>1            
            ));
            $setup->addColumnName(array(
                "name"=>"cache_type",
                "displayValue"=>"Cache Type",            
                "default"=>false,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"description",
                "displayValue"=>"Description",                
                "type"=>"text",	
            ));   
            $setup->addColumnName(array(
                "name"=>"code",
                "displayValue"=>"Code",                
                "type"=>"varchar",
                "size"=>"255"                
            ));  
            $setup->addColumnName(array(
                "name"=>"status",
                "displayValue"=>"Status",                
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
