<?php
namespace Core\Controllers;
use \Core\Pages\Render;
class AdminController extends Render
{
    //put your code here
    
    public function adminAction()
    {
        $this->getAdminLayout();
        $this->renderLayout();
    }
}
