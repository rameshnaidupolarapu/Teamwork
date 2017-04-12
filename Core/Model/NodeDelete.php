<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NodeDelete
 *
 * @author ramesh
 */
namespace Core\Model;
use \Core\Model\Settings;
class NodeDelete extends Settings
{    
    protected $_pkValue;
    
    public function setPkValue($pkValue)
    {
        $this->_pkValue=$pkValue;
    }
    public function delete()
    {   
        $_NodeProperties=$this->_NodeProperties;        
        try
        {
            $db=new \Core\DataBase\ProcessQuery();          
            $db->setTable($this->_tableName);
            $db->addWhere($_NodeProperties['primkey']."='".$this->_pkValue."'");
            $db->buildSelect();
            $record=$db->getRow();
            
            $node=new \Core\Model\NodeSave();          
            $node->setNode("core_archive_data");
            $node->setData("node", $this->_nodeName);
            $node->setData("table_name", $this->_tableName);
            $node->setData("primkey", $this->_pkName);
            $node->setData("primkeyvalue", $this->_pkValue);
            $node->setData("rowdata", json_encode($record));            
            $node->save();
            $datetime=  date('Y-m-d H:i:s');
            $session=new \Core\Session();
            $session->setProcessActive();
            $session=$session->getSessionMaganager();    
            $host_ip=$session['ipaddress'];
            $ns=new \Core\DataBase\ProcessQuery();
            $ns->setTable("core_node_history");
            $core_user_id = 0;
            $ns->addFieldArray(array("node_id"=>$this->_nodeName,"table_name"=>$this->_tableName,"pk_value"=>$this->_pkValue,"core_node_actions_id"=>"delete","datetime"=>$datetime,"core_user_id"=>$core_user_id,"host_ip"=>$host_ip));
            $ns->buildInsert();
            $ns->executeQuery();
            
            
            $db=new \Core\DataBase\ProcessQuery();          
            $db->setTable($this->_tableName);
            $db->addWhere($this->_whereCon);
            $db->buildDelete();            
            $db->executeQuery();        
            return true;
        }
        catch (Exception $ex)
        {
            \Core::Log(__METHOD__.$ex->getMessage(), $this->_tableName."_delete.log");
        }
    }
}