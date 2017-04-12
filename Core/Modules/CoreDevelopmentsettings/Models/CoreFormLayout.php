<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreFormLayout
 *
 * @author ramesh
 */
namespace Core\Modules\CoreDevelopmentsettings\Models;
use Core\Model\Node;
class CoreFormLayout extends Node
{
    //put your code here
    public function coreFormLayoutOnchange()
    {
        $events=array();
        $events['core_form_settings_id']="getFieldsForFormSettings();";           
        return $events;
    }

}
