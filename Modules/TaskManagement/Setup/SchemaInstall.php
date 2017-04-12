<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SchemaInstall
 *
 * @author ramesh
 */
 namespace Modules\TaskManagement\Setup;
class SchemaInstall
{
    //put your code here
    function __construct() 
    {
        $this->setUp();
    }
    protected function setUp()
    {
        $nodesArray=array(
            // Project            
            "Task"=>"Task",
            "TaskStatus"=>"TaskStatus",
            "TaskMember"=>"TaskMember",
            "TaskMemberTime"=>"TaskMemberTime"
            
        );
        foreach ($nodesArray as $node) 
        {
            $nodeClass="\Modules\TaskManagement\Setup"."\\".$node;
            $rnode=new $nodeClass();
            $rnode->execute();
        }               
    }
}
