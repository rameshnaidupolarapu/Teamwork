<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NodeInsert
 *
 * @author ramesh
 */
namespace Core\Model;
use \Core\Model\Settings;
class NodeSave extends Settings
{
    public $_forceUpdate=0;
    public $_nodeSql=NUll;
    public function setForceUpdate()
    {
        $this->_forceUpdate=1;
    }
    public function save()
    {
        $core_user_id=0;
        $mts=new \Core\Model\TableStructure();
        $mts->setTable($this->_tableName);
        $tableStructure=$mts->getStructure();        
        $db=new \Core\DataBase\ProcessQuery();            
        $db->setTable($this->_tableName);              
        if(count($this->_tableFieldWithData)>0)
        {
            foreach ($this->_TableStructure as $key => $Data) 
            {
                $updatedKeys=array_keys($this->_tableFieldWithData);
                if(in_array($key,$updatedKeys) && $this->_autoKey!=$key)
                {
					if(($Data['Type']=="tinyint") && $this->_tableFieldWithData[$key]!="1")
					{
						$this->_tableFieldWithData[$key]=0;
					}
                    $db->addFieldArray(array($key=>$this->_tableFieldWithData[$key]));
                }
            }                        
            
        }
        $buildUpdate=0;
        if($this->_autoKey!="")
        {
            if($this->_autoKey==$this->_pkName)
            {
                if($this->getId())
                {
                    $buildUpdate=1;
                    $db->addWhere($this->_pkName."='".$this->getId()."'");
                }
            }
            else
            {
                if(\Core::getValueFromArray($this->_tableFieldWithData, $this->_autoKey))
                {
                    $buildUpdate=1;
                    $db->addWhere($this->_autoKey."='".$this->_tableFieldWithData[$this->_autoKey]."'");
                }
            }
            
        }
        else
        {
            if($this->_tableFieldWithData[$this->_pkName])
            {
                $buildUpdate=1;
                $db->addWhere($this->_pkName."='".$this->_tableFieldWithData[$this->_pkName]."'");
            }
        }
        $datetime=date('Y-m-d H:i:s');
        $action="edit";
        if(\Core::keyInArray("updatedat", $tableStructure))                
        {
            $db->addFieldArray(array("updatedat"=>$datetime));
        }
        if($buildUpdate==1 || $this->_forceUpdate==1)
        {
            if($this->_tableFieldWithData[$this->_pkName]!="")
            {
                $db->buildUpdate();
                $db->executeQuery(); 
            }
        }
        else
        {     
            $action="add";
            if(\Core::keyInArray("createdat", $tableStructure))                
            {
                $db->addFieldArray(array("createdat"=>$datetime));
            }
            $db->buildInsert();   
            $this->_nodeSql=$db->sql;
            $db->executeQuery(); 
        }
        
          
        if($this->_autoKey)
        {
            if(!\Core::getValueFromArray($this->_tableFieldWithData, $this->_autoKey))
            {
                $newDb =new \Core\DataBase\ProcessQuery();
                $newDb->setTable($this->_tableName);
                $newDb->addFieldArray(array("max(".$this->_tableName.".".$this->_autoKey.")"=>"lastinsert"));
                $newDb->buildSelect();                
                $this->_tableFieldWithData[$this->_autoKey]=$newDb->getValue();                
            }
        }
        try
        {
            $session=new \Core\Session();
            $session->setProcessActive();
            $session=$session->getSessionMaganager();    
            $host_ip=$session['ipaddress'];
            $ns=new \Core\DataBase\ProcessQuery();
            $ns->setTable("core_node_history");
            $ns->addFieldArray(array("node_id"=>$this->_nodeName,"table_name"=>$this->_tableName,"pk_value"=>$this->_tableFieldWithData[$this->_pkName],"core_node_actions_id"=>$action,"datetime"=>$datetime,"core_user_id"=>$core_user_id,"host_ip"=>$host_ip));
            $ns->buildInsert();
            
            $ns->executeQuery();
        }
        catch(Exception $ex)
        {
            \Core::Log(__METHOD__.$ex->getMessage(),"NodeSave.log");
        }
        $nodeModel=\CoreClass::getModel("core_node_attribute_option");
        $nodeModel->addCustomFilter("core_node_settings_id='".$this->_nodeName."'");        
        $nodeModel->getCollection();
        if($nodeModel->_totalRecordsCount>0)
        {
            foreach ($nodeModel->_collections as $record)
            {                
                if(\Core::keyInArray($record['core_attribute_option_id'], $this->_tableFieldWithData))
                {
                    $nodeoption=\CoreClass::getModel("core_node_attribute_option_value");
                    $nodeoption->addCustomFilter("core_node_settings_id='".$this->_nodeName."'");
                    $nodeoption->addCustomFilter("core_attribute_option_id='".$record['core_attribute_option_id']."'");
                    $nodeoption->addCustomFilter("parentid='".$this->_tableFieldWithData[$this->_pkName]."'");
                    $nodeoption->getCollection();
                    $existingrecord=$nodeoption->getRecord();
                    $nodeSave=new \Core\Model\NodeSave();
                    $nodeSave->setNode("core_node_attribute_option_value");
                    if(\Core::keyInArray("id", $existingrecord))
                    {
                        $nodeSave->setData("id", $existingrecord['id']);
                    }
                    $nodeSave->setData("core_node_settings_id", $this->_nodeName);
                    $nodeSave->setData("core_attribute_option_id", $record['core_attribute_option_id']);
                    $nodeSave->setData("parentid", $this->_tableFieldWithData[$this->_pkName]);
                    $nodeSave->setData("attibute_value",$this->_tableFieldWithData[$record['core_attribute_option_id']] );
                    $nodeSave->save();                               
                }
            }
        }        
        return $this->_tableFieldWithData[$this->_pkName];
    }
    
    //put your code here
}
