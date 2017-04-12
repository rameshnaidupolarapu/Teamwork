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
 namespace Core\Modules\CoreDevelopmentsettings\Setup\V1;
class CoreSetupschema
{
    //put your code here
    function execute()
    {
        $cc = new \CoreClass();         $setup=$cc->getObject("\Core\DataBase\Setup");  
        $setup->setTable("core_setupschema");
        if($setup->tableExists($setup->getTable()))
        {
            $setup->addColumnName(["name"=>"attributeversion",
                "displayValue"=>"Attribute Version",                
                "type"=>"varchar",
                "size"=>"255",
                "after"=>"dataversion"
                ]);
            $setup->alterTable();
        }
        
    }
}
