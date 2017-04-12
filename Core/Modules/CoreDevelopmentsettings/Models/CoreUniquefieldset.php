<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreUniquefieldset
 *
 * @author ramesh
 */
namespace Core\Modules\CoreDevelopmentsettings\Models;
use Core\Model\Node;
class CoreUniquefieldset extends Node
{
    //put your code here
    public function coreUniquefieldsetOnchange()
    {        
        $events=array();
        $events['core_node_settings_id']="getFieldsForUniqueFieldset();";           
        return $events;
    }
}
