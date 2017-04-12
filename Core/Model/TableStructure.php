<?php
    namespace Core\Model;
    class TableStructure 
    {
        public $_tableName;
        public $_tableStructure=array();
        public function setTable($tableName)
        {
            $this->_tableName=$tableName;
        }
        public function getStructure()
        {
            if($this->_tableName)
            {
                $cc=new \CoreClass();
                $qp=$cc->getObject("\Core\DataBase\ProcessQuery");
                $qp->setTable($this->_tableName);
                $this->_tableStructure=$qp->getDescription();
            }
            return $this->_tableStructure;
        }
        
    }
    
?>