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
 namespace Core\Modules\CoreUsermanagement\Setup;
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
            //User Management
            "CoreAccess"=>"CoreAccess",
            "CoreProfileLevel"=>"CoreProfileLevel",
            "CoreProfile"=>"CoreProfile",
            "CoreUsers"=>"CoreUsers",
            "CoreLoginhistory"=>"CoreLoginhistory",
            "CoreUseronline"=>"CoreUseronline",
            "CoreWebsiteloginhistory"=>"CoreWebsiteloginhistory",
            "CoreWebsiteusers"=>"CoreWebsiteusers",
        );
        foreach ($nodesArray as $node) 
        {
            $nodeClass="\Core\Modules\CoreUsermanagement\Setup\'".$node;
            $nodeClass=str_replace("'","",$nodeClass);
            $rnode=new $nodeClass();
            $rnode->execute();
        }               
    }
}
