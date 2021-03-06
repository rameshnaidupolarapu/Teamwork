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
class TaskMemberTime 
{
    //put your code here
    function execute()
    {       
        $cc = new \CoreClass();         
        $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("tw_task_member_time");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Task Member Time");
            $setup->addColumnName(array(
                "name"=>"tw_task_member_time_id",
                "displayValue"=>"Task Member Id",                
                "type"=>"int",
                "size"=>"11",
                "key"=>"unique",
                "auto_increment"=>1,           
            ));
            $setup->addColumnName(array(
                "name"=>"tw_project_id",
                "displayValue"=>"Project Id",            
                "default"=>false,
                "type"=>"int",
                "size"=>"11"
            ));
            $setup->addColumnName(array(
                "name"=>"tw_task_id",
                "displayValue"=>"Task Id",            
                "default"=>false,
                "type"=>"int",
                "size"=>"11"
            ));
            $setup->addColumnName(array(
                "name"=>"tw_member_id",
                "displayValue"=>"Member Id",            
                "default"=>false,
                "type"=>"int",
                "size"=>"11"
            ));  
            $setup->addColumnName(array(
                "name"=>"log_date",
                "displayValue"=>"Member Id",            
                "default"=>false,
                "type"=>"date",
            ));  
            $setup->addColumnName(array(
                "name"=>"from_time",
                "displayValue"=>"From Time",            
                "default"=>false,
                "type"=>"time",
            ));
            $setup->addColumnName(array(
                "name"=>"to_time",
                "displayValue"=>"To Time",            
                "default"=>false,
                "type"=>"time",
            ));
            $setup->addColumnName(array(
                "name"=>"is_billable",
                "displayValue"=>"Is Billable",            
                "default"=>false,
                "type"=>"time",
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
