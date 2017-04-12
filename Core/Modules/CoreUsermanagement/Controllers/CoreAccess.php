<?php
namespace Core\Modules\CoreUsermanagement\Controllers;
use Core\Controllers\NodeController;
class CoreAccess extends NodeController
{
    public $_profileAccess;
    public $_existingRecord;
            
    function adminRefreshAction()
    {
        $this->setProfileAccess();     
        $this->loadLayout("profileaccess.phtml");           
        return true;
    }
    protected function setProfileAccess()
    {
        global $currentProfileCode;
        $db=new \Core\DataBase\ProcessQuery();
        $db->setTable($this->_tableName);
        $db->addWhere($this->_parentColName."='".$this->_parentSelector."'");
        $this->_existingRecord=$db->getRows("node");        
        $this->_profileAccess=new \Core\Attributes\ProfilePrivileges();
        $this->_profileAccess->buildMenu();        
    }
    public function saveAction()
    {       
        try 
        {          
        
            $db=new \Core\DataBase\ProcessQuery();
            $db->setTable($this->_tableName);
            $db->addWhere($this->_parentColName."='".$this->_parentSelector."'");
            $db->buildDelete();
            $db->executeQuery();
            foreach($this->_requestedData as $key=>$data)
            {
                if(\Core::isArray($data))
                {
                    $db->setTable($this->_tableName);
                    $db->addFieldArray(array("node"=>$key,"action"=>\Core::convertArrayToString($data, "|"),$this->_parentColName=>$this->_parentSelector));
                    $db->buildInsert();    
                    $db->executeQuery();
                }
            }
            $cache=new \Core\Cache\Refresh();        
            $cache->profilePrivileges($this->_parentSelector);
        }
        catch (Exception $ex) 
        {
            \Core::Log($ex->getMessage(),"accessexception.log");
        }
        $backUrl=$this->_websiteAdminUrl.$this->_parentNode."/".$this->_parentAction."/".$this->_parentSelector;
        $output=array();
        $output['status']="success";
        $output['redirecturl']=$backUrl;            
        echo json_encode($output);
    }
}