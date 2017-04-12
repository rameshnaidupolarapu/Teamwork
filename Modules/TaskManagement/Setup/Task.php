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
class Task 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         
        $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("tw_task");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Task");
            $setup->addColumnName(array(
                "name"=>"tw_task_id",
                "displayValue"=>"task Id",                
                "type"=>"int",
                "size"=>"11",
                "key"=>"primary",
                "auto_increment"=>1,           
            ));
             $setup->addColumnName(array(
                "name"=>"tw_project_id",
                "displayValue"=>"Project Id",                
                "type"=>"int",
                "size"=>"11",      
            ));
            $setup->addColumnName(array(
                "name"=>"task_name",
                "displayValue"=>"Task Name",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"task_code",
                "displayValue"=>"Task Code",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));            
            $setup->addColumnName(array(
                "name"=>"task_description",
                "displayValue"=>"Task Description",            
                "default"=>false,
                "type"=>"text"
            ));
            $setup->addColumnName(array(
                "name"=>"parent",
                "displayValue"=>"Task Parent",            
                "type"=>"int",
                "size"=>"11",
                "default"=>false,
            ));
            $setup->addColumnName(array(
                "name"=>"parent_level",
                "displayValue"=>"Task Parent",            
                "type"=>"int",
                "size"=>"11",
                "default"=>false,
            ));
             $setup->addColumnName(array(
                "name"=>"task_from_date",
                "displayValue"=>"Task From Date",            
                "default"=>false,
                "type"=>"datetime"
            ));
            $setup->addColumnName(array(
                "name"=>"task_to_date",
                "displayValue"=>"Task To Date",            
                "default"=>false,
                "type"=>"datetime"
            ));
            $setup->addColumnName(array(
                "name"=>"task_status_id",
                "displayValue"=>"Task Status",            
                "default"=>false,
                "type"=>"text"
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
