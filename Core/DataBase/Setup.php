<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Setup
 *
 * @author ramesh
 */
namespace Core\DataBase;
class Setup 
{
    //put your code here
    protected $_table=NULL;
    protected $_columnNames=array();
    protected $_sql=NULL;
    protected $_displayValue=NULL;
    protected $_fieldName=NULL;
    public function setTable($tableName)
    {
        $this->_table=$tableName;
        $this->_displayValue=$tableName;
    }
    public function setDisplayValue($displayName)
    {
        $this->_displayValue=$displayName;
    }
    public function getTable()
    {
        return $this->_table;
    }
    public function setFieldName($fieldName)
    {
        $this->_fieldName=$fieldName;
    }
    public function getFieldName()
    {
        return $this->_fieldName;
    }
    public function addColumnName($data)
    {
        $this->_columnNames[]=$data;
    }
    public function getColumnNames()
    {
        return $this->_columnNames;
    }
    public function tableExists()
    {
        $dbConfig=\Core::getDBConfig();
        $cc = new \CoreClass();
        $db=$cc->getObject("\Core\DataBase\ProcessQuery");
        $db->setDataBaseName('information_schema');
        $db->setTable("TABLES");
        $db->addField("count(TABLES.TABLE_NAME)");
        $db->addWhere("TABLE_NAME='".$this->_table."'");
        $db->addWhere("TABLE_SCHEMA='".$dbConfig['default']['Name']."'");
        $db->buildSelect();
        
        $count=$db->getValue();
        if($count>0)
        {
            return true;
        }
        return false;
    }
    public function create() 
    {
        $this->_sql=" Create Table ".$this->_table;
        $this->_sql.=" ( ";
        $count=\Core::countArray($this->_columnNames);
        $k=0;
        foreach ($this->_columnNames as $columnData)
        {
            $k++;
            $this->_sql.=$columnData['name'];
            $this->_sql.=" ".$columnData['type'];
            if(\Core::getValueFromArray($columnData,'size'))
            {
                $this->_sql.="(".$columnData['size'].")";
            }            
            if(\Core::getValueFromArray($columnData,'prmiary'))
            {
                $this->_sql.=" NOT NULL ";
            }
            if(\Core::getValueFromArray($columnData,'auto_increment'))
            {
                $this->_sql.=" auto_increment ";
            }
            if(\Core::getValueFromArray($columnData,'key'))
            {
                $this->_sql.=" ".$columnData['key']." KEY ";
            }
            if(\Core::getValueFromArray($columnData,'prmiary'))
            {
                $this->_sql.=" PRIMARY KEY ";
            }
            $this->_sql.=" COLLATE 'utf8_general_ci' ";
            
            $this->_sql.=" COMMENT '".$columnData['displayValue']."'";   
            if($count>$k)
            {
                $this->_sql.=" ,";
            }
        }
        $this->_sql.=" ) ";
        $this->_sql.="ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 Comment '".$this->_displayValue."'";
        try
        {
            $cc = new \CoreClass();
            $db=$cc->getObject("\Core\DataBase\DbConnect");
            $db->executeQuery($this->_sql);        
        }
        catch (Exception $ex)
        {
            \Core::Log(__METHOD__.$this->_sql." ::  ".$ex->getMessage(),"setup");
        }
    }
    public function alterTable()
    {
        $cc = new \CoreClass();
        $db=$cc->getObject("\Core\DataBase\ProcessQuery");
        $db->setTable($this->_table);
        $tableDescription=$db->getDescription();
        if(\Core::countArray($this->_columnNames)>0)
        {
            $count=\Core::countArray($this->_columnNames);
            $k=0;
            $this->_sql=" ALTER TABLE ".$this->_table." ";
            foreach ($this->_columnNames as $columnData)
            {
                $k++;
                if(\Core::keyInArray($columnData['name'], $tableDescription))
                {
                    $this->_sql.=" CHANGE ".$columnData['name']." ".$columnData['name'];
                }
                else 
                {
                    $this->_sql.=" Add ".$columnData['name'];
                }
                $this->_sql.=" ".$columnData['type'];
                if(\Core::getValueFromArray($columnData,'size'))
                {
                    $this->_sql.="(".$columnData['size'].")";
                }            
                if(\Core::getValueFromArray($columnData,'prmiary'))
                {
                    $this->_sql.=" NOT NULL ";
                }
                if(\Core::getValueFromArray($columnData,'auto_increment'))
                {
                    $this->_sql.=" auto_increment ";
                }
                if(\Core::getValueFromArray($columnData,'key'))
                {
                    $this->_sql.=" ".$columnData['key']." KEY ";
                }
                if(\Core::getValueFromArray($columnData,'prmiary'))
                {
                    $this->_sql.=" PRIMARY KEY ";
                }
                $this->_sql.=" COLLATE 'utf8_general_ci' ";

                $this->_sql.=" COMMENT '".$columnData['displayValue']."'";  

                if(\Core::getValueFromArray($columnData,'after'))
                {
                    if(\Core::keyInArray($columnData['after'], $tableDescription))
                    {
                        $this->_sql.=" AFTER ".$columnData['after'];
                    }
                }
                if($count>$k)
                {
                    $this->_sql.=" ,";
                }
                else
                {
                    $this->_sql.=" ; ";
                }
            }
        }
        try
        {
            $cc = new \CoreClass();
            $db=$cc->getObject("\Core\DataBase\DbConnect");
            $db->executeQuery($this->_sql);        
        }
        catch (Exception $ex)
        {
            \Core::Log(__METHOD__.$this->_sql." ::  ".$ex->getMessage(),"setup");
        }
    }
    public function fieldExitsinTable()
    {
        $cc = new \CoreClass();
        $db=$cc->getObject("\Core\DataBase\ProcessQuery");
        $db->setTable($this->_table);
        if($this->tableExists())
        {            
            $tableDescription=$db->getDescription();
            if(\Core::countArray($tableDescription)>0)
            {
                if(\Core::keyInArray($this->_fieldName, $tableDescription))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else 
            {
                return false;
            }
        }
        else 
        {
            return false;
        }
    }
    public function dropfieldTable()
    {
        
        $cc = new \CoreClass();
        $db=$cc->getObject("\Core\DataBase\ProcessQuery");
        $db->setTable($this->_table);
        $tableDescription=$db->getDescription();
        if(\Core::countArray($this->_columnNames)>0)
        {
            $count=\Core::countArray($this->_columnNames);
            $k=0;
            $this->_sql=" ALTER TABLE ".$this->_table." ";
            foreach ($this->_columnNames as $columnData)
            {
                $k++;
                if(\Core::keyInArray($columnData['name'], $tableDescription))
                {
                    $this->_sql.=" DROP ".$columnData['name'];
                }
                if($count>$k)
                {
                    $this->_sql.=" ,";
                }
                else
                {
                    $this->_sql.=" ; ";
                }
            }
            
        }
        try
        {
            $cc = new \CoreClass();
            $db=$cc->getObject("\Core\DataBase\DbConnect");
            $db->executeQuery($this->_sql);        
        }
        catch (Exception $ex)
        {
            \Core::Log(__METHOD__.$this->_sql." ::  ".$ex->getMessage(),"setup");
        }
       
    }
}
