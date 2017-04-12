<?php
namespace Core\Controllers\Frontend;
use \Core\Pages\Render;
class IndexController extends Render
{
    //put your code here
    
    public function indexAction()
    {
        $wp = new \Core\WebsiteSettings();
        $session =  new \Core\Session();
        $sessionData = $session->getFrontendSession();
        $location = \Core::getValueFromArray($sessionData, "location");
        if($location==""){
            $this->getLayout();
            $this->renderLayout();
        }else{
            \Core::redirectUrl($wp->websiteUrl."home.html","");
        }
    }
    public function  returnJsonResponse($output)
    {
        ob_clean();
        header('Content-Type: application/json');
        echo json_encode($output);  
    }
    public function removeFrontendSessionValue() {
        $session =  new \Core\Session();
        $session->removeFrontendSessionValue("userId");
    }
}
