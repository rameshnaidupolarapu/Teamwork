<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccessController
 *
 * @author ramesh
 */

namespace Core\Controllers;
class AccessController 
{
    //put your code here
    public function NodeCheckForProfile($nodeRelations) 
    {
        $session=new \Core\Session();
        $sessionData=$session->getSessionMaganager();        
        $np = new \Core\Model\NodeProperties();
        
        $nodeStructureData=$np->getCurrentProfilePermission(\Core::getValueFromArray($sessionData,'profile_id'));
        $output=array();
        if($nodeRelations!="")
        {
            if(!\Core::isArray($nodeRelations))
            {
                $nodeRelations=array($nodeRelations);
            }
            foreach ($nodeRelations as $key => $data) 
            {
                if(\Core::keyInArray($key, $nodeStructureData))
                {
                    $output[$key]=$data;
                }
            }
            
        }
        return $output;        
    }
}
