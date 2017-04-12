<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreDefaultvalues
 *
 * @author ramesh
 */
namespace Core\Modules\CoreDevelopmentsettings\Models;
use Core\Model\Node;
class CoreDefaultvalues extends Node
{
    //put your code here
    public function coreDefaultvaluesOnchange()
    {
        $events=array();
        $events['core_node_settings_id']="getFieldsForDefualtFields();";           
        return $events;
    }
}
