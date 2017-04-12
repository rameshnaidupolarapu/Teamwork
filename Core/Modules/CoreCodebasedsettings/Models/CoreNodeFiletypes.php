<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreNodeFiletypes
 *
 * @author ramesh
 */
namespace Core\Modules\CoreCodebasedsettings\Models;
use Core\Model\Node;
class CoreNodeFiletypes extends Node
{
    //put your code here
    public function coreNodeSettingsIdAddSingleFilter()
    {
        return "file!=''";
    }
    public function coreNodeFiletypesOnchange()
    {
        $events=array();
        $events['core_node_settings_id']="getFieldsForNodeFiletypes();";           
        return $events;
    }
    
}
