<?php
namespace Core\Model;
use \Core\Model\RameshAbstract;
class Node extends RameshAbstract {

    public $_record = array();
    public $_jsonrecord = array();
    public $_defaulthideAttributes = array("id","createdat","createdby", "updatedby", "updatedat");
    public $_whereCon = null;
    public $_totalRecordsCount = null;
    public $_rpp = null;
    public $_page = null;
    public $_wsrpp = null;
    public $_eventMethods = array();
    public $_conditionMTO = array();
    public $_isReport = 0;
    public $_childNode = NULL;
    public $_defaultValues = array();
    public $_requestedData = array();
    public $_filesData = array();
    public $_nolimit = 0;
    public $_customOrderBy = 0;
    public $_customGroupBy = 0;
    public $_orderBy = NULL;
    public $_groupBy = NULL;
    public $_preDefaultOrderBy = NULL;
    public $_preDefaultGroupBy = NULL;
    protected $_sql;
    public $_removeTotalCollection=0;

    public function __construct($node = null, $model = NULL) {
        $this->setNodeName($node);
    }

    public function setRequestedData($requesteddata) {
        $this->_requestedData = $requesteddata;
    }

    public function setFilesData($filesdata) {
        $this->_filesData = $filesdata;
    }
    public function getRequestedData() {
        return $this->_requestedData;
    }

    public function getFilesData() {
        return $this->_filesData;
    }

    public function setChildNode($childNode) {
        $this->_childNode = $childNode;
    }

    public function setReport() {
        $this->_isReport = 1;
    }

    public function removeReport() {
        $this->_isReport = 0;
    }

    public function setRpp($rpp) {
        $this->_rpp = $rpp;
    }

    public function setPage($page) {
        $this->_page = $page;
    }

    public function setNolimit() {
        $this->_nolimit = 1;
    }

    public function hideAttributes() {
        $this->_currentAction;
        $defaulthideAttributes = $this->_defaulthideAttributes;
        $action = $this->_currentAction;
        if (strtolower($action) == 'adminrefresh') {
            $action = "admin";
        }
        $hide_column = "hide_" . strtolower($action);

        if (key_exists($hide_column, $this->_currentNodeStructure)) {
            $nodehideattributes = explode("|", $this->_currentNodeStructure[$hide_column]);
        } else {
            $nodehideattributes = explode("|", \Core::getValueFromArray($this->_currentNodeStructure, "hide_edit"));
        }

        return array_merge($defaulthideAttributes, $nodehideattributes);
    }

    public function mandotatoryAttributes($action = NULL) {
        $this->_currentAction;
        if (!$action) {
            $mandotatory_column = "mandotatory_" . strtolower($this->_currentAction);
        } else {
            $mandotatory_column = "mandotatory_" . strtolower($action);
        }
        $mandotatoryAttributes = array();
        if (key_exists($mandotatory_column, $this->_currentNodeStructure)) {
            $mandotatoryAttributes = explode("|", $this->_currentNodeStructure[$mandotatory_column]);
        }

        return $mandotatoryAttributes;
    }

    public function readonlyAttributes($actionName = NULL) {
        if ($actionName == "") {
            $actionName = $this->_currentAction;
        }
        $readonly_column = "readonly_" . strtolower($actionName);
        $readonlyAttributes = array();
        if (key_exists($readonly_column, $this->_currentNodeStructure)) {
            $readonlyAttributes = explode("|", $this->_currentNodeStructure[$readonly_column]);
        } else {
            $readonlyAttributes = array_keys($this->_NodeFieldsList);
        }
        return $readonlyAttributes;
    }

    public function setShowAttributes() {
        $this->getFieldsForNode();        
        if($this->_currentAction=='admin' || $this->_currentAction=='adminRefresh')
        {
            $fileName=\Core::createFolder("","C")."adminTemplates/".\Core::convertStringToFileName($this->_currentNodeModule)."/".\Core::convertStringToFileName($this->_nodeName)."_admin.xml";
            if(\Core::fileExists($fileName))
            {            
                $i=0;
                $configFileContent = \Core::getFileContent($fileName);
                $configFileContentSettings = \Core::convertXmlToArray($configFileContent,"columns");
                $columnsData=array();
                if(\Core::countArray($configFileContentSettings)>0)
                {
                    foreach ($configFileContentSettings as $data)
                    {

                        $i++;
                        if(isset($data['column']))
                        {
                        if(isset($data['column'][0]))
                        {
                            foreach ($data['column'] as  $coldata)
                            {
                                $columnsData[]=$coldata;
                            }
                        }
                        else
                        {                        
                            $columnsData[]=$data['column'];
                        }
                        }
                    }
                }

                foreach ($columnsData as $columnData)
                {
                    $this->_showAttributes[]=$columnData['@attributes']['name'];
                }

            }
            else 
            {
                $this->_showAttributes = array_diff(array_keys($this->_NodeFieldsList), $this->hideAttributes());
            }  
        }
        else 
        {
            $this->_showAttributes = array_diff(array_keys($this->_NodeFieldsList), $this->hideAttributes());
        } 
    }
    public function getRecordLoad() {
        $db = new \Core\DataBase\ProcessQuery();
        $db->setTable($this->_tableName);
        $db->addField("*");
        $db->addWhere($this->_primaryKey . "='" . $this->_currentSelector . "'");
        $this->_record = $db->getRow();
	$this->_sql = $db->sql;
        if (\Core::countArray($this->_record) > 0) {
            foreach ($this->_record as $key => $value) {
                if (!\Core::inArray($this->_NodeFieldsList[$key], array("longtext", 'mediumtext'))) {
                    $this->_jsonrecord[$key] = $value;
                } else {
                    if (\Core::keyInArray($key, $this->_NodeFieldAttributes)) {
                        $this->_jsonrecord[$key] = $value;
                    }
                }
            }
        }
    }

    public function getCollection() {
        try {
            if($this->_removeTotalCollection!=1)
            {
                $this->getTotalResultCount();
            }
            $db = new \Core\DataBase\ProcessQuery();
            $db->setTable($this->_tableName, $this->_nodeName);
            $indexKey = $this->_primaryKey;
            if (count($this->_showAttributes) > 0) {
                $db->addField($this->_autoKey);
                foreach ($this->_showAttributes as $fieldName) {
                    
                if(\Core::keyInArray($fieldName, $this->_NodeFieldsList)){
                    
                    if (\Core::keyInArray($fieldName, $this->_nodeMTORelations)) {
                        if ($indexKey == $fieldName) {
                            $indexKey = $fieldName . "pk";
                        }
                        $relationNode = $this->_nodeMTORelations[$fieldName];
                        $np = new \Core\Model\NodeProperties($relationNode);
                        $np->setNode($relationNode);
                        $relationNodeStructure = $np->currentNodeStructure();

                        $nr = new \Core\Model\NodeRelations();
                        $nr->setNode($relationNode);
                        $nodeRelations = $nr->getCurrentNodeRelation();
                        $relationNodeTable = $relationNodeStructure['tablename'];
                        $relationNodePK = $relationNodeStructure['primkey'];
                        $relationNodeDR = $relationNodeStructure['descriptor'];
                        $db->addFieldArray(array($fieldName => $fieldName . "pk"));
                        if (\Core::keyInArray($fieldName, $this->_multivaluesAttributes)) {
                            $joinCondition = $this->_nodeName . "." . $fieldName . " like concat('%','|'," . $fieldName . "." . $relationNodePK . ",'|','%') 
                    || " . $this->_nodeName . "." . $fieldName . " like concat(" . $fieldName . "." . $relationNodePK . ",'|','%') 
                    || " . $this->_nodeName . "." . $fieldName . " like concat('%','|'," . $fieldName . "." . $relationNodePK . ") 
                    || (" . $this->_nodeName . "." . $fieldName . "=" . $fieldName . "." . $relationNodePK . ")";
                            $db->addJoin($fieldName, $relationNodeTable, $fieldName, $joinCondition);
                            $db->addFieldArray(array("group_concat(distinct(" . $fieldName . "." . $relationNodeDR . ") separator '|' )" => $fieldName));
                        } else {
                            $joinCondition = $this->_nodeName . "." . $fieldName . "=" . $fieldName . "." . $relationNodePK;
                            $db->addJoin($fieldName, $relationNodeTable, $fieldName, $joinCondition);
                            if (\Core::keyInArray($relationNodeDR, $nodeRelations)) {
                                $np = new \Core\Model\NodeProperties();
                                $np->setNode($nodeRelations[$relationNodeDR]);
                                $parentNodeStructure = $np->currentNodeStructure();
                                $db->addFieldArray(array($fieldName . $relationNodeDR . "." . $parentNodeStructure['descriptor'] => $fieldName));
                                $joinCondition = $fieldName . "." . $relationNodeDR . "=" . $fieldName . $relationNodeDR . "." . $parentNodeStructure['primkey'];
                                $db->addJoin($fieldName . $relationNodeDR, $parentNodeStructure['tablename'], $fieldName . $relationNodeDR, $joinCondition);
                                $db->addFieldArray(array($fieldName . "." . $relationNodeDR => $relationNodeDR . "pk"));
                            } else {

                                $db->addFieldArray(array($fieldName . "." . $relationNodeDR => $fieldName));
                            }
                        }
                    } else {
                        $db->addField($fieldName);
                    }
                    }
                    else
                    {
                        if($this->checkIsAttribute($fieldName))
                        {
                            $db->addFieldArray(array($fieldName . ".attibute_value" => $fieldName));
                            $attributejoinCondition=$fieldName.".core_node_settings_id='".$this->_nodeName."' and ".$fieldName.".parentid=".$this->_nodeName.".".$this->_primaryKey." and ".$fieldName.".core_attribute_option_id='".$fieldName."'";
                            $db->addJoin($fieldName,"core_node_attribute_option_value",$fieldName,$attributejoinCondition);
                            
                        }                        
                    }
                }
            }
            if(\Core::countArray($this->_customSelectFields)>0)
            {
                    foreach($this->_customSelectFields as $fieldData)
                    {
                            $db->addFieldArray(array($fieldData['key'] => $fieldData['aliasname']));
                    }
            }
            if(\Core::countArray($this->_joinList)>0)
            {
                    foreach($this->_joinList as $joinData)
                    {
                            $db->addJoin($joinData['colname'], $joinData['nodeTable'], $joinData['fieldName'], $joinData['con']);
                    }
            }
            global $rootObj;
            $ws =$rootObj;
            if ($this->_isReport == 0) {
                $rpp = $ws->rpp;
                $page = 1;
                if (\Core::getValueFromArray($this->_requestedData, 'rpp_' . $this->_nodeName)) {
                    $rpp = $this->_requestedData['rpp_' . $this->_nodeName];
                }
		if($this->_rpp=="")
		{
			$this->_rpp = $rpp;
		}
                if (\Core::getValueFromArray($this->_requestedData, 'page_' . $this->_nodeName)) {
                    $page = $this->_requestedData['page_' . $this->_nodeName];
		    $this->_page = $page;
                }
		if($this->_page=="")
		{
			$this->_page = $page;
		}
                
            } else {
                $page = $this->_page;
            }
			
			
            $this->_wsrpp = $ws->rpp;
			
			
			
            $this->addFilter();
            
            $db->addWhere($this->_whereCon);
            if ($this->_groupBy != "") {
                if ($this->_customGroupBy != 1) {
                    if ($this->_preDefaultGroupBy == 1) {
                        $this->_groupBy = $this->_autoKey . " , " . $this->_groupBy;
                    } else {
                        $this->_groupBy = $this->_groupBy . " ," . $this->_autoKey;
                    }
                }
            } else {
                if ($this->_customGroupBy != 1) {
                $this->_groupBy = $this->_autoKey;
                }
            }
            $db->addGroupBy($this->_groupBy);

            if ($this->_orderBy != "") {
                if ($this->_customOrderBy != 1) {
                    if ($this->_preDefaultOrderBy == 1) {
                        $this->_orderBy = $this->_autoKey . " DESC , " . $this->_orderBy;
                    } else {
                        $this->_orderBy = $this->_orderBy . " ," . $this->_autoKey . " DESC ";
                    }
                }
            } else {
                $this->_orderBy = $this->_autoKey . " DESC";
            }

            $db->addOrderBy($this->_orderBy);
            if ($this->_nolimit != 1) {
                $db->setLimit(($this->_page - 1) * $this->_rpp, $this->_rpp);
            }

            $db->buildSelect();
            $this->_sql = $db->sql;
            $this->_collections = $db->getRows($indexKey);
        } catch (Exception $ex) {
            \Core::Log($ex->getMessage(), "collections.log");
        }
        return $this;
    }
    public function buildSelectCollection()
    {
        return $this;
    }

    public function getTotalResultCount() {
        $db = new \Core\DataBase\ProcessQuery();
        $db->setTable($this->_tableName, $this->_nodeName);
        $this->addFilter();
        $db->addFieldArray(array("count(distinct(" . $this->_nodeName . ".".$this->_autoKey."))" => "count"));
        if (\Core::countArray($this->_conditionMTO) > 0) {
            foreach ($this->_conditionMTO as $FieldName => $parentNode) {
                $parentNodeDetails = new \Core\Model\NodeProperties();
                $parentNodeDetails->setNode($parentNode);
                $parentStructure = $parentNodeDetails->currentNodeStructure();
                $joinCondition = $this->_nodeName . "." . $FieldName . "=" . $FieldName . "." . $parentStructure['primkey'];
                $db->addJoin($FieldName, $parentStructure['tablename'], $FieldName, $joinCondition);
                $nr = new \Core\Model\NodeRelations();
                $nr->setNode($parentNode);
                $nodeRelations = $nr->getCurrentNodeRelation();
                $relationNodeDR = $parentStructure['descriptor'];
                if (\Core::keyInArray($relationNodeDR, $nodeRelations)) {
                    $np = new \Core\Model\NodeProperties();
                    $np->setNode($nodeRelations[$relationNodeDR]);
                    $parentNodeStructure = $np->currentNodeStructure();
                    $joinCondition = $FieldName . $relationNodeDR . "." . $parentNodeStructure['primkey'] . "=" . $FieldName . "." . $relationNodeDR;
                    $db->addJoin($FieldName . $relationNodeDR . $relationNodeDR, $parentNodeStructure['tablename'], $FieldName . $relationNodeDR, $joinCondition);
                }
            }
        }
        if(\Core::countArray($this->_joinList)>0)
        {
                foreach($this->_joinList as $joinData)
                {
                        $db->addJoin($joinData['colname'], $joinData['nodeTable'], $joinData['fieldName'], $joinData['con']);
                }
        }
        $db->addWhere($this->_whereCon);
        $db->buildSelect();       
        $this->_totalRecordsCount = $db->getValue();
    }

    public function nodeFieldDisplay($row, $FieldName) {
        $displayValue = $row[$FieldName];
        $functionName = $this->_nodeName . "_" . $FieldName . "_nodeFieldDisplay";
        if (method_exists($this, $functionName)) {
            $displayValue = $this->$functionName($row, $FieldName);
        }
        if (in_array($FieldName, $this->_boolAttributes)) {
            if ($displayValue == 1) {
                $displayValue = "Yes";
            } else {
                $displayValue = "No";
            }
        }

        return $displayValue;
    }

    public function loadAttribute($FieldName, $record = array()) {        
        $isAjaxLoader = false;
        if (isset($this->_nodeMTORelations[$FieldName])) {
            $isAjaxLoader = true;
        }
        $currentNodeStructure = $this->_currentNodeStructure;
        $mandotatoryAttributes = $this->mandotatoryAttributes();
        $readonlyAttributes = $this->readonlyAttributes();
        $onchangeEvents = array();

		$multivalueFlag=0;
		if(\Core::inArray($FieldName,$this->_multivaluesAttributes))
		{
			$multivalueFlag=1;
		}
		
        $sourceNodeObj = \CoreClass::getModel($this->_nodeName, \Core::getValueFromArray($this->_record, 'action'));
        $sourceNodeObj->setNodeName($this->_nodeName);
        $filePath = isset($sourceNodeObj->_filePath[$FieldName]['storagefolder']) ? $sourceNodeObj->_filePath[$FieldName]['storagefolder'] : "";

        $eventmethod = lcfirst(str_replace(" ", "", ucwords(str_replace("_", " ", $this->_nodeName))) . "Onchange");

        if (\Core::methodExists($sourceNodeObj, $eventmethod)) {

            $onchangeEvents = $sourceNodeObj->$eventmethod();
        }
        $methodName = $FieldName . "_loadAttribute";
        if (\Core::methodExists($sourceNodeObj, $methodName)) {
            $sourceNodeObj->$methodName();
        } else {
            if (\Core::keyInArray($FieldName, $this->_NodeFieldAttributes)) {
                $attributeType = ucwords($this->_NodeFieldAttributes[$FieldName]);
            } else {

                if (\Core::inArray($this->_NodeFieldsList[$FieldName], array("text", "longtext", "mediumint"))) {
                    $attributeType = "Textarea";
                } else {
                    $attributeType = "Text";
                }
            }
            try {
                $FieldNameOptions = array();
                $actionName = $this->_currentAction;
                if ($actionName == "adminRefresh") {
                    $actionName = "admin";
                }
                if ($actionName != "admin") {
                    $record = $this->_record;
                }
                $defaultValue = \Core::getValueFromArray($record,$FieldName);
                if ($defaultValue == "") {
                    if (\Core::getValueFromArray($this->_record, 'action') == "add") {
                        if (\Core::keyInArray($FieldName, $this->_defaultValues)) {
                            $defaultValue = $this->_defaultValues[$FieldName];
                        }
                    }
                }
                $attributeDetails = new \Core\Attributes\LoadAttribute($attributeType);
                $attributeClass = "\Core\Attributes\'" . $attributeDetails->_attributeName;
                $attributeClass=str_replace("'", "", $attributeClass);
                $attribute = new $attributeClass;
                $attribute->setNodeName($this->_nodeName);
                $attribute->setPkName($currentNodeStructure['primkey']);
                $attribute->setIdName($FieldName);
                $attribute->setValue($defaultValue);
                $attribute->setRecord($record);
                $attribute->setMultiValues($multivalueFlag);
                $attribute->setFolderPath($filePath);
                if (\Core::keyInArray($FieldName, $onchangeEvents)) {

                    $attribute->setOnchange($onchangeEvents[$FieldName]);
                }
                if (in_array($FieldName, $mandotatoryAttributes)) {
                    $attribute->setRequired();
                }
                if (in_array($FieldName, $readonlyAttributes)) {
                    $attribute->setReadonly();
                }
                if ($actionName == "admin") {
                    $multiEditFields = $this->getMultiEditAttributes();

                    if ($this->checkMultiEditActionInProgress()) {

                        if (\Core::inArray($FieldName, $multiEditFields)) {
                            if (\Core::keyInArray($FieldName, $this->_nodeMTORelations)) {
                                $sourceNodeObj = \CoreClass::getModel($this->_nodeMTORelations[$FieldName]);

                                $sourceNodeObj->setNodeName($this->_nodeMTORelations[$FieldName]);

                                $db = new \Core\DataBase\ProcessQuery();
                                $db->setTable($sourceNodeObj->_currentNodeStructure['tablename'], $sourceNodeObj->_nodeName);
                                $db->addField($sourceNodeObj->_nodeName . "." . $sourceNodeObj->_primaryKey . " as pid");
                                $db->addFieldArray(array($sourceNodeObj->_nodeName . "." . $sourceNodeObj->_descriptor => "pds"));
                                $methodName = \CoreClass::getMethod($this, "filter", $sourceNodeObj->_nodeName, $FieldName);
                                if ($methodName) {
                                    $db->addWhere($this->$methodName());
                                }
                                $db->addOrderBy($sourceNodeObj->_descriptor);
                                $db->buildSelect();
                                $FieldNameOptions = $db->getRows();
                            }
                            $attribute->setMultiEdit();
                        }
                    }
                }
                $attribute->setOptions($FieldNameOptions);
                $attribute->setAction($actionName);
                $attribute->loadAttributeTemplate($attributeType, $FieldName, $actionName);
            } catch (Exception $ex) {
                \Core::Log(__METHOD__ . $ex->getMessage(), "exception.log");
            } catch (ErrorException $ex) {
                \Core::Log(__METHOD__ . $ex->getMessage(), "exception.log");
            }
        }
        return true;
    }

    public function addFilter() {

        if ($this->_parentNode) {
            if ($this->_whereCon != "") {
                        $this->_whereCon.=" and ";
            }
            $this->_whereCon.= $this->_nodeName.".".$this->_parentColName . "='" . $this->_parentSelector . "'";
        }
        $requestedData = $this->_requestedData;
        if (count($this->_showAttributes) > 0) {
            foreach ($this->_showAttributes as $FieldName) {
                if (\Core::getValueFromArray($requestedData, $FieldName) != "") {
                    if ($this->_whereCon != "") {
                        $this->_whereCon.=" and ";
                    }
                    if (\Core::keyInArray($FieldName, $this->_nodeMTORelations)) {
                        $this->_conditionMTO[$FieldName] = $this->_nodeMTORelations[$FieldName];
                        $parentNodeDetails = new \Core\Model\NodeProperties();
                        $parentNodeDetails->setNode($this->_nodeMTORelations[$FieldName]);
                        $parentStructure = $parentNodeDetails->currentNodeStructure();
                        $relationNodeDR = $parentStructure['descriptor'];
                        $nr = new \Core\Model\NodeRelations();
                        $nr->setNode($this->_nodeMTORelations[$FieldName]);
                        $nodeRelations = $nr->getCurrentNodeRelation();
                        if (\Core::keyInArray($relationNodeDR, $nodeRelations)) {
                            $np = new \Core\Model\NodeProperties();
                            $np->setNode($nodeRelations[$relationNodeDR]);
                            $parentNodeStructure = $np->currentNodeStructure();
                            $this->_whereCon.=$FieldName . $relationNodeDR . "." . $parentNodeStructure['descriptor'] . " like '%" . $requestedData[$FieldName] . "%'";
                        } else {
                            $this->_whereCon.=$FieldName . "." . $parentStructure['descriptor'] . " like '%" . $requestedData[$FieldName] . "%'";
                        }
                    } else {
                        if (\Core::getValueFromArray($this->_NodeFieldAttributes, $FieldName) == 'bool' && $requestedData[$FieldName] == "0") {
                            $this->_whereCon.="(" . $this->_nodeName . "." . $FieldName . " is NULL || " . $this->_nodeName . "." . $FieldName . "='0' || " . $this->_nodeName . "." . $FieldName . "='')";
                        } else {
                            $this->_whereCon.=$this->_nodeName . "." . $FieldName . " like '%" . $requestedData[$FieldName] . "%'";
                        }
                    }
                }
            }
        }
    }

    public function defaultOnchangeEvents($FieldName) {
        $np = new \Core\Model\NodeProperties();
        $np->setNode($this->_nodeName);
        $dependencyDetails = $np->setRelationDependency();
        $eventmethods = array();
        if (count($dependencyDetails) > 0) {
            if (\Core::keyInArray($FieldName, $dependencyDetails)) {
                $attributelist = \Core::convertStringToArray($dependencyDetails[$FieldName], "|");
                $nodeMTORelations = $this->_nodeMTORelations;
                $onchange = "";
                foreach ($attributelist as $childColName) {
                    $onchange.="defaultphpfile('" . $this->_nodeName . "','" . $this->_currentAction . "','" . $nodeMTORelations[$childColName] . "','" . $childColName . "');";
                }
                $eventmethods[$FieldName] = $onchange;
            }
        }
        return $eventmethods;
    }

    public function defaultDependeeFilter($FieldName) {

        $np = new \Core\Model\NodeProperties();
        $np->setNode($this->_nodeName);
        $dependencyDetails = $np->setRelationDependency();
        $FilterDependency = array();
        $depentparentList = array();
        if (count($dependencyDetails) > 0) {
            foreach ($dependencyDetails as $parentColName => $dependentData) {
                $attributelist = \Core::convertStringToArray($dependentData, "|");
                foreach ($attributelist as $childColName) {
                    if (\Core::getValueFromArray($FilterDependency, $childColName)) {
                        $FilterDependency[$childColName] = $FilterDependency[$childColName] . "|" . $parentColName;
                    } else {
                        $FilterDependency[$childColName] = $parentColName;
                    }
                }
            }
        }
        $methodName = \Core::convertStringToMethod($FieldName . "_addDescriptorFieldsFilter");
        if (\Core::methodExists($this, $methodName)) {
            $this->$methodName();
        } else {
            if (\Core::getValueFromArray($FilterDependency, $FieldName)) {
                $depentparentList = \Core::convertStringToArray($FilterDependency[$FieldName]);
            }
        }
        return $depentparentList;
    }

    public function coreNodeSettingsOnchange() {
        $events = array();
        $events['tablename'] = "getPrimarykey();getAutokey();getNodeStructure();";
        return $events;
    }

    public function getDefaultAttributeValues() {
        $np = new \Core\Model\NodeProperties($this->_nodeName);
        $np->setNode($this->_nodeName);
        $this->_defaultValues = $np->getDefaultValues();
    }

    public function loadActionButton($actionData, $primaryKeyValue, $parentActionPath) {
        $this->loadActionButtonTemapate($actionData, $primaryKeyValue, $parentActionPath);
    }

    public function addCustomFilter($whereCon) {

        if ($whereCon) {
            if ($this->_whereCon != "") {
                $this->_whereCon.=" and ";
            }
            $this->_whereCon.=" " . $whereCon;
        }
    }

    public function setCustomOrderBy() {
        $this->_customOrderBy = 1;
    }

    public function setCustomGroupBy() {
        $this->_customGroupBy = 1;
    }

    public function addCustomOrderBy($columname, $orderType = NULL) {
        if ($columname != "") {
            if ($orderType == "") {
                $orderType = "ASC";
            }
            if ($this->_orderBy != "") {
                $this->_orderBy.=",";
            }
            $this->_orderBy.=" " . $columname . " " . $orderType;
        }
    }

    public function addCustomGroupBy($columname, $havingCondition = NULL) {
        if ($columname != "") {
            if ($this->_groupBy != "") {
                $this->_groupBy.=",";
            }
            $this->_groupBy.=" " . $columname;
            if ($havingCondition != "") {
                $this->_groupBy.=" HAVING " . $havingCondition;
            }
        }
    }

    public function setPreDefaultOrderBy() {
        $this->_preDefaultOrderBy = 1;
    }

    public function setPreDefaultGroupBy() {
        $this->_preDefaultGroupBy = 1;
    }

    public function getSql() {
        return $this->_sql;
    }

    public function getRecord() {
        if (\Core::countArray($this->_collections) > 0) {
            foreach ($this->_collections as $collection) {
		$this->_record=$collection;
                return $collection;
            }
        } else {
            return array();
        }
    }

    public function resetDefaultSelectFields() {
        $this->_showAttributes = array();
    }

    public function addFieldToSelect($fieldName) {
        if (!\Core::inArray($fieldName, $this->_showAttributes)) {
            $this->_showAttributes[] = $fieldName;
        }        
        return $this;
    }
    public function removeTotalCollection()
    {
        $this->_removeTotalCollection=1;
    }
    public function  loadByField($value,$fieldName)
    {
        $whereCon=$this->_nodeName.".".$fieldName."='".$value."'";
        $this->removeTotalCollection();
        $this->addCustomFilter($whereCon);
        $this->getCollection();
        return $this->getRecord();
    }
	public function getResultValue()
	{		
		$this->getCollection();
		if (Core::countArray($this->_collections) > 0) {
            foreach ($this->_collections as $collection) {
				$this->_record=$collection;
            }
        } 
		return Core::getValueFromArray(Core::getValuesFromArray($this->_record),0);
	}
}
?>