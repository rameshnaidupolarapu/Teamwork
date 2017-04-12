<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataInstall
 *
 * @author ramesh
 */
namespace Modules\TaskManagement\Data;
class DataInstall 
{
    //put your code here
    function __construct() 
    {
        $this->setDataUp();
    }
    protected function setDataUp()
    {
        $nodesArray=array(
        "ModuleCreate"=>"ModuleCreate",
        "TaskDetails"=>"TaskDetails",
        "TaskStatus"=>"TaskStatus",
        "TaskMember"=>"TaskMember",
        "TaskMemberTime"=>"TaskMemberTime"
        );
        foreach ($nodesArray as $node) 
        {
            $nodeClass="\Modules\TaskManagement\Data"."\\".$node;
            $rnode=new $nodeClass();
            $rnode->execute();
        } 
        
    }
}
