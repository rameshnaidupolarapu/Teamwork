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
namespace Modules\Project\Data;
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
        "ProjectDetails"=>"ProjectDetails",
        "ProjectStatus"=>"ProjectStatus",
        "ProjectMember"=>"ProjectMember"
        );
        foreach ($nodesArray as $node) 
        {
            $nodeClass="\Modules\Project\Data"."\\".$node;
            $rnode=new $nodeClass();
            $rnode->execute();
        } 
        
    }
}
