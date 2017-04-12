<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreNodeSettings
 *
 * @author ramesh
 */

namespace Core\Modules\CoreDevelopmentsettings\Controllers;

use \Core\Controllers\NodeController;

class CoreNodeSettings extends NodeController {

    //put your code here
    private $_core_registernode_id = NULL;
    private $_tablename = NULL;
    private $_nodeautokey = NULL;
    private $_nodeprimkey = NULL;
    private $_nodedescriptor = NULL;
    private $_mandotatory_add = NULL;
    private $_mandotatory_edit = NULL;
    private $_uniquefields = NULL;
    private $_hide_add = NULL;
    private $_hide_edit = NULL;
    private $_hide_view = NULL;
    private $_hide_admin = NULL;
    private $_readonly_add = NULL;
    private $_readonly_edit = NULL;
    private $_boolattributes = NULL;
    private $_file = NULL;
    private $_fck = NULL;
    private $_checkbox = NULL;
    private $_selectbox = NULL;
    private $_multivalues = NULL;
    private $_editlist = NULL;
    private $_numberattribute = NULL;
    private $_search = NULL;
    private $_dependee = NULL;
    private $_defaultvalues = NULL;
    private $_exactsearch = NULL;
    private $_total = NULL;
    private $_colorattributes = NULL;
    private $_core_node_actions_id = NULL;
    private $_actionrestriction = NULL;
    private $_default_action = NULL;
    private $_is_archive = NULL;
    private $_default_collection = NULL;

    public function getPrimaryKeyAction() {
        try {
            $tbmodel = new \Core\Model\TableStructure();
            $tbmodel->setTable($this->_requestedData['tablename']);
            $tableStructure = $tbmodel->getStructure();
            if (count($tableStructure) > 0) {
                $PrimaryKey = "";
                $UniqueKey = "";
                foreach ($tableStructure as $fieldData) {
                    if ($fieldData['Key'] == 'PRI') {
                        $PrimaryKey = $fieldData['Field'];
                    }
                    if ($fieldData['Key'] == 'UNI') {
                        $UniqueKey = $fieldData['Field'];
                    }
                }
                if ($PrimaryKey == "") {
                    $PrimaryKey = $UniqueKey;
                }
                echo $PrimaryKey;
            } else {
                echo "please check the table";
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function getAutokeyAction() {
        try {
            $tbmodel = new \Core\Model\TableStructure();
            $tbmodel->setTable($this->_requestedData['tablename']);
            $tableStructure = $tbmodel->getStructure();
            if (count($tableStructure) > 0) {
                $PrimaryKey = "";
                $UniqueKey = "";
                foreach ($tableStructure as $fieldData) {
                    if ($fieldData['Extra'] == 'auto_increment') {
                        echo $fieldData['Field'];
                    }
                }
            }
        } catch (Exception $ex) {
            \Core::Log($ex->getMessage());
        }
    }

    public function getNodeStructureDetailsAction() {
        $cc = new \CoreClass();
        $tbmodel = $cc->getObject("\Core\Model\TableStructure");
        $rquestedData = $this->_requestedData;
        $tbmodel->setTable($this->_requestedData['tablename']);
        $noderesult = $this->_requestedData['noderesult'];
        $tableStructure = $tbmodel->getStructure();
        $readonlyAttributes = $this->readonlyAttributes($this->_requestedData['action']);
        $fieldsArray = array();
        $idName = $this->_requestedData['idname'];
        if ($noderesult != "") {
            $noderesult = json_decode($noderesult, true);
        } else {
            $noderesult = array();
        }
        $sourceNodeStructure = $this->_currentNodeStructure;
        if (\Core::isArray($sourceNodeStructure)) {
            $readonlyAttributes = \Core::convertStringToArray($sourceNodeStructure['readonly_' . $rquestedData['action']]);
            $mandotatoryAttributes = \Core::convertStringToArray($sourceNodeStructure['mandotatory_' . $rquestedData['action']]);
            $multiSelectedValues = \Core::convertStringToArray($sourceNodeStructure['multivalues']);
        }
        $defaultValue = $noderesult[$idName];
        if (count($tableStructure) > 0) {
            $PrimaryKey = "";
            $UniqueKey = "";
            $i = 0;
            foreach ($tableStructure as $field => $fieldData) {
                if (!\Core::inArray($field, array("id", "createdby", "createdat", "updatedby", "updatedat"))) {
                    $fieldsArray[$i]['pid'] = $field;
                    $fieldsArray[$i]['pds'] = $this->getLabel($field);
                    $i++;
                }
            }
        }
        $attributeType = "checkbox";
        $attributeDetails = new \Core\Attributes\LoadAttribute($attributeType);
        $attributeClass = "\Core\Attributes\\". $attributeDetails->_attributeName;
        $attribute = new $attributeClass;
        $attribute->setIdName($idName);
        $attribute->setOptions($fieldsArray);
        $attribute->setValue($defaultValue);

        $attribute->setAction($this->_requestedData['action']);
        $FieldName="";
        if (in_array($FieldName, $mandotatoryAttributes)) {
            $attribute->setRequired();
            $FieldName = \Core::getValueFromArray($mandotatoryAttributes, $FieldName);
        }
        if (in_array($FieldName, $readonlyAttributes) || $rquestedData['action'] == 'view') {
            $attribute->setReadonly();
            $FieldName = \Core::getValueFromArray($readonlyAttributes, $FieldName);
        }
        $attribute->loadAttributeTemplate($attributeType, $FieldName);
    }

    public function coreNodeSettingsAfterDataUpdate() {
        $cache = new \Core\Cache\Refresh();
        $cache->setNodeName($this->_requestedData['core_registernode_id']);
        $cache->nodeStructure();
        $cache->profilePrivileges();
        return TRUE;
    }

    public function coreReportsdetailsSettingsNodeIdDescriptorAction() {
        $defaultValue = $this->_requestedData['node_id'];
        $result = array();
        $finalResult = array();
        if ($this->_requestedData['core_reportsdetails_id']) {
            $cc = new \CoreClass();
            $db = $cc->getObject("\Core\DataBase\ProcessQuery");
            $db->setTable("core_reportsdetails");
            $db->addWhere("core_reportsdetails.id='" . $this->_requestedData['core_reportsdetails_id'] . "'");
            $report = $db->getRow();
            $db = new \Core\DataBase\ProcessQuery();
            $db->setTable("core_registernode");
            $db->addField("displayvalue");
            $db->addWhere("core_registernode.nodename='" . $report['node_id'] . "'");

            $nodeDisplay = $db->getValue();
            $finalResult[] = array("pid" => $report['node_id'], "pds" => $nodeDisplay);
            $db = new \Core\DataBase\ProcessQuery();
            $db->setTable("core_node_relations", "nrl");
            $db->addFieldArray(array("rnd.nodename" => "pid", "rnd.displayvalue" => "pds"));
            $db->addJoin("node_id", "core_registernode", "rnd", "nrl.core_node_parent=rnd.nodename");
            $db->addWhere("((nrl.core_node_settings_id='" . $report['node_id'] . "' and nrl.core_node_parent!='" . $report['node_id'] . "' and nrl.core_relation_type_id='MTO'))");
            $db->addGroupBy("rnd.nodename");
            $db->addOrderBy("rnd.sort_value");
            $db->buildSelect();
            $result = $db->getRows();
            foreach ($result as $rs) {
                $finalResult[] = $rs;
            }
        }
        $attributeType = "select";
        $attributeDetails = new \Core\Attributes\LoadAttribute($attributeType);
        $attributeClass = "\Core\Attributes\\" . $attributeDetails->_attributeName;
        $attribute = new $attributeClass;
        $attribute->setIdName('node_id');
        $attribute->setOptions($finalResult);
        $attribute->setValue($defaultValue);
        $attribute->setOnchange("getFieldsforReport();");
        $attribute->loadAttributeTemplate($attributeType, 'node_id');
    }

    public function setRegisternodeId($registernodeid) {
        $this->_core_registernode_id = $registernodeid;
    }

    public function getRegisternodeId() {
        return $this->_core_registernode_id;
    }

    public function setTablename($tablename) {
        $this->_tablename = $tablename;
    }

    public function getTablename() {
        return $this->_tablename;
    }

    public function setAutokey($autokey) {
        $this->_nodeautokey = $autokey;
    }

    public function getAutokey() {
        return $this->_nodeautokey;
    }

    public function setPrimarykey($primkey) {
        $this->_nodeprimkey = $primkey;
    }

    public function getPrimarykey() {
        return $this->_nodeprimkey;
    }

    public function setDescriptorkey($descriptor) {
        $this->_nodedescriptor = $descriptor;
    }

    public function getDescriptorkey() {
        return $this->_nodedescriptor;
    }

    public function setMandotatoryAdd($mandotatory_add) {
        $this->_mandotatory_add = $mandotatory_add;
    }

    public function getMandotatoryAdd() {
        return $this->_mandotatory_add;
    }

    public function setMandotatoryEdit($mandotatory_edit) {
        $this->_mandotatory_edit = $mandotatory_edit;
    }

    public function getMandotatoryEdit() {
        return $this->_mandotatory_edit;
    }

    public function setUniquefields($uniquefields) {
        $this->_uniquefields = $uniquefields;
    }

    public function getUniquefields() {
        return $this->_uniquefields;
    }

    public function setHideAdd($hide_add) {
        $this->_hide_add = $hide_add;
    }

    public function getHideAdd() {
        return $this->_hide_add;
    }

    public function setHideEdit($hide_edit) {
        $this->_hide_edit = $hide_edit;
    }

    public function getHideEdit() {
        return $this->_hide_edit;
    }

    public function setHideView($hide_view) {
        $this->_hide_view = $hide_view;
    }

    public function getHideView() {
        return $this->_hide_view;
    }

    public function setHideAdmin($hide_admin) {
        $this->_hide_admin = $hide_admin;
    }

    public function getHideAdmin() {
        return $this->_hide_admin;
    }

    public function setReadonlyAdd($readonly_add) {
        $this->_readonly_add = $readonly_add;
    }

    public function getReadonlyAdd() {
        return $this->_readonly_add;
    }

    public function setBoolattributes($boolattributes) {
        $this->_boolattributes = $boolattributes;
    }

    public function getBoolattributes() {
        return $this->_boolattributes;
    }

    public function setReadonlyEdit($readonly_edit) {
        $this->_readonly_edit = $readonly_edit;
    }

    public function getReadonlyEdit() {
        return $this->_readonly_edit;
    }

    public function setFile($file) {
        $this->_file = $file;
    }

    public function getFile() {
        return $this->_file;
    }

    public function setFck($fck) {
        $this->_fck = $fck;
    }

    public function getFck() {
        return $this->_fck;
    }

    public function setCheckbox($checkbox) {
        $this->_checkbox = $checkbox;
    }

    public function getCheckbox() {
        return $this->_checkbox;
    }

    public function setSelectbox($selectbox) {
        $this->_selectbox = $selectbox;
    }

    public function getSelectbox() {
        return $this->_selectbox;
    }

    public function setMultivalues($multivalues) {
        $this->_multivalues = $multivalues;
    }

    public function getMultivalues() {
        return $this->_multivalues;
    }

    public function setEditlist($editlist) {
        $this->_editlist = $editlist;
    }

    public function getEditlist() {
        return $this->_editlist;
    }

    public function setNumberattribute($numberattribute) {
        $this->_numberattribute = $numberattribute;
    }

    public function getNumberattribute() {
        return $this->_numberattribute;
    }

    public function setSearch($search) {
        $this->_search = $search;
    }

    public function getSearch() {
        return $this->_search;
    }

    public function setDependee($dependee) {
        $this->_dependee = $dependee;
    }

    public function getDependee() {
        return $this->_dependee;
    }

    public function setDefaultvalues($defaultvalues) {
        $this->_defaultvalues = $defaultvalues;
    }

    public function getDefaultvalues() {
        return $this->_defaultvalues;
    }

    public function setExactsearch($exactsearch) {
        $this->_exactsearch = $exactsearch;
    }

    public function getExactsearch() {
        return $this->_exactsearch;
    }

    public function setTotal($total) {
        $this->_total = $total;
    }

    public function getTotal() {
        return $this->_total;
    }

    public function setColorattributes($colorattributes) {
        $this->_colorattributes = $colorattributes;
    }

    public function getColorattributes() {
        return $this->_colorattributes;
    }

    public function setCoreNodeActionsId($core_node_actions_id) {
        $this->_core_node_actions_id = $core_node_actions_id;
    }

    public function getCoreNodeActionsId() {
        return $this->_core_node_actions_id;
    }

    public function setActionrestriction($actionrestriction) {
        $this->_actionrestriction = $actionrestriction;
    }

    public function getActionrestriction() {
        return $this->_actionrestriction;
    }

    public function setDefaultAction($default_action) {
        $this->_default_action = $default_action;
    }

    public function getDefaultAction() {
        return $this->_default_action;
    }

    public function setIsArchive($is_archive) {
        $this->_dis_archive = $is_archive;
    }

    public function getIsArchive() {
        return $this->_is_archive;
    }

    public function setDefaultCollection($default_collection) {
        $this->_default_collection = $default_collection;
    }

    public function getDefaultCollection() {
        return $this->_default_collection;
    }

    public function dataSave() {
        try {
            $cc = new \CoreClass();
            $db1 = $cc->getObject("\Core\DataBase\ProcessQuery");
            $db1->setTable("core_node_settings");
            $db1->addField("id");
            $db1->addWhere("core_registernode_id='" . $this->getRegisternodeId() . "'");
            $registernodeid = $db1->getValue();
            $db = $cc->getObject("\Core\DataBase\ProcessQuery");
            $db->setTable("core_node_settings");
            $db->addFieldArray(array("core_registernode_id" => $this->getRegisternodeId()));
            $db->addFieldArray(array("tablename" => $this->getTablename()));
            $db->addFieldArray(array("autokey" => $this->getAutokey()));
            $db->addFieldArray(array("primkey" => $this->getPrimarykey()));
            $db->addFieldArray(array("descriptor" => $this->getDescriptorkey()));
            $db->addFieldArray(array("mandotatory_add" => $this->getMandotatoryAdd()));
            $db->addFieldArray(array("mandotatory_edit" => $this->getMandotatoryEdit()));
            $db->addFieldArray(array("uniquefields" => $this->getUniquefields()));
            $db->addFieldArray(array("hide_add" => $this->getHideAdd()));
            $db->addFieldArray(array("hide_edit" => $this->getHideEdit()));
            $db->addFieldArray(array("hide_view" => $this->getHideView()));
            $db->addFieldArray(array("hide_admin" => $this->getHideAdmin()));
            $db->addFieldArray(array("readonly_add" => $this->getReadonlyAdd()));
            $db->addFieldArray(array("readonly_edit" => $this->getReadonlyEdit()));
            $db->addFieldArray(array("boolattributes" => $this->getBoolattributes()));
            $db->addFieldArray(array("file" => $this->getFile()));
            $db->addFieldArray(array("fck" => $this->getFck()));
            $db->addFieldArray(array("checkbox" => $this->getCheckbox()));
            $db->addFieldArray(array("selectbox" => $this->getSelectbox()));
            $db->addFieldArray(array("multivalues" => $this->getMultivalues()));
            $db->addFieldArray(array("editlist" => $this->getEditlist()));
            $db->addFieldArray(array("numberattribute" => $this->getNumberattribute()));
            $db->addFieldArray(array("search" => $this->getSearch()));
            $db->addFieldArray(array("dependee" => $this->getDependee()));
            $db->addFieldArray(array("defaultvalues" => $this->getDefaultvalues()));
            $db->addFieldArray(array("exactsearch" => $this->getExactsearch()));
            $db->addFieldArray(array("total" => $this->getTotal()));
            $db->addFieldArray(array("colorattributes" => $this->getColorattributes()));
            $db->addFieldArray(array("core_node_actions_id" => $this->getCoreNodeActionsId()));
            $db->addFieldArray(array("actionrestriction" => $this->getActionrestriction()));
            $db->addFieldArray(array("default_action" => $this->getDefaultAction()));
            $db->addFieldArray(array("default_collection" => $this->getDefaultCollection()));
            $db->addFieldArray(array("is_archive" => $this->getIsArchive()));
            $db->addFieldArray(array("updatedat" => \Core::getDateTime()));
            if ($registernodeid) {
                $db->addWhere("core_registernode_id='" . $this->getRegisternodeId() . "'");
                $db->buildUpdate();
            } else {
                $db->addFieldArray(array("createdat" => \Core::getDateTime()));
                $db->buildInsert();
            }
            $db->executeQuery();
        } catch (Exception $ex) {
            \Core::Log($ex->getMessage(), "installdata.log");
        }
    }

}
