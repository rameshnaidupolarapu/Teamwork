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
 namespace Modules\Project\Setup;
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
            "Project"=>"Project",
            "ProjectMember"=>"ProjectMember",
            "ProjectStatus"=>"ProjectStatus"
            
        );
        foreach ($nodesArray as $node) 
        {
            $nodeClass="\Modules\Project\Setup"."\\".$node;
            $rnode=new $nodeClass();
            $rnode->execute();
        }               
    }
}
