<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Block
 *
 * @author venkatesh
 */
namespace Core\Block;
use \Core\Pages\PageLayout;
class Block extends PageLayout
{
    //put your code here
    public $_layout=NULL;
    public $_blockName;
    public $_parentBlock=NULL;
    public $_template;
    public $_websiteSettings=NULL;
    public $_accordionList=array();    
    public $_accordionFields=array();
    public $_partentObject;
   
    function __construct($controller = NULL) 
    {
        global $rootObj;
	$this->_websiteSettings=$rootObj; 
        parent::__construct($controller);
    }
    public function setLayout($layout)
    {
        $this->_layout=$layout;
    }
    public function setControllerObject($controllerObj)
    {
        $this->_controllerObj=$controllerObj;
    }
    public function setBlockName($block)
    {
        $this->_blockName=$block;
    }
    public function setParentBlock($parent)
    {
        $this->_parentBlock=$parent;
    }
    public function setTemplate($template)
    {
        $this->_template=$template;
    }
    public function execute()
    {        
        $this->loadLayout($this->_template.".phtml", 1);
    }
    public function setParentObject($_partentObject)
    {
        $this->_partentObject=$_partentObject;
    }
    public function loadChildBlock($blockName=NULL)
    {
        if($blockName)
        {
            $pattern='//block[@parent="'.$this->_blockName.'"][@name="'.$blockName.'"]';
        }
        else
        {
            $pattern='//block[@parent="'.$this->_blockName.'"]';
        }
       
        $layoutContent=\Core::getFileContent($this->_layout);
        $blockProperties=\Core::processXmlData($layoutContent,$pattern);
        foreach ($blockProperties as $eachblockProperties)
        {
            if(\Core::keyInArray('@attributes', $eachblockProperties))
            {
                $blockConfigData=$eachblockProperties['@attributes'];
                $class=$blockConfigData['class'];
                if($class)
                {
                    try
                    {
                        $block=new $class($this->_controllerObj);   
                        $block->setLayout($this->_layout);
                        $block->setBlockName($blockConfigData['name']);
                        $block->setParentBlock($this->_blockName);
                        $block->setParentObject($this);
                        $block->setTemplate($blockConfigData['template']);                        
                        $block->execute();
                    }
                    catch (Exception $ex)
                    {
                       echo $ex->getMessage();
                    }
                }
            }
        }
    }
    public function getFromTabs()
    {
        
    }
    
    
}
