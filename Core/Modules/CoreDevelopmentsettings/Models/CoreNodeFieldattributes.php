<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreNodeFieldattributes
 *
 * @author ramesh
 */
namespace Core\Modules\CoreDevelopmentsettings\Models;
use Core\Model\Node;
class CoreNodeFieldattributes extends Node
{
    //put your code here
    public function coreNodeFieldattributesOnchange()
    {
        $events=array();
        $events['core_node_settings_id']="getFieldsForAttributeFields();";           
        return $events;
    }
}
