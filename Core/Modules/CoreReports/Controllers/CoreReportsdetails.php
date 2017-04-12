<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreReportsdetails
 *
 * @author ramesh
 */
  namespace Core\Modules\CoreReports\Controllers;
use \Core\Controllers\NodeController;
class CoreReportsdetails extends NodeController
{
    //put your code here
    public function coreReportsdetailsAfterDataUpdate()
    {
        $requestedData=$this->_requestedData;
        $nodeOTMRelations=$this->_nodeOTMRelations;
        $node=new Core_Model_Node();
        $node->setNodeName($requestedData['node_id']);
        $reportNodeRelations=$node->_nodeMTORelations;
        $reportNode=$requestedData['node_id'];
        
        
        $nodeToCol=array();
        if(count($reportNodeRelations)>0)
        {
            foreach ($reportNodeRelations as $key=>$keyNode)
            {
                $nodeToCol[$keyNode]=$key;
            }
        }
        
        $db= new Core_DataBase_ProcessQuery();
        $db->setTable("core_reportsdetails_settings");
        $db->addField("core_queryclause_id");
        $db->addField("core_orderclausetype_id");
        $db->addField("core_aggregate_function_id");
        $db->addField("fieldsdata");
        $db->addField("displayname");
        $db->addField("node_id");        
        $db->addWhere("core_reportsdetails_id='".$requestedData['id']."'");
        $db->addOrderBy("core_queryclause_id ASC");
        $db->addOrderBy("sortno ASC");
        $reportNodeSettings=$db->getRows();
        
        $db=new Core_DataBase_ProcessQuery();
        $db->setTable($node->_tableName,$reportNode);
        
        $selectFields=array();
        
        if(count($reportNodeSettings)>0)
        {
            foreach ($reportNodeSettings as $SettingsData)
            {
                if($SettingsData['core_queryclause_id']=='SELECT')
                {
                    $selectFields[]=$SettingsData['displayname'];
                    if($SettingsData['node_id']==$reportNode)
                    {
                        if(\Core::keyInArray($SettingsData['fieldsdata'],$reportNodeRelations))
                        {
                            $relationcol=$SettingsData['fieldsdata'];
                            $tempnode=new Core_Model_Node();
                            $tempnode->setNodeName($reportNodeRelations[$relationcol]);
                            $db->addJoin($relationcol,$tempnode->_tableName,$relationcol,$reportNode.".".$relationcol."=".$relationcol.".".$tempnode->_primaryKey);
                            $db->addFieldArray(array($relationcol.".".$tempnode->_descriptor=>"'".$SettingsData['displayname']."'"));
                        }
                        else
                        {
                            $db->addFieldArray(array($reportNode.".".$SettingsData['fieldsdata']=>"'".$SettingsData['displayname']."'"));
                        }
                    }
                    else
                    {
                        $tempnode=new Core_Model_Node();
                        $tempnode->setNodeName($SettingsData['node_id']);
                        $relationcol=$nodeToCol[$SettingsData['node_id']];
                        
                        $db->addJoin($relationcol,$tempnode->_tableName,$relationcol,$reportNode.".".$relationcol."=".$relationcol.".".$tempnode->_primaryKey);
                        if(\Core::keyInArray($tempnode->_descriptor, $tempnode->_nodeMTORelations))
                        {
                            $parentColNode=$tempnode->_nodeMTORelations[$tempnode->_descriptor];
                            $tempparentnode=new Core_Model_Node();
                            $tempparentnode->setNodeName($parentColNode);
                            $db->addJoin($tempnode->_descriptor."pk",$tempparentnode->_tableName,$parentColNode.$tempnode->_descriptor,$relationcol.".".$tempnode->_descriptor."=".$parentColNode.$tempnode->_descriptor.".".$tempparentnode->_primaryKey);
                            $db->addFieldArray(array($parentColNode.$tempnode->_descriptor.".".$tempparentnode->_descriptor=>"'".$SettingsData['displayname']."'")); 
                        }
                        else 
                        {
                           $db->addFieldArray(array($relationcol.".".$SettingsData['fieldsdata']=>"'".$SettingsData['displayname']."'")); 
                        }
                        
                    }
                }
            }
            $db->buildSelect();
            $querysql=$db->sql;   
            $reportFolder=\Core::createFolder($reportNode, "R");
            \Core::createFile($reportFolder.$requestedData['id']."_query.log", 1, $querysql);
            \Core::createFile($reportFolder.$requestedData['id']."_selectfields.log", 1, \Core::convertArrayToJson($selectFields));            
            $db=new Core_DataBase_ProcessQuery();
            $db->setTable("core_reportsdetails");
            $db->addFieldArray(array("is_custom"=>"1"));
            $db->addWhere("core_reportsdetails.id='".$requestedData['id']."'");
            $db->buildUpdate();
            $db->executeQuery();
        }        
    }
}
