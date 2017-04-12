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
 namespace Modules\Project\Setup;
class Project 
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         
        $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("tw_project");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Project");
            $setup->addColumnName(array(
                "name"=>"tw_project_id",
                "displayValue"=>"project Id",                
                "type"=>"int",
                "size"=>"11",
                "key"=>"primary",
                "auto_increment"=>1,           
            ));
            $setup->addColumnName(array(
                "name"=>"project_name",
                "displayValue"=>"Project Name",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"project_code",
                "displayValue"=>"Project Code",            
                "default"=>false,
                "type"=>"varchar",
                "size"=>"255"
            ));            
            $setup->addColumnName(array(
                "name"=>"project_logo",
                "displayValue"=>"Project Logo",            
                "default"=>false,
                "type"=>"text"
            ));
            $setup->addColumnName(array(
                "name"=>"project_status_id",
                "displayValue"=>"Project Status",            
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
