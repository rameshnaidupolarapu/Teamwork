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
class CoreCountry 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_country");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Country");
            $setup->addColumnName(array(
                "name"=>"id",
                "displayValue"=>"User Id",
                "key"=>"unique",
                "default"=>NULL,
                "type"=>"int",
                "size"=>"11",
                "auto_increment"=>1,           
            ));
            $setup->addColumnName(array(
                "name"=>"name",
                "displayValue"=>"User Name",            
                "default"=>NULL,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"short_code",
                "displayValue"=>"Short Code",            
                "default"=>false,  
                "prmiary"=>1,
                "type"=>"varchar",
                "size"=>"50"          
            ));
             $setup->addColumnName(array(
                "name"=>"isd_code",
                "displayValue"=>"ISD Code",            
                "default"=>NULL,                
                "type"=>"varchar",
                "size"=>"50"          
            ));
             $setup->addColumnName(array(
                "name"=>"phno_size",
                "displayValue"=>"Pnone No",            
                "default"=>NULL,                
                "type"=>"int",
                "size"=>"2"          
            ));
              $setup->addColumnName(array(
                "name"=>"createdby",
                "displayValue"=>"Created Id",            
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
                "displayValue"=>"Updated Id",            
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
