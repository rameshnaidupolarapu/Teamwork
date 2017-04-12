<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TreeNode
 *
 * @author ramesh
 */
namespace Core\Model;
class TreeNode {

    protected $_nodeName;
    protected $_filterCon;
    protected $_tableName;
    protected $_records;
    protected $_parent;
    protected $_treeRecords;

    public function setNodeName($node) {
        $this->_nodeName = $node;
    }

    public function getNodeName() {
        return $this->_nodeName;
    }

    public function addFilter($condition) {
        if ($condition != "") {
            if ($this->_filterCon) {
                $this->_filterCon . " and ";
            }
            $this->_filterCon . $condition;
        }
    }

    public function setParent($parent) {
        $this->_parent = $parent;
    }

    public function getChildrecords() {
        $cc=new \CoreClass();
        $np = $cc->getObject("\Core\Model\NodeProperties",$this->_nodeName);
        $currentNodeStructure = $np->currentNodeStructure();
        $this->_tableName = $currentNodeStructure['tablename'];
        $primkey = $currentNodeStructure['primkey'];
        $descriptor = $currentNodeStructure['descriptor'];
        $db = new Core_DataBase_ProcessQuery();
        $db->setTable($this->_tableName);
        $db->addFieldArray(array($descriptor => $descriptor));
        $db->addFieldArray(array($primkey => $primkey));
        $db->addFieldArray(array("parent_level" => "parent_level"));
        $db->addWhere($this->_filterCon);
        if ($this->_parent) {
            $db->addWhere("parent='" . $this->_parent . "'");
        } else {
            $db->addWhere("parent_level='1'");
        }

        $result1 = $db->getRows();
        if (count($result1) > 0) {
            foreach ($result1 as $rs1) {
                $loop = $rs1['parent_level'];
                $tabspace = "";
                for ($k = 1; $k < $loop; $k++) {
                    $tabspace.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                }
                $tabspace.="-->";
                $this->_records[$rs1[$primkey]] = $tabspace . $rs1[$descriptor];
                $this->_parent = $rs1[$primkey];
                $this->getChildrecords();
            }
            return $this->_records;
        } else {
            return $this->_records;
        }
    }
    
    public function getChildrecordsWithIds() {
        $np = new Core_Model_NodeProperties($this->_nodeName);
        $currentNodeStructure = $np->currentNodeStructure();
        $this->_tableName = $currentNodeStructure['tablename'];
        $primkey = $currentNodeStructure['primkey'];
        $descriptor = $currentNodeStructure['descriptor'];
        $db = new Core_DataBase_ProcessQuery();
        $db->setTable($this->_tableName);
        $db->addFieldArray(array($descriptor => $descriptor));
        $db->addFieldArray(array($primkey => $primkey));
        $db->addFieldArray(array("parent" => "parent"));
        $db->addFieldArray(array("parent_level" => "parent_level"));
        $db->addWhere($this->_filterCon);
        if ($this->_parent) {
            $db->addWhere("parent='" . $this->_parent . "'");
        } else {
            $db->addWhere("parent_level='1'");
        }

        $result1 = $db->getRows();
        if (count($result1) > 0) {
            $parent="";
            foreach ($result1 as $rs1) {   
                
                $parentIds=array_unique(explode("/", $rs1['parent']>0?$this->_records[$rs1['parent']]."/". $rs1[$primkey]: $rs1[$primkey]));
                $this->_records[$rs1[$primkey]] = implode("/",$parentIds);
                $this->_parent = $rs1[$primkey];
                $this->getChildrecordsWithIds();
            }
            return $this->_records;
        } else {
            return $this->_records;
        }
    }
    public function getTreeRecords() {
        $parent = $this->_parent;
        if ($parent == "") {
            $parent = "parent";
        }
        $records = array();
        $cc=new \CoreClass();
        $np =$cc->getObject("\Core\Model\NodeProperties",$this->_nodeName);
        $np->setNode($this->_nodeName);
        $currentNodeStructure = $np->currentNodeStructure();        
        $this->_tableName = $currentNodeStructure['tablename'];
        $primkey = $currentNodeStructure['primkey'];
        $descriptor = $currentNodeStructure['descriptor'];
        $db =$cc->getObject("\Core\DataBase\ProcessQuery");
        $db->setTable($this->_tableName);
        $db->addField("*");
        $db->addFieldArray(array($descriptor => $descriptor));
        $db->addFieldArray(array($primkey => $primkey));
        $db->addFieldArray(array("parent" => "parent"));
        $db->addFieldArray(array("parent_level" => "parent_level"));
        $db->addWhere($this->_filterCon);
        if ($this->_parent) {
            $db->addWhere("parent='" . $this->_parent . "'");
        } else {
            $db->addWhere("parent_level='1'");
        }
        $db->buildSelect();
       
        $result1 = $db->getRows();

        if (count($result1) > 0) {
            foreach ($result1 as $rs1) {
                $loop = $rs1['parent_level'];
                $this->_records[$rs1[$primkey]] = $rs1[$descriptor];
                $records[$rs1[$primkey]] = $rs1;
                $this->_parent = $rs1[$primkey];
                $this->getTreeRecords();
            }
            return $this->_records;
        } else {
            return $this->_records;
        }
    }

}
