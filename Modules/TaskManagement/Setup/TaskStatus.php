<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreSmsSettings
 *
 * @author ramesh
 */
 namespace Modules\TaskManagement\Setup;
class TaskStatus 
{
    //put your code here
    function execute()
    {       
        $cc = new \CoreClass();         
        $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("tw_task_status");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Task Status");
            $setup->addColumnName(array(
                "name"=>"tw_task_status_id",
                "displayValue"=>"Status Id",                
                "type"=>"int",
                "size"=>"11",
                "key"=>"unique",
                "auto_increment"=>1,           
            ));
            $setup->addColumnName(array(
                "name"=>"status_name",
                "displayValue"=>"Status Name",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"status_code",
                "displayValue"=>"Status Code",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255",
                "key"=>"primary",
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
