<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SchemaInstall
 *
 * @author venkatesh
 */
namespace Core\Modules\CoreDevelopmentsettings\Data\V102;
class DataInstall
{
    //put your code here
    function __construct() 
    {
        $this->setDataUp();
    }
    protected function setDataUp()
    {
        $nodesArray=array("CoreCacheManagement","CoreNodeSettings");
        foreach ($nodesArray as $node)
        {
            $nodeClass="\Core\Modules\CoreDevelopmentsettings\Data\V102\'".$node;
            $nodeClass=str_replace("'","",$nodeClass);
            $rnode=new $nodeClass();
            $rnode->execute();
        }
        
    }
}
