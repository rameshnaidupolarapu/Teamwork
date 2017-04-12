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
class CoreNodeActions
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_node_actions");
        if($setup->tableExists($setup->getTable()))
        {
            $setup->addColumnName(["name"=>"is_layout",
                "displayValue"=>"Is Layout",                
                "type"=>"tinyint",
                "size"=>"1",
                "after"=>"short_code"
                ]);
            $setup->alterTable();
        }
        
    }
}
