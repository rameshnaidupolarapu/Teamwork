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
class CoreNodeHistory
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_node_history");
        if(!$setup->tableExists($setup->getTable()))
        {
            $setup->setDisplayValue("Node History");
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
                "name"=>"node_id",
                "displayValue"=>"Node Id",            
                "default"=>NULL,                
                "type"=>"varchar",
                "size"=>"255"          
            ));
            $setup->addColumnName(array(
                "name"=>"table_name",
                "displayValue"=>"Table Name",            
                "default"=>NULL,  
                "type"=>"varchar",
                "size"=>"255"
            ));
            $setup->addColumnName(array(
                "name"=>"pk_value",
                "displayValue"=>"PK Value",            
                "default"=>NULL,  
                "type"=>"varchar",
                "size"=>"255"
            ));
           $setup->addColumnName(array(
                "name"=>"core_node_actions_id",
                "displayValue"=>"Node Action Id",            
                "default"=>NULL,  
                "type"=>"varchar",
                "size"=>"255"
            ));
             $setup->addColumnName(array(
                "name"=>"datetime",
                "displayValue"=>"Date And Time",
                "default"=>NULL,
                "type"=>"datetime"
            ));
            $setup->addColumnName(array(
                "name"=>"core_user_id",
                "displayValue"=>"User Id",            
                "default"=>NULL,
                "type"=>"bigint",
                "size"=>"20"
            ));
            $setup->addColumnName(array(
                "name"=>"host_ip",
                "displayValue"=>"Host Ip",            
                 "type"=>"varchar",
                "size"=>"255"
            ));
             $setup->create();
        }
    }
}
