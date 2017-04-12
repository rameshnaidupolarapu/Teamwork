<?php

namespace Core\Cache;

class Refresh {

    public $_nodeName = NULL;

    public function setNodeName($nodeName) {
        $this->_nodeName = $nodeName;
    }

    public function refreshCache() {
        try {
            $this->nodeActions();
            $this->nodeFiles();
            $this->nodeStructure();
            $this->adminThemeSettings();
            $this->profilePrivileges();
            $this->setLables();
            $this->actionTypeList();
            $this->setRelations();
            $this->setDefaultValues();
            $this->setUniqueSetValues();
            $this->setFieldAttributes();
            $this->setFilePath();
            $this->setActionTeamples();
        } catch (Exception $ex) {
            \Core::Log($ex->getMessage());
        }
    }

    public function nodeStructure() {
        $cc = new \CoreClass();
        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_node_settings", "cns");
        if ($this->_nodeName != "") {
            $qry->addWhere("core_registernode_id='" . $this->_nodeName . "'");
        }
        $result = $qry->getRows("core_registernode_id");
        if (count($result) > 0) {
            foreach ($result as $key => $rs) {
                $this->setLayout($key, $rs);
                $this->setTableStructure($key, $rs);
                $filepath = \Core::getCachefilePath($key, "S", 1);
                \Core::createFile($filepath, 1, json_encode($rs));
                $this->setNodeActions($rs);
            }
        }
        return;
    }

    public function setNodeActions($rs) {
        $core_node_actions = $rs['core_node_actions_id'];
        $core_node_actions = \Core::convertStringToArray($core_node_actions);
        $cc = new \CoreClass();
        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_node_actions");
        $qry->addFieldArray(array("lower(core_node_actions.short_code)" => "short_code", "core_action_type_id" => "core_action_type_id"));
        $qry->addWhere("lower(core_node_actions.short_code) in('" . \Core::convertArrayToString($core_node_actions, "','") . "')");
        $result = $qry->getRows("short_code", "core_action_type_id");
        $filepath = \Core::getCachefilePath($rs['core_registernode_id'], "NA", 1);

        \Core::createFile($filepath, 1, json_encode($result));
    }

    public function nodeFiles() {
        $cc = new \CoreClass();
        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_registernode", "rn");
        $qry->addFieldArray(array("nodename" => "nodename", "nodefile" => "nodefile", "core_root_module_id" => "rootmodule", "core_module_id" => "module", "core_module_display_id" => "moduledisplay"));
        $result = $qry->getRows("nodename");
        if (count($result) > 0) {
            foreach ($result as $key => $rs) {
                $filepath = \Core::getCachefilePath($key, "N", 1);
                \Core::createFile($filepath, 1, json_encode($rs));
            }
        }
        return;
    }

    public function profilePrivileges() {
        global $rootObj;
        $wb = $rootObj;
        $cc = new \CoreClass();
        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_registernode", "rnd");
        $qry->addField("rnd.nodename
				,rnd.icon
				,rnd.menu
				,rnd.is_module
                                ,rnd.displayvalue
				,if(rnd.core_module_id is null,rnd.nodename,rnd.core_module_id) as core_module_id
				,if(rnd.core_module_display_id is null,rnd.nodename,rnd.core_module_display_id) as core_module_display_id
				,if(rnd.core_root_module_id is null,rnd.nodename,rnd.core_root_module_id) as core_root_module_id
				,group_concat(nac.short_code ORDER BY nac.sort_no ASC separator ',') as core_node_actions_id
				,group_concat(concat(nac.name,'||',nac.short_code) ORDER BY nac.sort_no ASC separator ',') as action_name_code");
        $qry->addJoin("nodename", "core_node_settings", "ns", "rnd.nodename=ns.core_registernode_id");
        $qry->addJoin("core_node_actions_id", "core_node_actions", "nac", " ns.core_node_actions_id like concat('%','|',nac.short_code,'|','%') 
		|| ns.core_node_actions_id like concat(nac.short_code,'|','%') 
		|| ns.core_node_actions_id like concat('%','|',nac.short_code) 
		|| (ns.core_node_actions_id=nac.short_code) ");
        $qry->addGroupBy("rnd.nodename");
        $qry->addOrderBy("rnd.is_module DESC ,rnd.sort_value ASC");
        $result = $qry->getRows("nodename");
        $totalResult['ROOT'] = $result;

        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_profile");
        $profileDetails = $qry->getRows();
        if (count($profileDetails) > 0) {
            foreach ($profileDetails as $pd) {
                $qry = new \Core\DataBase\ProcessQuery();
                $qry->setTable("core_registernode", "rnd");
                $qry->addField("rnd.nodename
                                        ,rnd.icon
                                        ,rnd.menu
                                        ,rnd.is_module
                                        ,rnd.displayvalue
                                        ,if(rnd.core_module_id is null,rnd.nodename,rnd.core_module_id) as core_module_id
                                        ,if(rnd.core_module_display_id is null,rnd.nodename,rnd.core_module_display_id) as core_module_display_id
                                        ,if(rnd.core_root_module_id is null,rnd.nodename,rnd.core_root_module_id) as core_root_module_id
                                        ,group_concat(nac.short_code ORDER BY nac.sort_no ASC separator ',') as core_node_actions_id
                                        ,group_concat(concat(nac.name,'||',nac.short_code) ORDER BY nac.sort_no ASC separator ',') as action_name_code");
                $qry->addJoin("nodename", "core_node_settings", "ns", "rnd.nodename=ns.core_registernode_id");
                $qry->addJoin("core_node_actions_id", "core_node_actions", "nac", " ns.core_node_actions_id like concat('%','|',nac.short_code,'|','%') 
                        || ns.core_node_actions_id like concat(nac.short_code,'|','%') 
                        || ns.core_node_actions_id like concat('%','|',nac.short_code) 
                        || (ns.core_node_actions_id=nac.short_code) ");
                $qry->addJoin("core_profile_id", "core_access", "urac", " urac.action like concat('%',nac.short_code,'%') and urac.node=rnd.nodename ");
                $qry->addWhere("(urac.core_profile_id='" . $pd['short_code'] . "' || is_module='1' )");
                $qry->addGroupBy("rnd.nodename");
                $qry->addOrderBy("rnd.is_module DESC ,rnd.sort_value ASC");
                $qry->buildSelect();
                $result = $qry->getRows("nodename");

                $totalResult[$pd['short_code']] = $result;
            }
        }
        if (count($totalResult) > 0) {
            foreach ($totalResult as $key => $rs) {

                $folderpath = \Core::createFolder("profileaccess/" . $key, "C");
                $fp = fopen($folderpath . "/profileacess.json", "w+");
                fwrite($fp, json_encode($rs));
                fclose($fp);
                foreach ($rs as $node => $data) {
                    $folderpath = \Core::createFolder("profileaccess/" . $key . "/" . $node, "C");
                    $fp = fopen($folderpath . "/profileacess.json", "w+");
                    fwrite($fp, json_encode($data));
                    fclose($fp);
                }
            }
        }
        return;
    }

    public function nodeActions() {
        global $rootObj;
        $wb = $rootObj;
        $cc = new \CoreClass();
        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_node_actions");
        $qry->addFieldArray(array("lower(core_node_actions.short_code)" => "short_code", "name" => "name"));
        $result = $qry->getRows("short_code", "name");
        $folderpath = \Core::createFolder(NULL, 'C');
        if (!file_exists($folderpath)) {
            mkdir($folderpath, 0755, true);
        }
        $fp = fopen($folderpath . "/nodeactions.json", "w+");
        fwrite($fp, json_encode($result));
        fclose($fp);

        return;
    }

    public function adminThemeSettings() {
        global $rootObj;
        $wb = $rootObj;
        $cc = new \CoreClass();
        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_adminthemesettings");
        $qry->addField("*");
        $result = $qry->getRow();
        $folderpath = \Core::createFolder(NULL, "C");
        if (!file_exists($folderpath)) {
            mkdir($folderpath, 0755, true);
        }
        $fp = fopen($folderpath . "/admintheme.json", "w+");
        fwrite($fp, json_encode($result));
        fclose($fp);
        return;
    }

    public function actionTypeList() {
        global $rootObj;
        $wb = $rootObj;
        $cc = new \CoreClass();
        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_node_actions");
        $qry->addFieldArray(array("short_code" => "short_code", "core_action_type_id" => "core_action_type_id"));
        $result = $qry->getRows("short_code", "core_action_type_id");
        $folderpath = \Core::createFolder(NULL, "C");
        if (!file_exists($folderpath)) {
            mkdir($folderpath, 0755, true);
        }
        $fp = fopen($folderpath . "/actiontype.json", "w+");
        fwrite($fp, json_encode($result));
        fclose($fp);
        return;
    }

    public function setLables() {
        global $rootObj;
        $wb = $rootObj;
        $cc = new \CoreClass();
        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_registernode");
        $qry->addFieldArray(array("nodename" => "nodename", "displayvalue" => "displayvalue"));
        $noderesult = $qry->getRows("nodename", "displayvalue");
        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_label_details");
        $qry->addFieldArray(array("original_name" => "original_name", "display_name" => "display_name"));
        $result = $qry->getRows("original_name", "display_name");
        $result+=$noderesult;
        $folderpath = \Core::createFolder(NULL, "C");
        if (!file_exists($folderpath)) {
            mkdir($folderpath, 0755, true);
        }
        $fp = fopen($folderpath . "/language.json", "w+");
        fwrite($fp, json_encode($result));
        fclose($fp);
        return;
    }

    public function setRelations() {
        global $rootObj;
        $wb = $rootObj;
        $cc = new \CoreClass();
        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_node_relations");
        $qry->addFieldArray(array("core_node_settings_id" => "node", "core_relation_type_id" => "type", "core_node_colname" => "colname", "core_node_parent" => "parent"));
        if ($this->_nodeName) {
            $qry->addWhere("( core_node_relations.core_node_settings_id='" . $this->_nodeName . "')");
        }
        $qry->buildSelect();
        $noderesult = $qry->getRows();
        $finalresult = array();
        $childRelations = array();
        if (count($noderesult) > 0) {
            foreach ($noderesult as $nodeRelation) {
                $type = $nodeRelation['type'];
                $key = $nodeRelation['colname'];
                $value = $nodeRelation['parent'];
                if ($type != 'MTO') {
                    $key = $value;
                    $value = $nodeRelation['colname'];
                } else {
                    $childRelations[$value][$nodeRelation['node']][$key] = $key;
                }
                $finalresult[$nodeRelation['node']][$type][$key] = $value;
            }
        }
        if (count($finalresult) > 0) {
            foreach ($finalresult as $key => $rs) {
                $filepath = \Core::getCachefilePath($key, "R", 1);
                \Core::createFile($filepath, 1, json_encode($rs));
                $this->setRelationDependency($key);
            }
        }
        if (count($childRelations) > 0) {
            foreach ($childRelations as $key => $rs) {
                $filepath = \Core::getCachefilePath($key, "CR", 1);
                \Core::createFile($filepath, 1, json_encode($rs));
            }
        }
        return;
    }

    public function setRelationDependency($nodeName) {
        global $rootObj;
        $wb = $rootObj;
        $cc = new \CoreClass();
        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_node_relations");
        $qry->addFieldArray(array("core_node_settings_id" => "node", "dependee_fields" => "dependee_fields", "core_node_colname" => "colname", "core_node_parent" => "parent"));
        $qry->addWhere("( core_node_relations.core_node_settings_id='" . $nodeName . "')");
        $qry->addWhere("core_node_relations.core_relation_type_id='MTO'");
        $qry->addWhere("core_node_relations.dependee_fields!=''");
        $qry->buildSelect();
        $noderesult = $qry->getRows("colname");
        $dependencyDetails = array();
        if (count($noderesult) > 0) {
            foreach ($noderesult as $colname => $data) {
                $dependee_fields = \Core::convertStringToArray($data['dependee_fields']);
                if (\Core::countArray($dependee_fields) > 0) {
                    foreach ($dependee_fields as $dependentColName) {
                        if (\Core::keyInArray($dependentColName, $dependencyDetails)) {
                            if ($dependencyDetails[$dependentColName]) {
                                $dependencyDetails[$dependentColName] = $dependencyDetails[$dependentColName] . "|" . $colname;
                            } else {
                                $dependencyDetails[$dependentColName] = $colname;
                            }
                        } else {
                            $dependencyDetails[$dependentColName] = $colname;
                        }
                    }
                }

                $filepath = \Core::getCachefilePath($nodeName, 'D', 1);
                \Core::createFile($filepath, 1, json_encode($dependencyDetails));
            }
        }
    }

    public function setChildRelations() {
        global $rootObj;
        $wb = $rootObj;
        $cc = new \CoreClass();
        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_node_relations");
        $qry->addFieldArray(array("core_node_settings_id" => "node", "core_relation_type_id" => "type", "core_node_colname" => "colname", "core_node_parent" => "parent"));
        if ($this->_nodeName) {
            $qry->addWhere("( core_node_relations.core_node_parent='" . $this->_nodeName . "')");
        }
        $qry->addWhere("core_node_relations.core_relation_type_id='MTO'");
        $qry->buildSelect();
        $noderesult = $qry->getRows();
        $childRelations = array();
        if (count($noderesult) > 0) {
            foreach ($noderesult as $nodeRelation) {
                $type = $nodeRelation['type'];
                $key = $nodeRelation['colname'];
                $value = $nodeRelation['parent'];
                $childRelations[$value][$nodeRelation['node']][$key] = $key;
            }
        }
        if (count($childRelations) > 0) {
            foreach ($childRelations as $key => $rs) {
                $filepath = \Core::getCachefilePath($key, "CR", 1);
                \Core::createFile($filepath, 1, json_encode($rs));
            }
        }
        return;
    }

    public function setLayout($key, $data) {
        $layout = array();
        $default = array();
        $table = $data['tablename'];
        $cc = new \CoreClass();
        $db = $cc->getObject("\Core\Model\TableStructure");
        $db->setTable($table);
        $nodeStructure = $db->getStructure();
        $fields = \Core::getKeysFromArray($nodeStructure);
        $layout['default_tab'] = $fields;
        $filepath = \Core::getCachefilePath($key, "L", 1);
        \Core::createFile($filepath, 1, json_encode($layout));
        return;
    }

    public function setTableStructure($key, $data) {

        $table = $data['tablename'];
        $cc = new \CoreClass();
        $db = $cc->getObject("\Core\Model\TableStructure");
        $db->setTable($table);
        $nodeStructure = $db->getStructure();
        $tableWithType = array();
        if (count($nodeStructure) > 0) {
            foreach ($nodeStructure as $Field => $keydata) {
                $tableWithType[$keydata['Field']] = $keydata['Type'];
            }
        }
        $filepath = \Core::getCachefilePath($key, "T", 1);
        \Core::createFile($filepath, 1, json_encode($tableWithType));
        return;
    }

    public function setDefaultValues() {
        $cc = new \CoreClass();
        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_defaultvalues");
        $qry->addFieldArray(array("core_node_settings_id" => "node", "fieldname" => "fieldname", "value" => "value"));
        if ($this->_nodeName) {
            $qry->addWhere("( core_defaultvalues.core_node_settings_id='" . $this->_nodeName . "')");
        }
        $qry->buildSelect();
        $noderesult = $qry->getRows();
        $nodewiseData = array();
        if (count($noderesult) > 0) {
            foreach ($noderesult as $nodeDefaultData) {
                $node = $nodeDefaultData['node'];
                $fieldname = $nodeDefaultData['fieldname'];
                $value = $nodeDefaultData['value'];

                $nodewiseData[$node][$fieldname] = $value;
            }
        }
        if (\Core::countArray($nodewiseData)) {
            foreach ($nodewiseData as $node => $data) {
                $filepath = \Core::getCachefilePath($node, "DF", 1);
                \Core::createFile($filepath, 1, json_encode($data));
            }
        }
    }

    public function setUniqueSetValues() {
        $cc = new \CoreClass();
        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_uniquefieldset");
        $qry->addFieldArray(array("core_node_settings_id" => "node", "uniquefieldset" => "uniquefieldset"));
        if ($this->_nodeName) {
            $qry->addWhere("( core_uniquefieldset.core_node_settings_id='" . $this->_nodeName . "')");
        }
        $qry->buildSelect();
        $noderesult = $qry->getRows();
        $nodewiseData = array();
        if (count($noderesult) > 0) {
            foreach ($noderesult as $nodeDefaultData) {
                $node = $nodeDefaultData['node'];
                $uniquefieldset = $nodeDefaultData['uniquefieldset'];
                $nodewiseData[$node][$uniquefieldset] = $uniquefieldset;
            }
        }
        if (\Core::countArray($nodewiseData)) {
            foreach ($nodewiseData as $node => $data) {
                $filepath = \Core::getCachefilePath($node, "UFS", 1);
                \Core::createFile($filepath, 1, json_encode($data));
            }
        }
    }

    public function setFieldAttributes() {
        $cc = new \CoreClass();
        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_node_fieldattributes");
        $qry->addFieldArray(array("core_node_settings_id" => "node", "fieldname" => "fieldname", "core_root_attribute_id" => "attribute"));
        if ($this->_nodeName) {
            $qry->addWhere("( core_node_fieldattributes.core_node_settings_id='" . $this->_nodeName . "')");
        }
        $qry->buildSelect();
        $noderesult = $qry->getRows();
        $nodewiseData = array();
        if (count($noderesult) > 0) {
            foreach ($noderesult as $nodeDefaultData) {
                $node = $nodeDefaultData['node'];
                $fieldname = $nodeDefaultData['fieldname'];
                $attribute = $nodeDefaultData['attribute'];
                $nodewiseData[$node][$fieldname] = $attribute;
            }
        }
        if (\Core::countArray($nodewiseData)) {
            foreach ($nodewiseData as $node => $data) {
                $filepath = \Core::getCachefilePath($node, "FA", 1);
                \Core::createFile($filepath, 1, json_encode($data));
            }
        }
    }

    public function setFilePath() {
        $cc = new \CoreClass();
        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_node_filetypes");
        $qry->addFieldArray(array("core_node_settings_id" => "node", "colmanname" => "fieldname", "core_cms_uploadfolders_id" => "storagefolder", "core_cms_image_settings_id" => "imagesizeid", "core_file_types_id" => "filetypes"));
        if ($this->_nodeName) {
            $qry->addWhere("( core_node_filetypes.core_node_settings_id='" . $this->_nodeName . "')");
        }
        $qry->buildSelect();
        $noderesult = $qry->getRows();
        $nodewiseData = array();
        if (count($noderesult) > 0) {
            foreach ($noderesult as $nodeDefaultData) {
                $node = $nodeDefaultData['node'];
                $fieldname = $nodeDefaultData['fieldname'];
                $pathData = array();
                $pathData['storagefolder'] = $nodeDefaultData['storagefolder'];
                $pathData['imagesizeid'] = $nodeDefaultData['imagesizeid'];
                $pathData['filetypes'] = $nodeDefaultData['filetypes'];
                $nodewiseData[$node][$fieldname] = $pathData;
            }
        }
        if (\Core::countArray($nodewiseData)) {
            foreach ($nodewiseData as $node => $data) {
                $filepath = \Core::getCachefilePath($node, "FP", 1);
                \Core::createFile($filepath, 1, json_encode($data));
            }
        }
    }

    public function setActionTeamples() {
        set_time_limit(0);
        $cc = new \CoreClass();
        $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
        $qry->setTable("core_node_actions");
        $qry->addFieldArray(array("lower(core_node_actions.short_code)" => "short_code"));
        $qry->addWhere("is_layout='1'");
        $resultaction = $qry->getRows();
        if (count($resultaction) > 0) {
            $qry = $cc->getObject("\Core\DataBase\ProcessQuery");
            $qry->setTable("core_registernode", "rn");
            $qry->addFieldArray(array("nodename" => "nodename", "nodefile" => "nodefile", "core_root_module_id" => "rootmodule", "core_module_id" => "module", "core_module_display_id" => "moduledisplay"));
            $result = $qry->getRows("nodename");
            if (count($result) > 0) {
                foreach ($result as $key => $rs) {

                    foreach ($resultaction as $actionData) {
                        if ($rs['module']) {
                            $action = $actionData['short_code'];
                            $parentFile = "";
                            $path = "*/*/View/adminhtml/Uicomponent/" . \Core::convertStringToFileName($key) . "_" . $action . ".xml";
                            $corefiles = glob("*/" . $path);
                            $modulesfiles = glob("*/*/View/adminhtml/Uicomponent/" . \Core::convertStringToFileName($key) . "_" . $action . ".xml");
                            $childfiles = array();
                            $fileslist = [];
                            if (count($corefiles) > 0) {
                                foreach ($corefiles as $file) {
                                    if ($parentFile == "") {
                                        $parentFile = $file;
                                    } else {
                                        $childfiles[] = $file;
                                    }
                                    $fileslist[] = $file;
                                }
                            }
                            if (count($modulesfiles) > 0) {
                                foreach ($modulesfiles as $file) {
                                    if ($parentFile == "") {
                                        $parentFile = $file;
                                    } else {
                                        $childfiles[] = $file;
                                    }
                                    $fileslist[] = $file;
                                }
                            }
                            if (count($fileslist) > 0) {
                                $folderName = $action . "Templates/" . \Core::convertStringToFileName($rs['module']) . "/";
                                $folderName = \Core::createFolder($folderName, "C");
                                $fileName = $folderName . "/" . \Core::convertStringToFileName($key) . "_" . $action . ".xml";
                                \Core::joinXML($fileslist, $fileName);
                            }
                        }
                    }
                }
            }
        }
        return;
    }

}
