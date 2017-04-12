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

namespace Core\Install;

class Setup {

    //put your code here
    function __construct() {
        $this->schemaSetup();
    }

    public function schemaSetup() {
        try {
            $cc = new \CoreClass();
            $setup = $cc->getObject("\Core\DataBase\Setup");
            $setup->setTable("core_setupschema");
            if (!$setup->tableExists($setup->getTable())) {
                $setup->setDisplayValue("Setup Schema Details");
                $setup->addColumnName(array(
                    "name" => "id",
                    "displayValue" => "Id",
                    "prmiary" => false,
                    "key" => "unique",
                    "default" => NULL,
                    "type" => "bigint",
                    "size" => "11",
                    "prmiary" => 1,
                    "auto_increment" => 1
                ));
                $setup->addColumnName(array(
                    "name" => "modulename",
                    "displayValue" => "Module Name",
                    "default" => false,
                    "type" => "varchar",
                    "size" => "255"
                ));
                $setup->addColumnName(array(
                    "name" => "schemaversion",
                    "displayValue" => "Schema Version",
                    "type" => "varchar",
                    "size" => "255"
                ));
                $setup->addColumnName(array(
                    "name" => "dataversion",
                    "displayValue" => "Data Version",
                    "type" => "varchar",
                    "size" => "255"
                ));
                $setup->addColumnName(array(
                    "name" => "attributeversion",
                    "displayValue" => "Attribute Version",
                    "type" => "varchar",
                    "size" => "255"
                ));

                $setup->addColumnName(array(
                    "name" => "createdby",
                    "displayValue" => "Created User Id",
                    "default" => NULL,
                    "type" => "int",
                    "size" => "11"
                ));
                $setup->addColumnName(array(
                    "name" => "createdat",
                    "displayValue" => "Created Datetime",
                    "default" => NULL,
                    "type" => "datetime"
                ));
                $setup->addColumnName(array(
                    "name" => "updatedby",
                    "displayValue" => "Updated User Id",
                    "default" => NULL,
                    "type" => "int",
                    "size" => "11"
                ));
                $setup->addColumnName(array(
                    "name" => "updatedat",
                    "displayValue" => "Updated Datetime",
                    "default" => NULL,
                    "type" => "datetime"
                ));
                $setup->create();
            }
            $cc = new \CoreClass();
            $cp = $cc->getObject("\Core\CodeProcess");
            $directoryList = $cp->searchDirectory("Config\DataBase");
            if (\Core::countArray($directoryList) > 0) {
                foreach ($directoryList as $moduleConfig) {
                    $directory = substr($moduleConfig, 1);
                    $moduleFiles = $cp->dirToArray($directory);
                    if (\Core::countArray($moduleFiles) > 0) {
                        foreach ($moduleFiles as $configFile) {
                            $configFile = str_replace("'", "", $directory . "\'" . $configFile);
                            $configFileContent = \Core::getFileContent($configFile);
                            $configFileContentSettings = \Core::convertXmlToArray($configFileContent);
                            if ($configFileContentSettings) {
                                $dp = $cc->getObject("\Core\DataBase\ProcessQuery");
                                $dp->setTable("core_setupschema");
                                $dp->addField("id");
                                $dp->addWhere("core_setupschema.modulename='" . $configFileContentSettings['name'] . "'");
                                $dp->buildSelect();
                                $existingRow = $dp->getRow();
                                $processFlag = 0;
                                $recordid = $existingRow['id'];
                                $schemaprocess = 0;
                                $dataprocess = 0;
                                $attributeprocess = 0;
                                if ($recordid == "") {
                                    $dp = $cc->getObject("\Core\DataBase\ProcessQuery");
                                    $dp->setTable("core_setupschema");
                                    $dp->addFieldArray(array("modulename" => $configFileContentSettings['name']));
                                    $dp->buildInsert();
                                    $recordid = $dp->executeQuery();
                                    $processFlag = 1;
                                    $schemaprocess = 1;
                                    $dataprocess = 1;
                                    $attributeprocess = 1;
                                } else {
                                    if (version_compare(\Core::getValueFromArray($configFileContentSettings, 'schemaversion'),\Core::getValueFromArray($existingRow,'schemaversion')) > 0) {                                    
                                    
                                        $processFlag = 1;
                                        $schemaprocess = 1;
                                    }
                                    if (version_compare(\Core::getValueFromArray($configFileContentSettings, 'dataversion'),\Core::getValueFromArray($existingRow,'dataversion')) > 0) {                                    
                                        $processFlag = 1;
                                        $dataprocess = 1;
                                    }
                                    if (version_compare(\Core::getValueFromArray($configFileContentSettings, 'attributeversion'),\Core::getValueFromArray($existingRow,'attributeversion')) > 0) {
                                        $processFlag = 1;
                                        $attributeprocess = 1;
                                    }
                                }
                                if ($processFlag == 1) {
                                    if ($schemaprocess == 1) {
                                        if (trim($configFileContentSettings['setuppath']) != "") {
                                            $setuppath = $configFileContentSettings['setuppath'] . "\SchemaInstall";
                                            $className = $setuppath;
                                            $setup = new $className();
                                        }
                                    }
                                    if ($dataprocess == 1) {
                                        if ($configFileContentSettings['datapath']) {
                                            $setuppath = $configFileContentSettings['datapath'] . "\DataInstall";
                                            $className = $setuppath;
                                            $setup = new $className();
                                        }
                                    }
                                    if ($attributeprocess == 1) {
                                        if ($configFileContentSettings['attributepath']) {
                                            $setuppath = $configFileContentSettings['attributepath'] . "\AttributeInstall";
                                            $className = $setuppath;
                                            $setup = new $className();
                                        }
                                    }
                                    $cc = new \CoreClass();
                                    $dp = $cc->getObject("\Core\DataBase\ProcessQuery");
                                    $dp->setTable("core_setupschema");
                                    if ($schemaprocess == 1) {
                                        if (isset($configFileContentSettings['schemaversion'])) {
                                            $dp->addFieldArray(array("schemaversion" => $configFileContentSettings['schemaversion']));
                                        }
                                    }
                                    if ($dataprocess == 1) {
                                        if (isset($configFileContentSettings['dataversion'])) {
                                            $dp->addFieldArray(array("dataversion" => $configFileContentSettings['dataversion']));
                                        }
                                    }
                                    if ($attributeprocess == 1) {
                                        if (isset($configFileContentSettings['attributeversion'])) {
                                            $dp->addFieldArray(array("attributeversion" => $configFileContentSettings['attributeversion']));
                                        }
                                    }
                                    $dp->addWhere("id='" . $recordid . "'");
                                    $dp->buildUpdate();
                                    $recordid = $dp->executeQuery();
                                }
                            }
                        }
                    }
                }
            }
            \Core::createFile("mode.flag", 1, "prod");
        } catch (Exception $ex) {
            \Core::Log(__METHOD__ . "::" . $ex->getMessage(), "installexception.log");
        }
    }

}
