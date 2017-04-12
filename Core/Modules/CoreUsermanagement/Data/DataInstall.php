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
 namespace Core\Modules\CoreUsermanagement\Data;
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
            "CoreModuleCreate"=>"CoreModuleCreate",
            "CoreAccess"=>"CoreAccess",
            "CoreLoginhistory"=>"CoreLoginhistory",
            "CoreProfile"=>"CoreProfile",
            "CoreProfileLevel"=>"CoreProfileLevel",
            "CoreUsers"=>"CoreUsers",
            
        );
        foreach ($nodesArray as $node) 
        {
            $nodeClass="\Core\Modules\CoreUsermanagement\Data\'".$node;
            $nodeClass=str_replace("'","",$nodeClass);
            $rnode=new $nodeClass();
            $rnode->execute();
        } 
        
    }
}
