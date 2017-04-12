<?php

namespace Core\DataBase;

use \Core\DataBase\BuildQuery;

class ProcessQuery extends BuildQuery {

    public $query = NULL;
    public $result = array();
    public $_customQuery = NULL;

    public function setCustomQuery($query) {
        $this->_customQuery = $query;
    }

    public function getRows($key = NULL, $value = NULL) {
        try {
            if (!$this->_customQuery) {
                $this->query = $this->buildSelect();
            } else {
                $this->query = $this->_customQuery;
            }

            $cc = new \CoreClass();
            $db = $cc->getObject("\Core\DataBase\DbConnect");
            $output = $db->executeQuery($this->query);
            $tempresult = $output['result'];
            $i = 0;
            while ($rs = mysqli_fetch_assoc($tempresult)) {
                if ($key != "") {

                    if ($value != "") {
                        $this->result[$rs[$key]] = \Core::getStripslashes($rs[$value]);
                    } else {
                        $this->result[$rs[$key]] = \Core::getStripslashes($rs);
                    }
                } else {
                    $this->result[$i] = \Core::getStripslashes($rs);
                }
                $i++;
            }
            return $this->result;
        } catch (Exception $ex) {
            \Core::Log($ex->getMessage());
        }
    }

    public function getRow() {
        try {
            $this->query = $this->buildSelect();
            $cc = new \CoreClass();
            $db = $cc->getObject("\Core\DataBase\DbConnect");
            $output = $db->executeQuery($this->query);
            $tempresult = $output['result'];
            $i = 0;
            while ($rs = mysqli_fetch_assoc($tempresult)) {

                $this->result = $rs;
            }
            return $this->result;
        } catch (Exception $ex) {
            \Core::Log($ex->getMessage());
        }
    }

    public function getValue() {
        $this->query = $this->buildSelect();
        $cc = new \CoreClass();
        $db = $cc->getObject("\Core\DataBase\DbConnect");
        $output = $db->executeQuery($this->query);
        $tempresult = $output['result'];
        $i = 0;
        $this->result = NULL;
        while ($rs = mysqli_fetch_assoc($tempresult)) {
            foreach ($rs as $key => $value) {
                $this->result = $value;
                break;
            }
        }
        return $this->result;
    }

    public function getDescription() {
        try {
            if ($this->table) {
                $this->query = $this->buildDesc();
                $cc = new \CoreClass();
                $db = $cc->getObject("\Core\DataBase\DbConnect");
                $output = $db->executeQuery($this->query);
                $tempresult = $output['result'];
                while ($rs = mysqli_fetch_assoc($tempresult)) {
                    $this->result[$rs['Field']] = $rs;
                }
                return $this->result;
            }
        } catch (Exception $ex) {
            \Core::Log($ex->getMessage());
        }
    }

    public function executeQuery() {
        try {
            $cc = new \CoreClass();
            $db = $cc->getObject("\Core\DataBase\DbConnect");
            $output = $db->executeQuery($this->sql);
            if (trim(strtoupper($this->actionType)) == "INSERT") {
                return $db->getLastInsertId();
            } else {
                return true;
            }
        } catch (Exception $ex) {
            \Core::Log($ex->getMessage());
        }
    }

    public function getTablesFromDatabase() {
        try {
            $db = new Core_DataBase_DbConnect();
            $output = $db->executeQuery("SHOW TABLES");
            $tables = array();
            while ($rs = mysqli_fetch_assoc($output['result'])) {
                $tables = \Core::mergeArrays($tables, \Core::getValuesFromArray($rs));
            }
            $output['tables'] = $tables;
            return $output;
        } catch (Exception $ex) {
            \Core::Log($ex->getMessage());
        }
        return false;
    }

    public function getTableCreateQuery() {
        try {
            $query = "SHOW CREATE TABLE " . $this->table;
            $cc = new \CoreClass();
            $db = $cc->getObject("\Core\DataBase\DbConnect");
            $output = $db->executeQuery($query);
            $result = $output['result'];
            $result = mysqli_fetch_row($result);
            if ($result) {
                return $result[1];
            }
        } catch (Exception $ex) {
            \Core::Log($ex->getMessage());
        }
        return false;
    }

    public function getTableDataQuery($fileName) {
        try {
            $query = "SELECT * INTO OUTFILE '" . $fileName . "' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '" . '"' . "' LINES TERMINATED BY '),\\" . 'n' . "(' FROM " . $this->table;
            $cc = new \CoreClass();
            $db = $cc->getObject("\Core\DataBase\DbConnect");
            $output = $db->executeQuery($query);
            return true;
        } catch (Exception $ex) {
            \Core::Log($ex->getMessage());
        }
        return false;
    }

}
