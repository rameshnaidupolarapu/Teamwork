<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author venkatesh
 */
 namespace Core\Modules\CoreUsermanagement\Block;
 use \Core\Block\Block;
class User extends Block
{
	public function execute()
	{
		$this->loadLayout($this->_template.".phtml", 1);
	}   

}
