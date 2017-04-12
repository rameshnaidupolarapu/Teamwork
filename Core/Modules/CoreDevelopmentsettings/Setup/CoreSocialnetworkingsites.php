<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreSocialnetworkingsites
 *
 * @author ramesh
 */
namespace Core\Modules\CoreDevelopmentsettings\Setup;
class CoreSocialnetworkingsites 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_socialnetworkingsites");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Social Networking Site ");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"Social Networking Site Id",                
                "type"=>"int",
                "size"=>"11",
                "key"=>"unique",
                "auto_increment"=>1,           
            ));
            $setup->addColumnName(array(
                "name"=>"name",
                "displayValue"=>"Name",            
                "default"=>NULL,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"short_code",
                "displayValue"=>"Short Code",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255",
                "key"=>"primary"
            ));
            $setup->addColumnName(array(
                "name"=>"icon",
                "displayValue"=>"Icon",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
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
