<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreLabelDetails
 *
 * @author ramesh
 */
namespace Core\Modules\CoreCodebasedsettings\Controllers;
use \Core\Controllers\NodeController;
class CoreLabelDetails extends NodeController
{
    //put your code here
    public function coreLabelDetailsAfterDataUpdate()
    {
        $cache=new Core_Cache_Refresh();
        $cache->setLables();
        return TRUE;        
    }
}
