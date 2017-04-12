<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AttributeInstall
 *
 * @author venkatesh
 */
 namespace Core\Modules\CoreUsermanagement\Attribute;
class AttributeInstall 
{
    //put your code here
    //put your code here
    function __construct() 
    {
        $this->setAttributeSetUp();
    }
    protected function setAttributeSetUp()
    {
        $nodesArray=array(            
            "CoreProfile"=>"CoreProfile"            
        );
        foreach ($nodesArray as $node) 
        {
            $nodeClass="\Core\Modules\CoreUsermanagement\Attribute\'".$node;
            $nodeClass=str_replace("'","",$nodeClass);
            $rnode=new $nodeClass();
            $rnode->execute();
        } 
        
    }
}
