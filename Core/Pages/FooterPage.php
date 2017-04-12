<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FooterPage
 *
 * @author ramesh
 */
class Core_Pages_FooterPage extends Core_Pages_PageLayout
{
    public function __construct()
    {
        
        $this->buildFooter(); 
       
    }
    protected function buildFooter()
    {
        $this->loadLayout("footer.phtml");
    }    
}