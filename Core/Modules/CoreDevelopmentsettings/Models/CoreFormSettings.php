<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreFormSettings
 *
 * @author ramesh
 */
namespace Core\Modules\CoreDevelopmentsettings\Models;
use Core\Model\Node;
class CoreFormSettings extends Node
{
    //put your code here
    public function coreFormSettingsOnchange()
    {        
        $events=array();
        $events['core_node_settings_id']="defaultphpfile('".$this->_nodeName."','".$this->_currentAction."','".$this->_nodeName."','parent');";           
        return $events;
    }

}